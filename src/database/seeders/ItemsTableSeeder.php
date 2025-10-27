<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [];

        $items[] = Item::create([
            'user_id' => null,
            'name' => '腕時計',
            'item_image' => 'items/Armani+Mens+Clock.jpg',
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
            'condition' => '良好',
            'sold' => false
        ]);

        $items[] = Item::create([
            'user_id' => null,
            'name' => 'HDD',
            'item_image' => 'items/HDD+Hard+Disk.jpg',
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'price' => 5000,
            'condition' => '目立った傷や汚れなし',
            'sold' => false
        ]);

        $items[] = Item::create([
            'user_id' => null,
            'name' => '玉ねぎ３束',
            'item_image' => 'items/iLoveIMG+d.jpg',
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ３束セット',
            'price' => 300,
            'condition' => 'やや傷や汚れあり',
            'sold' => false
        ]);

        $items[] = Item::create([
            'user_id' => null,
            'name' => '革靴',
            'item_image' => 'items/Leather+Shoes+Product+Photo.jpg',
            'brand' => '',
            'description' => 'クラシックなデザインの革靴',
            'price' => 4000,
            'condition' => '状態が悪い',
            'sold' => false
        ]);

        $items[] = Item::create([
            'user_id' => null,
            'name' => 'ノートPC',
            'item_image' => 'items/Living+Room+Laptop.jpg',
            'brand' => '',
            'description' => '高性能なノートパソコン',
            'price' => 45000,
            'condition' => '良好',
            'sold' => false
        ]);

        $items[] = Item::create([
            'user_id' => null,
            'name' => 'マイク',
            'item_image' => 'items/Music+Mic+4632231.jpg',
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'price' => 8000,
            'condition' => '目立った傷や汚れなし',
            'sold' => false
        ]);

        $items[] = Item::create([
            'user_id' => null,
            'name' => 'ショルダーバッグ',
            'item_image' => 'items/Purse+fashion+pocket.jpg',
            'brand' => '',
            'description' => 'おしゃれなショルダーバッグ',
            'price' => 3500,
            'condition' => 'やや傷や汚れあり',
            'sold' => false
        ]);

        $items[] = Item::create([
            'user_id' => null,
            'name' => 'タンブラー',
            'item_image' => 'items/Tumbler+souvenir.jpg',
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
            'price' => 500,
            'condition' => '状態が悪い',
            'sold' => false
        ]);

        $items[] = Item::create([
            'user_id' => null,
            'name' => 'コーヒーミル',
            'item_image' => 'items/Waitress+with+Coffee+Grinder.jpg',
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'price' => 4000,
            'condition' => '良好',
            'sold' => false
        ]);

        $items[] = Item::create([
            'user_id' => null,
            'name' => 'メイクセット',
            'item_image' => 'items/MakeUpSet+Women+OutDoor.jpg',
            'brand' => '',
            'description' => '便利なメイクアップセット',
            'price' => 2500,
            'condition' => '目立った傷や汚れなし',
            'sold' => false
        ]);

        // カテゴリーを結びつける
        $items[0]->categories()->attach([1, 5, 12]);
        $items[1]->categories()->attach([2, 3, 8]);
        $items[2]->categories()->attach([10]);
        $items[3]->categories()->attach([1, 5]);
        $items[4]->categories()->attach([2, 8, 13]);
        $items[5]->categories()->attach([2, 8, 13]);
        $items[6]->categories()->attach([1, 4, 12]);
        $items[7]->categories()->attach([5, 9]);
        $items[8]->categories()->attach([3, 10]);
        $items[9]->categories()->attach([1, 4, 6]);
    }
}
