<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'password' => 'qwerty',
            'nama' => 'Administrator',
        ]);
        User::create([
            'username' => 'sonya',
            'password' => 'qwerty',
            'nama' => 'Sonya Dinda F.',
        ]);
    }
}
