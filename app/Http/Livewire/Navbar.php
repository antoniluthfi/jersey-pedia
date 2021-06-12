<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Liga;
use App\Models\Pesanan;
use App\Models\PesananDetail;

class Navbar extends Component
{
    public $jumlah = 0;
    protected $listeners = [
        'masukKeranjang' => 'updateKeranjang'
    ];

    public function updateKeranjang()
    {
        if(Auth::check()) {
            $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
            if($pesanan) {
                $this->jumlah = PesananDetail::where('pesanan_id', $pesanan->id)->count();
            } else {
                $this->jumlah = 0;
            }
        }
    }

    public function mount()
    {
        if(Auth::check()) {
            $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
            if($pesanan) {
                $this->jumlah = PesananDetail::where('pesanan_id', $pesanan->id)->count();
            } else {
                $this->jumlah = 0;
            }
        }
    }

    public function render()
    {
        return view('livewire.navbar', [
            'ligas' => Liga::all(),
        ]);
    }
}
