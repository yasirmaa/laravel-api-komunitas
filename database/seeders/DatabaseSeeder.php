<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'firstname' => 'Yasir',
            'lastname' => 'Maarif',
            'username' => 'yasirma',
            'email' => 'yasir@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        User::create([
            'firstname' => 'Badang',
            'lastname' => 'Epic',
            'username' => 'badang',
            'email' => 'badang@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        User::create([
            'firstname' => 'Abdul',
            'lastname' => 'Mamad',
            'username' => 'abdul',
            'email' => 'abdul@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        Category::create([
            'name' => 'Kendaraan',
            'slug' => 'kendaraan'
        ]);
        Category::create([
            'name' => 'Pakaian',
            'slug' => 'pakaian'
        ]);
        Category::create([
            'name' => 'Alat Musik',
            'slug' => 'alat-musik'
        ]);

        Product::create([
            'name' => 'Vario 125',
            'stock' => '1',
            'price' => '10000000',
            'description' => 'Vario 125 CBS dijual dengan harga Rp 21.000.000 juta sementara tipe CBS-ISS Rp 21.900.000 juta.',
            'user_id' => 2,
            'category_id' => 1
        ]);
        Product::create([
            'name' => 'Vario 150',
            'stock' => '1',
            'price' => '20000000',
            'description' => 'Vario 125 CBS dijual dengan harga Rp 21.000.000 juta sementara tipe CBS-ISS Rp 21.900.000 juta.',
            'user_id' => 2,
            'category_id' => 1
        ]);
        Product::create([
            'name' => 'Vario 160',
            'stock' => '1',
            'price' => '25000000',
            'description' => 'Vario 125 CBS dijual dengan harga Rp 21.000.000 juta sementara tipe CBS-ISS Rp 21.900.000 juta.',
            'user_id' => 2,
            'category_id' => 1
        ]);

        Product::create([
            'name' => 'Gitar bekas',
            'stock' => '1',
            'price' => '200000',
            'description' => 'Secara umum, gitar terbagi atas 2 jenis: akustik dan elektrik. Gitar akustik, dengan bagian badannya yang berlubang (hollow body), telah digunakan selama ribuan tahun. Terdapat tiga jenis utama gitar akustik modern: gitar akustik senar-nilon, gitar akustik senar-baja, dan gitar archtop.',
            'user_id' => 1,
            'category_id' => 2
        ]);
        Product::create([
            'name' => 'Gitar bekas hitam',
            'stock' => '1',
            'price' => '200000',
            'description' => 'Secara umum, gitar terbagi atas 2 jenis: akustik dan elektrik. Gitar akustik, dengan bagian badannya yang berlubang (hollow body), telah digunakan selama ribuan tahun. Terdapat tiga jenis utama gitar akustik modern: gitar akustik senar-nilon, gitar akustik senar-baja, dan gitar archtop.',
            'user_id' => 2,
            'category_id' => 1
        ]);

        Comment::create([
            'user_id' => '1',
            'product_id' => '1',
            'content' => 'Harga berapa bang?'
        ]);
        Comment::create([
            'user_id' => '3',
            'product_id' => '1',
            'content' => 'Harga berapa bang? sama kandang'
        ]);
    }
}
