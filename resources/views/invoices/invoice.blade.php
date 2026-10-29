<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ccc; padding: 8px; }
        .total { font-weight: bold; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>INVOICE</h2>
        <p>No: {{ $invoice->id }}[cite: 8]</p>
        <p>Tanggal: {{ $invoice->created_at->format('d/m/Y') }}[cite: 8]</p>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->product->name }}[cite: 8]</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}[cite: 8]</td>
                <td>{{ $item->quantity }}[cite: 8]</td>
                <td>Rp {{ number_format($item->total, 0, ',', '.') }}[cite: 8]</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Grand Total:</td>
                <td class="total">Rp {{ number_format($invoice->total, 0, ',', '.') }}[cite: 8]</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>