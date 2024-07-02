<html>

<title>Laporan Sewa Harian {{ $date_start }} - {{ $date_end }}</title>

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
                <td>Tanggal Awal</td>
                <td>:</td>
                <td style="font-weight: bold;">{{ $date_start }}</td>
            </tr>
            <tr>
                <td>Tanggal Akhir</td>
                <td>:</td>
                <td style="font-weight: bold;">{{ $date_end }}</td>
            </tr>
        </tbody>
    </table>

    <table class="content-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Motor</th>
                <th>Nama Penyewa</th>
                <th>No. Kontak</th>
                <th>No. Polisi</th>
                <th>Tgl mulai sewa</th>
                <th>Tgl akhir sewa</th>
                <th>Jumlah Hari</th>
                <th>Harga Sewa</th>
                <th>TOtal Sewa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $item->penyewaan->motor->name }}</td>
                    <td>{{ $item->penyewaan->nama_penyewa }}</td>
                    <td>{{ $item->penyewaan->kontak_penyewa }}</td>
                    <td style="width:70px;">{{ $item->penyewaan->motor->nomor_polisi }}</td>
                    <td>{{ $item->penyewaan->tanggal_penyewaan }}</td>
                    <td>{{ $item->penyewaan->tanggal_pengembalian }}</td>
                    <td>{{ $item->total_hari_sewa }} hari</td>
                    <td>
                        @php
                            $harga_sewa = 0;
                            if ($item->penyewaan->jenis_penyewaan == 'harian') {
                                $harga_sewa = number_format($item->penyewaan->motor->harga_sewa_harian, 0, ',', '.');
                            }
                            $harga_sewa = number_format($item->penyewaan->motor->harga_sewa_bulanan, 0, ',', '.');
                        @endphp
                        {{ $harga_sewa }}
                    </td>
                    <td>{{ number_format($item->debit, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="9">Total</th>
                <th>{{ number_format($total_harga_sewa, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>
