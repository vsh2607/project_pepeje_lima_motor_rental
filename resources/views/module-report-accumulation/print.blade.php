<html>

<title>Laporan Akumulasi</title>

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
                <th style="padding-top: 10px; padding-bottom:15px; text-size: 50px" colspan="4">
                   LAPORAN AKUMULASI
                </th>
            </tr>
        </thead>
    </table>

    <table class="content-table">
        <thead>
            <tr>
                <th>NO</th>
                <th>Nama Kendaraan</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Selisih</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td style="width: 5%;">{{ ++$key }}</td>
                    <td style="width: 30%">{{ $item['motor_name'] }}</td>
                    <td style="text-align: right;">{{ number_format($item['debit'], 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($item['credit'], 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($item['total_saldo'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th style="text-align: right">{{ number_format($total_debit, 0, ',', '.') }}</th>
                <th style="text-align: right">{{ number_format($total_credit, 0, ',', '.') }}</th>
                <th style="text-align: right">{{ number_format($total_debit - $total_credit, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
