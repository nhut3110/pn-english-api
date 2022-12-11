<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            DB::table('student')->insert([
                'full_name' => $faker->name,
                'student_phone' => $faker->e164PhoneNumber,
                'parent_phone' => $faker->e164PhoneNumber,
                'student_email' => $faker->email,
                'age' => $faker->numberBetween($min = 15, $max = 45),
                'address' => $faker->address,
                'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
                'current_class_id' => $faker->numberBetween($min = 1, $max = 10),
                'is_paid' => $faker->boolean($chanceOfGettingTrue = 50),
                'start_date'=>Carbon::now()->format('Y-m-d H:i:s'),
                'end_date'=>Carbon::now()->format('Y-m-d H:i:s'),
                'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')
           ]);
        }
    }
}
