@extends('adminlte::page')

@section('title', 'Info Data Administrasi Motor')

@section('adminlte_css_pre')
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .required::after {
            content: '*';
            color: red;
        }
    </style>
@endsection

@section('content_header')
    <h1>Info Data Administrasi Motor</h1>
@stop

@section('content')
    @if (session('error'))
        <div class="alert alert-danger mb-2">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success mb-2">
            {{ session('success') }}
        </div>
    @endif
    <div class="container-fluid" style="margin-top:20px; text-transform: uppercase;">
        <form method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                    <a href='{{ url('/module-manajemen/module-administrasi-motor/' . $data->id . '/edit') }}'
                        class='btn  btn-warning d-inline-block float-right'><i class='fas fa-edit'></i></a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="id_master_motor">Motor</label>
                                <input name="id_master_motor" id="id_master_motor" class="form-control" readonly
                                    value="{{ $data->motor->name }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="credit">Total Pengeluaran</label>
                                <input type="text" class="form-control my-input" id="credit" name="credit" readonly
                                    placeholder="MASUKKAN TOTAL PENGELUARAN"
                                    value="Rp. {{ number_format($data->credit, 0, ',', '.') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="credit_date">Tanggal Pengeluaran</label>
                                <input readonly type="text" name="credit_date" id="credit_date"
                                    class="form-control my-input" placeholder="MASUKKAN TANGGAL Pengeluaran"
                                    value="{{ $data->credit_date }}">
                            </div>

                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="total_km">Total KM</label>
                                <input value="{{ number_format($data->logKm->total_km, 0, ',', '.') }}" type="text"
                                    readonly class="my-input form-control" id="total_km" name="total_km"
                                    placeholder="MASUKKAN KM MOTOR SAAT INI">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="remark">Keterangan</label>
                                <textarea name="remark" id="remark" class="form-control my-input" cols="30" rows="5" readonly>{{ $data->remark }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </form>
    </div>


@stop

@section('plugins.Datatables', true)
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@stop
