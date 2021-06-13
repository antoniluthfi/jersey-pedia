<div class="container">
    <div class="row mb-2">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product') }}" class="text-dark">List Jersey</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card gambar-product">
                <div class="card-body">
                    <img src="{{ $product->gambar }}" alt="{{ $product->gambar }}" class="img-fluid">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <h2><strong>{{ $product->nama }}</strong></h2>
            <h4>
                Rp. {{ number_format($product->harga) }}

                @if ($product->is_ready == 1)
                    <span class="badge badge-success"><i class="fas fa-check"></i> Ready Stok</span>
                @else 
                    <span class="badge badge-danger"><i class="fas fa-times"></i> Stok Habis</span>
                @endif
            </h4>

            <div class="row">
                <div class="col">
                    <form wire:submit.prevent="masukkanKeranjang">
                        <table class="table" style="border: none;">
                            <tr>
                                <td>Liga</td>
                                <td>:</td>
                                <td>
                                    <img src="{{ $product->liga->gambar }}" alt="{{ $product->liga->nama }}" class="img-fluid" width="50">
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis</td>
                                <td>:</td>
                                <td>{{ $product->jenis }}</td>
                            </tr>
                            <tr>
                                <td>Berat</td>
                                <td>:</td>
                                <td>{{ $product->berat }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Pesanan</td>
                                <td>:</td>
                                <td>
                                    <input wire:model="jumlah_pesanan" id="jumlah_pesanan" type="number" min="1" class="form-control @error('jumlah_pesanan') is-invalid @enderror" value="{{ old('jumlah_pesanan') }}" required autocomplete="jumlah_pesanan" autofocus>

                                    @error('jumlah_pesanan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror    
                                </td>
                            </tr>

                            @if ($jumlah_pesanan == 1)
                                <tr>
                                    <td colspan="3"><strong>Nameset (isi jika tambah nameset)</strong></td>
                                </tr>
                                <tr>
                                    <td>Harga Name Set</td>
                                    <td>:</td>
                                    <td>Rp. {{ number_format($product->harga_nameset) }}</td>
                                </tr>    
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>
                                        <input id="nama" type="text" class="form-control @error('nama') is-invalid @enderror" wire:model="nama" value="{{ old('nama') }}" autocomplete="nama" autofocus>

                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror    
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nomor</td>
                                    <td>:</td>
                                    <td>
                                        <input id="nomor" type="number" class="form-control @error('nomor') is-invalid @enderror" wire:model="nomor" value="{{ old('nomor') }}" autocomplete="nomor" autofocus>

                                        @error('nomor')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror    
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td colspan="3">
                                    <button type="submit" class="btn btn-dark btn-block" @if ($product->is_ready != 1) disabled @endif><i class="fas fa-shopping-cart"></i> Masukkan Keranjang</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>    
