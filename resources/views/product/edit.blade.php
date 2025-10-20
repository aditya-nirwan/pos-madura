@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <div class="container-fluid">
        @include('layouts.alert')

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Produk</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="mb-3">
                        <label for="code" class="form-label">Kode Produk</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                            name="code" value="{{ old('code', $product->code) }}" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                            name="category_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="3">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="buy_price" class="form-label">Harga Beli</label>
                        <input type="text" step="0.01" class="form-control @error('buy_price') is-invalid @enderror"
                            id="buy_price" name="buy_price" value="{{ old('buy_price', $product->buy_price) }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="sell_price" class="form-label">Harga Jual</label>
                        <input type="text" step="0.01" class="form-control @error('sell_price') is-invalid @enderror"
                            id="sell_price" name="sell_price" value="{{ old('sell_price', $product->sell_price) }}"
                            readonly>

                    </div>

                    <input type="hidden" class="form-control @error('stock') is-invalid @enderror" id="stock"
                        name="stock" value="{{ old('stock', $product->stock) }}" required>

                    {{-- Diskon --}}
                    <div class="row">
                        <div class="col-md-4">
                            <label for="discount_type" class="form-label">Tipe Diskon</label>
                            <select name="discount_type" id="discount_type" class="form-control">
                                <option value="percent"
                                    {{ old('discount_type', $product->discount_type) == 'percent' ? 'selected' : '' }}>
                                    Persen (%)</option>
                                <option value="amount"
                                    {{ old('discount_type', $product->discount_type) == 'amount' ? 'selected' : '' }}>
                                    Nominal (Rp)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="discount_percent" class="form-label">Diskon (%)</label>
                            <input type="number" step="0.01" class="form-control" id="discount_percent"
                                name="discount_percent"
                                value="{{ old('discount_percent', $product->discount_percent ?? 0) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="discount_amount" class="form-label">Diskon (Rp)</label>
                            <input type="number" step="0.01" class="form-control" id="discount_amount"
                                name="discount_amount"
                                value="{{ old('discount_amount', $product->discount_amount ?? 0) }}">
                        </div>
                    </div>

                    <hr>

                    {{-- Pajak / PPN --}}
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="tax_type" class="form-label">Tipe Pajak</label>
                            <select name="tax_type" id="tax_type" class="form-control">
                                <option value="percent"
                                    {{ old('tax_type', $product->tax_type) == 'percent' ? 'selected' : '' }}>Persen (%)
                                </option>
                                <option value="amount"
                                    {{ old('tax_type', $product->tax_type) == 'amount' ? 'selected' : '' }}>Nominal (Rp)
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="tax_percent" class="form-label">Pajak (%)</label>
                            <input type="number" step="0.01" class="form-control" id="tax_percent"
                                name="tax_percent" value="{{ old('tax_percent', $product->tax_percent ?? 0) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="tax_amount" class="form-label">Pajak (Rp)</label>
                            <input type="number" step="0.01" class="form-control" id="tax_amount" name="tax_amount"
                                value="{{ old('tax_amount', $product->tax_amount ?? 0) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($product->image)
                            <div class="mt-2">
                                <img src="{{ asset('images/' . $product->image) }}" alt="Produk" class="img-thumbnail"
                                    style="max-height: 150px;">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
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
                    discountPercent.removeAttribute("readonly");
                    discountAmount.setAttribute("readonly", true);

                    const percent = parseFloat(discountPercent.value) || 0;
                    discountAmount.value = ((price * percent) / 100).toFixed(2);
                } else {
                    discountPercent.setAttribute("readonly", true);
                    discountAmount.removeAttribute("readonly");
                    discountPercent.value = 0;
                }
            }

            function updateTax() {
                const price = parseFloat(sellPrice.value) || 0;
                const afterDiscount = price - (parseFloat(discountAmount.value) || 0);

                if (taxType.value === "percent") {
                    taxPercent.removeAttribute("readonly");
                    taxAmount.setAttribute("readonly", true);

                    const percent = parseFloat(taxPercent.value) || 0;
                    taxAmount.value = ((afterDiscount * percent) / 100).toFixed(2);
                } else {
                    taxPercent.setAttribute("readonly", true);
                    taxAmount.removeAttribute("readonly");
                    taxPercent.value = 0;
                }
            }

            // Event listener
            discountType.addEventListener("change", function() {
                updateDiscount();
                updateTax(); // <-- ini penting
            });
            discountPercent.addEventListener("input", function() {
                updateDiscount();
                updateTax(); // <-- ikut refresh pajak
            });
            discountAmount.addEventListener("input", function() {
                updateDiscount();
                updateTax(); // <-- ikut refresh pajak
            });

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
