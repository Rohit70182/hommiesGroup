<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Str;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'rohit@admin.com',
                'password' => Hash::make('Rohit@1999'),
                'role' => 0,
                'customer_id' => Str::random(16),
            ]
        ]);
    }
}
