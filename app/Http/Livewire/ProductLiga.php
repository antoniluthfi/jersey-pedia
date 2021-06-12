<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Liga;

class ProductLiga extends Component
{
    use WithPagination;

    public $search, $liga;
    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';
    
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($id)
    {
        $this->liga = Liga::find($id);
    }

    public function render()
    {
        if($this->search) {
            $product = Product::where('liga_id', $this->liga->id)->where('nama', 'LIKE', '%'.$this->search.'%')->paginate(8);
        } else {    
            $product = Product::where('liga_id', $this->liga->id)->paginate(8);
        }

        return view('livewire.product-index', [
            'products' => $product,
            'title' => 'Jersey ' . $this->liga->nama
        ])->extends('layouts.app')->section('content');
    }
}
