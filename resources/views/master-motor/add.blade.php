@extends('adminlte::page')

@section('title', 'Tambah Data Motor')

@section('adminlte_css_pre')
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
    <style>
        .required::after {
            content: '*';
            color: red;
        }
    </style>
@endsection

@section('content_header')
    <h1>Tambah Data Motor</h1>
@stop

@section('content')

    <div class="container-fluid" style="margin-top:20px; text-transform: uppercase;">
        <form method="POST" enctype="multipart/form-data">
            <div class="card">
                <div class="card-body">
                    @csrf
                    <div class="form-group">
                        <label class='required' for="name">Nama Kendaraan</label>
                        <input required type="text" name="name" id="name" class="form-control my-input"
                            placeholder="Masukkan Nama Kendaraan">
                    </div>
                    <div class="form-group">
                        <label class='required' for="nomor_polisi">Nomor Polisi</label>
                        <input required type="text" name="nomor_polisi" id="nomor_polisi" class="form-control my-input"
                            placeholder="Masukkan Nomor Polisi">
                    </div>
                    <div class="form-group">
                        <label class='required' for="nama_pemilik">Nama Pemilik</label>
                        <input required type="text" name="nama_pemilik" id="nama_pemilik" class="form-control my-input"
                            placeholder="Masukkan Nama Pemilik">
                    </div>
                    <div class="form-group">
                        <label class='required' for="tahun_pembuatan">Tahun Pembuatan</label>
                        <input required type="number" name="tahun_pembuatan" id="tahun_pembuatan"
                            class="form-control my-input" placeholder="Masukkan Tahun Pembuatan" min="1900"
                            max="{{ date('Y') }}">
                    </div>
                    <div class="form-group">
                        <label class='required' for="warna_kb">Warna KB</label>
                        <input required type="text" name="warna_kb" id="warna_kb" class="form-control my-input"
                            placeholder="Masukkan Warna KB">
                    </div>
                    <div class="form-group">
                        <label class='required' for="tanggal_pajak">Tanggal Pajak</label>
                        <input required type="text" name="tanggal_pajak" id="tanggal_pajak" class="form-control my-input"
                            placeholder="Masukkan Tanggal Pajak">
                    </div>
                    <div class="form-group">
                        <label class='required' for="tanggal_pembelian">Tanggal Pembelian</label>
                        <input required type="text" name="tanggal_pembelian" id="tanggal_pembelian"
                            class="form-control my-input" placeholder="Masukkan Tanggal Pembelian">
                    </div>
                    <div class="form-group">
                        <label class='required' for="harga_sewa_harian">Harga Sewa Harian</label>
                        <input required type="text" name="harga_sewa_harian" id="harga_sewa_harian"
                            class="form-control my-input" placeholder="Masukkan Harga Sewa Harian">
                    </div>
                    <div class="form-group">
                        <label class='required' for="harga_sewa_bulanan">Harga Sewa Bulanan</label>
                        <input required type="text" name="harga_sewa_bulanan" id="harga_sewa_bulanan"
                            class="form-control my-input" placeholder="Masukkan Harga Sewa Bulanan">
                    </div>
                    <div class="form-group">
                        <label for="img_url">Upload Gambar Kendaraan</label>
                        <input type="file" name="img_url" id="img_url" class="form-control"
                            placeholder="Upload Gambar Kendaraan">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </div>
            </div>
        </form>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.FlatPickr', true)
@section('js')
    <script>
        $(document).ready(function() {
            $("#tanggal_pajak").flatpickr();
            $("#tanggal_pembelian").flatpickr();
        });

        function formatInputPriceValue(inputId) {
            let value = $(inputId).val();
            value = value.replace(/\D/g, '');
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            value = 'Rp. ' + value;
            $(inputId).val(value);
        }

        $('.my-input').on('input', function() {
            $(this).val($(this).val().toUpperCase());
        })

        $('#harga_sewa_harian').on('input', function() {
            formatInputPriceValue("#harga_sewa_harian");
        });

        $('#harga_sewa_bulanan').on('input', function() {
            formatInputPriceValue("#harga_sewa_bulanan");
        });
    </script>
@stop
