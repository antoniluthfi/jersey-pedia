<div class="container">
    <div class="row mb-2">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('keranjang') }}" class="text-dark">Keranjang</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Check Out</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if (session()->has('hapus-keranjang'))
                <div class="alert alert-danger">
                    {{ session('hapus-keranjang') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            <a href="{{ route('keranjang') }}" class="btn btn-sm btn-dark"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <h4>Informasi Pengiriman dan Pembayaran</h4>
            <hr>

            <form wire:submit.prevent="checkout">
                <div class="form-group">
                    <label for="nohp">Nomor HP</label>
                    <input wire:model="nohp" id="nohp" type="number" class="form-control @error('nohp') is-invalid @enderror" wire:model="nohp" value="{{ old('nohp') }}" autocomplete="nohp" autofocus required>

                    @error('nohp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror    
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat Lengkap</label>
                    <textarea wire:model="alamat" id="alamat" cols="30" rows="5" class="form-control" value="{{ old('alamat') }}" autocomplete="alamat" autofocus required></textarea>

                    @error('alamat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror    
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col">
                            <label for="provinsi">Alamat Pengiriman</label>
                            <div class="input-group mb-3">
                                <select wire:model="provinsi" class="custom-select" id="provinsi">
                                    <option selected>Pilih Provinsi</option>
                                    @forelse ($daftar_provinsi as $provinsi)
                                        <option value="{{ $provinsi->province_id }}">{{ $provinsi->title }}</option>
                                    @empty
                                        <option value="">Tidak ada provinsi</option>
                                    @endforelse 
                                </select>
                            </div>        
                        </div>

                        @if (count($daftar_kota) > 0)
                            <div class="col">
                                <label for="kota" style="visibility: hidden;">Alamat Pengiriman</label>
                                <div class="input-group mb-3">
                                    <select wire:model="kab_kota" class="custom-select" id="kota">
                                        <option selected>Pilih Kota</option>
                                        @forelse ($daftar_kota as $kota)
                                            <option value="{{ $kota->city_id }}">{{ $kota->title }}</option>
                                        @empty
                                            <option value="">Tidak ada kota</option>
                                        @endforelse 
                                    </select>
                                </div>   
                            </div>
                        @endif

                        <div class="col">
                            <label for="kurir">Kurir Ekspedisi</label>
                            <div class="input-group mb-3">
                                <select wire:model="kurir" class="custom-select" id="kurir">
                                    <option selected>Pilih kurir</option>
                                    @forelse ($daftar_kurir as $kurir)
                                        <option value="{{ $kurir->code }}">{{ $kurir->title }}</option>
                                    @empty
                                        <option value="">Tidak ada kurir</option>
                                    @endforelse 
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @if ($ongkir)
                            @forelse ($ongkir["\x00*\x00result"][0]['costs'] as $row)
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h5 class="mt-0 text-center">{{ $row['service'] }}</h5>
                                                    <h6 class="text-center">{{ $row['description'] }}</h6>
                                                    <p class="text-center">Rp. {{ number_format($row['cost'][0]['value']) }}</p>
                                                    <p class="text-center">Estimasi {{ $row['cost'][0]['etd'] }} Hari</p>
                                                    <button wire:click="tambahOngkir({{ $row['cost'][0]['value'] }})" type="button" class="btn btn-dark btn-block" @if ($buttonVisible == 0) disabled @endif>Pilih</button>
                                                </div>
                                            </div>        
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="card">
                                    <div class="card-body">
                                        <div class="media">
                                            <div class="media-body">
                                                <h5 class="mt-0 text-center">Tentukan Alamat Pengiriman</h5>
                                            </div>
                                        </div>        
                                    </div>
                                </div>
                            @endforelse                       
                        @endif
                    </div>
                </div>

                <p>Biaya yang harus dibayarkan sebesar <strong>Rp. {{ number_format($total_harga) }} {{ $cek_ongkir }}</strong></p>

                <div class="row">
                    <div class="col-md-12">
                        @if (session()->has('danger'))
                            <div class="alert alert-danger">
                                {{ session('danger') }}
                            </div>
                        @endif
                    </div>
                </div>
            
                <button type="submit" class="btn btn-success btn-block" id="checkout-final" data-token="{{ $tokenMidtrans }}" @if (!$ongkir && $buttonVisible == 1) disabled @endif><i class="fas fa-arrow-right"></i> Check Out</button>
            </form>

            <a href="{{ route('history') }}" id="history-link" class="d-none"></a>
        </div>
    </div>
</div>

<script type="text/javascript">
    const historyLink = document.getElementById('history-link');
    const payButton = document.getElementById('checkout-final');
    // For example trigger on button clicked, or any time you need
    payButton.addEventListener('click', function () {
        snap.pay(this.dataset.token, {
            // Optional
            onSuccess: function(result){
                historyLink.click();
            },
            // Optional
            onPending: function(result){
                historyLink.click();
            },
            // Optional
            onError: function(result){
                historyLink.click();
            }
        }); // Replace it with your transaction token
    });
</script>