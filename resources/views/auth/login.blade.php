@extends('adminlte::auth.login')

@section('title', 'Login Page')

@section('adminlte_css_pre')
    <link rel="icon" href="{{ asset('assets/logo.png') }}" type="image/x-icon">
@endsection

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('assets/logo.png') }}" alt="logo" width="100px">
        </div>

        @if (session('error'))
            <div class="alert alert-danger mb-2">
                {{ session('error') }}
            </div>
        @endif


        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Silahkan Login Terlebih Dahulu</p>
                <form method="post">
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="text" name="username"
                            class="user form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                            value="{{ old('username') }}" placeholder="Username" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>

                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password"
                            class="pass form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="{{ __('adminlte::adminlte.password') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-8">
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
