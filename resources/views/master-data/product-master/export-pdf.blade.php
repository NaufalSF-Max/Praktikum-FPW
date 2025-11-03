<!DOCTYPE html>
<html>
<head>
    <title>Rekap Mutasi Stock</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header-text { text-align: left; margin-bottom: 20px; }
        .title { font-size: 24px; font-weight: bold; }
        .subtitle { font-size: 20px; }
        .company { font-size: 18px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer-table { width: 100%; margin-top: 40px; border: none; }
        .footer-table td { text-align: center; border: none; }
    </style>
</head>
<body>

    <div class="header-text">
        <div class="title">BEE</div>
        <div class="subtitle">ACCOUNTING</div>
        <div class="company">Bee Gas Jaya Nusantara</div>
    </div>

    <p>The following table: (Contoh Teks)</p>
    <p>Rekap Mutasi Stock Bulanan (Contoh Judul)</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Unit</th>
                <th>Type</th>
                <th>Qty</th>
                <th>Producer</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->unit }}</td>
                <td>{{ $product->type }}</td>
                <td>{{ $product->qty }}</td>
                <td>{{ $product->producer }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td>
                Dilaksanakan Oleh
                <br><br><br><br>
                (Logistik)
            </td>
            <td>
                Diketahui Oleh
                <br><br><br><br>
                (Kepala Depo)
            </td>
            <td>
                <br><br><br><br>
                (Fin & ACC)
            </td>
        </tr>
    </table>
</body>
</html>