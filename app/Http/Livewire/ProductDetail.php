<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Product;
use App\Models\Pesanan;
use App\Models\PesananDetail;

class ProductDetail extends Component
{
    public $product, $nama, $nomor, $jumlah_pesanan = 1;

    public function mount($id)
    {
        $this->product = Product::find($id);
    }

    public function masukkanKeranjang()
    {
        $this->validate([
            'jumlah_pesanan' => 'required'
        ]);
    
        // check user sudah login atau belum kalo ingin beli
        if(!Auth::check()) {
            return redirect('/login');
        }

        // hitung harga dari total barang
        // cek apakah user pesan nameset juga atau tidak
        if(!empty($this->nama)) {
            $total_harga = $this->jumlah_pesanan * $this->product->harga + $this->product->harga_nameset;
        } else {
            $total_harga = $this->jumlah_pesanan * $this->product->harga;
        }

        // cek apakah user memliki keranjang yg belum dibayar
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
        
        if(empty($pesanan)) {
            Pesanan::create([
                'user_id' => Auth::user()->id,
                'total_harga' => $total_harga,
                'status' => 0,
                'kode_unik' => mt_rand(100, 999)
            ]);

            $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
            $pesanan->kode_pemesanan = 'JP.'.$pesanan->id;
            $pesanan->update();
        } else {
            $pesanan->total_harga = $pesanan->total_harga + $total_harga;
            $pesanan->update();
        }

        PesananDetail::create([
            'product_id' => $this->product->id,
            'pesanan_id' => $pesanan->id,
            'jumlah_pesanan' => $this->jumlah_pesanan,
            'nameset' => $this->nama ? true : false,
            'nama' => $this->nama,
            'nomor' => $this->nomor,
            'total_harga' => $total_harga
        ]);

        $this->emit('masukKeranjang');

        session()->flash('message', 'Sukses masukkan keranjang');
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.product-detail')->extends('layouts.app')->section('content');;
    }
}
