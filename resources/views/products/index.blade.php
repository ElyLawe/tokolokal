@extends('layouts.app')

@section('content')

<div style="
    min-height: 100vh;
    background: #f3f4f6;
    padding: 35px 20px;
">

    <div style="
        max-width: 1200px;
        margin: 0 auto;
    ">


        {{-- HEADER --}}

        <div style="
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        ">

            <div>

                <h1 style="
                    margin: 0;
                    color: #111827;
                    font-size: 30px;
                    font-weight: 700;
                ">
                    Data Product
                </h1>

                <p style="
                    margin: 7px 0 0;
                    color: #6b7280;
                    font-size: 15px;
                ">
                    Kelola product yang tersedia di TokoLokal.
                </p>

            </div>


            <a
                href="{{ route('products.create') }}"
                style="
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    height: 44px;
                    padding: 0 18px;
                    background: #2563eb;
                    color: white;
                    border-radius: 8px;
                    text-decoration: none;
                    font-size: 14px;
                    font-weight: 700;
                "
            >
                + Tambah Product
            </a>

        </div>


        {{-- SUCCESS --}}

        @if(session('success'))

            <div style="
                margin-bottom: 20px;
                padding: 14px 18px;
                background: #ecfdf5;
                border: 1px solid #a7f3d0;
                border-radius: 9px;
                color: #047857;
                font-size: 14px;
            ">
                {{ session('success') }}
            </div>

        @endif


        {{-- TABLE CARD --}}

        <div style="
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow-x: auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        ">

            <table style="
                width: 100%;
                border-collapse: collapse;
                min-width: 900px;
            ">

                <thead>

                    <tr style="
                        background: #f9fafb;
                        border-bottom: 1px solid #e5e7eb;
                    ">

                        <th style="padding: 15px; text-align: left; font-size: 13px; color: #6b7280; width: 60px;">
                            No
                        </th>

                        <th style="padding: 15px; text-align: left; font-size: 13px; color: #6b7280; width: 70px;">
                            Foto
                        </th>

                        <th style="padding: 15px; text-align: left; font-size: 13px; color: #6b7280;">
                            Product
                        </th>

                        <th style="padding: 15px; text-align: left; font-size: 13px; color: #6b7280;">
                            Kategori
                        </th>

                        <th style="padding: 15px; text-align: right; font-size: 13px; color: #6b7280;">
                            Harga
                        </th>

                        <th style="padding: 15px; text-align: center; font-size: 13px; color: #6b7280;">
                            Stock
                        </th>

                        <th style="padding: 15px; text-align: center; font-size: 13px; color: #6b7280;">
                            Status
                        </th>

                        <th style="padding: 15px; text-align: center; font-size: 13px; color: #6b7280;">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($products as $product)

                        <tr style="
                            border-bottom: 1px solid #f3f4f6;
                        ">

                            {{-- NO --}}
                            <td style="
                                padding: 16px;
                                color: #6b7280;
                                font-size: 14px;
                            ">
                                {{ $products->firstItem() + $loop->index }}
                            </td>


                            {{-- FOTO THUMBNAIL --}}
                            <td style="
                                padding: 16px;
                            ">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 45px; height: 45px; object-fit: cover; border-radius: 6px; border: 1px solid #e5e7eb;">
                                @else
                                    <div style="width: 45px; height: 45px; background: #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #6b7280;">No Img</div>
                                @endif
                            </td>


                            {{-- PRODUCT --}}
                            <td style="
                                padding: 16px;
                            ">

                                <div style="
                                    font-weight: 700;
                                    color: #1f2937;
                                    font-size: 14px;
                                ">
                                    {{ $product->name }}
                                </div>

                                @if($product->description)

                                    <div style="
                                        margin-top: 4px;
                                        color: #9ca3af;
                                        font-size: 12px;
                                    ">
                                        {{ Str::limit($product->description, 50) }}
                                    </div>

                                @endif

                            </td>


                            {{-- KATEGORI --}}
                            <td style="
                                padding: 16px;
                                color: #4b5563;
                                font-size: 14px;
                            ">
                                {{ $product->category ?: '-' }}
                            </td>


                            {{-- HARGA --}}
                            <td style="
                                padding: 16px;
                                text-align: right;
                                color: #1f2937;
                                font-size: 14px;
                                font-weight: 600;
                            ">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>


                            {{-- STOCK --}}
                            <td style="
                                padding: 16px;
                                text-align: center;
                            ">

                                <span style="
                                    display: inline-block;
                                    min-width: 40px;
                                    padding: 5px 9px;
                                    background: #f3f4f6;
                                    border-radius: 6px;
                                    color: #374151;
                                    font-size: 13px;
                                    font-weight: 600;
                                ">
                                    {{ $product->stock }}
                                </span>

                            </td>


                            {{-- STATUS --}}
                            <td style="
                                padding: 16px;
                                text-align: center;
                            ">

                                @if($product->is_active)

                                    <span style="
                                        display: inline-block;
                                        padding: 5px 10px;
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
                                        display: inline-block;
                                        padding: 5px 10px;
                                        background: #fee2e2;
                                        color: #b91c1c;
                                        border-radius: 999px;
                                        font-size: 12px;
                                        font-weight: 700;
                                    ">
                                        Tidak Aktif
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td style="
                                padding: 16px;
                            ">

                                <div style="
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    gap: 7px;
                                ">


                                    {{-- DETAIL --}}

                                    <a
                                        href="{{ route('products.show', $product) }}"
                                        style="
                                            display: inline-flex;
                                            align-items: center;
                                            justify-content: center;
                                            height: 34px;
                                            padding: 0 11px;
                                            background: #eff6ff;
                                            color: #2563eb;
                                            border-radius: 6px;
                                            text-decoration: none;
                                            font-size: 12px;
                                            font-weight: 700;
                                        "
                                    >
                                        Detail
                                    </a>


                                    {{-- EDIT --}}

                                    <a
                                        href="{{ route('products.edit', $product) }}"
                                        style="
                                            display: inline-flex;
                                            align-items: center;
                                            justify-content: center;
                                            height: 34px;
                                            padding: 0 11px;
                                            background: #fff7ed;
                                            color: #c2410c;
                                            border-radius: 6px;
                                            text-decoration: none;
                                            font-size: 12px;
                                            font-weight: 700;
                                        "
                                    >
                                        Edit
                                    </a>


                                    {{-- HAPUS --}}

                                    <form
                                        action="{{ route('products.destroy', $product) }}"
                                        method="POST"
                                        style="display: inline;"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus product ini?');"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            style="
                                                height: 34px;
                                                padding: 0 11px;
                                                background: #fef2f2;
                                                color: #dc2626;
                                                border: none;
                                                border-radius: 6px;
                                                font-size: 12px;
                                                font-weight: 700;
                                                cursor: pointer;
                                            "
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                style="
                                    padding: 50px 20px;
                                    text-align: center;
                                "
                            >

                                <div style="
                                    font-size: 40px;
                                    margin-bottom: 12px;
                                ">
                                    📦
                                </div>

                                <div style="
                                    font-weight: 700;
                                    color: #374151;
                                ">
                                    Belum ada product
                                </div>

                                <div style="
                                    margin-top: 5px;
                                    color: #9ca3af;
                                    font-size: 14px;
                                ">
                                    Silakan tambahkan product baru.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}

        <div style="
            margin-top: 20px;
        ">
            {{ $products->links() }}
        </div>

    </div>

</div>

@endsection