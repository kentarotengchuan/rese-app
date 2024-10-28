<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        \DB::table('areas')->delete();
        \DB::statement("ALTER TABLE areas AUTO_INCREMENT = 1");
        \DB::table('areas')->insert([
        [
            'name' => '東京都',
        ],[
            'name' => '大阪府',
        ],[
            'name' => '福岡県',
        ],       
        ]);
    }
}
