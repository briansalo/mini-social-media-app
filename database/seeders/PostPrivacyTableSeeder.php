<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;


class PostPrivacyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('postprivacies')->delete();
            $postprivacy = array(
                array('id' => 1,'name' => "Public"),
                array('id' => 2,'name' => "Only Friends"),

                );
                DB::table('postprivacies')->insert($postprivacy);
    }
}
