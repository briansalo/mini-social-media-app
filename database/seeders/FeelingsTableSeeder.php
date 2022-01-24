<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class FeelingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('feelings')->delete();
            $feeling = array(
                array('id' => 1,'icon_name' => "far fa-smile",'name' => "happy"),
                array('id' => 2,'icon_name' => "far fa-frown-open",'name' => "sad"),
                array('id' => 3,'icon_name' => "far fa-grin-hearts",'name' => "in love"),
                array('id' => 4,'icon_name' => "far fa-angry",'name' => "mad"),
                array('id' => 5,'icon_name' => "fas fa-surprise",'name' => "shock"),


                );
                DB::table('feelings')->insert($feeling);
    }
}
