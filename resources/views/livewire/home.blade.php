<div class="container">

    {{-- banner --}}
    <div class="banner">
        <img src="{{ url('assets/slider/slider1.png') }}" alt="slider">
    </div>

    {{-- pilih liga --}}
    <section class="pilih-liga mt-4">
        <h3><strong>Pilih Liga</strong></h3>

        <div class="row mt-4">
            @foreach ($ligas as $liga)
                <div class="col">
                    <a href="{{ route('product.liga', $liga->id) }}">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <img src="{{ url('assets/liga') }}/{{ $liga->gambar }}" alt="{{ $liga->gambar }}" class="img-fluid">
                            </div>
                        </div>
                    </a>
                </div>                                        
            @endforeach

        </div>
    </section>

    {{-- best product --}}
    <section class="products mt-5">
        <h3>
            <strong>Produk Populer</strong>
            <a href="{{ route('product') }}" class="btn btn-dark float-right"><i class="fas fa-eye"></i> Lihat Semua</a>
        </h3>

        <div class="row mt-4">
            @foreach ($products as $product)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="{{ url('assets/jersey') }}/{{ $product->gambar }}" alt="{{ $product->gambar }}" class="img-fluid">
                        
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <h5><strong>{{ $product->nama }}</strong></h5>
                                    <h5>Rp. {{ number_format($product->harga) }}</h5>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <a href="{{ route('product.detail', $product->id) }}" class="btn btn-dark btn-block"><i class="fas fa-eye"></i> Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                    
            @endforeach

        </div>
    </section>
</div>
