<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .receipt-container {
            text-align: center;
            margin: 20px;
        }
        h2.receipt-title {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .date-section {
            text-align: right;
            margin-right: 10px;
            font-size: 14px;
        }
        .table-header {
            text-align: left;
            font-weight: bold;
            font-size: 16px;
        }
        .table-data {
            text-align: right;
            font-size: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th,
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        hr {
            border: 1px solid #ddd;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <hr>
        <h2 class="receipt-title">Struk Transaksi</h2>
        <div class="date-section">{{ $transaction->tanggal_transaction }}</div>
        <div>
            <p>ID Transaksi: {{ $transaction->invoice }}</p>
            <p>ID Pembayaran: {{ $transaction->id }}</p>
            <p>Nama Customer: {{ $transaction->customer ?? 'Customer' }}</p>
        </div>
        <hr>
        <table align="center" cellspacing="0" cellpadding="10">
            <tr>
                <th align="center" class="table-header">Nama Product</th>
                <th align="center" class="table-header">Jumlah</th>
                <th align="center" class="table-header">Harga Satuan</th>
                <th align="center" class="table-header">Total</th>
            </tr>
            @foreach ($rows as $row)
                <tr>
                    <td align="center" class="table-data">{{ $row['nama'] }}</td>
                    <td align="center" class="table-data">{{ $row['qty'] }}</td>
                    <td align="center" class="table-data">Rp. {{ number_format($row['harga'], 0, ',', '.') }}</td>
                    <td align="center" class="table-data">Rp. {{ number_format($row['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
        <hr>
        <table align="center" cellspacing="0" cellpadding="10">
            <tr>
                <th class="table-header">Total Harga</th>
                <th class="table-data">Rp. {{ number_format($dibayar, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th class="table-header">Kembali</th>
                <th class="table-data">Rp. {{ number_format($kembali, 0, ',', '.') }}</th>
            </tr>
        </table>
        <hr>
        <div>
            <h5 style="font-style: italic;" align="center">Terimakasih Telah Berbelanja Di Sini</h5>
        </div>
    </div>
</body>
</html>
