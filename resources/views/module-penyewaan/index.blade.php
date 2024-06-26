@extends('adminlte::page')

@section('title', 'Module Sewa')

@section('adminlte_css_pre')
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
    <style>
        table.thead.tr {}
    </style>
@endsection

@section('content_header')
    <h1>List Penyewaan Motor</h1>
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
                <a href="{{ url('/module-manajemen/module-sewa/add') }}" class="btn btn-success btn-sm float-right">+
                    Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-stripped" id="list_table">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap;">NO</th>
                                <th style="white-space: nowrap;">Nama Motor</th>
                                <th style="white-space: nowrap;">Nama Penyewa</th>
                                <th style="white-space: nowrap;">Tanggal Mulai</th>
                                <th style="white-space: nowrap;">Jenis Penyewaan</th>
                                <th style="white-space: nowrap;">Harga Sewa</th>
                                <th style="white-space: nowrap;">Total Biaya</th>
                                <th style="white-space: nowrap;">Status</th>
                                <th style="white-space: nowrap;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@stop

@section('plugins.Datatables', true)
@section('js')
    <script>
        $(document).ready(function() {

            $('#list_table').DataTable({
                processing: true,
                serverside: true,
                ajax: "{{ url('/module-manajemen/module-sewa/list-data') }}",
                order: [],
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
                        data: 'nama_penyewa',
                        name: 'nama_penyewa'
                    },
                    {
                        data: 'tanggal_penyewaan',
                        name: 'tanggal_penyewaan'
                    },
                    {
                        data: 'jenis_penyewaan',
                        name: 'jenis_penyewaan'
                    },
                    {
                        data: 'harga_sewa',
                        name: 'harga_sewa'
                    },
                    {
                        data: 'total_sewa',
                        name: 'total_sewa'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },

                ]

            });
        })
    </script>
@stop
