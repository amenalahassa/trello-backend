<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Al am',
            'email' => 'am@yao.com',
            'password' => bcrypt('12345678')
        ]);
    }
}
