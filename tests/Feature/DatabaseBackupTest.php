<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Role;
use App\Services\DatabaseBackupService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\TestCase;

/** Restore drops and recreates tables (DDL commits), so each test starts and ends with a fresh schema instead of a rolled-back transaction. */
class DatabaseBackupTest extends TestCase
{
    use ActsAsAdmin;

    private string $dir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'backup-test-' . uniqid();
        config(['app.backup_path' => $this->dir]);
        $this->actingAsAdmin();
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->dir);
        $this->artisan('migrate:fresh');
        parent::tearDown();
    }

    public function test_backup_then_restore_brings_data_back(): void
    {
        Brand::create(['name' => "O'Neil \"Quotes\"\nNew line", 'slug' => 'oneil', 'status' => true]);

        $this->post('/admin/backups')->assertRedirect('/admin/backups');
        $backups = app(DatabaseBackupService::class)->list();
        $this->assertCount(1, $backups);
        $name = $backups[0]['name'];

        Brand::query()->delete();
        Brand::create(['name' => 'Added later', 'slug' => 'later', 'status' => true]);

        $this->post("/admin/backups/{$name}/restore", ['confirm' => 'RESTORE'])->assertRedirect('/admin/backups');

        $this->assertSame(["O'Neil \"Quotes\"\nNew line"], Brand::pluck('name')->all());
        // A safety backup of the data before the restore was kept.
        $this->assertCount(1, collect(app(DatabaseBackupService::class)->list())->where('type', 'pre-restore'));
    }

    public function test_restore_needs_typed_confirmation(): void
    {
        $name = app(DatabaseBackupService::class)->create('manual');

        $this->post("/admin/backups/{$name}/restore", ['confirm' => 'yes'])->assertSessionHasErrors('confirm');
    }

    public function test_only_super_admin_can_restore(): void
    {
        $name = app(DatabaseBackupService::class)->create('manual');
        $role = Role::create(['name' => 'Manager', 'permissions' => ['backups.view', 'backups.create']]);
        $this->actingAsAdmin(['role_id' => $role->id]);

        $this->get('/admin/backups')->assertOk()->assertDontSee('Upload &amp; Restore', false);
        $this->post("/admin/backups/{$name}/restore", ['confirm' => 'RESTORE'])->assertForbidden();
    }

    public function test_foreign_file_upload_is_rejected(): void
    {
        $file = UploadedFile::fake()->createWithContent('evil.sql.gz', gzencode('DROP TABLE admins;'));

        $this->post('/admin/backups/upload', ['backup_file' => $file, 'confirm' => 'RESTORE'])
            ->assertSessionHasErrors('backup_file');
        $this->assertTrue(\Illuminate\Support\Facades\Schema::hasTable('admins'));
    }

    public function test_download_rejects_bad_names(): void
    {
        $name = app(DatabaseBackupService::class)->create('manual');

        $this->get("/admin/backups/{$name}/download")->assertOk();
        $this->get('/admin/backups/..%2F.env/download')->assertNotFound();
    }
}
