<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Fills in richer long-form content (materials/fit/care) for the starter
 * catalog from 2026_07_29_100000_seed_starter_apparel_products.php, shown
 * on the product-details "Description" tab. Generic but honest — no
 * fabricated specific claims (no "imported", "waterproof", etc. unless
 * genuinely true of the real item the owner eventually lists here).
 */
return new class extends Migration
{
    public function up(): void
    {
        $byCategory = [
            't-shirt' => "Made from soft, breathable cotton jersey for everyday comfort. Regular fit, crew neckline, true to size.\n\nCare: machine wash cold, tumble dry low, do not bleach.",
            'polo-t-shirt' => "Pique cotton knit with a ribbed collar and two-button placket for a smart-casual look. True to size.\n\nCare: machine wash cold, iron on low if needed.",
            'shirt' => "Woven cotton shirt with a clean, tailored finish — dresses up easily or wears open over a tee. True to size.\n\nCare: machine wash cold, iron on medium heat.",
            'boxy-shirt' => "Relaxed, drop-shoulder boxy fit in soft cotton. Runs slightly oversized — size down for a closer fit.\n\nCare: machine wash cold, tumble dry low.",
            'jeans' => "Stretch cotton denim with a comfortable, everyday fit through the hip and thigh. True to size.\n\nCare: machine wash cold inside-out, avoid tumble drying to preserve color.",
            'baggy-jeans' => "Loose, relaxed-through-the-seat denim with a dropped fit. Consider sizing down if you prefer less volume.\n\nCare: machine wash cold inside-out, line dry recommended.",
            'semi-baggy-jeans' => "Roomy through the thigh with a tapered leg opening — a middle ground between slim and baggy. True to size.\n\nCare: machine wash cold inside-out, line dry recommended.",
            'cargo-pant' => "Durable cotton cargo pant with side utility pockets. Regular fit through the leg. True to size.\n\nCare: machine wash cold, tumble dry low.",
            'formal-pant' => "Smooth-weave formal trouser with a tailored finish, suitable for office or formal wear. True to size.\n\nCare: dry clean recommended, or machine wash cold and iron on low.",
            'chino-pant' => "Classic cotton twill chino for everyday wear, smart enough for the office, casual enough for the weekend. True to size.\n\nCare: machine wash cold, tumble dry low.",
            'shorts' => "Lightweight cotton shorts built for warm-weather comfort. Regular fit. True to size.\n\nCare: machine wash cold, tumble dry low.",
            'sneakers' => "Everyday sneaker with a cushioned footbed and durable rubber outsole. True to size — order half a size up if between sizes.\n\nCare: spot clean with a damp cloth, air dry away from direct heat.",
            'formal-shoes' => "Leather formal shoe with a cushioned insole for all-day wear. True to size.\n\nCare: wipe clean and condition leather regularly, use a shoe tree to hold shape.",
            'boots' => "Sturdy lace-up boot built for durability and everyday wear. True to size — consider half a size up if you'll wear thick socks.\n\nCare: wipe clean, treat leather/suede with an appropriate protector.",
            'slides' => "Lightweight slide with an adjustable strap and contoured footbed for everyday comfort. True to size.\n\nCare: rinse with water, air dry.",
            'slippers' => "Soft, cushioned slipper for everyday indoor and outdoor comfort. True to size.\n\nCare: spot clean with a damp cloth.",
            'running-shoes' => "Breathable mesh upper with a cushioned midsole built for daily runs. True to size — order half a size up if between sizes.\n\nCare: spot clean, air dry away from direct heat.",
            'sports-shoes' => "All-purpose training shoe with a grippy outsole for lateral support. True to size.\n\nCare: spot clean, air dry away from direct heat.",
            'loafers' => "Slip-on loafer with a stitched sole, easy to dress up or down. True to size.\n\nCare: wipe clean and condition leather/suede regularly.",
        ];

        foreach ($byCategory as $slug => $longDescription) {
            $categoryId = DB::table('categories')->where('slug', $slug)->value('id');
            if (! $categoryId) {
                continue;
            }

            DB::table('products')
                ->where('category_id', $categoryId)
                ->whereNull('long_description')
                ->update(['long_description' => $longDescription, 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        // No-op: don't blindly wipe content an admin may have since edited.
    }
};
