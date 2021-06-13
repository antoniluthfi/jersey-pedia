<div class="container">
    <form wire:submit.prevent="updateProduk()" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama">Nama</label>
            <input wire:model="nama" type="text" class="form-control" id="nama" value="{{ $product->nama }}">
            @error('nama') <span class="error text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="harga-satuan">Harga Satuan</label>
                    <input wire:model="harga_satuan" type="number" class="form-control" id="harga-satuan" value="{{ $product->harga }}">
                    @error('harga_satuan') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="harga-nameset">Harga Nameset</label>
                    <input wire:model="harga_nameset" type="number" class="form-control" id="harga-nameset" value="{{ $product->harga_nameset }}">
                    @error('harga_nameset') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="liga">Liga</label>
                    <div class="input-group mb-3">
                        <select wire:model="liga" class="custom-select" id="liga" value="{{ $product->liga_id }}">
                            <option selected>Pilih Liga</option>
                            @forelse ($ligas as $liga)
                                <option value="{{ $liga->id }}">{{ $liga->nama }}</option>
                            @empty
                                <option value="">Tidak ada liga</option>
                            @endforelse 
                        </select>
                    </div> 
                    @error('liga') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>                                
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="is_ready">Ketersediaan Barang</label>
                    <div class="input-group mb-3">
                        <select wire:model="is_ready" class="custom-select" id="is_ready" value="{{ $product->is_ready }}">
                            <option value="1">Tersedia</option>
                            <option value="0">Tidak Tersedia</option>
                        </select>
                    </div> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="berat">Berat (gram)</label>
                    <input type="number" wire:model="berat" id="berat" class="form-control" value="{{ $product->berat * 1000 }}">
                    @error('berat') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col">
                <label for="gambar">Gambar</label>
                <div class="custom-file">
                    <input type="file" wire:model="gambar" class="custom-file-input" id="gambar">
                    <label class="custom-file-label" for="gambar">Choose file</label>
                    @error('gambar') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <button type="submit" class="btn btn-dark btn-block">Update Produk</button>
        </div>
    </form>
</div>
