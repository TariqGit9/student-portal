<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Roles;
class UserRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Role = Roles::updateOrCreate([
            'id' => '1',
            'name' => 'admin',
          //  'type' => '0',
      
        ]);
        $Role = Roles::updateOrCreate([
            'id' => '2',
            'name' => 'teacher',
          //  'type' => '0',
           
        ]);
        $Role = Roles::updateOrCreate([
            'id' => '3',
            'name' => 'student',
         //   'type' => '0',
        ]);
    }
}
