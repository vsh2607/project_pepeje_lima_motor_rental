@extends('adminlte::page')

@section('title', 'Tambah Data Administrasi Motor')

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
    <h1>Tambah Data Administrasi Motor</h1>
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="id_master_motor" class="required">Motor</label>
                                <select name="id_master_motor" id="id_master_motor" class="form-control" required></select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="credit" class="required">Total Pengeluaran</label>
                                <input type="text" class="form-control my-input" id="credit" name="credit" required
                                    placeholder="MASUKKAN TOTAL PENGELUARAN">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label class='required' for="credit_date">Tanggal Pengeluaran</label>
                                <input required type="text" name="credit_date" id="credit_date"
                                    class="form-control my-input" placeholder="MASUKKAN TANGGAL Pengeluaran"
                                    value="{{ \Carbon\Carbon::today()->toDateString() }}">
                            </div>

                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="total_km" class="required">Total KM</label>
                                <input required type="text" class="my-input form-control" id="total_km" name="total_km" placeholder="MASUKKAN KM MOTOR SAAT INI">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="remark" class="required">Keterangan</label>
                                <textarea name="remark" id="remark" class="form-control my-input" cols="30" rows="5" required></textarea>
                            </div>
                        </div>
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
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#credit_date').flatpickr();

            $('#id_master_motor').select2({
                ajax: {
                    url: "{{ url('resources/list-all-motor') }}",
                    data: function(params) {
                        var query = {
                            name: params.term
                        };
                        return query;
                    },
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        var processedData = $.map(data, function(obj) {
                            obj.id = obj.id;
                            obj.text = obj.name;
                            obj.nomor_polisi = obj.nomor_polisi;
                            return obj;
                        });
                        return {
                            results: processedData,
                        };
                    },
                },
                minimumInputLength: 0,
                placeholder: 'Cari Motor',
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

            $('#credit').on('input', function() {
                formatInputPriceValue("#credit");
            });

            $('#total_km').on('input', function(){
                let value = $(this).val();
                value = value.replace(/\D/g, '');
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                $(this).val(value);
            });


        });
    </script>
@stop
