<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('genres')->delete();
        \DB::statement("ALTER TABLE genres AUTO_INCREMENT = 1");
        \DB::table('genres')->insert([
            [
                'name' => '寿司'
            ],[
                'name' => '焼肉'
            ],[
                'name' => '居酒屋'
            ],[
                'name' => 'イタリアン'
            ],[
                'name' => 'ラーメン'
            ],
        ]);
    }
}
