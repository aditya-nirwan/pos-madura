@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Tambah Stok Masuk Gudang</h3>
        <form action="{{ route('stock_in.store') }}" method="POST">
            @csrf

            <!-- Data Transaksi -->
            <div class="mb-3">
                <label>Kode Transaksi</label>
                <input type="text" name="code" class="form-control" value="{{ 'IN-' . date('Ymd-His') }}" required>
            </div>
            <div class="mb-3">
                <label>Tanggal</label>
                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <!-- Barang -->
            <h5>Barang Masuk</h5>
            <table class="table table-bordered" id="product-table">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <button type="button" class="btn btn-sm btn-success" id="add-product">+ Tambah Barang</button>

            <!-- Biaya Lain -->
            <h5 class="mt-4">Biaya Lain</h5>
            <table class="table table-bordered" id="cost-table">
                <thead>
                    <tr>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <button type="button" class="btn btn-sm btn-success" id="add-cost">+ Tambah Biaya</button>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            </div>
        </form>
    </div>

    <script>
        let productIndex = 0;

        document.getElementById('add-product').addEventListener('click', function() {
            let row = `
    <tr>
        <td>
            <select name="products[${productIndex}][product_id]" class="form-control" required>
                <option value="">-- Pilih Produk --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="products[${productIndex}][qty]" class="form-control qty" min="1" required></td>
        <td>
            <select name="products[${productIndex}][unit_id]" class="form-control" required>
                <option value="">-- Pilih Satuan --</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="products[${productIndex}][buy_price]" class="form-control price" min="0" step="0.01" required></td>
        <td><input type="number" class="form-control total" readonly></td>
        <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
    </tr>`;
            document.querySelector('#product-table tbody').insertAdjacentHTML('beforeend', row);
            productIndex++;
        });


        let costIndex = 0;

        document.getElementById('add-cost').addEventListener('click', function() {
            let row = `
                <tr>
                    <td><input type="text" name="other_costs[${costIndex}][description]" class="form-control" required></td>
                    <td><input type="number" name="other_costs[${costIndex}][amount]" class="form-control" min="0" step="0.01" required></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
                </tr>`;
            document.querySelector('#cost-table tbody').insertAdjacentHTML('beforeend', row);
            costIndex++;
        });


        // Auto calculate product total
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('qty') || e.target.classList.contains('price')) {
                let tr = e.target.closest('tr');
                let qty = parseFloat(tr.querySelector('.qty').value) || 0;
                let price = parseFloat(tr.querySelector('.price').value) || 0;
                tr.querySelector('.total').value = qty * price;
            }
        });

        // Remove row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
            }
        });
    </script>
@endsection
