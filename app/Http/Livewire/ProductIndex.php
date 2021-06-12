<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class ProductIndex extends Component
{
    use WithPagination;

    public $search;
    protected $queryString = ['search'];
    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if($this->search) {
            $product = Product::where('nama', 'like', '%'.$this->search.'%')->orderBy('id', 'desc')->paginate(8);
        } else {
            $product = Product::orderBy('id', 'desc')->paginate(8);
        }

        return view('livewire.product-index', [
            'products' => $product,
            'title' => 'List Jersey'
        ])->extends('layouts.app')->section('content');
    }
}
