<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'ユーザー1',
            'email' => 'test1@example.com',
            'email_verified_at' => '2025-09-15 1:00:00',
            'password' => Hash::make('password'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'ユーザー2',
            'email' => 'test2@example.com',
            'email_verified_at' => '2025-09-15 1:00:00',
            'password' => Hash::make('password'),
        ];
        DB::table('users')->insert($param);
    }
}
