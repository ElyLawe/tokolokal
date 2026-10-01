@extends('layouts.app')

@section('content')

<div style="
    background:#f3f4f6;
    min-height:100vh;
    padding:40px 20px;
">

    <div style="
        max-width:1200px;
        margin:auto;
    ">

        {{-- HEADER --}}
        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
            gap:15px;
            flex-wrap:wrap;
        ">

            <div>
                <h1 style="
                    margin:0;
                    font-size:28px;
                    font-weight:700;
                    color:#111827;
                ">
                    Detail Transaksi
                </h1>

                <p style="
                    margin:6px 0 0;
                    color:#6b7280;
                    font-size:14px;
                ">
                    Informasi lengkap transaksi penjualan
                </p>
            </div>

            <div style="
                display:flex;
                gap:10px;
                flex-wrap:wrap;
            ">

                <a href="{{ route('transactions.index') }}"
                   style="
                       text-decoration:none;
                       background:#6b7280;
                       color:white;
                       padding:10px 16px;
                       border-radius:7px;
                       font-size:14px;
                       font-weight:600;
                   ">
                    Kembali
                </a>

                <a href="{{ route('transactions.receipt', $transaction) }}"
                   target="_blank"
                   style="
                       text-decoration:none;
                       background:#2563eb;
                       color:white;
                       padding:10px 16px;
                       border-radius:7px;
                       font-size:14px;
                       font-weight:600;
                   ">
                    Cetak Struk
                </a>

            </div>

        </div>


        {{-- INFORMASI TRANSAKSI --}}
        <div style="
            background:white;
            border-radius:12px;
            padding:25px;
            margin-bottom:20px;
            box-shadow:0 2px 8px rgba(0,0,0,0.06);
        ">

            <h2 style="
                margin:0 0 20px;
                font-size:20px;
                color:#111827;
            ">
                Informasi Transaksi
            </h2>

            <div style="
                display:grid;
                grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
                gap:20px;
            ">

                {{-- Nomor Transaksi --}}
                <div>
                    <div style="
                        font-size:13px;
                        color:#6b7280;
                        margin-bottom:5px;
                    ">
                        Nomor Transaksi
                    </div>

                    <div style="
                        font-size:16px;
                        font-weight:700;
                        color:#111827;
                    ">
                        {{ $transaction->transaction_number }}
                    </div>
                </div>


                {{-- Kasir --}}
                <div>
                    <div style="
                        font-size:13px;
                        color:#6b7280;
                        margin-bottom:5px;
                    ">
                        Kasir
                    </div>

                    <div style="
                        font-size:16px;
                        font-weight:600;
                        color:#111827;
                    ">
                        {{ $transaction->user->name ?? '-' }}
                    </div>
                </div>


                {{-- Tanggal --}}
                <div>
                    <div style="
                        font-size:13px;
                        color:#6b7280;
                        margin-bottom:5px;
                    ">
                        Tanggal
                    </div>

                    <div style="
                        font-size:16px;
                        font-weight:600;
                        color:#111827;
                    ">
                        {{ $transaction->created_at?->format('d-m-Y H:i') ?? '-' }}
                    </div>
                </div>


                {{-- Status --}}
                <div>
                    <div style="
                        font-size:13px;
                        color:#6b7280;
                        margin-bottom:5px;
                    ">
                        Status
                    </div>

                    @if($transaction->status === 'completed')

                        <span style="
                            display:inline-block;
                            background:#dcfce7;
                            color:#166534;
                            padding:6px 12px;
                            border-radius:20px;
                            font-size:13px;
                            font-weight:700;
                        ">
                            Selesai
                        </span>

                    @else

                        <span style="
                            display:inline-block;
                            background:#fef3c7;
                            color:#92400e;
                            padding:6px 12px;
                            border-radius:20px;
                            font-size:13px;
                            font-weight:700;
                        ">
                            {{ ucfirst($transaction->status ?? '-') }}
                        </span>

                    @endif

                </div>

            </div>

        </div>


        {{-- DAFTAR PRODUK --}}
        <div style="
            background:white;
            border-radius:12px;
            padding:25px;
            margin-bottom:20px;
            box-shadow:0 2px 8px rgba(0,0,0,0.06);
        ">

            <h2 style="
                margin:0 0 20px;
                font-size:20px;
                color:#111827;
            ">
                Detail Produk
            </h2>


            @if($transaction->details->count() > 0)

                <div style="
                    overflow-x:auto;
                ">

                    <table style="
                        width:100%;
                        border-collapse:collapse;
                        min-width:700px;
                    ">

                        <thead>

                            <tr style="
                                background:#f9fafb;
                            ">

                                <th style="
                                    padding:13px;
                                    text-align:left;
                                    border-bottom:1px solid #e5e7eb;
                                    font-size:13px;
                                    color:#374151;
                                ">
                                    No
                                </th>

                                <th style="
                                    padding:13px;
                                    text-align:left;
                                    border-bottom:1px solid #e5e7eb;
                                    font-size:13px;
                                    color:#374151;
                                ">
                                    Produk
                                </th>

                                <th style="
                                    padding:13px;
                                    text-align:right;
                                    border-bottom:1px solid #e5e7eb;
                                    font-size:13px;
                                    color:#374151;
                                ">
                                    Harga
                                </th>

                                <th style="
                                    padding:13px;
                                    text-align:center;
                                    border-bottom:1px solid #e5e7eb;
                                    font-size:13px;
                                    color:#374151;
                                ">
                                    Qty
                                </th>

                                <th style="
                                    padding:13px;
                                    text-align:right;
                                    border-bottom:1px solid #e5e7eb;
                                    font-size:13px;
                                    color:#374151;
                                ">
                                    Diskon
                                </th>

                                <th style="
                                    padding:13px;
                                    text-align:right;
                                    border-bottom:1px solid #e5e7eb;
                                    font-size:13px;
                                    color:#374151;
                                ">
                                    Subtotal
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($transaction->details as $detail)

                                <tr>

                                    <td style="
                                        padding:14px 13px;
                                        border-bottom:1px solid #f3f4f6;
                                        color:#6b7280;
                                    ">
                                        {{ $loop->iteration }}
                                    </td>


                                    <td style="
                                        padding:14px 13px;
                                        border-bottom:1px solid #f3f4f6;
                                    ">

                                        <div style="
                                            font-weight:700;
                                            color:#111827;
                                        ">
                                            {{ $detail->product_name ?? $detail->product->name ?? 'Produk tidak ditemukan' }}
                                        </div>

                                        @if($detail->product_code)
                                            <div style="
                                                font-size:12px;
                                                color:#9ca3af;
                                                margin-top:3px;
                                            ">
                                                Kode: {{ $detail->product_code }}
                                            </div>
                                        @endif

                                    </td>


                                    <td style="
                                        padding:14px 13px;
                                        border-bottom:1px solid #f3f4f6;
                                        text-align:right;
                                        color:#374151;
                                    ">
                                        Rp {{ number_format($detail->price, 0, ',', '.') }}
                                    </td>


                                    <td style="
                                        padding:14px 13px;
                                        border-bottom:1px solid #f3f4f6;
                                        text-align:center;
                                        color:#374151;
                                        font-weight:600;
                                    ">
                                        {{ $detail->qty }}
                                    </td>


                                    <td style="
                                        padding:14px 13px;
                                        border-bottom:1px solid #f3f4f6;
                                        text-align:right;
                                        color:#374151;
                                    ">
                                        Rp {{ number_format($detail->discount ?? 0, 0, ',', '.') }}
                                    </td>


                                    <td style="
                                        padding:14px 13px;
                                        border-bottom:1px solid #f3f4f6;
                                        text-align:right;
                                        color:#111827;
                                        font-weight:700;
                                    ">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div style="
                    text-align:center;
                    padding:40px 20px;
                    color:#6b7280;
                ">

                    <div style="
                        font-size:40px;
                        margin-bottom:10px;
                    ">
                        📦
                    </div>

                    <div style="
                        font-size:16px;
                        font-weight:600;
                    ">
                        Belum ada detail produk
                    </div>

                    <div style="
                        font-size:14px;
                        margin-top:5px;
                    ">
                        Transaksi ini tidak memiliki detail produk.
                    </div>

                </div>

            @endif

        </div>


        {{-- RINGKASAN PEMBAYARAN --}}
        <div style="
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
            gap:20px;
        ">


            {{-- KIRI --}}
            <div style="
                background:white;
                border-radius:12px;
                padding:25px;
                box-shadow:0 2px 8px rgba(0,0,0,0.06);
            ">

                <h2 style="
                    margin:0 0 20px;
                    font-size:20px;
                    color:#111827;
                ">
                    Pembayaran
                </h2>


                <div style="
                    display:flex;
                    justify-content:space-between;
                    padding:10px 0;
                    border-bottom:1px solid #f3f4f6;
                ">

                    <span style="color:#6b7280;">
                        Metode Pembayaran
                    </span>

                    <strong style="
                        color:#111827;
                        text-transform:uppercase;
                    ">
                        {{ $transaction->payment_method ?? '-' }}
                    </strong>

                </div>


                <div style="
                    display:flex;
                    justify-content:space-between;
                    padding:10px 0;
                    border-bottom:1px solid #f3f4f6;
                ">

                    <span style="color:#6b7280;">
                        Uang Dibayar
                    </span>

                    <strong style="color:#111827;">
                        Rp {{ number_format($transaction->paid_amount ?? 0, 0, ',', '.') }}
                    </strong>

                </div>


                <div style="
                    display:flex;
                    justify-content:space-between;
                    padding:10px 0;
                ">

                    <span style="color:#6b7280;">
                        Kembalian
                    </span>

                    <strong style="
                        color:#16a34a;
                        font-size:18px;
                    ">
                        Rp {{ number_format($transaction->change_amount ?? 0, 0, ',', '.') }}
                    </strong>

                </div>

            </div>


            {{-- KANAN --}}
            <div style="
                background:white;
                border-radius:12px;
                padding:25px;
                box-shadow:0 2px 8px rgba(0,0,0,0.06);
            ">

                <h2 style="
                    margin:0 0 20px;
                    font-size:20px;
                    color:#111827;
                ">
                    Ringkasan Total
                </h2>


                <div style="
                    display:flex;
                    justify-content:space-between;
                    padding:8px 0;
                    color:#6b7280;
                ">

                    <span>
                        Subtotal
                    </span>

                    <span style="color:#111827;">
                        Rp {{ number_format($transaction->subtotal ?? 0, 0, ',', '.') }}
                    </span>

                </div>


                <div style="
                    display:flex;
                    justify-content:space-between;
                    padding:8px 0;
                    color:#6b7280;
                ">

                    <span>
                        Diskon
                    </span>

                    <span style="color:#111827;">
                        Rp {{ number_format($transaction->discount ?? 0, 0, ',', '.') }}
                    </span>

                </div>


                <div style="
                    display:flex;
                    justify-content:space-between;
                    padding:8px 0;
                    color:#6b7280;
                ">

                    <span>
                        Pajak
                    </span>

                    <span style="color:#111827;">
                        Rp {{ number_format($transaction->tax ?? 0, 0, ',', '.') }}
                    </span>

                </div>


                <div style="
                    display:flex;
                    justify-content:space-between;
                    padding:8px 0 15px;
                    color:#6b7280;
                    border-bottom:1px solid #e5e7eb;
                ">

                    <span>
                        Biaya Lain
                    </span>

                    <span style="color:#111827;">
                        Rp {{ number_format($transaction->other_fee ?? 0, 0, ',', '.') }}
                    </span>

                </div>


                <div style="
                    display:flex;
                    justify-content:space-between;
                    padding-top:18px;
                ">

                    <span style="
                        font-size:18px;
                        font-weight:700;
                        color:#111827;
                    ">
                        GRAND TOTAL
                    </span>

                    <span style="
                        font-size:22px;
                        font-weight:800;
                        color:#2563eb;
                    ">
                        Rp {{ number_format($transaction->grand_total ?? 0, 0, ',', '.') }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection