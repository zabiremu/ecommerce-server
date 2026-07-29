<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SocialLinkSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            'social_facebook'  => 'https://facebook.com/roventex',
            'social_instagram' => 'https://instagram.com/roventex',
            'social_youtube'   => 'https://youtube.com/@roventex',
            'social_twitter'   => 'https://x.com/roventex',
            'social_discord'   => 'https://discord.gg/roventex',
            'social_whatsapp'  => 'https://wa.me/8801820834086',
        ];

        foreach ($links as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'social']
            );
        }

        SiteSetting::flushCache();

        $this->command->info('Social links seeded successfully. Total: ' . count($links));
    }
}
