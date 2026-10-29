@extends('layouts.app')

@section('content')

<style>
    .pos-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 30px 20px;
        font-family: Arial, sans-serif;
    }
    .pos-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 20px;
    }
    @media (max-width: 900px) {
        .pos-grid {
            grid-template-columns: 1fr;
        }
    }
    .pos-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .pos-card-header {
        padding: 16px 20px;
        background: #1e293b;
        color: white;
        font-weight: 700;
        font-size: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .pos-card-body {
        padding: 20px;
    }
    /* Grid Produk */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 12px;
        max-height: 480px;
        overflow-y: auto;
        padding-right: 4px;
    }
    .product-item-card {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        transition: 0.2s;
        overflow: hidden;
        text-align: center;
    }
    .product-item-card:hover {
        border-color: #2563eb;
        box-shadow: 0 4px 10px rgba(37,99,235,0.1);
        transform: translateY(-2px);
    }
    .product-img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        background: #f3f4f6;
    }
    .product-info {
        padding: 8px;
    }
    .product-name {
        font-size: 13px;
        font-weight: 700;
        color: #1f2937;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 4px;
    }
    .product-price {
        font-size: 12px;
        color: #2563eb;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .product-stock {
        font-size: 10px;
        background: #f3f4f6;
        padding: 2px 6px;
        border-radius: 4px;
        color: #4b5563;
        display: inline-block;
    }
    /* Tabel Keranjang */
    .cart-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .cart-table th {
        background: #f9fafb;
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
    }
    .cart-table td {
        padding: 10px;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    .form-control-custom {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 13px;
        box-sizing: border-box;
        outline: none;
    }
    .form-control-custom:focus {
        border-color: #2563eb;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 14px;
        color: #374151;
    }
    .summary-row.total {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        border-top: 1px dashed #d1d5db;
        padding-top: 10px;
        margin-top: 10px;
    }
    .btn-pos {
        width: 100%;
        padding: 12px;
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 15px;
    }
    .btn-pos:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }
    .search-input {
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
        width: 200px;
        outline: none;
    }
</style>

<div class="pos-container">
    <div class="pos-grid">
        
        <!-- KOLOM KIRI: DAFTAR PRODUK -->
        <div>
            <div class="pos-card">
                <div class="pos-card-header">
                    <span>📦 Pilih Produk</span>
                    <input type="text" id="searchProduct" class="search-input" placeholder="Cari produk...">
                </div>
                <div class="pos-card-body">
                    <div class="product-grid" id="productList">
                        @foreach($products as $product)
                            <div class="product-item-card" data-name="{{ strtolower($product->name) }}" onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock }})">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="product-img" alt="{{ $product->name }}">
                                @else
                                    <div class="product-img" style="display:flex; align-items:center; justify-content:center; color:#9ca3af; font-size:11px;">No Image</div>
                                @endif
                                <div class="product-info">
                                    <div class="product-name" title="{{ $product->name }}">{{ $product->name }}</div>
                                    <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                    <div class="product-stock">Stok: {{ $product->stock }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: KERANJANG & PEMBAYARAN -->
        <div>
            <div class="pos-card">
                <div class="pos-card-header" style="background: #0f172a;">
                    <span>🛒 Keranjang Belanja</span>
                </div>
                <div class="pos-card-body">
                    @if(session('error'))
                        <div style="background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
                        @csrf
                        <div style="max-height: 220px; overflow-y: auto; margin-bottom: 15px;">
                            <table class="cart-table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th style="width: 60px;">Qty</th>
                                        <th style="text-align: right;">Subtotal</th>
                                        <th style="width: 30px;">#</th>
                                    </tr>
                                </thead>
                                <tbody id="cartTableBody">
                                    <tr id="emptyCartRow">
                                        <td colspan="4" style="text-align: center; color: #9ca3af; padding: 20px;">Belum ada produk dipilih</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 15px 0;">

                        <!-- RINGKASAN BIAYA -->
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="displaySubtotal">Rp 0</span>
                        </div>

                        <div class="summary-row">
                            <span>Diskon (Rp)</span>
                            <input type="number" name="discount" id="discountInput" class="form-control-custom" style="width: 120px; text-align: right;" value="0" min="0" oninput="calculateTotal()">
                        </div>

                        <div class="summary-row">
                            <span>Pajak (Rp)</span>
                            <input type="number" name="tax" id="taxInput" class="form-control-custom" style="width: 120px; text-align: right;" value="0" min="0" oninput="calculateTotal()">
                        </div>

                        <div class="summary-row">
                            <span>Biaya Lain (Rp)</span>
                            <input type="number" name="other_fee" id="otherFeeInput" class="form-control-custom" style="width: 120px; text-align: right;" value="0" min="0" oninput="calculateTotal()">
                        </div>

                        <div class="summary-row total">
                            <span>Grand Total</span>
                            <span id="displayGrandTotal" style="color: #2563eb;">Rp 0</span>
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label style="font-size: 13px; font-weight: 700; color: #374151; display: block; margin-bottom: 5px;">Metode Pembayaran</label>
                            <select name="payment_method" class="form-control-custom" required>
                                <option value="tunai">Tunai</option>
                                <option value="qris">QRIS</option>
                                <option value="debit">Debit</option>
                                <option value="kredit">Kredit</option>
                                <option value="e-wallet">E-Wallet</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label style="font-size: 13px; font-weight: 700; color: #374151; display: block; margin-bottom: 5px;">Uang Dibayar (Rp)</label>
                            <input type="number" name="paid_amount" id="paidAmountInput" class="form-control-custom" required min="0" oninput="calculateTotal()">
                        </div>

                        <div class="summary-row" style="font-weight: 700; color: #16a34a; margin-bottom: 15px;">
                            <span>Kembalian</span>
                            <span id="displayChange">Rp 0</span>
                        </div>

                        <button type="submit" class="btn-pos" id="submitBtn" disabled>
                            💾 Proses Transaksi & Cetak Struk
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- SKRIP JAVASCRIPT POS -->
<script>
    let cart = [];

    // Filter pencarian produk
    document.getElementById('searchProduct').addEventListener('input', function(e) {
        let keyword = e.target.value.toLowerCase();
        let items = document.querySelectorAll('.product-item-card');
        items.forEach(item => {
            let name = item.getAttribute('data-name');
            item.style.display = name.includes(keyword) ? '' : 'none';
        });
    });

    function addToCart(id, name, price, maxStock) {
        let existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            if (existingItem.qty < maxStock) {
                existingItem.qty++;
            } else {
                alert('Stok produk tidak mencukupi!');
                return;
            }
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                qty: 1,
                maxStock: maxStock
            });
        }
        renderCart();
    }

    function updateQty(id, qty) {
        let item = cart.find(item => item.id === id);
        if (item) {
            let newQty = parseInt(qty);
            if (newQty > item.maxStock) {
                alert('Stok maksimum adalah ' + item.maxStock);
                item.qty = item.maxStock;
            } else if (newQty < 1) {
                removeFromCart(id);
                return;
            } else {
                item.qty = newQty;
            }
        }
        renderCart();
    }

    function removeFromCart(id) {
        cart = cart.filter(item => item.id !== id);
        renderCart();
    }

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
    }

    function renderCart() {
        let tbody = document.getElementById('cartTableBody');
        tbody.innerHTML = '';

        if (cart.length === 0) {
            tbody.innerHTML = `<tr id="emptyCartRow"><td colspan="4" style="text-align: center; color: #9ca3af; padding: 20px;">Belum ada produk dipilih</td></tr>`;
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('displaySubtotal').innerText = 'Rp 0';
            document.getElementById('displayGrandTotal').innerText = 'Rp 0';
            document.getElementById('displayChange').innerText = 'Rp 0';
            return;
        }

        let subtotal = 0;

        cart.forEach((item, index) => {
            let itemSubtotal = item.price * item.qty;
            subtotal += itemSubtotal;

            let tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <div style="font-weight: 600; color: #1f2937;">${item.name}</div>
                    <div style="font-size: 11px; color: #6b7280;">${formatRupiah(item.price)}</div>
                    <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                </td>
                <td>
                    <input type="number" name="items[${index}][qty]" value="${item.qty}" min="1" max="${item.maxStock}" class="form-control-custom" style="width: 55px; padding: 4px;" onchange="updateQty(${item.id}, this.value)">
                </td>
                <td style="text-align: right; font-weight: 600;">${formatRupiah(itemSubtotal)}</td>
                <td>
                    <button type="button" style="background:#fee2e2; color:#dc2626; border:none; padding: 2px 6px; border-radius: 4px; cursor: pointer;" onclick="removeFromCart(${item.id})">&times;</button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        document.getElementById('displaySubtotal').innerText = formatRupiah(subtotal);
        calculateTotal();
    }

    function calculateTotal() {
        let subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        let discount = parseFloat(document.getElementById('discountInput').value) || 0;
        let tax = parseFloat(document.getElementById('taxInput').value) || 0;
        let otherFee = parseFloat(document.getElementById('otherFeeInput').value) || 0;
        let paidAmount = parseFloat(document.getElementById('paidAmountInput').value) || 0;

        let grandTotal = subtotal - discount + tax + otherFee;
        if (grandTotal < 0) grandTotal = 0;

        let change = paidAmount - grandTotal;

        document.getElementById('displayGrandTotal').innerText = formatRupiah(grandTotal);
        document.getElementById('displayChange').innerText = formatRupiah(change >= 0 ? change : 0);

        let submitBtn = document.getElementById('submitBtn');
        if (cart.length > 0 && paidAmount >= grandTotal) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }
</script>
@endsection