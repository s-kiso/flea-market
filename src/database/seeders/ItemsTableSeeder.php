<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '腕時計',
            'price' => 15000,
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image' => 'watch.jpg',
            'condition_id' => 1,
            'user_id' => 1,
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'HDD',
            'price' => 5000,
            'description' => '高速で信頼性の高いハードディスク',
            'image' => 'HDD.jpg',
            'condition_id' => 2,
            'user_id' => 1,
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => '玉ねぎ3束',
            'price' => 300,
            'description' => '新鮮な玉ねぎ3束のセット',
            'image' => 'onion.jpg',
            'condition_id' => 3,
            'user_id' => 1,
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => '革靴',
            'price' => 4000,
            'description' => 'クラシックなデザインの革靴',
            'image' => 'shoes.jpg',
            'condition_id' => 4,
            'user_id' => 1,
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'ノートPC',
            'price' => 45000,
            'description' => '高性能なノートパソコン',
            'image' => 'pc.jpg',
            'condition_id' => 1,
            'user_id' => 1,
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'マイク',
            'price' => 8000,
            'description' => '高音質のレコーディング用マイク',
            'image' => 'microphone.jpg',
            'condition_id' => 2,
            'user_id' => 2,
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'description' => 'おしゃれなショルダーバッグ',
            'image' => 'bag.jpg',
            'condition_id' => 3,
            'user_id' => 2,
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'タンブラー',
            'price' => 500,
            'description' => '使いやすいタンブラー',
            'image' => 'tumbler.jpg',
            'condition_id' => 4,
            'user_id' => 2,
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'コーヒーミル',
            'price' => 4000,
            'description' => '手動のコーヒーミル',
            'image' => 'mill.jpg',
            'condition_id' => 1,
            'user_id' => 2,
        ];
        DB::table('items')->insert($param);

        $param = [
            'name' => 'メイクセット',
            'price' => 2500,
            'description' => '便利なメイクアップセット',
            'image' => 'makeup.jpg',
            'condition_id' => 2,
            'user_id' => 2,
        ];
        DB::table('items')->insert($param);
    }
}
