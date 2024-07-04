@extends('adminlte::page')

@section('title', 'Laporan Total Tiap Bulan')

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
    <h1>Laporan Total Tiap Bulan</h1>
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
                        <p class="required">Pilih Tahun</p>
                    </div>
                    <div class="col-lg-2 col-sm-12">
                        <input type="number" class="form-control" id="filter_by_year" name="filter_by_year"
                            value="{{ \Carbon\Carbon::now()->format('Y') }}" max="{{ \Carbon\Carbon::now()->format('Y') }}" min="1000">
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
                            <th style="width: 5%">NO</th>
                            <th style="width: 15%">Bulan</th>
                            <th style="width: 18%">Debit</th>
                            <th style="width: 18%">Kredit</th>
                            <th style="width: 18%">Selisih</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <th colspan="2">Total </th>
                        <th></th>
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

    <script>

        $('.btn-filter').on('click', function() {
            $('#list_table').DataTable().ajax.reload();
        });

        $('.btn-reset').on('click', function() {
            $('#filter_by_year').val('{{ \Carbon\Carbon::now()->format('Y') }}');
            $('#list_table').DataTable().ajax.reload();
        });


        $('.btn-print-pdf').on('click', function() {
            let year = $('#filter_by_year').val();
            let url =
                `/module-print/laporan-total-tiap-bulan/print?year=${encodeURIComponent(year)}`;
            window.open(url, '_blank');
        });



        $(document).ready(function() {
            $('#list_table').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                info: false,
                ajax: {
                    url: "{{ url('/module-print/laporan-total-tiap-bulan/list-data') }}",
                    data: function(d) {
                        d.filter_by_year = $("#filter_by_year").val();
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
                        data: 'formatted_date',
                        name: 'formatted_date'
                    },
                    {
                        data: 'total_debit',
                        name: 'total_debit'
                    },
                    {
                        data: 'total_credit',
                        name: 'total_credit'
                    },
                    {
                        data: 'total_deposit',
                        name: 'total_deposit'
                    },


                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    let totalDebit = api
                        .column(2, {
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

                    $(api.column(2).footer()).html(formattedTotalDebit);



                    let totalKredit = api
                        .column(3, {
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

                    $(api.column(3).footer()).html(formattedTotalKredit);


                    let totalDeposits = api
                        .column(4, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(sum, value) {
                            let cleanValue = String(value).replace(/\./g, '');
                            return sum + parseFloat(cleanValue);
                        }, 0);

                    let formattedTotalDeposit = totalDeposits.toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });

                    $(api.column(4).footer()).html(formattedTotalDeposit);


                }

            });
        })
    </script>
@stop
