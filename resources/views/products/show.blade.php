@extends('layouts.app')

@section('content')

<div style="
    min-height: 100vh;
    background: #f3f4f6;
    padding: 35px 20px;
">

    <div style="
        max-width: 900px;
        margin: 0 auto;
    ">


        {{-- HEADER --}}

        <div style="
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 20px;
        ">

            <div>

                <h1 style="
                    margin: 0;
                    color: #111827;
                    font-size: 30px;
                    font-weight: 700;
                ">
                    Detail Product
                </h1>

                <p style="
                    margin: 7px 0 0;
                    color: #6b7280;
                    font-size: 15px;
                ">
                    Informasi lengkap product.
                </p>

            </div>


            <a
                href="{{ route('products.index') }}"
                style="
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    height: 42px;
                    padding: 0 18px;
                    background: white;
                    border: 1px solid #d1d5db;
                    border-radius: 8px;
                    color: #374151;
                    text-decoration: none;
                    font-size: 14px;
                    font-weight: 600;
                "
            >
                ← Kembali
            </a>

        </div>


        {{-- CARD --}}

        <div style="
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            overflow: hidden;
        ">


            {{-- PRODUCT HEADER --}}

            <div style="
                padding: 28px;
                border-bottom: 1px solid #e5e7eb;
            ">

                <div style="
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    gap: 20px;
                ">

                    <div>

                        <div style="
                            font-size: 13px;
                            color: #9ca3af;
                            margin-bottom: 6px;
                        ">
                            Product
                        </div>

                        <h2 style="
                            margin: 0;
                            color: #111827;
                            font-size: 24px;
                            font-weight: 700;
                        ">
                            {{ $product->name }}
                        </h2>

                        <div style="
                            margin-top: 8px;
                            color: #6b7280;
                            font-size: 14px;
                        ">
                            {{ $product->category ?: 'Tanpa kategori' }}
                        </div>

                    </div>


                    @if($product->is_active)

                        <span style="
                            padding: 6px 12px;
                            background: #dcfce7;
                            color: #15803d;
                            border-radius: 999px;
                            font-size: 12px;
                            font-weight: 700;
                        ">
                            Aktif
                        </span>

                    @else

                        <span style="
                            padding: 6px 12px;
                            background: #fee2e2;
                            color: #b91c1c;
                            border-radius: 999px;
                            font-size: 12px;
                            font-weight: 700;
                        ">
                            Tidak Aktif
                        </span>

                    @endif

                </div>

            </div>


            {{-- DETAIL --}}

            <div style="
                padding: 28px;
            ">


                {{-- HARGA + STOCK --}}

                <div style="
                    display: grid;
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 20px;
                    margin-bottom: 25px;
                ">


                    <div style="
                        padding: 20px;
                        background: #f9fafb;
                        border-radius: 10px;
                    ">

                        <div style="
                            color: #6b7280;
                            font-size: 13px;
                        ">
                            Harga
                        </div>

                        <div style="
                            margin-top: 6px;
                            color: #111827;
                            font-size: 22px;
                            font-weight: 700;
                        ">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>

                    </div>


                    <div style="
                        padding: 20px;
                        background: #f9fafb;
                        border-radius: 10px;
                    ">

                        <div style="
                            color: #6b7280;
                            font-size: 13px;
                        ">
                            Stock
                        </div>

                        <div style="
                            margin-top: 6px;
                            color: #111827;
                            font-size: 22px;
                            font-weight: 700;
                        ">
                            {{ $product->stock }}
                        </div>

                    </div>

                </div>


                {{-- DESKRIPSI --}}

                <div style="
                    margin-bottom: 25px;
                ">

                    <h3 style="
                        margin: 0 0 8px;
                        color: #374151;
                        font-size: 15px;
                        font-weight: 700;
                    ">
                        Deskripsi
                    </h3>

                    <div style="
                        padding: 16px;
                        background: #f9fafb;
                        border-radius: 9px;
                        color: #4b5563;
                        font-size: 14px;
                        line-height: 1.7;
                    ">
                        {{ $product->description ?: 'Tidak ada deskripsi product.' }}
                    </div>

                </div>


                {{-- IMAGE PREVIEW --}}

                <div style="
                    margin-bottom: 25px;
                ">

                    <h3 style="
                        margin: 0 0 8px;
                        color: #374151;
                        font-size: 15px;
                        font-weight: 700;
                    ">
                        Image Product
                    </h3>

                    <div style="
                        padding: 16px;
                        background: #f9fafb;
                        border-radius: 9px;
                    ">
                        @if($product->image)
                            <img 
                                src="{{ asset('storage/' . $product->image) }}" 
                                alt="{{ $product->name }}" 
                                style="
                                    max-width: 250px; 
                                    max-height: 250px; 
                                    object-fit: cover; 
                                    border-radius: 8px; 
                                    border: 1px solid #d1d5db;
                                    display: block;
                                "
                            >
                        @else
                            <span style="color: #6b7280; font-size: 14px;">Tidak ada image.</span>
                        @endif
                    </div>

                </div>


                {{-- BUTTON --}}

                <div style="
                    display: flex;
                    justify-content: flex-end;
                    gap: 10px;
                    padding-top: 20px;
                    border-top: 1px solid #e5e7eb;
                ">

                    <a
                        href="{{ route('products.edit', $product) }}"
                        style="
                            display: inline-flex;
                            align-items: center;
                            justify-content: center;
                            height: 42px;
                            padding: 0 20px;
                            background: #fff7ed;
                            color: #c2410c;
                            border-radius: 8px;
                            text-decoration: none;
                            font-size: 14px;
                            font-weight: 700;
                        "
                    >
                        Edit Product
                    </a>


                    <form
                        action="{{ route('products.destroy', $product) }}"
                        method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus product ini?');"
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            style="
                                height: 42px;
                                padding: 0 20px;
                                background: #fee2e2;
                                color: #dc2626;
                                border: none;
                                border-radius: 8px;
                                font-size: 14px;
                                font-weight: 700;
                                cursor: pointer;
                            "
                        >
                            Hapus Product
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection