<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FoodType;

class FoodTypeSeeder extends Seeder
{

    public function run(): void
    {
        $foodTypes = [
            [
                'name' => 'Tagine',
                'description' => 'A slow-cooked stew braised at low temperatures, traditionally prepared in a clay or ceramic pot.'
            ],
            [
                'name' => 'Couscous',
                'description' => 'Steamed semolina grains typically served with vegetables, meat, or broth.'
            ],
            [
                'name' => 'Pastilla',
                'description' => 'A savory-sweet pie made with layers of thin pastry, pigeon or chicken, almonds, and cinnamon.'
            ],
            [
                'name' => 'Harira',
                'description' => 'A hearty soup made with tomatoes, lentils, chickpeas, and lamb, often eaten to break the fast during Ramadan.'
            ],
            [
                'name' => 'Mechoui',
                'description' => 'Slow-roasted lamb, seasoned with spices, traditionally cooked whole in a pit oven.'
            ],
            [
                'name' => 'Brochettes',
                'description' => 'Grilled meat skewers seasoned with Moroccan spices.'
            ],
            [
                'name' => 'Rfissa',
                'description' => 'A comforting dish of chicken and lentils served over shredded, steamed bread with a fenugreek sauce.'
            ],
            [
                'name' => 'Bissara',
                'description' => 'A creamy fava bean soup or dip seasoned with olive oil and cumin.'
            ],
            [
                'name' => 'Tanjia',
                'description' => 'A slow-cooked beef or lamb stew, traditionally prepared by Marrakech artisans.'
            ],
            [
                'name' => 'Zaalouk',
                'description' => 'A warm salad of cooked eggplant and tomatoes seasoned with garlic, olive oil, and spices.'
            ],
            [
                'name' => 'Maakouda',
                'description' => 'Fried potato cakes spiced with herbs, commonly served as street food.'
            ],
            [
                'name' => 'Msemen',
                'description' => 'Layered, square-shaped Moroccan pancakes, often served with honey or jam.'
            ],
            [
                'name' => 'Baghrir',
                'description' => 'Spongy semolina pancakes full of tiny holes, known as "thousand-hole pancakes".'
            ],
            [
                'name' => 'Seffa',
                'description' => 'Sweetened couscous or vermicelli, topped with cinnamon, powdered sugar, and sometimes chicken.'
            ],
            [
                'name' => 'Briouat',
                'description' => 'Small, stuffed pastries filled with meat, cheese, or almonds and fried until golden.'
            ],
            [
                'name' => 'Khobz (Moroccan Bread)',
                'description' => 'Thick, round loaves of bread, a staple in every Moroccan meal.'
            ],
            [
                'name' => 'Hout Quari',
                'description' => 'Grilled whole fish, marinated with chermoula herbs and spices.'
            ],
            [
                'name' => 'Kefta',
                'description' => 'Spiced ground meat, typically beef or lamb, shaped into balls or patties and grilled.'
            ],
            [
                'name' => 'Mrouzia',
                'description' => 'A sweet and savory lamb tagine made with raisins, almonds, and honey.'
            ],
            [
                'name' => 'Chebakia',
                'description' => 'Sesame cookies shaped into a flower, fried, and coated with honey; popular during Ramadan.'
            ],
        ];

        foreach ($foodTypes as $type) {
            FoodType::create($type);
        }
    }
}
