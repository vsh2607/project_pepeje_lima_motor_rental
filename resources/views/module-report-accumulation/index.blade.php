@extends('adminlte::page')

@section('title', 'Laporan Akumulasi Kendaraan')

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
    <h1>Laporan Akumulasi Kendaraan</h1>
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
                <div class="float-right">
                    <a href="#" class="btn btn-danger btn-print-pdf"><i class="fa fa-print"></i></a>
                </div>

            </div>
            <div class="card-body">
                <table class="table table-stripped" id="list_table">
                    <thead>
                        <tr>
                            <th style="width: 5px">NO</th>
                            <th style="width: 5px">Nama Kendaraan</th>
                            <th style="width: 20px">Debit</th>
                            <th style="width: 20px">Kredit</th>
                            <th style="width: 20px">Selisih</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <th colspan="2">Total</th>
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
@section('plugins.FlatPickr', true)
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.btn-print-pdf').on('click', function() {
            let url = `/module-print/laporan-akumulasi/print`;
            window.open(url, '_blank');
        });


        $(document).ready(function() {
            $('#list_table').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                info: false,
                ajax: {
                    url: "{{ url('/module-print/laporan-akumulasi/list-data') }}",
                    data: function(d) {
                        d.name = $("#filter_by_name").val();
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'debits_sum_debit',
                        name: 'debits_sum_debit'
                    },
                    {
                        data: 'credits_sum_credit',
                        name: 'credits_sum_credit'
                    },
                    {
                        data: 'total_saldo',
                        name: 'total_saldo'
                    }

                ],
                footerCallback: function(row, data, start, end, display) {
                    let api = this.api();

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

                    let totalDeposit = totalDebit - totalKredit;


                    let formattedTotalDeposit = totalDeposit.toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });

                    $(api.column(4).footer()).html(formattedTotalDeposit);

                }

            });
        })
    </script>
@stop
