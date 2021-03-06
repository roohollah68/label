<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name'=>'admin',
            'username'=>'admin',
            'phone'=>'09384902913',
            'verified'=>true,
            'role'=>'admin',
            'password'=>bcrypt('admin1234'),
            'telegram_code' => Str::random(40),
        ]);
    }
}
