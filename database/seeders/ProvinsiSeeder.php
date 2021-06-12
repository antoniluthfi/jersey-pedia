<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use App\Models\Provinsi;
use App\Models\Kota;

class ProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $daftarProvinsi = RajaOngkir::provinsi()->all();
        foreach ($daftarProvinsi as $provinsi) {
            Provinsi::create([
                'province_id' => $provinsi['province_id'],
                'title' => $provinsi['province']
            ]);

            $daftarKota = RajaOngkir::kota()->dariProvinsi($provinsi['province_id'])->get();
            foreach ($daftarKota as $kota) {
                Kota::create([
                    'province_id' => $kota['province_id'],
                    'city_id' => $kota['city_id'],
                    'title' => $kota['city_name']
                ]);
            }
        }
    }
}
