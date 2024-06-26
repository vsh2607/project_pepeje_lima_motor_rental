@extends('adminlte::page')

@section('title', 'Dashboard Page')

@section('adminlte_css_pre')
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
@endsection

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $total_motor_available }} / {{ $total_motor }}</h3>

                    <p>Total Motor Tersedia</p>
                </div>
                <div class="icon">
                    <i class="fa fa-bicycle"></i>
                </div>
                <a href="{{ url('/master-data/master-motor') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $total_debit }}</h3>

                    <p>Jumlah Uang Masuk (Debit)</p>
                </div>
                <div class="icon">
                    <i class="fa fa-bicycle"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>Rp. 0</h3>

                    <p>Jumlah Uang Keluar (Kredit)</p>
                </div>
                <div class="icon">
                    <i class="fa fa-bicycle"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>



@stop


@section('js')

@stop
