<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//run this
//php artisan db:seed --class=DatabaseSeeder
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminDetails::class,
            ClassGradeSeeder::class,
            UserRoles::class,
            DummySubjectsSeeder::class,
            DummySchoolSeeder::class,
            DummyResultTypesSeeder::class,

            //DummyResultTypesSeeder
        ]);
    }
}
