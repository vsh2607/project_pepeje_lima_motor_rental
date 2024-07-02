@extends('adminlte::page')

@section('title', 'Laporan Sewa Harian')

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
    <h1>Laporan Sewa Harian</h1>
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
                            value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
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
                <div class="float-right">
                    <a href="#" class="btn btn-danger btn-print-pdf"><i class="fa fa-print"></i></a>
                </div>

            </div>
            <div class="card-body">
                <table class="table table-stripped" id="list_table">
                    <thead>
                        <tr>
                            <th style="width: 10px">NO</th>
                            <th style="width: 20px">Nama Motor</th>
                            <th style="width: 20px">Nama Penyewa</th>
                            <th style="width: 20px">No. Kontak</th>
                            <th style="width: 20px">NO. Polisi</th>
                            <th style="width: 20px">Tanggal Mulai Sewa</th>
                            <th style="width: 20px">Tanggal Akhir Sewa</th>
                            <th style="width: 20px">Jumlah Hari</th>
                            <th style="width: 20px">Harga Sewa</th>
                            <th style="width: 20px">Total Sewa</th>

                        </tr>
                    </thead>

                    <tfoot>
                        <th colspan="9">Total </th>
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
            $('#filter_by_date_start').val('{{ \Carbon\Carbon::now()->format('Y-m-d') }}');
            $('#filter_by_date_end').val('{{ \Carbon\Carbon::now()->format('Y-m-d') }}');
            $('#list_table').DataTable().ajax.reload();
        });


        $('.btn-print-pdf').on('click', function(){
            let name = $('#filter_by_name').val();
            let date_start = $('#filter_by_date_start').val();
            let date_end = $('#filter_by_date_end').val();
            let url = `/module-print/laporan-sewa-harian/print?name=${encodeURIComponent(name)}&dateStart=${encodeURIComponent(date_start)}&dateEnd=${encodeURIComponent(date_end)}`;
            window.open(url, '_blank');
        });



        $(document).ready(function() {
            $('#list_table').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                info: false,
                ajax: {
                    url: "{{ url('/module-print/laporan-sewa-harian/list-data') }}",
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
                }, ],
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'penyewaan.motor.name',
                        name: 'penyewaan.motor.name'
                    },
                    {
                        data: 'penyewaan.nama_penyewa',
                        name: 'penyewaan.nama_penyewa'
                    },
                    {
                        data: 'penyewaan.kontak_penyewa',
                        name: 'penyewaan.kontak_penyewa'
                    },
                    {
                        data: 'penyewaan.motor.nomor_polisi',
                        name: 'penyewaan.motor.nomor_polisi'
                    },
                    {
                        data: 'penyewaan.tanggal_penyewaan',
                        name: 'penyewaan.tanggal_penyewaan'
                    },
                    {
                        data: 'penyewaan.tanggal_pengembalian',
                        name: 'penyewaan.tanggal_pengembalian'
                    },
                    {
                        data: 'total_hari_sewa',
                        name: 'total_hari_sewa'
                    },
                    {
                        data: 'harga_sewa',
                        name: 'harga_sewa'
                    },

                    {
                        data: 'debit',
                        name: 'debit'
                    },
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    var totalDebit = api
                        .column(9, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function(sum, value) {
                            var cleanValue = String(value).replace(/\./g, '');
                            return sum + parseFloat(cleanValue);
                        }, 0);

                    var formattedTotal = totalDebit.toLocaleString('id-ID', {
                        minimumFractionDigits: 0
                    });

                    $(api.column(9).footer()).html(formattedTotal);
                }

            });
        })
    </script>
@stop
