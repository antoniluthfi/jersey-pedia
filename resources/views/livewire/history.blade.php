<div class="container">
    <div class="row mb-2">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">History</li>
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

    <div class="row mt-4">
        <div class="col">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <td class="text-center">No. </td>
                        <td class="text-center">Tanggal Pesan</td>
                        <td class="text-center">Kode Pemesanan</td>
                        <td class="text-center">Pesanan</td>
                        <td class="text-center">Status</td>
                        <td class="text-center"><strong>Total Harga</strong></td>
                        <td class="text-center">Aksi</td>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($pesanans as $pesanan)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $pesanan->created_at }}</td>
                                <td class="text-center">{{ $pesanan->kode_unik }}</td>
                                <td>
                                    @php
                                        $pesanan_details = \App\Models\PesananDetail::where('pesanan_id', $pesanan->id)->get();
                                    @endphp
                                    
                                    @foreach ($pesanan_details as $pesanan_detail)
                                        <img src="{{ $pesanan_detail->product->gambar }}" alt="{{ $pesanan_detail->product->gambar }}" width="50">
                                        {{ $pesanan_detail->product->nama }}
                                        <br>
                                    @endforeach
                                </td>
                                <td class="text-center">{{ $pesanan->status == 0 ? 'Belum Lunas' : 'Lunas' }}</td>
                                <td class="text-right"><strong>Rp. {{ number_format($pesanan->total_harga) }}</strong></td>
                                <td class="text-center"><i wire:click="getTransactionStatus({{ $pesanan->id }})" class="fas fa-eye text-info" style="cursor: pointer;"></i></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center"><strong>History Kosong</strong></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            @if ($status)
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center"><strong>Status Pembayaran</strong></h5>
                        <table class="table">
                            <tr>
                                <th>Virtual Akun</th>
                                <td>: </td>
                                <td>{{ $status['va_numbers'][0]['va_number'] }}</td>    
                            </tr>    
                            <tr>
                                <th>Bank</th>
                                <td>: </td>
                                <td>{{ strtoupper($status['va_numbers'][0]['bank']) }}</td>    
                            </tr>    
                            <tr>
                                <th>Total Harga</th>
                                <td>: </td>
                                <td>Rp. {{ number_format($status['gross_amount']) }}</td>    
                            </tr>    
                            <tr>
                                <th>Status</th>
                                <td>: </td>
                                <td>
                                    <h5><span class="badge {{ $status['transaction_status'] == 'settlement' ? 'badge-success' : 'badge-danger' }}">{{ $status['transaction_status'] }}</span></h5>   
                                </td>    
                            </tr>    
                        </table>    
                    </div>
                </div>                
            @endif
        </div>
    </div>
</div>
