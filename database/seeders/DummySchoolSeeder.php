<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolInformation;
use App\Models\SchoolSession;
class DummySchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grade = SchoolInformation::updateOrCreate([
            'id' => '1',
            'school_unique_id' => time().'1',
            'name' => 'School System',
            'abbreviation' => 'SCH',
            'email' => 'admin2@admin.com',
            'phone' => '0122333333',
            'phone2' => '0122333333',
            'address' => 'address',
            'details' => 'address',

        ]);
        $grade = SchoolInformation::updateOrCreate([
            'id' => '2',
            'school_unique_id' => time().'2',
            'name' => 'Second School System',
            'abbreviation' => 'SSS',
            'email' => 'admin2@admin.com',
            'phone' => '0122333333',
            'phone2' => '0122333333',
            'address' => 'address',
            'details' => 'address',

        ]);
        $grade = SchoolSession::updateOrCreate([
            'id' => '1',
            'school_id' => 1,
            'name' => 'Session 21-22',
            'status' => 1,
        ]);
        $grade = SchoolSession::updateOrCreate([
            'id' => '2',
            'school_id' => 2,
            'name' => 'Session 21-22',
            'status' => 1,
        ]);


    }
}
