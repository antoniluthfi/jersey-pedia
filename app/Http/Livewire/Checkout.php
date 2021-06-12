<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\User;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kurir;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Midtrans\Config;

class Checkout extends Component
{
    public $pesanan_id, $total_harga, $berat, $nohp, $alamat, $provinsi, $kab_kota, $kurir, $tokenMidtrans;
    public $buttonVisible = 1;
    public $cek_ongkir = '(belum termasuk ongkir)';

    private function getMidtransToken()
    {
        if(Auth::check()) {
            // Set your Merchant Server Key
            Config::$serverKey = env('MIDTRANS_SERVERKEY');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            Config::$isProduction = false;
            // Set sanitization on (default)
            Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            Config::$is3ds = true;
            
            $params = array(
                'transaction_details' => array(
                    'order_id' => $this->pesanan_id,
                    'gross_amount' => $this->total_harga,
                ),
                'customer_details' => array(
                    'first_name' => Auth::user()->name,
                    'last_name' => '',
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->nohp ? Auth::user()->nohp : $this->nohp,
                ),
            );        
    
            $this->tokenMidtrans = \Midtrans\Snap::getSnapToken($params);        
        }
    }

    public function mount()
    {
        if(!Auth::check()) {
            return redirect('/login');
        }
    
        $this->nohp = Auth::user()->nohp;
        $this->alamat = Auth::user()->alamat;

        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
        if(!empty($pesanan)) {
            $this->pesanan_id = $pesanan->id;
            $this->total_harga = $pesanan->total_harga + $pesanan->kode_unik;

            $pesanan_details = PesananDetail::with('product')
                            ->where('pesanan_id', $pesanan->id)
                            ->get();
            
            $berat = 0;
            foreach($pesanan_details as $pesanan_detail) {
                $berat += $pesanan_detail->jumlah_pesanan * $pesanan_detail->product->berat * 1000;
            }
            $this->berat = $berat;
        } else {
            return redirect('/');
        }
    }

    public function checkout()
    {
        $this->validate([
            'nohp' => 'required',
            'alamat' => 'required'
        ]);

        // simpan nomor hp dan alamat ke data user
        $user = User::find(Auth::user()->id);
        $user->nohp = $this->nohp;
        $user->alamat = $this->alamat;
        $user->update();

        // get kurir
        $kurir = Kurir::where('code', $this->kurir)->first();

        if($this->buttonVisible == 1 && $this->cek_ongkir == '(belum termasuk ongkir)') {
            session()->flash('danger', 'Silahkan pilih kurir ekspedisi terlebih dahulu!');
        } else {
            // update pesanan
            $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
            $pesanan->total_harga = $this->total_harga;
            $pesanan->status = 1;
            $pesanan->kurir_id = $kurir->id;
            $pesanan->update();

            $this->emit('masukKeranjang');
            session()->flash('message', 'Checkout sukses');
        }
    }

    public function tambahOngkir($ongkir) 
    {
        $this->buttonVisible = 0;
        $this->total_harga += $ongkir;
        $this->cek_ongkir = '(sudah termasuk ongkir)';
        $this->getMidtransToken();
    }

    public function render()
    {
        $daftarProvinsi = Provinsi::all();
        $daftarKurir = Kurir::all();

        $daftarKota = [];
        if($this->provinsi) {
            $daftarKota = Kota::where('province_id', $this->provinsi)->get();
        }

        $ongkir = [];
        if($this->provinsi && $this->kab_kota && $this->kurir) {
            $ongkir = RajaOngkir::ongkir([
                'origin'        => 35,     // ID kota/kabupaten asal
                'destination'   => $this->kab_kota,      // ID kota/kabupaten tujuan
                'weight'        => intval($this->berat),    // berat barang dalam gram
                'courier'       => $this->kurir    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
            ]);

            $ongkir = (array) $ongkir;
        }

        return view('livewire.checkout', [
            'daftar_provinsi' => $daftarProvinsi,
            'daftar_kota' => $daftarKota,
            'daftar_kurir' => $daftarKurir,
            'ongkir' => $ongkir
        ])->extends('layouts.app')->section('content');
    }
}
