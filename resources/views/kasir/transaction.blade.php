@extends('layouts.app')

@section('content')

    {{-- =========================================================
         HEADER
    ========================================================== --}}
    <div>
        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:20px;
        ">
            <div>
                <h2 style="
                    margin:0;
                    font-size:24px;
                    font-weight:700;
                    color:#111827;
                ">
                    Kasir / Transaksi
                </h2>

                <p style="
                    margin:5px 0 0;
                    color:#6b7280;
                    font-size:14px;
                ">
                    Kelola transaksi pembayaran pelanggan
                </p>
            </div>

            <div style="
                text-align:right;
                color:#6b7280;
                font-size:14px;
            ">
                <div>
                    Kasir:
                    <strong style="color:#111827;">
                        {{ auth()->user()->name }}
                    </strong>
                </div>

                <div id="currentDateTime"></div>
            </div>
        </div>
    </div>


    {{-- =========================================================
         CONTENT
    ========================================================== --}}
    <div style="
        background:#f3f4f6;
        min-height:calc(100vh - 73px);
        padding:24px;
    ">

        {{-- FLASH SUCCESS --}}
        @if(session('success'))
            <div style="
                max-width:1400px;
                margin:0 auto 20px;
                padding:14px 18px;
                background:#dcfce7;
                border:1px solid #86efac;
                color:#166534;
                border-radius:10px;
            ">
                {{ session('success') }}
            </div>
        @endif


        {{-- FLASH ERROR --}}
        @if(session('error'))
            <div style="
                max-width:1400px;
                margin:0 auto 20px;
                padding:14px 18px;
                background:#fee2e2;
                border:1px solid #fca5a5;
                color:#991b1b;
                border-radius:10px;
            ">
                {{ session('error') }}
            </div>
        @endif


        {{-- VALIDATION ERROR --}}
        @if($errors->any())
            <div style="
                max-width:1400px;
                margin:0 auto 20px;
                padding:14px 18px;
                background:#fee2e2;
                border:1px solid #fca5a5;
                color:#991b1b;
                border-radius:10px;
            ">
                <strong>Terjadi kesalahan:</strong>

                <ul style="margin:8px 0 0 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div style="
            max-width:1400px;
            margin:0 auto;
        ">

            {{-- =================================================
                 BAGIAN ATAS: PRODUK + KERANJANG
            ================================================== --}}
            <div style="
                display:grid;
                grid-template-columns:minmax(0, 1.6fr) minmax(360px, 0.9fr);
                gap:20px;
                align-items:start;
            ">

                {{-- =============================================
                     KOLOM KIRI - PRODUK
                ============================================== --}}
                <div>

                    {{-- SEARCH --}}
                    <div style="
                        background:white;
                        border:1px solid #e5e7eb;
                        border-radius:12px;
                        padding:20px;
                        box-shadow:0 2px 6px rgba(0,0,0,.04);
                        margin-bottom:20px;
                    ">

                        <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                            margin-bottom:14px;
                        ">
                            <div>
                                <h3 style="
                                    margin:0;
                                    font-size:20px;
                                    font-weight:700;
                                    color:#111827;
                                ">
                                    Tambah Barang
                                </h3>

                                <p style="
                                    margin:5px 0 0;
                                    color:#6b7280;
                                    font-size:14px;
                                ">
                                    Cari produk berdasarkan nama, kode, atau barcode.
                                </p>
                            </div>

                            <div style="
                                background:#eff6ff;
                                color:#1d4ed8;
                                padding:8px 12px;
                                border-radius:8px;
                                font-size:13px;
                                font-weight:600;
                            ">
                                {{ $products->count() }} Produk
                            </div>
                        </div>

                        <input
                            type="text"
                            id="searchProduct"
                            placeholder="Cari produk / kode / barcode..."
                            autocomplete="off"
                            style="
                                width:100%;
                                height:46px;
                                border:1px solid #d1d5db;
                                border-radius:9px;
                                padding:0 14px;
                                font-size:15px;
                                outline:none;
                                box-sizing:border-box;
                            "
                        >

                    </div>


                    {{-- PRODUCT LIST --}}
                    <div style="
                        background:white;
                        border:1px solid #e5e7eb;
                        border-radius:12px;
                        padding:20px;
                        box-shadow:0 2px 6px rgba(0,0,0,.04);
                    ">

                        <div style="
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                            margin-bottom:18px;
                        ">
                            <div>
                                <h3 style="
                                    margin:0;
                                    font-size:20px;
                                    font-weight:700;
                                    color:#111827;
                                ">
                                    Daftar Produk
                                </h3>

                                <p style="
                                    margin:5px 0 0;
                                    color:#6b7280;
                                    font-size:14px;
                                ">
                                    Produk aktif dengan stok tersedia.
                                </p>
                            </div>
                        </div>


                        {{-- GRID PRODUK --}}
                        <div
                            id="productGrid"
                            style="
                                display:grid;
                                grid-template-columns:repeat(3, minmax(0, 1fr));
                                gap:16px;
                            "
                        >

                            @forelse($products as $product)

                                <div
                                    class="product-card"
                                    data-name="{{ strtolower($product->name) }}"
                                    data-category="{{ strtolower($product->category ?? '') }}"
                                    data-code="{{ strtolower($product->code ?? '') }}"
                                    data-barcode="{{ strtolower($product->barcode ?? '') }}"
                                    style="
                                        border:1px solid #e5e7eb;
                                        border-radius:12px;
                                        overflow:hidden;
                                        background:white;
                                        transition:all .2s ease;
                                        display:flex;
                                        flex-direction:column;
                                    "
                                >

                                    {{-- GAMBAR --}}
                                    <div style="
                                        height:150px;
                                        background:#f9fafb;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        overflow:hidden;
                                        border-bottom:1px solid #e5e7eb;
                                    ">

                                        @if(!empty($product->image))

                                            <img
                                                src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}"
                                                style="
                                                    width:100%;
                                                    height:100%;
                                                    object-fit:cover;
                                                "
                                            >

                                        @else

                                            <div style="
                                                font-size:46px;
                                                color:#9ca3af;
                                            ">
                    🛒
                                            </div>

                                        @endif

                                    </div>


                                    {{-- DETAIL PRODUK --}}
                                    <div style="
                                        padding:16px;
                                        flex:1;
                                        display:flex;
                                        flex-direction:column;
                                    ">

                                        <div style="
                                            font-size:17px;
                                            font-weight:700;
                                            color:#111827;
                                            margin-bottom:5px;
                                        ">
                                            {{ $product->name }}
                                        </div>

                                        @if($product->category)
                                            <div style="
                                                font-size:13px;
                                                color:#6b7280;
                                                margin-bottom:10px;
                                            ">
                                                {{ $product->category }}
                                            </div>
                                        @endif

                                        <div style="
                                            font-size:18px;
                                            font-weight:700;
                                            color:#2563eb;
                                            margin-bottom:5px;
                                        ">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </div>

                                        <div style="
                                            font-size:13px;
                                            color:#6b7280;
                                            margin-bottom:14px;
                                        ">
                                            Stok:
                                            <strong style="color:#111827;">
                                                {{ $product->stock }}
                                            </strong>
                                        </div>


                                        {{-- TOMBOL TAMBAH --}}
                                        <button
                                            type="button"
                                            class="add-product-btn"
                                            data-id="{{ $product->id }}"
                                            style="
                                                width:100%;
                                                border:none;
                                                border-radius:8px;
                                                padding:11px 14px;
                                                background:#2563eb;
                                                color:white;
                                                font-size:14px;
                                                font-weight:700;
                                                cursor:pointer;
                                                transition:background .2s;
                                                margin-top:auto;
                                            "
                                        >
                                            + Tambah
                                        </button>

                                    </div>

                                </div>

                            @empty

                                <div style="
                                    grid-column:1 / -1;
                                    text-align:center;
                                    padding:50px 20px;
                                    color:#6b7280;
                                ">
                                    <div style="
                                        font-size:50px;
                                        margin-bottom:10px;
                                    ">
                    📦
                                    </div>

                                    <strong style="
                                        display:block;
                                        color:#374151;
                                        font-size:17px;
                                        margin-bottom:5px;
                                    ">
                                        Belum ada produk tersedia.
                                    </strong>

                                    <span>
                                        Tambahkan produk terlebih dahulu melalui menu Products.
                                    </span>
                                </div>

                            @endforelse

                        </div>

                    </div>

                </div>


                {{-- =============================================
                     KOLOM KANAN - KERANJANG
                ============================================== --}}
                <div
                    style="
                        background:white;
                        border:1px solid #e5e7eb;
                        border-radius:12px;
                        box-shadow:0 2px 6px rgba(0,0,0,.04);
                        overflow:hidden;
                        position:sticky;
                        top:20px;
                    "
                >

                    <div style="
                        padding:18px 20px;
                        border-bottom:1px solid #e5e7eb;
                        display:flex;
                        justify-content:space-between;
                        align-items:center;
                    ">
                        <div>
                            <h3 style="
                                margin:0;
                                font-size:20px;
                                font-weight:700;
                                color:#111827;
                            ">
                                Keranjang Belanja
                            </h3>

                            <div
                                id="cartCount"
                                style="
                                    margin-top:4px;
                                    color:#6b7280;
                                    font-size:13px;
                                "
                            >
                                0 Item
                            </div>
                        </div>

                        <button
                            type="button"
                            id="clearCart"
                            style="
                                border:none;
                                background:none;
                                color:#dc2626;
                                font-size:13px;
                                font-weight:600;
                                cursor:pointer;
                            "
                        >
                            Kosongkan
                        </button>
                    </div>


                    {{-- TABLE CART --}}
                    <div style="
                        overflow-x:auto;
                        max-height:430px;
                        overflow-y:auto;
                    ">

                        <table style="
                            width:100%;
                            border-collapse:collapse;
                            font-size:13px;
                        ">
                            <thead style="
                                background:#f9fafb;
                                position:sticky;
                                top:0;
                                z-index:1;
                            ">
                                <tr>
                                    <th style="padding:10px 8px; text-align:center;">No</th>
                                    <th style="padding:10px 8px; text-align:left;">Barang</th>
                                    <th style="padding:10px 8px; text-align:right;">Harga</th>
                                    <th style="padding:10px 8px; text-align:center;">Qty</th>
                                    <th style="padding:10px 8px; text-align:right;">Subtotal</th>
                                    <th style="padding:10px 8px; text-align:center;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody id="cartBody">

                                <tr id="emptyCart">
                                    <td
                                        colspan="6"
                                        style="
                                            text-align:center;
                                            padding:40px 15px;
                                            color:#9ca3af;
                                        "
                                    >
                                        Keranjang masih kosong.
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>


                    {{-- TOTAL --}}
                    <div style="
                        border-top:1px solid #e5e7eb;
                        padding:18px 20px;
                    ">

                        <div style="
                            display:flex;
                            justify-content:space-between;
                            margin-bottom:8px;
                            font-size:14px;
                        ">
                            <span>Subtotal</span>

                            <strong id="subtotalText">
                                Rp 0
                            </strong>
                        </div>


                        {{-- DISCOUNT --}}
                        <div style="margin-bottom:10px;">

                            <label style="
                                display:block;
                                font-size:13px;
                                font-weight:600;
                                margin-bottom:5px;
                            ">
                                Diskon
                            </label>

                            <input
                                type="number"
                                id="discount"
                                name="discount"
                                value="0"
                                min="0"
                                step="1000"
                                style="
                                    width:100%;
                                    height:38px;
                                    border:1px solid #d1d5db;
                                    border-radius:7px;
                                    padding:0 10px;
                                    box-sizing:border-box;
                                "
                            >

                        </div>


                        {{-- TAX --}}
                        <div style="margin-bottom:10px;">

                            <label style="
                                display:block;
                                font-size:13px;
                                font-weight:600;
                                margin-bottom:5px;
                            ">
                                Pajak
                            </label>

                            <input
                                type="number"
                                id="tax"
                                name="tax"
                                value="0"
                                min="0"
                                step="1000"
                                style="
                                    width:100%;
                                    height:38px;
                                    border:1px solid #d1d5db;
                                    border-radius:7px;
                                    padding:0 10px;
                                    box-sizing:border-box;
                                "
                            >

                        </div>


                        {{-- OTHER FEE --}}
                        <div style="margin-bottom:10px;">

                            <label style="
                                display:block;
                                font-size:13px;
                                font-weight:600;
                                margin-bottom:5px;
                            ">
                                Biaya Lain
                            </label>

                            <input
                                type="number"
                                id="other_fee"
                                name="other_fee"
                                value="0"
                                min="0"
                                step="1000"
                                style="
                                    width:100%;
                                    height:38px;
                                    border:1px solid #d1d5db;
                                    border-radius:7px;
                                    padding:0 10px;
                                    box-sizing:border-box;
                                "
                            >

                        </div>


                        {{-- GRAND TOTAL --}}
                        <div style="
                            margin-top:15px;
                            padding-top:15px;
                            border-top:1px dashed #d1d5db;
                            display:flex;
                            justify-content:space-between;
                            align-items:center;
                        ">
                            <span style="
                                font-size:16px;
                                font-weight:700;
                            ">
                                Grand Total
                            </span>

                            <strong
                                id="grandTotalText"
                                style="
                                    font-size:21px;
                                    color:#2563eb;
                                "
                            >
                                Rp 0
                            </strong>
                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 PEMBAYARAN
            ================================================== --}}
            <div style="
                margin-top:20px;
                background:white;
                border:1px solid #e5e7eb;
                border-radius:12px;
                padding:20px;
                box-shadow:0 2px 6px rgba(0,0,0,.04);
            ">

                <h3 style="
                    margin:0 0 18px;
                    font-size:20px;
                    font-weight:700;
                    color:#111827;
                ">
                    Pembayaran
                </h3>


                <div style="
                    display:grid;
                    grid-template-columns:repeat(3, minmax(0, 1fr));
                    gap:16px;
                ">

                    {{-- CUSTOMER --}}
                    <div>

                        <label style="
                            display:block;
                            margin-bottom:6px;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Pelanggan
                        </label>

                        <select
                            id="customer_id"
                            style="
                                width:100%;
                                height:42px;
                                border:1px solid #d1d5db;
                                border-radius:8px;
                                padding:0 10px;
                                background:white;
                            "
                        >
                            <option value="">
                                Tanpa Pelanggan
                            </option>

                            @foreach(\App\Models\User::orderBy('name')->get() as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->name }}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    {{-- PAYMENT METHOD --}}
                    <div>

                        <label style="
                            display:block;
                            margin-bottom:6px;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Metode Pembayaran
                        </label>

                        <select
                            id="payment_method"
                            style="
                                width:100%;
                                height:42px;
                                border:1px solid #d1d5db;
                                border-radius:8px;
                                padding:0 10px;
                                background:white;
                            "
                        >
                            <option value="tunai">Tunai</option>
                            <option value="qris">QRIS</option>
                            <option value="debit">Debit</option>
                            <option value="kredit">Kredit</option>
                            <option value="e-wallet">E-Wallet</option>
                            <option value="transfer">Transfer</option>
                        </select>

                    </div>


                    {{-- PAID --}}
                    <div>

                        <label style="
                            display:block;
                            margin-bottom:6px;
                            font-size:13px;
                            font-weight:600;
                        ">
                            Uang Dibayar
                        </label>

                        <input
                            type="number"
                            id="paid_amount"
                            min="0"
                            step="1000"
                            placeholder="Masukkan jumlah pembayaran"
                            style="
                                width:100%;
                                height:42px;
                                border:1px solid #d1d5db;
                                border-radius:8px;
                                padding:0 10px;
                                box-sizing:border-box;
                            "
                        >

                    </div>

                </div>


                {{-- CHANGE --}}
                <div style="
                    margin-top:18px;
                    background:#f0fdf4;
                    border:1px solid #bbf7d0;
                    border-radius:10px;
                    padding:16px;
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                ">
                    <span style="
                        font-weight:600;
                        color:#166534;
                    ">
                        Kembalian
                    </span>

                    <strong
                        id="changeText"
                        style="
                            font-size:22px;
                            color:#15803d;
                        "
                    >
                        Rp 0
                    </strong>
                </div>


                {{-- FORM SUBMIT --}}
                <form
                    id="transactionForm"
                    action="{{ route('transactions.store') }}"
                    method="POST"
                    style="margin-top:20px;"
                >

                    @csrf

                    {{-- hidden items akan dibuat JavaScript --}}

                    <input
                        type="hidden"
                        name="customer_id"
                        id="hiddenCustomer"
                    >

                    <input
                        type="hidden"
                        name="discount"
                        id="hiddenDiscount"
                    >

                    <input
                        type="hidden"
                        name="tax"
                        id="hiddenTax"
                    >

                    <input
                        type="hidden"
                        name="other_fee"
                        id="hiddenOtherFee"
                    >

                    <input
                        type="hidden"
                        name="paid_amount"
                        id="hiddenPaidAmount"
                    >

                    <input
                        type="hidden"
                        name="payment_method"
                        id="hiddenPaymentMethod"
                    >


                    <div style="
                        display:flex;
                        justify-content:flex-end;
                        gap:10px;
                    ">

                        <button
                            type="button"
                            id="resetTransaction"
                            style="
                                border:1px solid #d1d5db;
                                background:white;
                                color:#374151;
                                border-radius:8px;
                                padding:12px 20px;
                                font-weight:600;
                                cursor:pointer;
                            "
                        >
                            Reset
                        </button>

                        <button
                            type="submit"
                            id="submitTransaction"
                            style="
                                border:none;
                                background:#16a34a;
                                color:white;
                                border-radius:8px;
                                padding:12px 24px;
                                font-weight:700;
                                cursor:pointer;
                            "
                        >
                        ✓ BAYAR & CETAK


                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- =========================================================
         JAVASCRIPT
    ========================================================== --}}
    <script>

        /*
        |--------------------------------------------------------------------------
        | DATA PRODUK
        |--------------------------------------------------------------------------
        */

        const products = {{ Illuminate\Support\Js::from($products->values()) }};


        /*
        |--------------------------------------------------------------------------
        | CART
        |--------------------------------------------------------------------------
        */

        let cart = [];


        /*
        |--------------------------------------------------------------------------
        | FORMAT RUPIAH
        |--------------------------------------------------------------------------
        */

        function formatRupiah(number)
        {
            return 'Rp ' + Number(number || 0).toLocaleString('id-ID');
        }


        /*
        |--------------------------------------------------------------------------
        | JAM / TANGGAL
        |--------------------------------------------------------------------------
        */

        function updateDateTime()
        {
            const element = document.getElementById('currentDateTime');

            if (!element) {
                return;
            }

            const now = new Date();

            element.textContent = now.toLocaleString('id-ID');
        }

        updateDateTime();

        setInterval(updateDateTime, 1000);


        /*
        |--------------------------------------------------------------------------
        | CARI PRODUK
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('searchProduct')
            .addEventListener('input', function () {

                const keyword = this.value.toLowerCase().trim();

                document
                    .querySelectorAll('.product-card')
                    .forEach(function (card) {

                        const name = card.dataset.name || '';
                        const category = card.dataset.category || '';
                        const code = card.dataset.code || '';
                        const barcode = card.dataset.barcode || '';

                        const found =
                            name.includes(keyword) ||
                            category.includes(keyword) ||
                            code.includes(keyword) ||
                            barcode.includes(keyword);

                        card.style.display = found
                            ? 'flex'
                            : 'none';

                    });

            });


        /*
        |--------------------------------------------------------------------------
        | TAMBAH PRODUK
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll('.add-product-btn')
            .forEach(function (button) {

                button.addEventListener('click', function () {

                    const productId = Number(this.dataset.id);

                    addToCart(productId);

                });

                button.addEventListener('mouseenter', function () {

                    this.style.background = '#1d4ed8';

                });

                button.addEventListener('mouseleave', function () {

                    this.style.background = '#2563eb';

                });

            });


        /*
        |--------------------------------------------------------------------------
        | ADD TO CART
        |--------------------------------------------------------------------------
        */

        function addToCart(productId)
        {
            const product = products.find(
                item => Number(item.id) === Number(productId)
            );

            if (!product) {
                return;
            }

            const existing = cart.find(
                item => Number(item.product_id) === Number(product.id)
            );

            if (existing) {

                if (existing.qty >= Number(product.stock)) {

                    alert('Jumlah produk sudah mencapai batas stok.');

                    return;
                }

                existing.qty++;

            } else {

                cart.push({
                    product_id: Number(product.id),
                    name: product.name,
                    price: Number(product.price),
                    stock: Number(product.stock),
                    qty: 1
                });

            }

            renderCart();
        }


        /*
        |--------------------------------------------------------------------------
        | RENDER CART
        |--------------------------------------------------------------------------
        */

        function renderCart()
        {
            const cartBody = document.getElementById('cartBody');
            const cartCount = document.getElementById('cartCount');
            const emptyCart = document.getElementById('emptyCart');

            cartBody.innerHTML = '';


            if (cart.length === 0) {

                cartBody.innerHTML = `
                    <tr id="emptyCart">
                        <td
                            colspan="6"
                            style="
                                text-align:center;
                                padding:40px 15px;
                                color:#9ca3af;
                            "
                        >
                            Keranjang masih kosong.
                        </td>
                    </tr>
                `;

            } else {

                cart.forEach(function (item, index) {

                    const subtotal =
                        item.price * item.qty;

                    const row = document.createElement('tr');

                    row.style.borderBottom =
                        '1px solid #f3f4f6';

                    row.innerHTML = `
                        <td style="
                            padding:12px 8px;
                            text-align:center;
                        ">
                            ${index + 1}
                        </td>

                        <td style="
                            padding:12px 8px;
                        ">
                            <strong style="
                                display:block;
                                color:#111827;
                                margin-bottom:3px;
                            ">
                                ${item.name}
                            </strong>

                            <small style="
                                color:#9ca3af;
                            ">
                                Stok ${item.stock}
                            </small>
                        </td>

                        <td style="
                            padding:12px 8px;
                            text-align:right;
                            white-space:nowrap;
                        ">
                            ${formatRupiah(item.price)}
                        </td>

                        <td style="
                            padding:12px 8px;
                            text-align:center;
                        ">
                            <div style="
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                gap:4px;
                            ">

                                <button
                                    type="button"
                                    onclick="changeQty(${index}, -1)"
                                    style="
                                        width:27px;
                                        height:27px;
                                        border:1px solid #d1d5db;
                                        background:white;
                                        border-radius:5px;
                                        cursor:pointer;
                                    "
                                >
                                    −
                                </button>

                                <span style="
                                    min-width:25px;
                                    text-align:center;
                                    font-weight:600;
                                ">
                                    ${item.qty}
                                </span>

                                <button
                                    type="button"
                                    onclick="changeQty(${index}, 1)"
                                    style="
                                        width:27px;
                                        height:27px;
                                        border:1px solid #d1d5db;
                                        background:white;
                                        border-radius:5px;
                                        cursor:pointer;
                                    "
                                >
                                    +
                                </button>

                            </div>
                        </td>

                        <td style="
                            padding:12px 8px;
                            text-align:right;
                            white-space:nowrap;
                            font-weight:600;
                        ">
                            ${formatRupiah(subtotal)}
                        </td>

                        <td style="
                            padding:12px 8px;
                            text-align:center;
                        ">
                            <button
                                type="button"
                                onclick="removeFromCart(${index})"
                                style="
                                    border:none;
                                    background:#fee2e2;
                                    color:#dc2626;
                                    width:30px;
                                    height:30px;
                                    border-radius:6px;
                                    cursor:pointer;
                                "
                                title="Hapus"
                            >
                                Ã—
                            </button>
                        </td>
                    `;

                    cartBody.appendChild(row);

                });

            }


            const totalQty = cart.reduce(
                (total, item) => total + item.qty,
                0
            );

            cartCount.textContent =
                totalQty + (totalQty === 1 ? ' Item' : ' Item');


            calculateTotal();
        }


        /*
        |--------------------------------------------------------------------------
        | CHANGE QTY
        |--------------------------------------------------------------------------
        */

        function changeQty(index, amount)
        {
            if (!cart[index]) {
                return;
            }

            const product = products.find(
                item => Number(item.id) === Number(cart[index].product_id)
            );

            cart[index].qty += amount;

            if (cart[index].qty <= 0) {

                cart.splice(index, 1);

            } else if (
                product &&
                cart[index].qty > Number(product.stock)
            ) {

                cart[index].qty = Number(product.stock);

                alert('Jumlah melebihi stok yang tersedia.');

            }

            renderCart();
        }


        /*
        |--------------------------------------------------------------------------
        | REMOVE
        |--------------------------------------------------------------------------
        */

        function removeFromCart(index)
        {
            cart.splice(index, 1);

            renderCart();
        }


        /*
        |--------------------------------------------------------------------------
        | HITUNG TOTAL
        |--------------------------------------------------------------------------
        */

        function calculateTotal()
        {
            const subtotal =
                cart.reduce(
                    (total, item) =>
                        total + (item.price * item.qty),
                    0
                );

            const discount =
                Number(document.getElementById('discount').value) || 0;

            const tax =
                Number(document.getElementById('tax').value) || 0;

            const otherFee =
                Number(document.getElementById('other_fee').value) || 0;

            const grandTotal =
                Math.max(
                    0,
                    subtotal - discount + tax + otherFee
                );

            const paid =
                Number(document.getElementById('paid_amount').value) || 0;

            const change =
                Math.max(
                    0,
                    paid - grandTotal
                );


            document.getElementById('subtotalText')
                .textContent = formatRupiah(subtotal);

            document.getElementById('grandTotalText')
                .textContent = formatRupiah(grandTotal);

            document.getElementById('changeText')
                .textContent = formatRupiah(change);
        }


        /*
        |--------------------------------------------------------------------------
        | EVENT TOTAL
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('discount')
            .addEventListener('input', calculateTotal);

        document
            .getElementById('tax')
            .addEventListener('input', calculateTotal);

        document
            .getElementById('other_fee')
            .addEventListener('input', calculateTotal);

        document
            .getElementById('paid_amount')
            .addEventListener('input', calculateTotal);


        /*
        |--------------------------------------------------------------------------
        | KOSONGKAN CART
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('clearCart')
            .addEventListener('click', function () {

                if (cart.length === 0) {
                    return;
                }

                if (
                    confirm('Apakah semua barang di keranjang ingin dihapus?')
                ) {

                    cart = [];

                    renderCart();

                }

            });


        /*
        |--------------------------------------------------------------------------
        | RESET TRANSACTION
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('resetTransaction')
            .addEventListener('click', function () {

                if (
                    !confirm(
                        'Reset transaksi dan kosongkan keranjang?'
                    )
                ) {
                    return;
                }

                cart = [];

                document.getElementById('discount').value = 0;
                document.getElementById('tax').value = 0;
                document.getElementById('other_fee').value = 0;
                document.getElementById('paid_amount').value = '';

                document.getElementById('customer_id').value = '';

                document.getElementById('payment_method').value = 'tunai';

                renderCart();

            });


        /*
        |--------------------------------------------------------------------------
        | SUBMIT TRANSACTION
        |--------------------------------------------------------------------------
        */

        document
            .getElementById('transactionForm')
            .addEventListener('submit', function (event) {

                event.preventDefault();


                if (cart.length === 0) {

                    alert(
                        'Keranjang masih kosong. Silakan tambahkan produk terlebih dahulu.'
                    );

                    return;
                }


                const discount =
                    Number(document.getElementById('discount').value) || 0;

                const tax =
                    Number(document.getElementById('tax').value) || 0;

                const otherFee =
                    Number(document.getElementById('other_fee').value) || 0;

                const paidAmount =
                    Number(document.getElementById('paid_amount').value) || 0;

                const customerId =
                    document.getElementById('customer_id').value;

                const paymentMethod =
                    document.getElementById('payment_method').value;


                const subtotal =
                    cart.reduce(
                        (total, item) =>
                            total + (item.price * item.qty),
                        0
                    );

                const grandTotal =
                    Math.max(
                        0,
                        subtotal - discount + tax + otherFee
                    );


                if (paidAmount < grandTotal) {

                    alert(
                        'Uang pembayaran masih kurang.\n\n' +
                        'Total: ' + formatRupiah(grandTotal) +
                        '\nDibayar: ' + formatRupiah(paidAmount)
                    );

                    return;
                }


                /*
                | HIDDEN ITEMS
                */

                document
                    .querySelectorAll('.transaction-item')
                    .forEach(
                        element => element.remove()
                    );


                cart.forEach(function (item, index) {

                    const productInput =
                        document.createElement('input');

                    productInput.type = 'hidden';
                    productInput.name =
                        `items[${index}][product_id]`;
                    productInput.value =
                        item.product_id;

                    productInput.className =
                        'transaction-item';


                    const qtyInput =
                        document.createElement('input');

                    qtyInput.type = 'hidden';
                    qtyInput.name =
                        `items[${index}][qty]`;
                    qtyInput.value =
                        item.qty;

                    qtyInput.className =
                        'transaction-item';


                    this.appendChild(productInput);
                    this.appendChild(qtyInput);

                }, this);


                document.getElementById('hiddenCustomer').value =
                    customerId;

                document.getElementById('hiddenDiscount').value =
                    discount;

                document.getElementById('hiddenTax').value =
                    tax;

                document.getElementById('hiddenOtherFee').value =
                    otherFee;

                document.getElementById('hiddenPaidAmount').value =
                    paidAmount;

                document.getElementById('hiddenPaymentMethod').value =
                    paymentMethod;


                this.submit();

            });


        /*
        |--------------------------------------------------------------------------
        | INITIAL
        |--------------------------------------------------------------------------
        */

        renderCart();

    </script>


    {{-- =========================================================
         RESPONSIVE
    ========================================================== --}}
    <style>

        @media (max-width: 1100px) {

            div[style*="grid-template-columns:minmax(0, 1.6fr)"] {
                grid-template-columns:1fr !important;
            }

            div[style*="position:sticky"] {
                position:static !important;
            }

        }


        @media (max-width: 800px) {

            #productGrid {
                grid-template-columns:repeat(2, minmax(0, 1fr)) !important;
            }

        }


        @media (max-width: 550px) {

            #productGrid {
                grid-template-columns:1fr !important;
            }

        }

    </style>

@endsection
