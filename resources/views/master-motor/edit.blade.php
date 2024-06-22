@extends('adminlte::page')

@section('title', 'Edit Data Motor')

@section('adminlte_css_pre')
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
@endsection

@section('content_header')
    <h1>Edit Data Motor</h1>
@stop
@section('content')
    <div class="container-fluid" style="margin-top:20px; text-transform: uppercase;">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-header">Gambar Motor</div>
                    <div class="card-body">
                        <img src="{{ asset('motor_images') . '/' . $data->img_url }}" alt="motor img" width="200px">
                    </div>
                    <div class="card-footer" style="text-align: center">
                        @if ($data->status == 1)
                            <span class='badge badge-success'>Tersedia</span>
                        @else
                            <span class='badge badge-danger'>Dipinjam</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <a href='{{ url('master-data/master-motor/' . $data->id . '/edit') }}'
                            class='btn  btn-warning d-inline-block float-right'><i class='fas fa-edit'></i></a>
                    </div>
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Kendaraan</label>
                            <input readonly type="text" name="name" id="name" class="form-control"
                                value="{{ $data->name }}">
                        </div>
                        <div class="form-group">
                            <label for="nomor_polisi">Nomor Polisi</label>
                            <input readonly type="text" name="nomor_polisi" id="nomor_polisi" class="form-control "
                                value="{{ $data->nomor_polisi }}">
                        </div>
                        <div class="form-group">
                            <label for="nama_pemilik">Nama Pemilik</label>
                            <input readonly type="text" name="nama_pemilik" id="nama_pemilik" class="form-control "
                                value="{{ $data->nama_pemilik }}">
                        </div>
                        <div class="form-group">
                            <label for="tahun_pembuatan">Tahun Pembuatan</label>
                            <input readonly type="number" name="tahun_pembuatan" id="tahun_pembuatan" class="form-control"
                                value="{{ $data->tahun_pembuatan }}">
                        </div>
                        <div class="form-group">
                            <label for="warna_kb">Warna KB</label>
                            <input readonly type="text" name="warna_kb" id="warna_kb" class="form-control "
                                value="{{ $data->warna_kb }}">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pajak">Tanggal Pajak</label>
                            <input readonly type="text" name="tanggal_pajak" id="tanggal_pajak" class="form-control "
                                value="{{ Carbon\Carbon::parse($data->tanggal_pajak)->format('Y F d') }}">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pembelian">Tanggal Pembelian</label>
                            <input readonly type="text" name="tanggal_pembelian" id="tanggal_pembelian"
                                class="form-control "
                                value="{{ Carbon\Carbon::parse($data->tanggal_pembelian)->format('Y F d') }}">
                        </div>
                        <div class="form-group">
                            <label for="harga_sewa_harian">Harga Sewa Harian</label>
                            <input readonly type="text" name="harga_sewa_harian" id="harga_sewa_harian"
                                class="form-control "
                                value="{{ 'Rp ' . number_format($data->harga_sewa_harian, 0, ',', '.') }}">
                        </div>
                        <div class="form-group">
                            <label for="harga_sewa_bulanan">Harga Sewa Bulanan</label>
                            <input readonly type="text" name="harga_sewa_bulanan" id="harga_sewa_bulanan"
                                class="form-control "
                                value="{{ 'Rp ' . number_format($data->harga_sewa_bulanan, 0, ',', '.') }}">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                    </div>
                </div>

            </div>

        </div>

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
