<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_path = 'http://127.0.0.1:8000/assets/jersey/';

        DB::table('products')->insert([
        	'nama' => 'CHELSEA 3RD 2018-2019',
            'liga_id' => 2,
            'gambar' => $file_path . 'chelsea.png'
        ]);

        DB::table('products')->insert([
        	'nama' => 'LEICESTER CITY HOME 2018-2019',
            'liga_id' => 2,
            'gambar' => $file_path . 'leicester.png'
        ]);

        DB::table('products')->insert([
        	'nama' => 'MAN. UNITED AWAY 2018-2019',
            'liga_id' => 2,
            'gambar' => $file_path . 'mu.png'
        ]);

        DB::table('products')->insert([
        	'nama' => 'LIVERPOOL AWAY 2018-2019',
            'liga_id' => 2,
            'gambar' => $file_path . 'liverpool.png'
        ]);

        DB::table('products')->insert([
        	'nama' => 'TOTTENHAM 3RD 2018-2019',
            'liga_id' => 2,
            'gambar' => $file_path . 'tottenham.png'
        ]);

        DB::table('products')->insert([
        	'nama' => 'DORTMUND AWAY 2018-2019',
            'liga_id' => 1,
            'gambar' => $file_path . 'dortmund.png'
        ]);

        DB::table('products')->insert([
        	'nama' => 'BAYERN MUNCHEN 3RD 2018 2019',
            'liga_id' => 1,
            'gambar' => $file_path . 'munchen.png'
        ]);

        DB::table('products')->insert([
        	'nama' => 'JUVENTUS AWAY 2018-2019',
            'liga_id' => 4,
            'gambar' => $file_path . 'juve.png'
        ]);

        DB::table('products')->insert([
        	'nama' => 'AS ROMA HOME 2018-2019',
            'liga_id' => 4,
            'gambar' => $file_path . 'asroma.png'
        ]);

        DB::table('products')->insert([
        	'nama' => 'AC MILAN HOME 2018 2019',
            'liga_id' => 4,
            'gambar' => $file_path . 'acmilan.png'
        ]);

        DB::table('products')->insert([
        	'nama' => 'LAZIO HOME 2018-2019',
            'liga_id' => 4,
            'gambar' => $file_path . 'lazio.png'
        ]);

        DB::table('products')->insert([
        	'nama' => 'REAL MADRID 3RD 2018-2019',
            'liga_id' => 3,
            'gambar' => $file_path . 'madrid.png'
        ]);
    }
}