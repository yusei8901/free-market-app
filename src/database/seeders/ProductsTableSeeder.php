<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [];

        $products[] = Product::create([
            'user_id' => null,
            'name' => '腕時計',
            'product_image' => 'products/Armani+Mens+Clock.jpg',
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
            'condition' => '良好',
            'sold' => false
        ]);

        $products[] = Product::create([
            'user_id' => null,
            'name' => 'HDD',
            'product_image' => 'products/HDD+Hard+Disk.jpg',
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'price' => 5000,
            'condition' => '目立った傷や汚れなし',
            'sold' => false
        ]);

        $products[] = Product::create([
            'user_id' => null,
            'name' => '玉ねぎ３束',
            'product_image' => 'products/iLoveIMG+d.jpg',
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ３束セット',
            'price' => 300,
            'condition' => 'やや傷や汚れあり',
            'sold' => false
        ]);

        $products[] = Product::create([
            'user_id' => null,
            'name' => '革靴',
            'product_image' => 'products/Leather+Shoes+Product+Photo.jpg',
            'brand' => '',
            'description' => 'クラシックなデザインの革靴',
            'price' => 4000,
            'condition' => '状態が悪い',
            'sold' => false
        ]);

        $products[] = Product::create([
            'user_id' => null,
            'name' => 'ノートPC',
            'product_image' => 'products/Living+Room+Laptop.jpg',
            'brand' => '',
            'description' => '高性能なノートパソコン',
            'price' => 45000,
            'condition' => '良好',
            'sold' => false
        ]);

        $products[] = Product::create([
            'user_id' => null,
            'name' => 'マイク',
            'product_image' => 'products/Music+Mic+4632231.jpg',
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'price' => 8000,
            'condition' => '目立った傷や汚れなし',
            'sold' => false
        ]);

        $products[] = Product::create([
            'user_id' => null,
            'name' => 'ショルダーバッグ',
            'product_image' => 'products/Purse+fashion+pocket.jpg',
            'brand' => '',
            'description' => 'おしゃれなショルダーバッグ',
            'price' => 3500,
            'condition' => 'やや傷や汚れあり',
            'sold' => false
        ]);

        $products[] = Product::create([
            'user_id' => null,
            'name' => 'タンブラー',
            'product_image' => 'products/Tumbler+souvenir.jpg',
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
            'price' => 500,
            'condition' => '状態が悪い',
            'sold' => false
        ]);

        $products[] = Product::create([
            'user_id' => null,
            'name' => 'コーヒーミル',
            'product_image' => 'products/Waitress+with+Coffee+Grinder.jpg',
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'price' => 4000,
            'condition' => '良好',
            'sold' => false
        ]);

        $products[] = Product::create([
            'user_id' => null,
            'name' => 'メイクセット',
            'product_image' => 'products/MakeUpSet+Women+OutDoor.jpg',
            'brand' => '',
            'description' => '便利なメイクアップセット',
            'price' => 2500,
            'condition' => '目立った傷や汚れなし',
            'sold' => false
        ]);

        // カテゴリーを結びつける
        $products[0]->categories()->attach([1, 5, 12]);
        $products[1]->categories()->attach([2, 3, 8]);
        $products[2]->categories()->attach([10]);
        $products[3]->categories()->attach([1, 5]);
        $products[4]->categories()->attach([2, 8, 13]);
        $products[5]->categories()->attach([2, 8, 13]);
        $products[6]->categories()->attach([1, 4, 12]);
        $products[7]->categories()->attach([5, 9]);
        $products[8]->categories()->attach([3, 10]);
        $products[9]->categories()->attach([1, 4, 6]);
    }
}
