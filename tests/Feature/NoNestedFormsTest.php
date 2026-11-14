<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * A <form> inside another <form> is invalid HTML: the browser drops the inner
 * <form> tag and its fields (e.g. _method=DELETE) end up in the outer form,
 * and the inner </form> closes the outer one early. That made "Update Role" /
 * "Update Admin" send a DELETE and broke contact-message bulk actions.
 * Use a separate form + the button's form="id" attribute instead.
 */
class NoNestedFormsTest extends TestCase
{
    public function test_no_blade_view_nests_a_form_inside_another_form(): void
    {
        $problems = [];
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(resource_path('views')));

        foreach ($files as $file) {
            if (!str_ends_with($file->getFilename(), '.blade.php')) continue;

            $src = file_get_contents($file->getPathname());
            $src = preg_replace('/\{\{--.*?--\}\}/s', '', $src);            // Blade comments
            $src = preg_replace('/<script\b.*?<\/script>/si', '', $src);   // forms built in JS strings

            $depth = 0;
            preg_match_all('/<form\b|<\/form>/i', $src, $m, PREG_OFFSET_CAPTURE);
            foreach ($m[0] as [$tag, $offset]) {
                if (strtolower($tag) === '</form>') { $depth = max(0, $depth - 1); continue; }
                if ($depth > 0) {
                    $line = substr_count(substr($src, 0, $offset), "\n") + 1;
                    $problems[] = str_replace(resource_path('views') . DIRECTORY_SEPARATOR, '', $file->getPathname()) . ":~{$line}";
                }
                $depth++;
            }
        }

        $this->assertSame([], $problems, "Nested <form> found (use form=\"id\" on the button instead):\n" . implode("\n", $problems));
    }
}
