<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inserts = [];

        for($i = 1; $i < 4; $i++) {
            $inserts[] = [
                'category_id' => 1,
                'title' => 'タイトル' . $i,
                'content' => '本文' . $i
            ];
        }

        DB::table('posts')->insert($inserts);
    }
}
