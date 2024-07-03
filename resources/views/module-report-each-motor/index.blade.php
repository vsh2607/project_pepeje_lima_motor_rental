@extends('adminlte::page')

@section('title', 'Laporan Keuangan Kendaraan')

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
    <h1>Laporan Keuangan Kendaraan</h1>
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
                        </select>

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
                            <th style="width: 5px">NO</th>
                            <th style="width: 5px">Tanggal</th>
                            <th style="width: 5px">KM</th>
                            <th style="width: 20px">Uraian</th>
                            <th style="width: 20px">Debet</th>
                            <th style="width: 20px">Kredit</th>
                            <th style="width: 20px">Saldo</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <th colspan="4">Total</th>
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
        $('#filter_by_name').select2({
            ajax: {
                url: "{{ url('resources/list-all-motor') }}",
                data: function(params) {
                    let query = {
                        name: params.term
                    };
                    return query;
                },
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    let processedData = $.map(data, function(obj) {
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
            $('#list_table').DataTable().ajax.reload();
        });


        $('.btn-print-pdf').on('click', function(){
            let name = $('#filter_by_name').val();
            let date_start = $('#filter_by_date_start').val();
            let date_end = $('#filter_by_date_end').val();
            let url = `/module-print/laporan-keuangan-kendaraan/print?name=${encodeURIComponent(name)}`;
            window.open(url, '_blank');
        });



        $(document).ready(function() {
            $('#list_table').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                info: false,
                ajax: {
                    url: "{{ url('/module-print/laporan-keuangan-kendaraan/list-data') }}",
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
                columns: [
                    {
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
                        data: 'total_km',
                        name: 'total_km'
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
                    {
                        data: 'total_deposit',
                        name: 'total_deposit'
                    },


                ],
                footerCallback: function(row, data, start, end, display) {
                    let api = this.api();

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

                    let totalDeposit = totalDebit - totalKredit;


                    let formattedTotalDeposit = totalDeposit.toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });

                    $(api.column(6).footer()).html(formattedTotalDeposit);

                }

            });
        })
    </script>
@stop
