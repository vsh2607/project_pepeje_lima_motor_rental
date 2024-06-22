@extends('adminlte::page')

@section('title', 'Master Motor')

@section('adminlte_css_pre')
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
@endsection

@section('content_header')
    <h1>List Master Motor</h1>
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
                <a href="{{ url('/master-data/master-motor/add') }}" class="btn btn-success btn-sm float-right">+ Tambah</a>
            </div>
            <div class="card-body">
                <table class="table table-stripped" id="list_table">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nama Kendaraan</th>
                            <th>NO. Polisi</th>
                            <th>Harga Sewa Harian</th>
                            <th>Harga Sewa Bulanan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
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
                ajax: "{{ url('/master-data/master-motor/list-data') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'nomor_polisi',
                        name: 'nomor_polisi'
                    },
                    {
                        data: 'harga_sewa_harian',
                        name: 'harga_sewa_harian'
                    },
                    {
                        data: 'harga_sewa_bulanan',
                        name: 'harga_sewa_bulanan'
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
