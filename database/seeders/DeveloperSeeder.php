<?php

namespace Database\Seeders;

use App\Models\Developer;
use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 6; $i++){
            $developer = new Developer();
            $developer->name = "Dev {$i}";
            $developer->difficult = $i;

            $developer->save();
        }
    }
}
