@extends('adminlte::page')

@section('title', 'Info Data Penyewaan')

@section('adminlte_css_pre')
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
@endsection

@section('content_header')
    <h1>Info Data Penyewaan</h1>
@stop
@section('content')
    <div class="container-fluid" style="margin-top:20px; text-transform: uppercase;">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-header">Gambar Motor</div>
                    <div class="card-body">
                        <img src="{{ asset('motor_images') . '/' . $data->motor->img_url }}" alt="motor img" width="200px">
                    </div>
                    <div class="card-footer" style="text-align: center">
                        @if ($data->status == 1)
                            <span class='badge badge-warning'>Masih Dipinjam</span>
                            <span class='badge badge-warning'>{{ $total_hari_sewa }} hari</span>
                            <span class='badge badge-warning'>{{ $total_biaya_sewa }}</span>
                        @else
                            <span class='badge badge-success'>Sudah Kembali</span>
                        @endif


                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Gambar Jaminan</div>
                    <div class="card-body">
                        <img src="{{ asset('jaminan_images') . '/' . $data->jaminan_img }}" alt="jaminan img" width="200px">
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        <a href='{{ url('module-penyewaan/module-sewa/' . $data->id . '/edit') }}'
                            class='btn  btn-warning d-inline-block float-right'><i class='fas fa-edit'></i></a>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class='required' for="id_master_motor">Nama Kendaraan</label>
                            <input type="text" name="id_master_motor" id="id_master_motor" class="form-control" readonly
                                value="{{ $data->motor->name }}">
                        </div>
                        <div class="form-group">
                            <label class='required' for="nomor_polisi">Nomor Polisi</label>
                            <input type="text" required readonly name="nomor_polisi" id="nomor_polisi"
                                class="form-control my-input" value="{{ $data->motor->nomor_polisi }}">
                        </div>
                        <div class="form-group">
                            <label class='required' for="nama_penyewa">Nama Penyewa</label>
                            <input readonly type="text" class="form-control my-input" name="nama_penyewa"
                                id="nama_penyewa" required placeholder="MASUKKAN NAMA PENYEWA"
                                value="{{ $data->nama_penyewa }}">
                        </div>
                        <div class="form-group">
                            <label class='required' for="kontak_penyewa">No. Kontak Penyewa</label>
                            <input readonly type="text" class="form-control my-input my-number" name="kontak_penyewa"
                                id="kontak_penyewa" required placeholder="MASUKKAN NO. KONTAK PENYEWA"
                                value="{{ $data->kontak_penyewa }}">
                        </div>
                        <div class="form-group">
                            <label for="jaminan">Jaminan</label>
                            <input type="text" name="jaminan" id="jaminan" value="{{ $data->jaminan }}"
                                class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label class='required' for="jenis_penyewaan">Jenis Penyewaan</label>
                            <input type="text" name="jenis_penyewaan" id="jenis_penyewaan"
                                value="{{ strtoupper($data->jenis_penyewaan) }}" class="form-control" readonly>

                        </div>

                        <div class="form-group">
                            <label class='required' for="tanggal_penyewaan">Tanggal Penyewaan</label>
                            <input required readonly type="text" name="tanggal_penyewaan" id="tanggal_penyewaan"
                                class="form-control my-input" placeholder="MASUKKAN TANGGAL PENYEWAAN"
                                value="{{ $data->tanggal_penyewaan }}">
                        </div>
                        {{-- <div class="form-group">

                            <label class='required' for="total_hari_sewa">Total Hari Sewa</label>
                            <input required readonly type="text" name="total_hari_sewa" id="total_hari_sewa"
                                class="form-control my-input" value="{{ $total_hari_sewa }} Hari">
                        </div>
                        <div class="form-group">

                            <label class='required' for="total_biaya_sewa">Total Biaya Sewa</label>
                            <input required readonly type="text" name="total_biaya_sewa" id="total_biaya_sewa"
                                class="form-control my-input" value="{{ $total_biaya_sewa }}">
                        </div> --}}
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

@stop
