<div class="container">
    <div class="row mb-2">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Admin</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if (session()->has('message'))
                <div class="alert alert-danger">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <h2>
                Produk Anda 
                <a href="{{ route('admin.detail') }}" class="btn btn-dark">Tambahkan Produk Baru</a>
            </h2>
        </div>

        <div class="col-md-3">
            <div class="input-group mb-3">
                <input wire:model="search" type="text" class="form-control" placeholder="Search ..." aria-label="Username" aria-describedby="basic-addon1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <section class="products">
        <div class="row mt-4">
            @foreach ($products as $product)
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="{{ $product->gambar }}" alt="{{ $product->gambar }}" class="img-fluid">
                        
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <h5><strong>{{ $product->nama }}</strong></h5>
                                    <h5>Rp. {{ number_format($product->harga) }}</h5>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <a href="{{ route('admin.edit.detail', $product->id) }}" class="btn btn-dark btn-block"><i class="fas fa-eye"></i> Edit</a>
                                </div>
                                <div class="col-md-6">
                                    <button wire:click="masukkanID({{ $product->id }})" type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                    
            @endforeach
        </div>

        {{-- delete modal --}}
        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Peringatan!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <h6><strong>Produk ini akan terhapus secara permanen. Anda yakin?</strong></h6>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Gak jadi deh</button>
                        <button wire:click="hapusProduk({{ $product_id }})" type="button" class="btn btn-danger" data-dismiss="modal">Ya, hapus saja!</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                {{ $products->links() }}
            </div>
        </div>
    </section>
</div>
