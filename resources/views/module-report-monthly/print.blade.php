<html>

<title>Laporan Keuangan Bulan {{ $month }}</title>

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
            <tr>
                <th style="padding-top: 10px; padding-bottom:15px; text-size: 50px; text-transform:uppercase;" colspan="4">
                    LAPORAN KEUANGAN BULANAN
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 150px; font-weight:bold;">{{ $month }}</td>
            </tr>
        </tbody>
    </table>

    <table class="content-table">
        <thead>
            <tr>
                <th style="width: 1px">NO</th>
                <th style="width: 1px">Tanggal</th>
                <th style="width: 5px">Nama Motor</th>
                <th style="width: 20px">Keterangan</th>
                <th style="width: 10px">Debit</th>
                <th style="width: 10px">Kredit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $item['tanggal'] }}</td>
                    <td>{{ $item['motor_name'] }}</td>
                    <td>{{ $item['remark'] }}</td>
                    <td style="text-align: right;">{{ number_format($item['debit'], 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($item['credit'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total</th>
                <th style="text-align: right">{{ number_format($total_debit, 0, ',', '.') }}</th>
                <th style="text-align: right">{{ number_format($total_credit, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="4">Total Pemasukan Bulan {{ $month }}</th>
                <th colspan="2">{{  number_format($total_debit - $total_credit, 0, ',', '.')  }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
