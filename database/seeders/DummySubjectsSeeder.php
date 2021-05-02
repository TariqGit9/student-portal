<?php

namespace Database\Seeders;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class DummySubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grade = Subject::updateOrCreate([
            'id' => '1',
            'school_id' => '1',
            'grade_id' => 1,
            'name' => 'English 1',
        ]);
        $grade = Subject::updateOrCreate([
            'id' => '2',
            'school_id' => '1',
            'grade_id' => 2,
            'name' => 'English 2',
        ]);
        $grade = Subject::updateOrCreate([
            'id' => '3',
            'school_id' => '1',
            'grade_id' => 3,
            'name' => 'English 3',
        ]);
        $grade = Subject::updateOrCreate([
            'id' => '4',
            'school_id' => '1',
            'grade_id' => 1,
            'name' => 'Urdu 1',
        ]);
        $grade = Subject::updateOrCreate([
            'id' => '5',
            'school_id' => '1',
            'grade_id' => 2,
            'name' => 'Urdu 2',
        ]);
        $grade = Subject::updateOrCreate([
            'id' => '6',
            'school_id' => '1',
            'grade_id' => 3,
            'name' => 'Urdu 3',
        ]);
        $grade = Subject::updateOrCreate([
            'id' => '7',
            'school_id' => '1',
            'grade_id' => 1,
            'name' => 'Math 1',
        ]);
        $grade = Subject::updateOrCreate([
            'id' => '8',
            'school_id' => '1',
            'grade_id' => 2,
            'name' => 'Math 2',
        ]);
        $grade = Subject::updateOrCreate([
            'id' => '9',
            'school_id' => '1',
            'grade_id' => 3,
            'name' => 'Math 3',
        ]);
        $grade = Subject::updateOrCreate([
            'id' => '10',
            'school_id' => '1',
            'grade_id' => 1,
            'name' => 'Islamiat 1',
        ]);
        $grade = Subject::updateOrCreate([
            'id' => '11',
            'school_id' => '1',
            'grade_id' => 2,
            'name' => 'Islamiat 2',
        ]);
        $grade = Subject::updateOrCreate([
            'id' => '12',
            'school_id' => '1',
            'grade_id' => 3,
            'name' => 'Islamiat 3',
        ]);
       
    }
}
