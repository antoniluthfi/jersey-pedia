<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Product;
use App\Models\Liga;
use Livewire\WithPagination;

class Admin extends Component
{
    use WithPagination;

    public $search, $product_id;
    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        if(!Auth::check() || !Auth::user()->role == 'admin') {
            return redirect('/');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function masukkanID($id)
    {
        $this->product_id = $id;
    }

    public function hapusProduk($id) 
    {
        $product = Product::find($id);
        if($product) {
            $product->delete();

            // remove image
            $nama_gambar_lama = explode('/', $product->gambar);
            $nama_gambar_lama = end($nama_gambar_lama);       
            unlink(public_path('/storage/photos/' . $nama_gambar_lama)); 
        }
    }

    public function render()
    {
        if($this->search) {
            $product = Product::where('nama', 'like', '%'.$this->search.'%')->orderBy('id', 'desc')->paginate(10);
        } else {
            $product = Product::orderBy('id', 'desc')->paginate(12);
        }

        return view('livewire.admin', [
            'products' => $product
        ])->extends('layouts.app')->section('content');
    }
}
