<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Liga;
use Livewire\WithFileUploads;
use App\Models\Product;

class AdminDetail extends Component
{
    use WithFileUploads;

    public $ligas, $nama, $harga_satuan, $harga_nameset, $liga, $is_ready, $berat, $gambar;

    public function mount()
    {
        if(!Auth::check() || !Auth::user()->role == 'admin') {
            return redirect('/login');
        }

        $this->ligas = Liga::all();
    }

    public function tambahProduk()
    {
        $this->validate([
            'nama' => 'required',
            'harga_satuan' => 'required',
            'harga_nameset' => 'required',
            'liga' => 'required',
            'berat' => 'required',
            'gambar' => 'image|max:2048', 
        ]);

        $file = \Storage::disk('public')->put('photos', $this->gambar);
        $protocol = current(explode('/',$_SERVER['SERVER_PROTOCOL']));
        $file_path = strtolower($protocol) . '://' . $_SERVER['HTTP_HOST'] . '/storage/' . $file;

        Product::create([
            'nama' => strtoupper($this->nama),
            'harga' => $this->harga_satuan,
            'harga_nameset' => $this->harga_nameset,
            'liga_id' => $this->liga,
            'is_ready' => $this->is_ready,
            // 'berat' => $this->berat / 1000,
            'gambar' => $file_path
        ]);

        return redirect('/admin');
    }

    public function render()
    {
        return view('livewire.admin-detail')->extends('layouts.app')->section('content');
    }
}
