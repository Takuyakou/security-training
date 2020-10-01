<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name'              => '管理者',
            'email'             => 'admin@diagram.co.jp',
            'password'          => Hash::make('password'),
            'admin_flg'         => true,
        ]);

        \DB::table('users')->insert([
            'name'              => '一般ユーザー',
            'email'             => 'user@diagram.co.jp',
            'password'          => Hash::make('password'),
            'admin_flg'         => false,
        ]);
    }
}
