@extends('layouts.app_logged')

@section('content')

    <div class="container-fluid">
        <div class="content-header">
            <h1>Nova empresa<br />
                <small>Criação de novas empresas na plataforma.</small>
            </h1>
        </div>

        @if (sizeof($errors->all()) > 0)
            <div class="alert alert-danger">
                <h4>Erros</h4>
                @foreach ($errors->all() as $error) {{ $error }}<br /> @endforeach
            </div>
        @endif

        <div class="row">
            <div class="col-md-12 col-lg-6">
                <form method="POST" class="row" action="{{ route('admin.establishments.create.post') }}">
                    @csrf
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h3>Dados empresa</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group row">
                                    <label for="name" class="form-label col-3">Nome da Empresa</label>
                                    <div class="col-9">
                                        <input
                                            id="name"
                                            type="text"
                                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                            name="name"
                                            value="{{old('name')}}"
                                            placeholder="Ex: Google"
                                            required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h3>Usuário proprietário</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group row">
                                    <label for="user_name" class="form-label col-3">Nome</label>
                                    <div class="col-9">
                                        <input
                                            id="user_name"
                                            type="text"
                                            class="form-control {{ $errors->has('user_name') ? 'is-invalid' : '' }}"
                                            name="user_name"
                                            value="{{old('user_name')}}"
                                             />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="user_email" class="form-label col-3">E-mail</label>
                                    <div class="col-9">
                                        <input
                                            id="user_email"
                                            type="email"
                                            class="form-control {{ $errors->has('user_email') ? 'is-invalid' : '' }}"
                                            name="user_email"
                                            value="{{old('user_email')}}"
                                             />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="user_password" class="form-label col-3">Senha</label>
                                    <div class="col-9">
                                        <input
                                            id="user_password"
                                            type="password"
                                            class="form-control {{ $errors->has('user_password') ? 'is-invalid' : '' }}"
                                            name="user_password"
                                            value="{{old('user_password')}}"
                                             />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-lg btn-success pull-right">Criar empresa</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

@endsection
