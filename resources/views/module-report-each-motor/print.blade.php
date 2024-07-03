<html>

<title>Laporan Keuangan Motor {{ $motor_name }}</title>

<head>
    <style>
        @page {
            size: a4;
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 10px;
        }

        .content-table {
            width: 100%;
            border: 1px solid;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
            text-transform: uppercase;
        }

        .content-table th {
            text-align: center;
            border: 1px solid;
        }

        .content-table td {
            border: 1px solid;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <table width='100%' style="text-transform: uppercase;">
        <thead>
            <tr>
                <th colspan="3">
                    <img src="{{ public_path('assets/header_kwitansi.jpg') }}" alt="logo kwitansi" width="760px">
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 200px;">Jenis Motor</td>
                <td style="width: 20px;">:</td>
                <td style="font-weight: bold;">{{ $motor_name }}</td>
            </tr>
            <tr>
                <td>Nomor Polisi</td>
                <td>:</td>
                <td style="font-weight: bold;">{{ $nomor_polisi }}</td>
            </tr>

        </tbody>
    </table>

    <table class="content-table">
        <thead>
            <tr>
                <th style="width: 5px">NO</th>
                <th style="width: 5px">Tanggal</th>
                <th style="width: 5px">KM</th>
                <th style="width: 20px">Uraian</th>
                <th style="width: 20px">Debet</th>
                <th style="width: 20px">Kredit</th>
                <th style="width: 20px">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $item['tanggal'] }}</td>
                    <td style="text-align: center;">{{ number_format($item['total_km'], 0, ',', '.') }}</td>
                    <td>{{ $item['remark'] }}</td>
                    <td style="text-align: right;">{{ number_format($item['debit'], 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($item['credit'], 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($item['total_deposit'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total</th>
                <th style="text-align: right">{{ number_format($total_debit, 0, ',', '.') }}</th>
                <th style="text-align: right">{{ number_format($total_credit, 0, ',', '.') }}</th>
                <th style="text-align: right">{{ number_format($total_debit - $total_credit, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
