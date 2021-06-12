<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pesanan;
use Midtrans\Config;

class History extends Component
{
    use WithPagination;

    public $pesanans, $status;
    protected $paginationTheme = 'bootstrap';

    public function getTransactionStatus($id)
    {
        Config::$serverKey = env('MIDTRANS_SERVERKEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = false;
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;
        $status = \Midtrans\Transaction::status($id);
        $this->status = json_decode(json_encode($status), true);
        // dd($this->status);
    }

    public function render()
    {
        if(Auth::check()) {
            $this->pesanans = Pesanan::where('user_id', Auth::user()->id)->where('status', '!=', 0)->orderBy('id', 'desc')->get();
        }

        return view('livewire.history')->extends('layouts.app')->section('content');
    }
}
