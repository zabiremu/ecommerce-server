<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RuntimeException;

/**
 * Plain-PHP MySQL backup/restore (no mysqldump needed, so it works on shared
 * hosting). Backups are gzipped SQL files in storage/app/backups, which is
 * not web-accessible. Each statement ends with a marker line so restore can
 * split them safely.
 */
class DatabaseBackupService
{
    public const KEEP = 30;
    private const HEADER = '-- ecommerce-backup v1';
    private const END = "\n-- @@end\n";
    private const NAME = '/^backup-\d{8}-\d{6}-(auto|manual|pre-restore|upload)\.sql\.gz$/';
    /** Structure only — their rows are throwaway. */
    private const SKIP_DATA = ['sessions', 'cache', 'cache_locks', 'jobs', 'failed_jobs', 'job_batches'];

    public function dir(): string
    {
        $dir = config('app.backup_path') ?: storage_path('app/backups');
        File::ensureDirectoryExists($dir);

        return $dir;
    }

    /** Newest first: [name, size, created_at (Carbon), type]. */
    public function list(): array
    {
        return collect(File::files($this->dir()))
            ->filter(fn ($f) => self::validName($f->getFilename()))
            ->map(fn ($f) => [
                'name'       => $f->getFilename(),
                'size'       => $f->getSize(),
                'created_at' => Carbon::createFromTimestamp($f->getMTime()),
                'type'       => preg_replace('/^backup-\d{8}-\d{6}-(.+)\.sql\.gz$/', '$1', $f->getFilename()),
            ])
            ->sortByDesc('name')
            ->values()
            ->all();
    }

    public static function validName(string $name): bool
    {
        return (bool) preg_match(self::NAME, $name);
    }

    public function path(string $name): string
    {
        if (!self::validName($name) || !is_file($path = $this->dir() . DIRECTORY_SEPARATOR . $name)) {
            throw new RuntimeException('Backup not found.');
        }

        return $path;
    }

    public function create(string $type = 'manual'): string
    {
        @set_time_limit(0);
        $name = 'backup-' . now()->format('Ymd-His') . "-{$type}.sql.gz";
        $tmp = $this->dir() . DIRECTORY_SEPARATOR . $name . '.part';
        $pdo = DB::connection()->getPdo();

        $gz = gzopen($tmp, 'wb6');
        try {
            gzwrite($gz, self::HEADER . "\n-- " . now()->toDateTimeString() . " UTC\n");
            gzwrite($gz, 'SET FOREIGN_KEY_CHECKS=0' . self::END);
            gzwrite($gz, "SET NAMES utf8mb4" . self::END);

            foreach ($this->tables() as $table) {
                $q = $this->quoteName($table);
                $create = (array) DB::selectOne("SHOW CREATE TABLE {$q}");
                gzwrite($gz, "DROP TABLE IF EXISTS {$q}" . self::END);
                gzwrite($gz, array_values($create)[1] . self::END);

                if (in_array($table, self::SKIP_DATA, true)) continue;

                $offset = 0;
                do {
                    $rows = DB::select("SELECT * FROM {$q} LIMIT 500 OFFSET {$offset}");
                    if ($rows) {
                        $columns = implode(', ', array_map(fn ($c) => $this->quoteName($c), array_keys((array) $rows[0])));
                        $values = array_map(fn ($row) => '(' . implode(', ', array_map(
                            fn ($v) => $v === null ? 'NULL' : $pdo->quote((string) $v),
                            (array) $row
                        )) . ')', $rows);
                        gzwrite($gz, "INSERT INTO {$q} ({$columns}) VALUES\n" . implode(",\n", $values) . self::END);
                    }
                    $offset += 500;
                } while (count($rows) === 500);
            }

            gzwrite($gz, 'SET FOREIGN_KEY_CHECKS=1' . self::END);
        } finally {
            gzclose($gz);
        }

        rename($tmp, $this->dir() . DIRECTORY_SEPARATOR . $name);
        $this->prune();

        return $name;
    }

    /** Replace the whole database with a backup. A safety backup is taken first. */
    public function restore(string $path): string
    {
        $this->assertBackupFile($path);
        @set_time_limit(0);
        $safety = $this->create('pre-restore');

        $gz = gzopen($path, 'rb');
        $buffer = '';
        DB::unprepared('SET FOREIGN_KEY_CHECKS=0');
        try {
            while (!gzeof($gz)) {
                $buffer .= gzread($gz, 1 << 20);
                while (($pos = strpos($buffer, self::END)) !== false) {
                    $sql = trim(substr($buffer, 0, $pos));
                    $buffer = substr($buffer, $pos + strlen(self::END));
                    $sql = trim(preg_replace('/^(--[^\n]*\n)+/', '', $sql . "\n"));
                    if ($sql !== '') DB::unprepared($sql);
                }
            }
        } finally {
            gzclose($gz);
            DB::unprepared('SET FOREIGN_KEY_CHECKS=1');
        }

        return $safety;
    }

    /** Only files this service wrote can be restored. */
    public function assertBackupFile(string $path): void
    {
        $gz = @gzopen($path, 'rb');
        $head = $gz ? (string) gzread($gz, strlen(self::HEADER)) : '';
        if ($gz) gzclose($gz);

        if ($head !== self::HEADER) {
            throw new RuntimeException('This is not a backup made by this website.');
        }
    }

    public function delete(string $name): void
    {
        File::delete($this->path($name));
    }

    public function latestAt(): ?Carbon
    {
        return $this->list()[0]['created_at'] ?? null;
    }

    /** Keep the newest KEEP backups (pre-restore ones included). */
    private function prune(): void
    {
        foreach (array_slice($this->list(), self::KEEP) as $old) {
            File::delete($this->dir() . DIRECTORY_SEPARATOR . $old['name']);
        }
    }

    private function tables(): array
    {
        return collect(DB::select("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'"))
            ->map(fn ($row) => array_values((array) $row)[0])
            ->all();
    }

    private function quoteName(string $name): string
    {
        return '`' . str_replace('`', '``', $name) . '`';
    }
}
