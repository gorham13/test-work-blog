<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!User::where('name', 'admin')->exists()){
            User::create([
                'name' => 'admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('secret'),
                'remember_token' => str_random(10),
                'role' => 'admin'
            ]);
        }
    }
}
