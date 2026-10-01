@extends('layouts.app')

@section('content')

<div style="
    background:#f3f4f6;
    min-height:100vh;
    padding:40px 20px;
">

    <div style="
        max-width:900px;
        margin:auto;
    ">

        {{-- HEADER --}}
        <div style="margin-bottom:25px;">

            <h1 style="
                margin:0;
                font-size:30px;
                font-weight:700;
                color:#111827;
            ">
                Edit Product
            </h1>

            <p style="
                margin:7px 0 0;
                color:#6b7280;
                font-size:15px;
            ">
                Ubah informasi product yang sudah tersimpan.
            </p>

        </div>


        {{-- ERROR VALIDATION --}}
        @if($errors->any())

            <div style="
                background:#fee2e2;
                color:#991b1b;
                border:1px solid #fecaca;
                padding:15px;
                border-radius:8px;
                margin-bottom:20px;
            ">

                <strong>
                    Terjadi kesalahan:
                </strong>

                <ul style="
                    margin:8px 0 0 20px;
                ">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- FORM --}}
        <div style="
            background:white;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,.06);
            padding:30px;
        ">

            <form
                action="{{ route('products.update', $product) }}"
                method="POST"
            >

                @csrf
                @method('PUT')


                {{-- NAMA PRODUCT --}}
                <div style="margin-bottom:20px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                        color:#374151;
                    ">
                        Nama Product
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $product->name) }}"
                        required
                        style="
                            width:100%;
                            box-sizing:border-box;
                            padding:11px 13px;
                            border:1px solid #d1d5db;
                            border-radius:7px;
                            font-size:14px;
                            outline:none;
                        "
                    >

                </div>


                {{-- KATEGORI --}}
                <div style="margin-bottom:20px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                        color:#374151;
                    ">
                        Kategori
                    </label>

                    <input
                        type="text"
                        name="category"
                        value="{{ old('category', $product->category) }}"
                        style="
                            width:100%;
                            box-sizing:border-box;
                            padding:11px 13px;
                            border:1px solid #d1d5db;
                            border-radius:7px;
                            font-size:14px;
                        "
                    >

                </div>


                {{-- DESKRIPSI --}}
                <div style="margin-bottom:20px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                        color:#374151;
                    ">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        rows="5"
                        style="
                            width:100%;
                            box-sizing:border-box;
                            padding:11px 13px;
                            border:1px solid #d1d5db;
                            border-radius:7px;
                            font-size:14px;
                            resize:vertical;
                        "
                    >{{ old('description', $product->description) }}</textarea>

                </div>


                {{-- HARGA DAN STOCK --}}
                <div style="
                    display:grid;
                    grid-template-columns:1fr 1fr;
                    gap:20px;
                    margin-bottom:20px;
                ">

                    {{-- HARGA --}}
                    <div>

                        <label style="
                            display:block;
                            margin-bottom:7px;
                            font-weight:600;
                            color:#374151;
                        ">
                            Harga
                        </label>

                        <input
                            type="number"
                            name="price"
                            value="{{ old('price', $product->price) }}"
                            min="0"
                            required
                            style="
                                width:100%;
                                box-sizing:border-box;
                                padding:11px 13px;
                                border:1px solid #d1d5db;
                                border-radius:7px;
                                font-size:14px;
                            "
                        >

                    </div>


                    {{-- STOCK --}}
                    <div>

                        <label style="
                            display:block;
                            margin-bottom:7px;
                            font-weight:600;
                            color:#374151;
                        ">
                            Stock
                        </label>

                        <input
                            type="number"
                            name="stock"
                            value="{{ old('stock', $product->stock) }}"
                            min="0"
                            required
                            style="
                                width:100%;
                                box-sizing:border-box;
                                padding:11px 13px;
                                border:1px solid #d1d5db;
                                border-radius:7px;
                                font-size:14px;
                            "
                        >

                    </div>

                </div>


                {{-- FOTO --}}
                <div style="margin-bottom:20px;">

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                        color:#374151;
                    ">
                        Foto Product
                    </label>

                    <input
                        type="text"
                        name="image"
                        value="{{ old('image', $product->image) }}"
                        placeholder="Contoh: sepatu.jpg"
                        style="
                            width:100%;
                            box-sizing:border-box;
                            padding:11px 13px;
                            border:1px solid #d1d5db;
                            border-radius:7px;
                            font-size:14px;
                        "
                    >

                    <p style="
                        margin:7px 0 0;
                        color:#6b7280;
                        font-size:13px;
                    ">
                        Masukkan nama file foto yang berada di
                        <strong>public/images/products</strong>.
                    </p>

                </div>


                {{-- PREVIEW FOTO --}}
                @if($product->image)

                    <div style="
                        margin-bottom:25px;
                        padding:15px;
                        background:#f9fafb;
                        border:1px solid #e5e7eb;
                        border-radius:8px;
                    ">

                        <div style="
                            font-size:13px;
                            font-weight:600;
                            color:#374151;
                            margin-bottom:10px;
                        ">
                            Foto Saat Ini
                        </div>

                        <img
                            src="{{ asset('images/products/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            style="
                                width:150px;
                                height:150px;
                                object-fit:cover;
                                border-radius:10px;
                                border:1px solid #d1d5db;
                            "
                        >

                    </div>

                @endif


                {{-- STATUS --}}
                <div style="
                    margin-bottom:30px;
                    padding:15px;
                    background:#f9fafb;
                    border:1px solid #e5e7eb;
                    border-radius:8px;
                ">

                    <label style="
                        display:flex;
                        align-items:center;
                        gap:10px;
                        cursor:pointer;
                    ">

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                            style="
                                width:18px;
                                height:18px;
                            "
                        >

                        <span style="
                            font-weight:600;
                            color:#374151;
                        ">
                            Product Aktif
                        </span>

                    </label>

                    <p style="
                        margin:7px 0 0 28px;
                        color:#6b7280;
                        font-size:13px;
                    ">
                        Product aktif akan dapat digunakan dalam transaksi kasir.
                    </p>

                </div>


                {{-- BUTTON --}}
                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    gap:10px;
                    flex-wrap:wrap;
                ">

                    <a
                        href="{{ route('products.index') }}"
                        style="
                            display:inline-block;
                            padding:11px 18px;
                            background:#6b7280;
                            color:white;
                            text-decoration:none;
                            border-radius:7px;
                            font-size:14px;
                            font-weight:600;
                        "
                    >
                        Kembali
                    </a>


                    <button
                        type="submit"
                        style="
                            padding:11px 20px;
                            background:#2563eb;
                            color:white;
                            border:none;
                            border-radius:7px;
                            font-size:14px;
                            font-weight:600;
                            cursor:pointer;
                        "
                    >
                        Update Product
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection