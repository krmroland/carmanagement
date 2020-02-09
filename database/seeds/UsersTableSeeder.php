<?php

use App\Users\Models\User;
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
        User::updateOrCreate(
            [ 'email' => 'admin@rentals.com'],
            ['password' => bcrypt('password'), 'name' => 'Admin']
        );
    }
}
