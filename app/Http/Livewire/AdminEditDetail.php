<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Liga;
use Livewire\WithFileUploads;
use App\Models\Product;

class AdminEditDetail extends Component
{
    use WithFileUploads;

    public $product, $ligas, $nama, $harga_satuan, $harga_nameset, $liga, $is_ready, $berat, $gambar;

    public function mount($id)
    {
        if(!Auth::check() || !Auth::user()->role == 'admin') {
            return redirect('/login');
        }

        $this->ligas = Liga::all();

        $this->product = Product::find($id);

        if($this->product) {
            $this->nama = $this->product->nama;
            $this->harga_satuan = intval($this->product->harga);
            $this->harga_nameset = intval($this->product->harga_nameset);
            $this->liga = $this->product->liga_id;
            $this->is_ready = $this->product->is_ready;
            $this->berat = $this->product->berat * 1000;
        }
    }

    public function updateProduk()
    {
        $this->validate([
            'nama' => 'required',
            'harga_satuan' => 'required',
            'harga_nameset' => 'required',
            'liga' => 'required',
            'berat' => 'required',
            'gambar' => 'image|max:2048', 
        ]);

        // remove old image 
        $nama_gambar_lama = explode('/', $this->product->gambar);
        $nama_gambar_lama = end($nama_gambar_lama);       
        unlink(public_path('/storage/photos/' . $nama_gambar_lama)); 

        // create new image
        $file = \Storage::disk('public')->put('photos', $this->gambar);
        $protocol = current(explode('/',$_SERVER['SERVER_PROTOCOL']));
        $file_path = strtolower($protocol) . '://' . $_SERVER['HTTP_HOST'] . '/storage/' . $file;
        
        // update product
        $this->product->nama = strtoupper($this->nama);
        $this->product->harga = $this->harga_satuan;
        $this->product->harga_nameset = $this->harga_nameset;
        $this->product->liga_id = $this->liga;
        $this->product->is_ready = $this->is_ready;
        // $this->product->berat = $this->berat / 1000;
        $this->product->gambar = $file_path;
        $this->product->update();

        return redirect('/admin');
    }

    public function render()
    {
        return view('livewire.admin-edit-detail')->extends('layouts.app')->section('content');
    }
}
