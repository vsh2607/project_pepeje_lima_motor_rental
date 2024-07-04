@extends('adminlte::page')

@section('title', 'Laporan Keuangan Bulanan')

@section('adminlte_css_pre')
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">

    <style>
        .required::after {
            content: '*';
            color: red;
        }
    </style>
@endsection

@section('content_header')
    <h1>Laporan Keuangan Bulanan</h1>
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
                        <p class="required">Pilih Bulan</p>
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <input type="text" class="form-control" id="filter_by_date_start" name="filter_by_date_start"
                            value="{{ \Carbon\Carbon::now()->format('Y-m') }}">
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
                <div class="float-right">
                    <a href="#" class="btn btn-danger btn-print-pdf"><i class="fa fa-print"></i></a>
                </div>

            </div>
            <div class="card-body">
                <table class="table table-stripped" id="list_table">
                    <thead>
                        <tr>
                            <th style="width: 10px">NO</th>
                            <th style="width: 20px">Tanggal</th>
                            <th style="width: 20px">Nama Motor</th>
                            <th style="width: 20px">Keterangan</th>
                            <th style="width: 20px">Debit</th>
                            <th style="width: 20px">Credit</th>



                        </tr>
                    </thead>

                    <tfoot>
                        <th colspan="4">Total </th>
                        <th></th>
                        <th></th>

                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@stop

@section('plugins.Datatables', true)
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>

    <script>
        $('#filter_by_date_start').flatpickr({
            plugins: [
                new monthSelectPlugin({
                    shorthand: true,
                    dateFormat: "Y-m",
                    altFormat: "F Y",
                })
            ]
        });

        $('.btn-filter').on('click', function() {
            $('#list_table').DataTable().ajax.reload();
        });

        $('.btn-reset').on('click', function() {
            $('#filter_by_date_start').val('{{ \Carbon\Carbon::now()->format('Y-m') }}');
            $('#list_table').DataTable().ajax.reload();
        });


        $('.btn-print-pdf').on('click', function() {
            let date_start = $('#filter_by_date_start').val();
            let url =
                `/module-print/laporan-keuangan-bulanan/print?dateStart=${encodeURIComponent(date_start)}`;
            window.open(url, '_blank');
        });



        $(document).ready(function() {
            $('#list_table').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                info: false,
                ajax: {
                    url: "{{ url('/module-print/laporan-keuangan-bulanan/list-data') }}",
                    data: function(d) {
                        d.date_start = $("#filter_by_date_start").val();
                    }
                },
                columnDefs: [{
                    "targets": [0],
                    "visible": true,
                    "searchable": false,
                    "orderable": false,
                }, ],
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'motor_name',
                        name: 'motor_name'
                    },
                    {
                        data: 'remark',
                        name: 'remark'
                    },
                    {
                        data: 'debit',
                        name: 'debit'
                    },
                    {
                        data: 'credit',
                        name: 'credit'
                    },


                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    let totalDebit = api
                        .column(4, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(sum, value) {
                            let cleanValue = String(value).replace(/\./g, '');
                            return sum + parseFloat(cleanValue);
                        }, 0);

                    let formattedTotalDebit = totalDebit.toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });

                    $(api.column(4).footer()).html(formattedTotalDebit);



                    let totalKredit = api
                        .column(5, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(sum, value) {
                            let cleanValue = String(value).replace(/\./g, '');
                            return sum + parseFloat(cleanValue);
                        }, 0);

                    let formattedTotalKredit = totalKredit.toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });

                    $(api.column(5).footer()).html(formattedTotalKredit);


                }

            });
        })
    </script>
@stop
