@extends('adminlte::page')

@section('title', 'Module Pengembalian')

@section('adminlte_css_pre')
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('content_header')
    <h1>Module Pengembalian Motor</h1>
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
            <div class="card-body">
                <div class="row">

                    <div class="col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="nomor_polisi">Nomor Polisi</label>
                            <select name="nomor_polisi" id="nomor_polisi" class="form-control"></select>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary filter">Filter</button>
                <button class="btn btn-secondary reset">Reset</button>
            </div>

        </div>

        <div class="card detail-card" style="display: none;">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-header">Gambar Motor</div>
                            <div class="card-body">
                                <img src="" alt="motor img"width="200px" id="motor_img">
                            </div>
                            <div class="card-footer" style="text-align: center">

                                <span class='badge badge-warning total_hari'></span>
                                <span class='badge badge-warning total_biaya'></span>


                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">Gambar Jaminan</div>
                            <div class="card-body">
                                <img src="" alt="jaminan img" width="200px" id="jaminan_img">
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class='required' for="id_master_motor">Nama Kendaraan</label>
                                    <input type="text" name="id_master_motor" id="id_master_motor" class="form-control"
                                        readonly>
                                    <input hidden type="text" id="penyewaan_id" name="penyewaan_id">
                                </div>
                                <div class="form-group">
                                    <label class='required' for="nomor_polisi_input">Nomor Polisi</label>
                                    <input type="text" required readonly name="nomor_polisi_input"
                                        id="nomor_polisi_input" class="form-control my-input">
                                    <input hidden type="text" id="motor_name" name="motor_name">
                                </div>
                                <div class="form-group">
                                    <label class='required' for="nama_penyewa">Nama Penyewa</label>
                                    <input readonly type="text" class="form-control my-input" name="nama_penyewa"
                                        id="nama_penyewa" required placeholder="MASUKKAN NAMA PENYEWA">
                                </div>
                                <div class="form-group">
                                    <label for="jaminan">Jaminan</label>
                                    <input type="text" name="jaminan" id="jaminan" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label class='required' for="jenis_penyewaan">Jenis Penyewaan</label>
                                    <input type="text" name="jenis_penyewaan" id="jenis_penyewaan" class="form-control"
                                        readonly>

                                </div>

                                <div class="form-group">
                                    <label class='required' for="tanggal_penyewaan">Tanggal Penyewaan</label>
                                    <input required readonly type="text" name="tanggal_penyewaan" id="tanggal_penyewaan"
                                        class="form-control my-input" placeholder="MASUKKAN TANGGAL PENYEWAAN">
                                </div>
                            </div>

                            <div class="card-footer">
                                <button class="btn btn-primary btn-return">KEMBALIKAN</button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.btn-return').on('click', function() {
                var htmlContent = `
        <div style="text-align: center;">
            <table style="display: inline-block; text-align: left;">
                <tr>
                    <td><b>Tanggal Sewa</b></td>
                    <td>:</td>
                    <td>&nbsp;${$('#tanggal_penyewaan').val()}</td>
                </tr>
                <tr>
                    <td><b>Tanggal Kembali</b></td>
                    <td>:</td>
                     <td>&nbsp;{{ \Carbon\Carbon::now()->format('Y-m-d') }}</td>
                </tr>

                <tr>
                    <td><b>Nama Penyewa</b></td>
                    <td>:</td>
                    <td>&nbsp;${$('#nama_penyewa').val()}</td>
                </tr>
                <tr>
                    <td><b>Nama Motor</b></td>
                    <td>:</td>
                    <td>&nbsp;${$('#motor_name').val()}</td>
                </tr>
                <tr>
                    <td><b>Total Hari Sewa</b></td>
                    <td>:</td>
                    <td>&nbsp;${$('.total_hari').text()}</td>
                </tr>
                <tr>
                    <td><b>Total Biaya Sewa</b></td>
                    <td>:</td>
                    <td>&nbsp;${$('.total_biaya').text()}</td>

                </tr>
            </table>
        </div>
    `;

                Swal.fire({
                    title: "Konfirmasi Pengembalian",
                    html: htmlContent,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#999999",
                    confirmButtonText: "Iya, Kembalikan",
                    cancelButtonText: "Batal",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        var penyewaanId = $('#penyewaan_id').val();
                        var url = `{{ url('module-penyewaan/module-kembali/${penyewaanId}/return') }}`;
                        window.open(url, '_blank');
                        location.reload();
                    }
                });
            });


            $('.reset').on('click', function() {
                $('.detail-card').css('display', 'none');
                $('#nomor_polisi').val('').trigger('change');

                $("#motor_img").attr('src', ``)
                $("#jaminan_img").attr('src', ``)
            });

            $('.filter').on('click', function() {
                let id_nomor_polisi = $('#nomor_polisi').val();
                if (id_nomor_polisi != null) {
                    $('.detail-card').css('display', '');
                    $.ajax({
                        url: `{{ url('resources/data-penyewaan') }}`,
                        data: {
                            id_nomor_polisi: id_nomor_polisi
                        },
                        success: function(data) {
                            console.log(data);

                            $("#motor_img").attr('src',
                                `{{ asset('motor_images/${data.data.motor.img_url}') }}`)
                            $("#jaminan_img").attr('src',
                                `{{ asset('jaminan_images/${data.data.jaminan_img}') }}`)
                            $('#id_master_motor').val(data.data.motor.name);
                            $('#nomor_polisi_input').val(data.data.motor.nomor_polisi);
                            $('#nama_penyewa').val(data.data.nama_penyewa);
                            $('#jaminan').val(data.data.jaminan);
                            $('#jenis_penyewaan').val(data.data.jenis_penyewaan.toUpperCase());
                            $('#tanggal_penyewaan').val(data.data.tanggal_penyewaan);
                            $('#penyewaan_id').val(data.data.id);
                            $('#motor_name').val(data.data.motor.name);
                            $('.total_hari').text(data.interval + ' hari');
                            $('.total_biaya').text(data.total_sewa);

                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            })

            $('#nomor_polisi').select2({
                ajax: {
                    url: "{{ url('resources/list-motor-sewa') }}",
                    data: function(params) {
                        var query = {
                            name: params.term,
                            type: 'nomor_polisi'
                        };
                        return query;
                    },
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        var processedData = $.map(data, function(obj) {
                            obj.id = obj.id;
                            obj.text = obj.nomor_polisi;

                            return obj;
                        });
                        return {
                            results: processedData,
                        };
                    },
                },
                minimumInputLength: 0,
                placeholder: 'Cari Penyewaan Berdasarkan Nomor Motor',
            });
        });
    </script>

@stop
