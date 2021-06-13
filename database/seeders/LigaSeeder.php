<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LigaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_path = 'http://127.0.0.1:8000/assets/liga/';

        DB::table('ligas')->insert([
        	'nama' => 'Bundes Liga',
        	'negara' => 'Jerman',
        	'gambar' => $file_path . 'bundesliga.png',
        ]);

        DB::table('ligas')->insert([
        	'nama' => 'Premier League',
        	'negara' => 'Inggris',
        	'gambar' => $file_path . 'premierleague.png',
        ]);

        DB::table('ligas')->insert([
        	'nama' => 'La Liga',
        	'negara' => 'Spanyol',
        	'gambar' => $file_path . 'laliga.png',
        ]);

        DB::table('ligas')->insert([
        	'nama' => 'Serie A',
        	'negara' => 'Itali',
        	'gambar' => $file_path . 'seriea.png',
        ]);
    }
}
