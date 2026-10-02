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
            margin-bottom: 30px;
        ">

            <h1 style="
                margin: 0;
                font-size: 30px;
                font-weight: 700;
                color: #111827;
            ">
                Dashboard Admin
            </h1>

            <p style="
                margin: 8px 0 0;
                color: #6b7280;
                font-size: 15px;
            ">
                Selamat datang di sistem TokoLokal.
            </p>

        </div>


        {{-- WELCOME CARD --}}
        <div style="
            background: #2563eb;
            color: white;
            border-radius: 14px;
            padding: 28px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        ">

            <div style="
                font-size: 14px;
                opacity: 0.9;
                margin-bottom: 8px;
            ">
                Panel Administrator
            </div>

            <div style="
                font-size: 24px;
                font-weight: 700;
            ">
                Kelola TokoLokal dengan mudah
            </div>

            <p style="
                margin: 8px 0 0;
                font-size: 14px;
                opacity: 0.9;
            ">
                Gunakan menu di bawah untuk mengelola product dan transaksi.
            </p>

        </div>


        {{-- MENU UTAMA --}}
        <div style="
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        ">


            {{-- PRODUCT --}}
            <a
                href="{{ route('products.index') }}"
                style="
                    display: block;
                    background: white;
                    border: 1px solid #e5e7eb;
                    border-radius: 14px;
                    padding: 25px;
                    text-decoration: none;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
                "
            >

                <div style="
                    width: 48px;
                    height: 48px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: #eff6ff;
                    border-radius: 10px;
                    font-size: 23px;
                    margin-bottom: 15px;
                ">
                    📦
                </div>

                <h2 style="
                    margin: 0;
                    color: #1f2937;
                    font-size: 19px;
                    font-weight: 700;
                ">
                    Data Product
                </h2>

                <p style="
                    margin: 7px 0 0;
                    color: #6b7280;
                    font-size: 14px;
                ">
                    Tambah, edit, lihat detail dan hapus product.
                </p>

            </a>


            {{-- TRANSAKSI --}}
            <a
                href="{{ route('transactions.index') }}"
                style="
                    display: block;
                    background: white;
                    border: 1px solid #e5e7eb;
                    border-radius: 14px;
                    padding: 25px;
                    text-decoration: none;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
                "
            >

                <div style="
                    width: 48px;
                    height: 48px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: #ecfdf5;
                    border-radius: 10px;
                    font-size: 23px;
                    margin-bottom: 15px;
                ">
                    🧾
                </div>

                <h2 style="
                    margin: 0;
                    color: #1f2937;
                    font-size: 19px;
                    font-weight: 700;
                ">
                    Riwayat Transaksi
                </h2>

                <p style="
                    margin: 7px 0 0;
                    color: #6b7280;
                    font-size: 14px;
                ">
                    Lihat transaksi yang telah dilakukan.
                </p>

            </a>

        </div>


        {{-- INFORMASI SISTEM --}}
        <div style="
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 25px;
        ">

            <h2 style="
                margin: 0 0 18px;
                font-size: 18px;
                font-weight: 700;
                color: #1f2937;
            ">
                Informasi Sistem
            </h2>

            <div style="
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 15px;
            ">

                <div style="
                    padding: 18px;
                    background: #f9fafb;
                    border-radius: 10px;
                ">
                    <div style="
                        font-size: 12px;
                        color: #6b7280;
                    ">
                        Role
                    </div>

                    <div style="
                        margin-top: 5px;
                        font-weight: 700;
                        color: #1f2937;
                    ">
                        Administrator
                    </div>
                </div>


                <div style="
                    padding: 18px;
                    background: #f9fafb;
                    border-radius: 10px;
                ">
                    <div style="
                        font-size: 12px;
                        color: #6b7280;
                    ">
                        Sistem
                    </div>

                    <div style="
                        margin-top: 5px;
                        font-weight: 700;
                        color: #1f2937;
                    ">
                        TokoLokal
                    </div>
                </div>


                <div style="
                    padding: 18px;
                    background: #f9fafb;
                    border-radius: 10px;
                ">
                    <div style="
                        font-size: 12px;
                        color: #6b7280;
                    ">
                        Status
                    </div>

                    <div style="
                        margin-top: 5px;
                        font-weight: 700;
                        color: #16a34a;
                    ">
                        Aktif
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection