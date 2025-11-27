<?php

namespace Database\Seeders;

use App\Models\Jenis;
use Illuminate\Database\Seeder;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Sunny Yellow',
                'slug' => 'sunny-yellow',
                'image' => 'sunny-yellow.jpg',
                'price' => 'Rp 1.699.000',
                'description' => 'Rangkaian bunga tulip kuning yang disusun dalam vas kaca bening membuat tampilannya begitu anggun. Sunny Yellow menyimbolkan semangat yang tinggi.',
            ],
            [
                'name' => 'Baby\'s Breath Flower',
                'slug' => 'babys-breath',
                'image' => 'babybreath.jpg',
                'price' => 'Rp 50.000',
                'description' => 'Baby\'s Breath memiliki Simbol Cinta Abadi, Kemurnian, dan Kekuatan.',
            ],
            [
                'name' => 'Helleborus Flower',
                'slug' => 'helleborus',
                'image' => 'helleborus.jpg',
                'price' => 'Rp 80.000',
                'description' => 'Bunga Helleborus sering dianggap sebagai simbol kedamaian dan ketenangan.',
            ],
        ];

        foreach ($items as $it) {
            Jenis::updateOrCreate(['slug' => $it['slug']], $it);
        }
    }
}
