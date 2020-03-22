<?php

use App\Users\Entities\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@rentals.com'],
            ['password' => bcrypt('password'), 'name' => 'Admin']
        );
    }
}
