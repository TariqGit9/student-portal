<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResultType;

class DummyResultTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ResultType::updateOrCreate([
            'id' => '1',
            'school_id' => '1',
            'name' => 'Test',
            'status' => '1',
            ]);
    
        $types = ResultType::updateOrCreate([
            'id' => '2',
            'school_id' => '1',
            'name' => 'Home work',
            'status' => '1',
            ]);
        $types = ResultType::updateOrCreate([
            'id' => '3',
            'school_id' => '1',
            'name' => 'Mid Term',
            'status' => '1',
            ]);
    
        $types = ResultType::updateOrCreate([
            'id' => '4',
            'school_id' => '1',
            'name' => 'Final Term',
            'status' => '1',
            ]);
    }
}
