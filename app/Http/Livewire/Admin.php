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

    public $search;
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
