<?php

use App\User;
use Illuminate\Support\Facades\Hash;
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
        $user = User::where('email', 'ashrafkabir95@gmail.com')->first();

        if (!$user) {
            User::create([
                'name' => 'Ashraf Kabir',
                'email' => 'ashrafkabir95@gmail.com',
                'status' => 1,
                'role' => 'admin',
                'password' => Hash::make('12345678')
            ]);
        }
    }
}
