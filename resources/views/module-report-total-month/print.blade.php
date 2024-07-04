<html>

<title>Laporan Tiap Bulan Tahun {{ $year }}</title>

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
                <th style="padding-top: 10px; padding-bottom:15px; text-size: 50px; text-transform:uppercase;"
                    colspan="4">
                    LAPORAN TIAP BULAN TAHUN {{ $year }}
                </th>
            </tr>
        </thead>
    </table>

    <table class="content-table">
        <thead>
            <tr>
                <th style="width: 1px">NO</th>
                <th style="width: 10px">Bulan</th>
                <th style="width: 10px">Debit</th>
                <th style="width: 10px">Kredit</th>
                <th style="width: 10px">Selisih</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>
                        @php

                            $date = Carbon\Carbon::createFromFormat('Y-m', $item->formatted_date);
                            $date = $date->format('F Y');
                        @endphp
                        {{ $date }}
                    </td>
                    <td style="text-align: right;">{{ number_format($item->total_debit, 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($item->total_credit, 0, ',', '.') }}</td>
                    <td style="text-align: right;">{{ number_format($item->total_deposit, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th style="text-align: right">{{ number_format($total_debit, 0, ',', '.') }}</th>
                <th style="text-align: right">{{ number_format($total_credit, 0, ',', '.') }}</th>
                <th style="text-align: right">{{ number_format($total_deposit, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
