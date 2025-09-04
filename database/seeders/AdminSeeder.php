<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'first_name' => 'Gabriel',
                'last_name' => 'Nwankwo',
                'email' => 'gfunzy@gmail.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => Hash::make("12244190"),
                'role_id' => 1,
                'work_group_id' => 1,
                'token' => Str::random(16),
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($data as $inv) {
            User::updateOrCreate($inv);
        }
    }
}
