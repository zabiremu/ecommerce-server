<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            [
                'title' => 'Say Hello to Adventure',
                'subtitle' => 'Perfect for fans of the iconic platformer',
                'description' => 'Discover collectibles, apparel and accessories inspired by your favorite worlds.',
                'image' => 'sliders/say-hello-to-adventure-aqagf3r9QVucXZZOaJU5.jpg',
                'status' => true,
            ],
            [
                'title' => 'Embrace the Epic World',
                'subtitle' => 'Featuring minimalist desert tones and iconic symbols',
                'description' => 'Shop limited-edition gear inspired by the saga that took the world by storm.',
                'image' => 'sliders/embrace-the-epic-world-6y6U29cyjogbgjGIevil.jpg',
                'status' => true,
            ],
            [
                'title' => 'Geralt of Rivia Figure',
                'subtitle' => 'A must-have collectible for any Witcher fan',
                'description' => 'Premium detail, hand-painted finish, and screen-accurate design.',
                'image' => 'sliders/geralt-of-rivia-figure-sm02pxmezMYZVFc9juUa.jpg',
                'status' => true,
            ],
        ];

        foreach ($slides as $slide) {
            Slider::updateOrCreate(
                ['title' => $slide['title']],
                $slide
            );
        }

        $total = Slider::count();
        $this->command->info("Sliders seeded successfully. Total: {$total}");
    }
}
