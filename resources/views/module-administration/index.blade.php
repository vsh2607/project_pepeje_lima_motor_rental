@extends('adminlte::page')

@section('title', 'List Administrasi Motor')

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
    <h1>List Administrasi Motor</h1>
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
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-1 col-sm-12">
                        <p class='required'>Nama Motor</p>
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <select name="filter_by_name" id="filter_by_name" class="form-control">
                            <option value="all" selected>Semua Motor</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-sm-12">
                        <p class="required">Tanggal Awal</p>
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <input type="text" class="form-control" id="filter_by_date_start" name="filter_by_date_start"
                            value="{{ \Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d') }}">
                    </div>
                    <div class="col-lg-1 col-sm-12">
                        <p class="required">Tanggal Akhir</p>
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <input type="text" class="form-control" id="filter_by_date_end" name="filter_by_date_start_end"
                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <button class="btn btn-filter btn-primary">Filter</button>
                        <button class="btn btn-reset btn-secondary">Reset</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <a href="{{ url('/module-manajemen/module-administrasi-motor/add') }}" class="btn btn-success float-right">+
                    Tambah</a>
            </div>
            <div class="card-body">
                <table class="table table-stripped" id="list_table">
                    <thead>
                        <tr>
                            <th style="width: 10px">NO</th>
                            <th>Nama Motor</th>
                            <th>Tanggal Pengeluaran</th>
                            <th>Total Pengeluaran</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('#filter_by_date_start').flatpickr();
        $('#filter_by_date_end').flatpickr();
        $('#filter_by_name').select2({
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
            placeholder: 'Cari Motor Tersedia',
        });

        $('.btn-filter').on('click', function() {
            $('#list_table').DataTable().ajax.reload();
        });

        $('.btn-reset').on('click', function() {
            $('#filter_by_name').val('all').trigger('change');
            $('#filter_by_date_start').val('{{ \Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d') }}');
            $('#filter_by_date_end').val('{{ \Carbon\Carbon::now()->format('Y-m-d') }}');
            $('#list_table').DataTable().ajax.reload();
        });

        $(document).ready(function() {
            $('#list_table').DataTable({
                processing: true,
                serverSide: true,
                "lengthMenu": [
                    [100, 250, 500, 1000],
                    [100, 250, 500, 1000]
                ],
                info: false,
                ajax: {
                    url: "{{ url('/module-manajemen/module-administrasi-motor/list-data') }}",
                    data: function(d) {
                        d.name = $("#filter_by_name").val();
                        d.date_start = $("#filter_by_date_start").val();
                        d.date_end = $("#filter_by_date_end").val();
                    }
                },
                columnDefs: [{
                    "targets": [0],
                    "visible": true,
                    "searchable": false,
                    "orderable": false,
                }],
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'motor.name',
                        name: 'motor.name'
                    },
                    {
                        data: 'credit_date',
                        name: 'credit_date'
                    },
                    {
                        data: 'credit',
                        name: 'credit'
                    },
                    {
                        data: 'remark',
                        name: 'remark'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],


                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();
                    var total = api
                        .column(3, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(sum, value) {
                            var cleanValue = String(value).replace(/\./g, '');
                            return sum + parseFloat(cleanValue);
                        }, 0);


                    var formattedTotal = total.toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });

                    $(api.column(3).footer()).html(formattedTotal);
                }
            });
        });
    </script>
@stop
