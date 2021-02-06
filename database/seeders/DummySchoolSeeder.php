<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolInformation;

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
            'name' => 'School System',
            'abrevation' => 'SCH',
            'phone' => '0122333333',
            'phone2' => '0122333333',
            'address' => 'address',
            'details' => 'address',

            ]);
    }
}
