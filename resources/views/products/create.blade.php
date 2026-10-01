@extends('layouts.app')

@section('content')

<div style="
    min-height: 100vh;
    background: #f3f4f6;
    padding: 40px 20px;
">

    <div style="
        max-width: 900px;
        margin: 0 auto;
    ">

        {{-- HEADER --}}
        <div style="margin-bottom: 28px;">

            <h1 style="
                margin: 0;
                color: #111827;
                font-size: 30px;
                font-weight: 700;
                line-height: 1.3;
            ">
                Tambah Product
            </h1>

            <p style="
                margin: 8px 0 0;
                color: #6b7280;
                font-size: 15px;
            ">
                Tambahkan product baru ke dalam sistem TokoMini.
            </p>

        </div>


        {{-- ERROR VALIDATION --}}
        @if ($errors->any())

            <div style="
                margin-bottom: 24px;
                padding: 16px 18px;
                background: #fef2f2;
                border: 1px solid #fecaca;
                border-radius: 10px;
                color: #b91c1c;
            ">

                <div style="
                    font-weight: 700;
                    margin-bottom: 8px;
                ">
                    Terdapat kesalahan:
                </div>

                <ul style="
                    margin: 0;
                    padding-left: 20px;
                    font-size: 14px;
                ">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- CARD FORM --}}
        <div style="
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
        ">

            {{-- CARD HEADER --}}
            <div style="
                padding: 24px 28px;
                border-bottom: 1px solid #e5e7eb;
            ">

                <h2 style="
                    margin: 0;
                    color: #1f2937;
                    font-size: 19px;
                    font-weight: 700;
                ">
                    Informasi Product
                </h2>

                <p style="
                    margin: 6px 0 0;
                    color: #6b7280;
                    font-size: 14px;
                ">
                    Lengkapi informasi product sebelum menyimpannya.
                </p>

            </div>


            {{-- FORM --}}
            <form
                action="{{ route('products.store') }}"
                method="POST"
            >

                @csrf


                {{-- FORM CONTENT --}}
                <div style="
                    padding: 28px;
                ">


                    {{-- NAMA PRODUCT --}}
                    <div style="
                        margin-bottom: 22px;
                    ">

                        <label
                            for="name"
                            style="
                                display: block;
                                margin-bottom: 8px;
                                color: #374151;
                                font-size: 14px;
                                font-weight: 600;
                            "
                        >
                            Nama Product
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Nasi Goreng"
                            required
                            style="
                                display: block;
                                width: 100%;
                                height: 46px;
                                padding: 0 14px;
                                box-sizing: border-box;
                                background: #ffffff;
                                border: 1px solid #d1d5db;
                                border-radius: 8px;
                                color: #111827;
                                font-size: 14px;
                                outline: none;
                            "
                        >

                        @error('name')

                            <div style="
                                margin-top: 6px;
                                color: #dc2626;
                                font-size: 13px;
                            ">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- KATEGORI --}}
                    <div style="
                        margin-bottom: 22px;
                    ">

                        <label
                            for="category"
                            style="
                                display: block;
                                margin-bottom: 8px;
                                color: #374151;
                                font-size: 14px;
                                font-weight: 600;
                            "
                        >
                            Kategori
                        </label>

                        <input
                            type="text"
                            id="category"
                            name="category"
                            value="{{ old('category') }}"
                            placeholder="Contoh: Makanan"
                            style="
                                display: block;
                                width: 100%;
                                height: 46px;
                                padding: 0 14px;
                                box-sizing: border-box;
                                background: #ffffff;
                                border: 1px solid #d1d5db;
                                border-radius: 8px;
                                color: #111827;
                                font-size: 14px;
                                outline: none;
                            "
                        >

                    </div>


                    {{-- DESKRIPSI --}}
                    <div style="
                        margin-bottom: 22px;
                    ">

                        <label
                            for="description"
                            style="
                                display: block;
                                margin-bottom: 8px;
                                color: #374151;
                                font-size: 14px;
                                font-weight: 600;
                            "
                        >
                            Deskripsi
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Masukkan deskripsi product..."
                            style="
                                display: block;
                                width: 100%;
                                padding: 12px 14px;
                                box-sizing: border-box;
                                background: #ffffff;
                                border: 1px solid #d1d5db;
                                border-radius: 8px;
                                color: #111827;
                                font-size: 14px;
                                resize: vertical;
                                outline: none;
                            "
                        >{{ old('description') }}</textarea>

                    </div>


                    {{-- HARGA + STOCK --}}
                    <div style="
                        display: grid;
                        grid-template-columns: repeat(2, minmax(0, 1fr));
                        gap: 20px;
                        margin-bottom: 22px;
                    ">


                        {{-- HARGA --}}
                        <div>

                            <label
                                for="price"
                                style="
                                    display: block;
                                    margin-bottom: 8px;
                                    color: #374151;
                                    font-size: 14px;
                                    font-weight: 600;
                                "
                            >
                                Harga
                            </label>

                            <input
                                type="number"
                                id="price"
                                name="price"
                                value="{{ old('price') }}"
                                min="0"
                                step="0.01"
                                placeholder="15000"
                                required
                                style="
                                    display: block;
                                    width: 100%;
                                    height: 46px;
                                    padding: 0 14px;
                                    box-sizing: border-box;
                                    background: #ffffff;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    color: #111827;
                                    font-size: 14px;
                                    outline: none;
                                "
                            >

                            @error('price')

                                <div style="
                                    margin-top: 6px;
                                    color: #dc2626;
                                    font-size: 13px;
                                ">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- STOCK --}}
                        <div>

                            <label
                                for="stock"
                                style="
                                    display: block;
                                    margin-bottom: 8px;
                                    color: #374151;
                                    font-size: 14px;
                                    font-weight: 600;
                                "
                            >
                                Stock
                            </label>

                            <input
                                type="number"
                                id="stock"
                                name="stock"
                                value="{{ old('stock', 0) }}"
                                min="0"
                                required
                                style="
                                    display: block;
                                    width: 100%;
                                    height: 46px;
                                    padding: 0 14px;
                                    box-sizing: border-box;
                                    background: #ffffff;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    color: #111827;
                                    font-size: 14px;
                                    outline: none;
                                "
                            >

                            @error('stock')

                                <div style="
                                    margin-top: 6px;
                                    color: #dc2626;
                                    font-size: 13px;
                                ">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- IMAGE --}}
                    <div style="
                        margin-bottom: 22px;
                    ">

                        <label
                            for="image"
                            style="
                                display: block;
                                margin-bottom: 8px;
                                color: #374151;
                                font-size: 14px;
                                font-weight: 600;
                            "
                        >
                            Image Product
                        </label>

                        <input
                            type="text"
                            id="image"
                            name="image"
                            value="{{ old('image') }}"
                            placeholder="Contoh: nasi-goreng.jpg"
                            style="
                                display: block;
                                width: 100%;
                                height: 46px;
                                padding: 0 14px;
                                box-sizing: border-box;
                                background: #ffffff;
                                border: 1px solid #d1d5db;
                                border-radius: 8px;
                                color: #111827;
                                font-size: 14px;
                                outline: none;
                            "
                        >

                        <p style="
                            margin: 6px 0 0;
                            color: #9ca3af;
                            font-size: 12px;
                        ">
                            Masukkan nama file gambar jika tersedia.
                        </p>

                    </div>


                    {{-- STATUS --}}
                    <div style="
                        display: flex;
                        align-items: center;
                    ">

                        <input
                            type="checkbox"
                            id="is_active"
                            name="is_active"
                            value="1"
                            checked
                            style="
                                width: 17px;
                                height: 17px;
                                margin: 0 9px 0 0;
                            "
                        >

                        <label
                            for="is_active"
                            style="
                                color: #374151;
                                font-size: 14px;
                                font-weight: 500;
                            "
                        >
                            Product aktif
                        </label>

                    </div>

                </div>


                {{-- FOOTER BUTTON --}}
                <div style="
                    padding: 20px 28px;
                    background: #f9fafb;
                    border-top: 1px solid #e5e7eb;
                ">

                    <div style="
                        display: flex;
                        justify-content: flex-end;
                        align-items: center;
                        gap: 12px;
                    ">

                        {{-- KEMBALI --}}
                        <a
                            href="{{ route('products.index') }}"
                            style="
                                display: inline-flex;
                                align-items: center;
                                justify-content: center;
                                min-width: 110px;
                                height: 44px;
                                padding: 0 20px;
                                box-sizing: border-box;
                                background: #ffffff;
                                border: 1px solid #d1d5db;
                                border-radius: 8px;
                                color: #374151;
                                text-decoration: none;
                                font-size: 14px;
                                font-weight: 600;
                            "
                        >
                            Kembali
                        </a>


                        {{-- SIMPAN --}}
                        <button
                            type="submit"
                            style="
                                display: inline-flex !important;
                                align-items: center !important;
                                justify-content: center !important;
                                min-width: 150px !important;
                                height: 44px !important;
                                padding: 0 22px !important;
                                box-sizing: border-box !important;
                                background: #2563eb !important;
                                border: 1px solid #2563eb !important;
                                border-radius: 8px !important;
                                color: #ffffff !important;
                                font-size: 14px !important;
                                font-weight: 700 !important;
                                cursor: pointer !important;
                                visibility: visible !important;
                                opacity: 1 !important;
                            "
                        >
                            Simpan Product
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection