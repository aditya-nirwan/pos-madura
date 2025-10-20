@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <div class="container-fluid">
        @include('layouts.alert')

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Produk</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="code" class="form-label">Kode Produk</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    </div>

                    {{-- Harga beli --}}
                    <input type="hidden" step="0.01" class="form-control" id="buy_price" name="buy_price"
                        value="{{ old('buy_price', 0) }}" required>

                    {{-- Harga jual --}}
                    <input type="hidden" step="0.01" class="form-control" id="sell_price" name="sell_price"
                        value="{{ old('sell_price', 0) }}" required>

                    {{-- Stok --}}
                    <input type="hidden" class="form-control" id="stock" name="stock" value="{{ old('stock', 0) }}"
                        required>

                    {{-- Upload gambar --}}
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>

                    <hr>
                    {{-- Diskon --}}
                    <div class="row">
                        <div class="col-md-12">
                            <small class="text-muted d-block mb-2">
                                ⚠️ Pengaturan <b>Diskon</b> dilakukan setelah update harga produk.<br>
                                Silakan lakukan perubahan ini di form <b>Edit Produk</b>.
                            </small>
                        </div>
                        <div class="col-md-4">
                            <label for="discount_type" class="form-label">Tipe Diskon</label>
                            <select name="discount_type" id="discount_type" class="form-control">
                                <option value="percent"
                                    {{ old('discount_type', 'percent') == 'percent' ? 'selected' : '' }}>
                                    Persen (%)
                                </option>
                                <option value="amount" {{ old('discount_type', 'percent') == 'amount' ? 'selected' : '' }}>
                                    Nominal (Rp)
                                </option>
                            </select>

                        </div>
                        <div class="col-md-4">
                            <label for="discount_percent" class="form-label">Diskon (%)</label>
                            <input type="number" step="0.01" class="form-control" id="discount_percent"
                                name="discount_percent" value="{{ old('discount_percent', 0) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="discount_amount" class="form-label">Diskon (Rp)</label>
                            <input type="number" step="0.01" class="form-control" id="discount_amount"
                                name="discount_amount" value="{{ old('discount_amount', 0) }}">
                        </div>
                    </div>

                    <hr>

                    {{-- Pajak / PPN --}}
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <small class="text-muted d-block mb-2">
                                ⚠️ Pengaturan <b>PPN</b> dilakukan setelah update harga produk.<br>
                                Silakan lakukan perubahan ini di form <b>Edit Produk</b>.
                            </small>
                        </div>
                        <div class="col-md-4">
                            <label for="tax_type" class="form-label">Tipe Pajak</label>
                            <select name="tax_type" id="tax_type" class="form-control">
                                <option value="percent" {{ old('tax_type', 'percent') == 'percent' ? 'selected' : '' }}>
                                    Persen (%)
                                </option>
                                <option value="amount" {{ old('tax_type', 'percent') == 'amount' ? 'selected' : '' }}>
                                    Nominal (Rp)
                                </option>
                            </select>

                        </div>
                        <div class="col-md-4">
                            <label for="tax_percent" class="form-label">Pajak (%)</label>
                            <input type="number" step="0.01" class="form-control" id="tax_percent"
                                name="tax_percent" value="{{ old('tax_percent', 0) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="tax_amount" class="form-label">Pajak (Rp)</label>
                            <input type="number" step="0.01" class="form-control" id="tax_amount" name="tax_amount"
                                value="{{ old('tax_amount', 0) }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sellPrice = document.getElementById("sell_price");

            // Diskon
            const discountType = document.getElementById("discount_type");
            const discountPercent = document.getElementById("discount_percent");
            const discountAmount = document.getElementById("discount_amount");

            // PPN
            const taxType = document.getElementById("tax_type");
            const taxPercent = document.getElementById("tax_percent");
            const taxAmount = document.getElementById("tax_amount");

            function updateDiscount() {
                const price = parseFloat(sellPrice.value) || 0;

                if (discountType.value === "percent") {
                    const percent = parseFloat(discountPercent.value) || 0;
                    discountAmount.value = ((price * percent) / 100).toFixed(2);
                } else {
                    discountPercent.value = 0;
                }
            }

            function updateTax() {
                const price = parseFloat(sellPrice.value) || 0;
                const afterDiscount = price - (parseFloat(discountAmount.value) || 0);

                if (taxType.value === "percent") {
                    // Jika PPN persentase → hitung otomatis nominal
                    const percent = parseFloat(taxPercent.value) || 0;
                    taxAmount.value = ((afterDiscount * percent) / 100).toFixed(2);
                } else {
                    // Jika PPN nominal → set persen jadi 0
                    taxPercent.value = 0;
                }
            }

            // Event listener
            discountType.addEventListener("change", updateDiscount);
            discountPercent.addEventListener("input", updateDiscount);
            discountAmount.addEventListener("input", updateDiscount);

            taxType.addEventListener("change", updateTax);
            taxPercent.addEventListener("input", updateTax);
            taxAmount.addEventListener("input", updateTax);

            sellPrice.addEventListener("input", function() {
                updateDiscount();
                updateTax();
            });

            // Inisialisasi awal
            updateDiscount();
            updateTax();
        });
    </script>

@endsection
