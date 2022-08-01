@extends('layouts.app')

@section('content')

    <div class="wrapper">
        <main class="content px-10">
            <div class="row">
                <div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                    <a href="#" class="d-flex justify-content-center">
                        <img src="{{asset('assets/images/logo-primary.png')}}" width="150" alt="{{ config('app.name') }}">
                    </a>
                    <form class="box needs-validation" method="POST" novalidate action="{{ route('login') }}">
                        @csrf

                        <div class="box-header justify-content-center">
                            <h3>Login</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="loginEmail">Usuário</label>

                                <input id="loginEmail" type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="Seu e-mail" required autofocus>

                                <span class="invalid-feedback">Informe um e-mail válido</span>
                            </div>
                            <div class="form-group">
                                <label for="loginPassword">Senha</label>
                                <input id="loginPassword" type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Sua senha" required autofocus >

                                <span class="invalid-feedback">Informe a sua senha</span>
                            </div>
                            {{-- <div class="form-group">
                                <label class="form-checkbox-custom">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <span class="form-label">Lembrar</span>
                                </label>
                            </div> --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-lg btn-block btn-secondary">{{ __('Login') }}</button>

                                        {{-- @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if ($errors->has('email') || $errors->has('password'))
                        <div class="alert alert-danger">
                            <button type="button" data-widget="dismiss" class="alert-close"><i class="fas fa-times"></i></button>
                            <h4>Erro</h4>
                            @if ($errors->has('email'))
                                {{ $errors->first('email') }}
                            @endif
                            <br />
                            @if ($errors->has('email'))
                                {{ $errors->first('password') }}
                            @endif
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger">
                            <button type="button" data-widget="dismiss" class="alert-close"><i class="fas fa-times"></i></button>
                            <h4>Alerta</h4>
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                </div>
            </div>
        </main>
    </div>

@endsection
