@extends('adminlte::page')

@section('title', 'Edit Data Penyewaan')

@section('adminlte_css_pre')
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .required::after {
            content: '*';
            color: red;
        }

        #canvas {
            width: 100%;
        }
    </style>
@endsection

@section('content_header')
    <h1>Edit Data Penyewaan</h1>
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
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-header">Gambar Motor</div>
                    <div class="card-body">
                        <img src="{{ asset('motor_images') . '/' . $data->motor->img_url }}" alt="motor img" width="200px">
                    </div>
                    <div class="card-footer" style="text-align: center">
                        @if ($data->status == 1)
                            <span class='badge badge-warning'>Masih Dipinjam</span>
                            <span class='badge badge-warning'>{{ $total_hari_sewa }} hari</span>
                            <span class='badge badge-warning'>{{ $total_biaya_sewa }}</span>
                        @else
                            <span class='badge badge-success'>Sudah Kembali</span>
                        @endif


                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Gambar Jaminan</div>
                    <div class="card-body">
                        <canvas id="canvas" style="display: none;"></canvas>
                        <img src="{{ asset('jaminan_images') . '/' . $data->jaminan_img }}" alt="jaminan img" width="200px"
                            id="gambar_jaminan">
                    </div>
                </div>
            </div>
            <div class="col-9">
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label class='required' for="id_master_motor">Nama Kendaraan</label>
                                <select required name="id_master_motor" id="id_master_motor" class="form-control"
                                    style="width: 100% !important;">
                                    <option value="{{ $data->motor->id }}" selected>{{ $data->motor->name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class='required' for="nomor_polisi">Nomor Polisi</label>
                                <input type="text" required readonly name="nomor_polisi" id="nomor_polisi"
                                    class="form-control my-input" value="{{ $data->motor->nomor_polisi }}">
                            </div>
                            <div class="form-group">
                                <label class='required' for="nama_penyewa">Nama Penyewa</label>
                                <input type="text" class="form-control my-input" name="nama_penyewa" id="nama_penyewa"
                                    required placeholder="MASUKKAN NAMA PENYEWA" value="{{ $data->nama_penyewa }}">
                            </div>
                            <div class="form-group">
                                <label class='required' for="kontak_penyewa">No. Kontak Penyewa</label>
                                <input type="text" class="form-control my-input my-number" name="kontak_penyewa"
                                    id="kontak_penyewa" required placeholder="MASUKKAN NO. KONTAK PENYEWA"
                                    value="{{ $data->kontak_penyewa }}">
                            </div>
                            <div class="form-group">
                                <label for="jaminan">Jaminan</label>
                                <select class="form-control" id="jaminan" name="jaminan" style="width: 100% !important;">
                                    <option></option>
                                    <option value="KTP" {{ $data->jaminan == 'KTP' ? 'selected' : '' }}>KTP</option>
                                    <option value="KTM" {{ $data->jaminan == 'KTM' ? 'selected' : '' }}>KTM</option>
                                    <option value="SIM" {{ $data->jaminan == 'SIM' ? 'selected' : '' }}>SIM</option>
                                </select>
                                <input hidden type="text" id="jaminan_img" name="jaminan_img">
                            </div>
                            <div class="form-group">
                                <label class='required' for="jenis_penyewaan">Jenis Penyewaan</label>
                                <select required name="jenis_penyewaan" id="jenis_penyewaan" class="form-control"
                                    style="width: 100% !important;">
                                    <option></option>
                                    <option value="bulanan" {{ $data->jenis_penyewaan == 'bulanan' ? 'selected' : '' }}>
                                        BULANAN</option>
                                    <option value="harian" {{ $data->jenis_penyewaan == 'harian' ? 'selected' : '' }}>
                                        HARIAN</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class='required' for="tanggal_penyewaan">Tanggal Penyewaan</label>
                                <input required type="text" name="tanggal_penyewaan" id="tanggal_penyewaan"
                                    class="form-control my-input" placeholder="MASUKKAN TANGGAL PENYEWAAN"
                                    value="{{ $data->tanggal_penyewaan }}">
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#cameraModal">AMBIL FOTO JAMINAN</button>
                            <button type="submit" class="btn btn-primary">SUBMIT</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>


    <!-- Camera Modal -->
    <div class="modal fade" id="cameraModal" tabindex="-1" role="dialog" aria-labelledby="cameraModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cameraModalLabel">Ambil Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <video id="video" width="100%" autoplay></video>
                    <div id="captureText" style="display: none; text-align: center; color: red; font-weight: bold;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="captureButton">Capture</button>
                    <button type="button" class="btn btn-secondary" id="retryButton"
                        style="display: none;">Ulangi</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('plugins.Datatables', true)
@section('plugins.FlatPickr', true)
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#tanggal_penyewaan').flatpickr();

            $('.my-input').on('input', function() {
                $(this).val($(this).val().toUpperCase());
            });

            $('.my-number').on('input', function() {
                let value = $(this).val();
                value = value.replace(/\D/g, '');
                $(this).val(value);

            });

            $('#jaminan').select2({
                placeholder: 'PILIH OPSI JAMINAN',
            });
            $('#jenis_penyewaan').select2({
                placeholder: 'PILIH OPSI JENIS PENYEWAAN',
            });

            $('#id_master_motor').select2({
                ajax: {
                    url: "{{ url('resources/list-motor') }}",
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
        });

        $('#id_master_motor').on('change', function() {

            $.ajax({
                url: `{{ url('resources/${$(this).val()}/list-motor') }}`,
                success: function(data) {
                    data_motor = data[0];
                    $("#nomor_polisi").val(data_motor.nomor_polisi);

                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }

            })
        });

        let videoStream;

        // Function to start camera stream
        function startCamera() {
            navigator.mediaDevices.getUserMedia({
                video: true
            }).then(function(stream) {
                videoStream = stream;
                var video = document.getElementById('video');
                video.srcObject = stream;
                video.play();
            }).catch(function(err) {
                console.log("An error occurred: " + err);
            });
        }

        // Function to capture image from camera
        function captureImage() {
            document.getElementById('gambar_jaminan').style.display = 'none';
            var video = document.getElementById('video');
            var canvas = document.getElementById('canvas');
            var context = canvas.getContext('2d');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            canvas.style.display = 'block';
            video.style.display = 'none';

            document.getElementById('retryButton').style.display = 'inline-block';
            document.getElementById('captureButton').style.display = 'none';
            document.getElementById('captureText').innerText = 'Foto Jaminan Sudah Diambil';
            document.getElementById('captureText').style.display = 'block';
            const dataURL = canvas.toDataURL('image/png');
            document.getElementById('jaminan_img').value = dataURL;
        }

        function retryCapture() {
            document.getElementById('captureText').innerText = '';
            var video = document.getElementById('video');
            var canvas = document.getElementById('canvas');

            canvas.style.display = 'none';
            video.style.display = 'block';

            document.getElementById('retryButton').style.display = 'none';
            document.getElementById('captureButton').style.display = 'inline-block';

            startCamera();
        }

        $('#cameraModal').on('show.bs.modal', function(e) {
            startCamera();
        });

        $('#cameraModal').on('hidden.bs.modal', function(e) {
            if (videoStream) {
                videoStream.getTracks().forEach(track => track.stop());
            }
        });

        document.getElementById('captureButton').addEventListener('click', function() {
            captureImage();
        });

        document.getElementById('retryButton').addEventListener('click', function() {
            document.getElementById('captureText').innerText = 'Foto Jaminan Sudah Diambil';
            retryCapture();
        });
    </script>
@stop
