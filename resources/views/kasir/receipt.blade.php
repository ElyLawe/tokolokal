<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk {{ $transaction->transaction_number }}</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #f3f4f6;
            font-family: 'Courier New', Courier, monospace, Arial, sans-serif;
            color: #000;
            padding: 20px 0;
        }

        /* 
        |--------------------------------------------------------------------------
        | PENGATURAN TAMPILAN DILAYAR (DEFAULT 58MM / 80MM)
        |--------------------------------------------------------------------------
        */
        .receipt-wrapper {
            width: 100%;
            /* Ganti ke 80mm jika mayoritas printer menggunakan ukuran 80mm */
            max-width: 58mm; 
            margin: 0 auto;
        }

        .receipt {
            background: white;
            padding: 10px 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,.08);
            border-radius: 4px;
        }

        .store-name {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .store-info {
            text-align: center;
            font-size: 10px;
            line-height: 1.3;
            margin-top: 2px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .transaction-info {
            font-size: 10px;
            line-height: 1.4;
        }

        .transaction-info-row {
            display: flex;
            justify-content: space-between;
            gap: 5px;
            margin-bottom: 2px;
        }

        .transaction-info-row span:first-child {
            color: #333;
            white-space: nowrap;
        }

        .transaction-info-row span:last-child,
        .transaction-info-row strong {
            text-align: right;
            word-break: break-all;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .items th {
            text-align: left;
            padding-bottom: 4px;
            border-bottom: 1px dashed #000;
            font-size: 10px;
        }

        .items td {
            padding: 4px 0;
            vertical-align: top;
        }

        .text-right {
            text-align: right !important;
        }

        .item-name {
            font-weight: bold;
            display: block;
            word-break: break-word;
        }

        .item-detail {
            display: block;
            font-size: 9px;
            margin-top: 1px;
        }

        .summary {
            font-size: 10px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .summary-row.total {
            font-size: 12px;
            font-weight: bold;
            padding-top: 5px;
            margin-top: 5px;
            border-top: 1px dashed #000;
        }

        .summary-row.change {
            font-weight: bold;
        }

        .payment-method {
            text-transform: uppercase;
        }

        .thank-you {
            text-align: center;
            margin-top: 10px;
            font-size: 10px;
            line-height: 1.3;
        }

        .button-area {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 15px;
        }

        .button {
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 12px;
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

        /* 
        |--------------------------------------------------------------------------
        | MODE CETAK (PRINT)
        |--------------------------------------------------------------------------
        */
        @media print {
            @page {
                /* Gunakan 58mm auto ATAU 80mm auto sesuai tipe printer Anda */
                size: 58mm auto;
                margin: 0;
            }

            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .receipt-wrapper {
                width: 100%;
                max-width: 100%;
            }

            .receipt {
                box-shadow: none;
                border-radius: 0;
                padding: 2mm 2mm;
            }

            .button-area {
                display: none !important;
            }
        }
    </style>
</head>

<body>

<div class="receipt-wrapper">
    <div class="receipt">

        {{-- HEADER TOKO --}}
        <div class="store-name">TokoLokal</div>
        <div class="store-info">
            Sistem Penjualan & Kasir<br>
            Terima kasih telah berbelanja
        </div>

        <div class="line"></div>

        {{-- INFORMASI TRANSAKSI --}}
        <div class="transaction-info">
            <div class="transaction-info-row">
                <span>No. Trans</span>
                <strong>{{ $transaction->transaction_number }}</strong>
            </div>

            <div class="transaction-info-row">
                <span>Tanggal</span>
                <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
            </div>

            <div class="transaction-info-row">
                <span>Kasir</span>
                <span>{{ $transaction->user->name ?? '-' }}</span>
            </div>

            <div class="transaction-info-row">
                <span>Pelanggan</span>
                <span>{{ $transaction->customer->name ?? 'Umum' }}</span>
            </div>
        </div>

        <div class="line"></div>

        {{-- DETAIL BARANG --}}
        <table class="items">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th class="text-right">Subtotal</th>
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
                                {{ $detail->qty }} x {{ number_format($detail->price, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-right">
                            {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="line"></div>

        {{-- RINGKASAN --}}
        <div class="summary">
            <div class="summary-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
            </div>

            @if(($transaction->discount ?? 0) > 0)
            <div class="summary-row">
                <span>Diskon</span>
                <span>-Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
            </div>
            @endif

            @if(($transaction->tax ?? 0) > 0)
            <div class="summary-row">
                <span>Pajak</span>
                <span>Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
            </div>
            @endif

            @if(($transaction->other_fee ?? 0) > 0)
            <div class="summary-row">
                <span>Biaya Lain</span>
                <span>Rp {{ number_format($transaction->other_fee, 0, ',', '.') }}</span>
            </div>
            @endif

            <div class="summary-row total">
                <span>TOTAL</span>
                <span>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
            </div>

            <div class="summary-row">
                <span>Bayar</span>
                <span>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</span>
            </div>

            <div class="summary-row change">
                <span>Kembalian</span>
                <span>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
            </div>

            <div class="summary-row">
                <span>Metode</span>
                <span class="payment-method">{{ $transaction->payment_method }}</span>
            </div>
        </div>

        <div class="line"></div>

        {{-- FOOTER --}}
        <div class="thank-you">
            <strong>Transaksi berhasil!</strong><br>
            Terima kasih telah berbelanja.<br>
            Semoga hari Anda menyenangkan.
        </div>

    </div>

    {{-- TOMBOL AKSfile --}}
    <div class="button-area">
        <button type="button" class="button button-print" onclick="window.print()">
            🖨 Cetak Struk
        </button>

        <a href="{{ route('transactions.create') }}" class="button button-back">
            ← Transaksi Baru
        </a>
    </div>
</div>

<script>
    window.addEventListener('load', function () {
        setTimeout(function () {
            window.print();
        }, 500);
    });
</script>

</body>
</html>