<div class="container">
    <div class="row mb-2">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
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
        <div class="col">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <td class="text-center">No. </td>
                        <td class="text-center">Gambar</td>
                        <td class="text-center">Keterangan</td>
                        <td class="text-center">Name Set</td>
                        <td class="text-center">Jumlah</td>
                        <td class="text-center">Harga</td>
                        <td class="text-center"><strong>Total Harga</strong></td>
                        <td></td>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($pesanan_details as $pesanan_detail)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">
                                    <img src="{{ $pesanan_detail->product->gambar }}" alt="{{ $pesanan_detail->product->gambar }}" width="100">
                                </td>
                                <td class="text-center">{{ $pesanan_detail->product->nama }}</td>
                                <td @if (!$pesanan_detail->nameset) class="text-center" @endif>
                                    @if ($pesanan_detail->nameset)
                                        Nama : {{ $pesanan_detail->nama }} <br>
                                        Nomor : {{ $pesanan_detail->nomor }}
                                    @else 
                                        -
                                    @endif
                                </td>
                                <td class="text-center">{{ $pesanan_detail->jumlah_pesanan }}</td>
                                <td class="text-right">Rp. {{ number_format($pesanan_detail->product->harga) }}</td>
                                <td class="text-right"><strong>Rp. {{ number_format($pesanan_detail->total_harga) }}</strong></td>
                                <td><i wire:click="destroy({{ $pesanan_detail->id }})" class="fas fa-trash text-danger" style="cursor: pointer;"></i></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center"><strong>Keranjang Kosong</strong></td>
                            </tr>
                        @endforelse

                        @if (!empty($pesanan))
                            <tr>
                                <td colspan="6" class="text-right"><strong>Total Harga : </strong></td>
                                <td class="text-right"><strong>Rp. {{ number_format($pesanan->total_harga) }}</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right"><strong>Kode Unik : </strong></td>
                                <td class="text-right"><strong>{{ $pesanan->kode_unik }}</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right"><strong>Total Yang Harus Dibayarkan : </strong></td>
                                <td class="text-right"><strong>Rp. {{ number_format($pesanan->total_harga + $pesanan->kode_unik) }}</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="6"></td>
                                <td colspan="2">
                                    <a href="{{ route('checkout') }}" class="btn btn-success btn-block"><i class="fas fa-arrow-right"></i> Check Out</a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>