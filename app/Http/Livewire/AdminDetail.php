<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Liga;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class AdminDetail extends Component
{
    use WithFileUploads;

    public $ligas, $nama = 'test', $gambar;

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
            'gambar' => 'image|max:2048', 
        ]);

        Storage::disk('public')->putFileAs('assets/jersey', $this->gambar, $this->nama . "." . $this->gambar->extension());
    }

    public function render()
    {
        return view('livewire.admin-detail')->extends('layouts.app')->section('content');
    }
}