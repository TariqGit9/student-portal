<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AdminDetails extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $User = User::updateOrCreate(
            [
                'id' => '1',
            ],
            [
           'id' => '1',
            'name' => 'super_admin',
            'user_name' => 'super_admin',
            'email' => 'super_admin@admin.com',
            'avatar' => 'default.webp',
            'password' => Hash::make('sdassdas'),
            'role_id' => '4',
            'status' => '1',
        ]);
        $User = User::updateOrCreate(
            [
                'id' => '2',
            ],
            [
           'id' => '2',
            'name' => 'admin',
            'user_name' => 'admin',
            'email' => 'admin@admin.com',
            'avatar' => 'default.webp',
            'password' => Hash::make('sdassdas'),
            'role_id' => '1',
            'school_id' => '1',
            'status' => '1',
        ]);
        $User = User::updateOrCreate(
            [
                'id' => '3',
            ],
            [
           'id' => '3',
            'name' => 'admin',
            'user_name' => 'admin2',
            'email' => 'admin2@admin.com',
            'avatar' => 'default.webp',
            'password' => Hash::make('sdassdas'),
            'role_id' => '1',
            'school_id' => '2',
            'status' => '1',
        ]);
    }
}
