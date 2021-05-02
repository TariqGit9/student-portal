<?php

namespace Database\Seeders;
use App\Models\ClassGrade;
use Illuminate\Database\Seeder;

class ClassGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grade = ClassGrade::updateOrCreate([
            'id' => '1',
            'school_id' => '1',
            'name' => 'Grade 1',
        ]);
        $grade = ClassGrade::updateOrCreate([
            'id' => '2',
            'school_id' => '1',
            'name' => 'Grade 2',
        ]);
        $grade = ClassGrade::updateOrCreate([
            'id' => '3',
            'school_id' => '1',
            'name' => 'Grade 3',
        ]);
        $grade = ClassGrade::updateOrCreate([
            'id' => '4',
            'school_id' => '1',
            'name' => 'Grade 4',
        ]);
        $grade = ClassGrade::updateOrCreate([
            'id' => '5',
            'school_id' => '1',
            'name' => 'Grade 5',
        ]);
        $grade = ClassGrade::updateOrCreate([
            'id' => '6',
            'school_id' => '1',
            'name' => 'Grade 6',
        ]);
        $grade = ClassGrade::updateOrCreate([
            'id' => '7',
            'school_id' => '1',
            'name' => 'Grade 7',
        ]);
        $grade = ClassGrade::updateOrCreate([
            'id' => '8',
            'school_id' => '1',
            'name' => 'Grade 8',
        ]);
        $grade = ClassGrade::updateOrCreate([
            'id' => '9',
            'school_id' => '1',
            'name' => 'Grade 9',
        ]);
        $grade = ClassGrade::updateOrCreate([
            'id' => '10',
            'school_id' => '1',
            'name' => 'Grade 10',
        ]);
        $grade = ClassGrade::updateOrCreate([
            'id' => '11',
            'school_id' => '1',
            'name' => 'Nursery',
        ]);
    }
}
