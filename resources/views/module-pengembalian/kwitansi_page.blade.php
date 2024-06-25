<html>

<title>Kwitansi Penyewaan Motor {{ $nama_penyewa}}</title>
<head>
    <style>
        @page {
            size: a4;
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 10px;
        }

        table{
            /* border:1px solid; */
        }
        th, td{
            /* border: 1px solid; */
        }

    </style>
</head>

<body>
    <table width='100%'>
        <thead>
            <tr>
                <th colspan="4">
                    <img src="{{ public_path('assets/header_kwitansi.jpg') }}" alt="logo kwitansi" width="760px">
                </th>
            </tr>
            <tr>
                <th style="padding-top: 10px; padding-bottom:15px; text-size: 50px" colspan="4">
                   KWITANSI
                </th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td style="width: 150px">Telah Diterima Dari</td>
                <td style="width: 5px;">:</td>
                <td style="font-weight: bold">{{ $nama_penyewa }}</td>
                <td></td>
            </tr>
            <tr>
                <td style="width: 150px">Uang Sebanyak</td>
                <td style="width: 5px;">:</td>
                <td style="font-weight: bold; background-color: #bcd4eb;">{{ $tot_sewa_terbilang }}</td>
                <td></td>
            </tr>
            <tr>
                <td style="width: 150px;">Guna Membayar</td>
                <td style="width: 5px;">:</td>
                <td colspan="2">Biaya sewa sepeda motor {{ $nama_motor }} selama {{ $interval }} hari ({{ $tanggal_mulai_sewa }} - {{ $tanggal_akhir_sewa }})</td>

            </tr>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="4" style="height: 20px;"></td>

            </tr>
            <tr>
                <td style="width: 150px; "></td>
                <td style="width: 5px;"></td>
                <td></td>
                <td style="text-align: center;">Yogyakarta, {{ $tanggal_cetak_kwitansi }}</td>
            </tr>
            <tr>
                <td style="width: 150px; height:80px"></td>
                <td style="width: 5px;"></td>
                <td></td>
                <td style="text-align: center;"></td>
            </tr>
            <tr>
                <td style="width: 150px;">Terbilang</td>
                <td style="width: 5px;"></td>
                <td style="background-color:#bcd4eb; font-weight: bold">{{ $tot_sewa_nominal }}</td>
                <td style="text-align: center;">L. Jacobus</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
