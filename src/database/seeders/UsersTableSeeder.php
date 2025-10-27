<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
        'name' => 'テストユーザー１',
        'email' => 'test@test',
        'password' => Hash::make('12345678'),
        'profile_image' => 'profile/Armani+Mens+Clock.jpg',
        'postal_code' => '333-5555',
        'address' => '東京都',
        'building' => '東京スカイツリー',
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'テストユーザー２',
            'email' => 'test2@test2',
            'password' => Hash::make('12345678'),
            'profile_image' => 'profile/Living+Room+Laptop.jpg',
            'postal_code' => '999-0000',
            'address' => '京都府',
            'building' => '京都タワー',
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'テストユーザー３',
            'email' => 'test3@test3',
            'password' => Hash::make('12345678'),
            'profile_image' => 'profile/Waitress+with+Coffee+Grinder.jpg',
            'postal_code' => '123-4567',
            'address' => '福岡県',
            'building' => 'PayPayドーム',
        ];
        DB::table('users')->insert($param);
    }
}
