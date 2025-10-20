@extends('layouts.app')

@section('title', 'Stok Masuk Gudang')

@section('content')
    <div class="container my-4">
        <h3 class="mb-4">Tambah Stok Masuk Gudang</h3>

        <form action="{{ route('warehouse.store') }}" method="POST">
            @csrf

            {{-- Card Data Transaksi --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <strong>Data Transaksi</strong>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Transaksi</label>
                        <input type="text" name="code" class="form-control" value="{{ 'IN-' . date('Ymd-His') }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <strong>Barang Masuk</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-sm mb-0 no-datatable" id="product-table">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th>Qty Karton/Dus</th>
                                <th>Isi per Dus/Karton</th>
                                <th>Unit</th>
                                <th>Harga Beli Satuan</th>
                                <th>Total</th>
                                <th style="width: 50px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-success" id="add-product">+ Tambah Barang</button>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <strong>Biaya Lain</strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-sm mb-0 no-datatable" id="cost-table">
                        <thead class="table-light">
                            <tr>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                                <th style="width: 50px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-success" id="add-cost">+ Tambah Biaya</button>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4">Simpan Transaksi</button>
            </div>
        </form>
    </div>
    {{-- jQuery dulu --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Select2 CSS & JS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        let productIndex = 0;
        document.getElementById('add-product').addEventListener('click', function() {
            let row = `
    <tr>
        <td>
            <select name="details[${productIndex}][product_id]" class="form-control form-control-sm select2-product" required>
                <option value="">-- Pilih Produk --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="details[${productIndex}][qty_pack]" class="form-control form-control-sm qty_karton" min="1" required>
        </td>
        <td>
            <input type="number" name="details[${productIndex}][qty_per_pack]" class="form-control form-control-sm isi_per_karton" min="1" required>
        </td>
        <td>
            <select name="details[${productIndex}][unit_id]" class="form-control form-control-sm" required>
                <option value="">-- Pilih Satuan --</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="details[${productIndex}][buy_price]" class="form-control form-control-sm price" min="0" step="0.01" required>
        </td>
        <td>
            <input type="number" class="form-control form-control-sm total" readonly>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
        </td>
    </tr>`;
            document.querySelector('#product-table tbody').insertAdjacentHTML('beforeend', row);
            productIndex++;

            $('.select2-product').select2({
                placeholder: "-- Pilih Produk --",
                width: '100%'
            });
        });


        let costIndex = 0;
        document.getElementById('add-cost').addEventListener('click', function() {
            let row = `
        <tr>
            <td><input type="text" name="other_costs[${costIndex}][description]" class="form-control form-control-sm" required></td>
            <td><input type="number" name="other_costs[${costIndex}][amount]" class="form-control form-control-sm" min="0" step="0.01" required></td>
            <td class="text-center"><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
        </tr>`;
            document.querySelector('#cost-table tbody').insertAdjacentHTML('beforeend', row);
            costIndex++;
        });

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('qty_karton') || e.target.classList.contains('isi_per_karton') || e
                .target.classList.contains('price')) {
                let tr = e.target.closest('tr');
                let qtyKarton = parseFloat(tr.querySelector('.qty_karton').value) || 0;
                let isiPerKarton = parseFloat(tr.querySelector('.isi_per_karton').value) || 0;
                let price = parseFloat(tr.querySelector('.price').value) || 0;

                let totalPcs = qtyKarton * isiPerKarton;
                tr.querySelector('.total').value = (totalPcs * price).toFixed(2);
            }
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
            }
        });

        $(document).ready(function() {
            $('.select2-product').select2({
                placeholder: "-- Pilih Produk --",
                width: '100%'
            });
        });
    </script>
@endsection
