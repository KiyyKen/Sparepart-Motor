<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->copySeedImages();

        User::create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@motopart.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $customer = User::create([
            'name' => 'Customer Demo',
            'email' => 'customer@motopart.test',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        $categories = collect([
            ['name' => 'Oli dan Pelumas', 'slug' => 'oli-dan-pelumas', 'description' => 'Oli mesin, oli gardan, dan cairan perawatan.'],
            ['name' => 'Rem', 'slug' => 'rem', 'description' => 'Kampas rem, cakram, dan minyak rem.'],
            ['name' => 'Kelistrikan', 'slug' => 'kelistrikan', 'description' => 'Aki, busi, lampu, dan kabel.'],
            ['name' => 'Ban dan Roda', 'slug' => 'ban-dan-roda', 'description' => 'Ban, velg, dan perlengkapan roda.'],
            ['name' => 'Aksesoris dan Variasi', 'slug' => 'aksesoris-dan-variasi', 'description' => 'Spion, cover jok, box, dan variasi lainnya.'],
            ['name' => 'Kaki-kaki dan Suspensi', 'slug' => 'kaki-kaki-dan-suspensi', 'description' => 'Shockbreaker, bearing, rantai, dan comstir.'],
            ['name' => 'Transmisi CVT', 'slug' => 'transmisi-cvt', 'description' => 'Vbelt, roller, kampas kopling, dan filter CVT.'],
        ])->mapWithKeys(fn (array $data) => [$data['slug'] => Category::create($data)]);

        $productsData = [
            // Oli dan Pelumas
            ['category' => 'oli-dan-pelumas', 'sku' => 'OLI-1040', 'name' => 'Oli Mesin Synthetic 10W-40', 'brand' => 'MotoLube', 'price' => 65000, 'stock' => 25, 'description' => 'Oli mesin synthetic untuk motor harian dengan perlindungan panas tinggi.'],
            ['category' => 'oli-dan-pelumas', 'sku' => 'OLI-GRDN', 'name' => 'Oli Gardan Matic 80ml', 'brand' => 'MotoLube', 'price' => 25000, 'stock' => 40, 'description' => 'Oli gardan khusus motor matic, mengurangi suara kasar CVT.'],
            ['category' => 'oli-dan-pelumas', 'sku' => 'OLI-RAD', 'name' => 'Cairan Radiator Coolant 1L', 'brand' => 'CoolRide', 'price' => 45000, 'stock' => 20, 'description' => 'Cairan radiator anti karat menjaga suhu mesin tetap stabil.'],
            ['category' => 'oli-dan-pelumas', 'sku' => 'OLI-DOT4', 'name' => 'Minyak Rem DOT 4 250ml', 'brand' => 'BrakePro', 'price' => 38000, 'stock' => 30, 'description' => 'Minyak rem DOT 4 titik didih tinggi untuk pengereman stabil.'],

            // Rem
            ['category' => 'rem', 'sku' => 'REM-CRMC', 'name' => 'Kampas Rem Depan Ceramic', 'brand' => 'BrakePro', 'price' => 85000, 'stock' => 15, 'description' => 'Kampas rem depan berbahan ceramic dengan gigitan stabil.'],
            ['category' => 'rem', 'sku' => 'REM-BLKG', 'name' => 'Kampas Rem Belakang Organic', 'brand' => 'BrakePro', 'price' => 70000, 'stock' => 20, 'description' => 'Kampas rem belakang bahan organic, minim decit.'],
            ['category' => 'rem', 'sku' => 'REM-CKRM', 'name' => 'Cakram Rem Depan Wave', 'brand' => 'DiscMax', 'price' => 175000, 'stock' => 4, 'description' => 'Cakram rem depan motif wave, pendinginan lebih optimal.'],
            ['category' => 'rem', 'sku' => 'REM-SLNG', 'name' => 'Selang Rem Braided Stainless', 'brand' => 'BrakePro', 'price' => 95000, 'stock' => 12, 'description' => 'Selang rem anyaman stainless, tarikan tuas lebih pakem.'],

            // Kelistrikan
            ['category' => 'kelistrikan', 'sku' => 'BUSI-IRD', 'name' => 'Busi Iridium Motor Matic', 'brand' => 'SparkMax', 'price' => 120000, 'stock' => 18, 'description' => 'Busi iridium untuk pembakaran lebih responsif dan efisien.'],
            ['category' => 'kelistrikan', 'sku' => 'AKI-MF5', 'name' => 'Aki Kering MF 12V 5Ah', 'brand' => 'PowerCell', 'price' => 210000, 'stock' => 15, 'description' => 'Aki bebas perawatan, starter lebih responsif.'],
            ['category' => 'kelistrikan', 'sku' => 'LED-H4', 'name' => 'Lampu LED Headlamp H4', 'brand' => 'BrightRide', 'price' => 90000, 'stock' => 22, 'description' => 'Lampu depan LED terang, hemat daya aki.'],
            ['category' => 'kelistrikan', 'sku' => 'KBL-BODI', 'name' => 'Kabel Bodi Set Universal', 'brand' => 'WireTech', 'price' => 65000, 'stock' => 18, 'description' => 'Set kabel bodi lengkap dengan soket, plug and play.'],

            // Ban dan Roda
            ['category' => 'ban-dan-roda', 'sku' => 'BAN-R14', 'name' => 'Ban Tubeless Ring 14 70/90', 'brand' => 'RoadGrip', 'price' => 245000, 'stock' => 16, 'description' => 'Ban tubeless grip kuat untuk jalan basah maupun kering.'],
            ['category' => 'ban-dan-roda', 'sku' => 'BAN-R17', 'name' => 'Ban Tubeless Ring 17 80/90', 'brand' => 'TrackForce', 'price' => 260000, 'stock' => 14, 'description' => 'Ban tubeless ring 17 untuk motor sport harian.'],
            ['category' => 'ban-dan-roda', 'sku' => 'VELG-R17', 'name' => 'Velg Racing CBS Ring 17', 'brand' => 'RimZone', 'price' => 550000, 'stock' => 0, 'description' => 'Velg racing ringan dengan desain palang sporty.'],
            ['category' => 'ban-dan-roda', 'sku' => 'PENTIL-10', 'name' => 'Pentil Ban Tubeless Set Isi 10', 'brand' => 'Universal', 'price' => 15000, 'stock' => 50, 'description' => 'Pentil ban tubeless karet tebal, anti bocor angin.'],

            // Aksesoris dan Variasi
            ['category' => 'aksesoris-dan-variasi', 'sku' => 'SPION-LPT', 'name' => 'Spion Lipat Universal', 'brand' => 'ViewPro', 'price' => 55000, 'stock' => 25, 'description' => 'Spion lipat model sporty, mudah dipasang di semua motor.'],
            ['category' => 'aksesoris-dan-variasi', 'sku' => 'COVER-JOK', 'name' => 'Cover Jok Anti Air', 'brand' => 'RideCover', 'price' => 48000, 'stock' => 30, 'description' => 'Cover jok waterproof, melindungi jok dari hujan dan panas.'],
            ['category' => 'aksesoris-dan-variasi', 'sku' => 'BOX-30L', 'name' => 'Box Motor 30L Universal', 'brand' => 'CargoBox', 'price' => 320000, 'stock' => 8, 'description' => 'Box motor kapasitas 30 liter, muat 2 helm full face.'],
            ['category' => 'aksesoris-dan-variasi', 'sku' => 'CHARGER-USB', 'name' => 'Charger USB Motor Waterproof', 'brand' => 'PowerCell', 'price' => 35000, 'stock' => 40, 'description' => 'Charger USB tahan air untuk isi daya HP saat berkendara.'],

            // Kaki-kaki dan Suspensi
            ['category' => 'kaki-kaki-dan-suspensi', 'sku' => 'SHOCK-BLK', 'name' => 'Shockbreaker Belakang Tabung', 'brand' => 'ShockTech', 'price' => 385000, 'stock' => 9, 'description' => 'Shockbreaker tabung untuk kenyamanan dan handling lebih baik.'],
            ['category' => 'kaki-kaki-dan-suspensi', 'sku' => 'BEARING-RD', 'name' => 'Bearing Roda Depan Set', 'brand' => 'RollBearing', 'price' => 45000, 'stock' => 20, 'description' => 'Bearing roda presisi tinggi, putaran roda lebih halus.'],
            ['category' => 'kaki-kaki-dan-suspensi', 'sku' => 'RANTAI-KTG', 'name' => 'Rantai Keteng Set', 'brand' => 'ChainForce', 'price' => 60000, 'stock' => 15, 'description' => 'Rantai keteng lengkap dengan tensioner, minim suara kasar.'],
            ['category' => 'kaki-kaki-dan-suspensi', 'sku' => 'COMSTIR-UNI', 'name' => 'Comstir Set Universal', 'brand' => 'SteerFit', 'price' => 95000, 'stock' => 10, 'description' => 'Comstir set membuat setang lebih ringan dan presisi.'],

            // Transmisi CVT
            ['category' => 'transmisi-cvt', 'sku' => 'VBELT-CVT', 'name' => 'Vbelt CVT Matic', 'brand' => 'BeltDrive', 'price' => 85000, 'stock' => 20, 'description' => 'Vbelt tahan panas untuk performa CVT yang halus.'],
            ['category' => 'transmisi-cvt', 'sku' => 'ROLLER-15', 'name' => 'Roller CVT Set 15gr', 'brand' => 'RollerMax', 'price' => 40000, 'stock' => 25, 'description' => 'Set roller CVT 15 gram, tarikan awal lebih responsif.'],
            ['category' => 'transmisi-cvt', 'sku' => 'KOPLING-CVT', 'name' => 'Kampas Kopling Ganda CVT', 'brand' => 'ClutchPro', 'price' => 110000, 'stock' => 12, 'description' => 'Kampas kopling ganda untuk akselerasi yang lebih bertenaga.'],
            ['category' => 'transmisi-cvt', 'sku' => 'FILTER-CVT', 'name' => 'Filter Udara CVT', 'brand' => 'AirFlow', 'price' => 32000, 'stock' => 18, 'description' => 'Filter udara CVT menjaga komponen dari debu dan kotoran.'],
        ];

        $products = collect($productsData)->mapWithKeys(function (array $data) use ($categories) {
            $product = Product::create([
                'category_id' => $categories[$data['category']]->id,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'sku' => $data['sku'],
                'description' => $data['description'],
                'price' => $data['price'],
                'stock' => $data['stock'],
                'brand' => $data['brand'],
                'image' => 'products/category-'.$data['category'].'.jpg',
                'is_active' => true,
            ]);

            return [$data['sku'] => $product];
        });

        $makeReviewedOrder = function (Product $product, int $rating, string $comment, int $daysAgo, int $sequence, int $quantity = 1) use ($customer): Order {
            $subtotal = $product->price * $quantity;

            $order = Order::create([
                'user_id' => $customer->id,
                'order_number' => sprintf('ORD-DEMO-%04d', $sequence),
                'status' => 'completed',
                'payment_type' => 'bank_transfer',
                'paid_at' => now()->subDays($daysAgo),
                'total_amount' => $subtotal,
                'customer_name' => $customer->name,
                'phone' => '081234567890',
                'shipping_address' => 'Jl. Bengkel Demo No. 1',
                'notes' => 'Pesanan contoh untuk demo fitur.',
            ]);

            $order->items()->create([
                'product_id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ]);

            $order->statusHistories()->createMany([
                ['status' => 'pending', 'note' => 'Order dibuat, menunggu pembayaran.'],
                ['status' => 'paid', 'note' => 'Pembayaran diterima.'],
                ['status' => 'processing', 'note' => 'Pesanan sedang disiapkan.'],
                ['status' => 'completed', 'note' => 'Pesanan selesai.'],
            ]);

            Review::create([
                'product_id' => $product->id,
                'user_id' => $customer->id,
                'order_id' => $order->id,
                'rating' => $rating,
                'comment' => $comment,
            ]);

            return $order;
        };

        $makeReviewedOrder($products['OLI-1040'], 5, 'Olinya bagus, motor jadi lebih halus. Pengiriman cepat!', 3, 1, 5);
        $makeReviewedOrder($products['REM-CRMC'], 4, 'Pengereman jadi pakem, pemasangan gampang.', 6, 2, 4);
        $makeReviewedOrder($products['BUSI-IRD'], 5, 'Tarikan motor lebih responsif dari sebelumnya.', 8, 3, 3);
        $makeReviewedOrder($products['AKI-MF5'], 4, 'Aki awet, starter langsung nyala.', 10, 4, 2);
        $makeReviewedOrder($products['BAN-R14'], 5, 'Grip mantap buat harian, alurnya bagus.', 12, 5, 6);
    }

    /**
     * Copy the tracked demo product photos (database/seeders/images) into the
     * public storage disk so they survive a fresh clone (storage/app/public
     * itself is gitignored, but these seed assets are not).
     */
    private function copySeedImages(): void
    {
        Storage::disk('public')->makeDirectory('products');

        foreach (File::glob(database_path('seeders/images/*.jpg')) as $path) {
            File::copy($path, storage_path('app/public/products/'.basename($path)));
        }
    }
}
