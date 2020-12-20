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
            'name' => 'admin',
            'user_name' => 'support_admin',
            'email' => 'support@pkteam.com',
            'avatar' => 'N/A',
            'password' => Hash::make('sdassdas'),
            'role_id' => '1',
            'status' => '1',
        ]);
    }
}
