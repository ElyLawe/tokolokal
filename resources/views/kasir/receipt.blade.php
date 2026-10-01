<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Struk {{ $transaction->transaction_number }}
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            background: #f3f4f6;
            font-family: Arial, Helvetica, sans-serif;
            color: #111827;
        }

        .receipt-wrapper {
            max-width: 420px;
            margin: 0 auto;
        }

        .receipt {
            background: white;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
        }

        .store-name {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .store-info {
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            line-height: 1.5;
        }

        .line {
            border-top: 1px dashed #9ca3af;
            margin: 15px 0;
        }

        .transaction-info {
            font-size: 13px;
            line-height: 1.7;
        }

        .transaction-info-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .transaction-info-row span:first-child {
            color: #6b7280;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .items th {
            text-align: left;
            padding-bottom: 8px;
            border-bottom: 1px solid #d1d5db;
        }

        .items td {
            padding: 8px 0;
            vertical-align: top;
        }

        .text-right {
            text-align: right !important;
        }

        .item-name {
            font-weight: 600;
        }

        .item-detail {
            display: block;
            color: #6b7280;
            font-size: 11px;
            margin-top: 3px;
        }

        .summary {
            font-size: 13px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .summary-row.total {
            font-size: 18px;
            font-weight: bold;
            padding-top: 10px;
            margin-top: 10px;
            border-top: 1px dashed #9ca3af;
        }

        .summary-row.change {
            font-weight: bold;
        }

        .payment-method {
            text-transform: uppercase;
        }

        .thank-you {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #374151;
        }

        .button-area {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .button {
            border: none;
            border-radius: 7px;
            padding: 11px 18px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .button-print {
            background: #2563eb;
            color: white;
        }

        .button-back {
            background: white;
            color: #374151;
            border: 1px solid #d1d5db;
        }


        /* =========================================
           MODE CETAK
        ========================================= */

        @media print {

            @page {
                size: 80mm auto;
                margin: 5mm;
            }

            body {
                background: white;
                padding: 0;
            }

            .receipt-wrapper {
                width: 100%;
                max-width: none;
            }

            .receipt {
                box-shadow: none;
                border-radius: 0;
                padding: 0;
            }

            .button-area {
                display: none;
            }

        }


        /* =========================================
           PRINTER THERMAL 58MM
        ========================================= */

        @media print and (max-width: 70mm) {

            @page {
                size: 58mm auto;
                margin: 3mm;
            }

            body {
                font-size: 11px;
            }

            .store-name {
                font-size: 17px;
            }

            .store-info {
                font-size: 9px;
            }

            .items {
                font-size: 10px;
            }

            .summary {
                font-size: 10px;
            }

            .summary-row.total {
                font-size: 14px;
            }

        }

    </style>

</head>


<body>

<div class="receipt-wrapper">

    <div class="receipt">

        {{-- =========================================
             HEADER TOKO
        ========================================== --}}

        <div class="store-name">
            TokoMini
        </div>

        <div class="store-info">
            Sistem Penjualan & Kasir
            <br>
            Terima kasih telah berbelanja
        </div>


        <div class="line"></div>


        {{-- =========================================
             INFORMASI TRANSAKSI
        ========================================== --}}

        <div class="transaction-info">

            <div class="transaction-info-row">
                <span>No. Transaksi</span>

                <strong>
                    {{ $transaction->transaction_number }}
                </strong>
            </div>


            <div class="transaction-info-row">
                <span>Tanggal</span>

                <span>
                    {{ $transaction->created_at->format('d/m/Y H:i') }}
                </span>
            </div>


            <div class="transaction-info-row">
                <span>Kasir</span>

                <span>
                    {{ $transaction->user->name ?? '-' }}
                </span>
            </div>


            <div class="transaction-info-row">
                <span>Pelanggan</span>

                <span>
                    {{ $transaction->customer->name ?? 'Umum' }}
                </span>
            </div>

        </div>


        <div class="line"></div>


        {{-- =========================================
             DETAIL BARANG
        ========================================== --}}

        <table class="items">

            <thead>

                <tr>

                    <th>
                        Barang
                    </th>

                    <th class="text-right">
                        Subtotal
                    </th>

                </tr>

            </thead>


            <tbody>

                @foreach($transaction->details as $detail)

                    <tr>

                        <td>

                            <span class="item-name">
                                {{ $detail->product_name ?? $detail->product->name ?? '-' }}
                            </span>

                            <span class="item-detail">
                                {{ $detail->qty }}
                                x
                                Rp {{ number_format($detail->price, 0, ',', '.') }}
                            </span>

                        </td>


                        <td class="text-right">

                            Rp
                            {{ number_format($detail->subtotal, 0, ',', '.') }}

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>


        <div class="line"></div>


        {{-- =========================================
             RINGKASAN
        ========================================== --}}

        <div class="summary">

            <div class="summary-row">

                <span>
                    Subtotal
                </span>

                <span>
                    Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}
                </span>

            </div>


            <div class="summary-row">

                <span>
                    Diskon
                </span>

                <span>
                    Rp {{ number_format($transaction->discount, 0, ',', '.') }}
                </span>

            </div>


            <div class="summary-row">

                <span>
                    Pajak
                </span>

                <span>
                    Rp {{ number_format($transaction->tax, 0, ',', '.') }}
                </span>

            </div>


            <div class="summary-row">

                <span>
                    Biaya Lain
                </span>

                <span>
                    Rp {{ number_format($transaction->other_fee, 0, ',', '.') }}
                </span>

            </div>


            <div class="summary-row total">

                <span>
                    TOTAL
                </span>

                <span>
                    Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                </span>

            </div>


            <div class="summary-row">

                <span>
                    Bayar
                </span>

                <span>
                    Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}
                </span>

            </div>


            <div class="summary-row change">

                <span>
                    Kembalian
                </span>

                <span>
                    Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}
                </span>

            </div>


            <div class="summary-row">

                <span>
                    Metode
                </span>

                <span class="payment-method">
                    {{ $transaction->payment_method }}
                </span>

            </div>

        </div>


        <div class="line"></div>


        {{-- =========================================
             FOOTER
        ========================================== --}}

        <div class="thank-you">

            <strong>
                Transaksi berhasil!
            </strong>

            <br>

            Terima kasih telah berbelanja di TokoMini.

            <br>

            Semoga hari Anda menyenangkan.

        </div>

    </div>


    {{-- =========================================
         BUTTON
    ========================================== --}}

    <div class="button-area">

        <button
            type="button"
            class="button button-print"
            onclick="window.print()"
        >
            🖨 Cetak Struk
        </button>


        <a
            href="{{ route('transactions.create') }}"
            class="button button-back"
        >
            ← Transaksi Baru
        </a>

    </div>

</div>


<script>

    /*
    |--------------------------------------------------------------------------
    | OTOMATIS BUKA DIALOG PRINT
    |--------------------------------------------------------------------------
    */

    window.addEventListener('load', function () {

        setTimeout(function () {

            window.print();

        }, 500);

    });

</script>

</body>

</html>