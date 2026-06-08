<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@motopart.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Customer Demo',
            'email' => 'customer@motopart.test',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $categories = collect([
            ['name' => 'Oli dan Pelumas', 'slug' => 'oli-dan-pelumas', 'description' => 'Oli mesin, oli gardan, dan cairan perawatan.'],
            ['name' => 'Rem', 'slug' => 'rem', 'description' => 'Kampas rem, cakram, dan minyak rem.'],
            ['name' => 'Kelistrikan', 'slug' => 'kelistrikan', 'description' => 'Aki, busi, lampu, dan kabel.'],
        ])->map(fn ($category) => Category::create($category));

        Product::create([
            'category_id' => $categories[0]->id,
            'name' => 'Oli Mesin Synthetic 10W-40',
            'slug' => 'oli-mesin-synthetic-10w-40',
            'sku' => 'OLI-1040',
            'description' => 'Oli mesin synthetic untuk motor harian dengan perlindungan panas tinggi.',
            'price' => 65000,
            'stock' => 25,
            'brand' => 'MotoLube',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $categories[1]->id,
            'name' => 'Kampas Rem Depan Ceramic',
            'slug' => 'kampas-rem-depan-ceramic',
            'sku' => 'REM-CRMC',
            'description' => 'Kampas rem depan berbahan ceramic dengan gigitan stabil.',
            'price' => 85000,
            'stock' => 15,
            'brand' => 'BrakePro',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $categories[2]->id,
            'name' => 'Busi Iridium Motor Matic',
            'slug' => 'busi-iridium-motor-matic',
            'sku' => 'BUSI-IRD',
            'description' => 'Busi iridium untuk pembakaran lebih responsif dan efisien.',
            'price' => 120000,
            'stock' => 18,
            'brand' => 'SparkMax',
            'is_active' => true,
        ]);
    }
}
