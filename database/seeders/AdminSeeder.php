<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@nfshop24.com',
                    'password' => 'password',
            ],
        ];

        foreach ($admins as $admin) {
            Admin::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => $admin['password'],
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('Admin seeded successfully.');
        $this->command->table(
            ['Email', 'Password'],
            array_map(fn ($a) => [$a['email'], $a['password']], $admins)
        );
    }
}
