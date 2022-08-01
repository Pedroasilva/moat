@extends('layouts.app_logged')

@section('content')

    <div class="container-fluid">
        <div class="content-header">
            <h1>Empresas</h1>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-bg card-bg-solid transition-dark-bottom">
                    <div class="card-image">
                        <img src="{{asset('images/stock-3.jpg')}}" alt="">
                    </div>
                    <div class="card-body card-body-jumbotron">
                        <div class="d-flex flex-column">
                            <h3 class="text-white mb-0 display-4">{{ $establishment->name }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-6">
                <form class="box" method="POST" novalidate action="{{ route('admin.establishments.update', ['establishmentId' => $establishment->establishment_id]) }}">
                    @csrf
                    <div class="box-header">
                        <h3>Limites mensais</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <label for="limite_mensal_templates" class="form-label col-3">Templates</label>
                            <div class="col-9">
                                <input
                                    id="limite_mensal_templates"
                                    type="tel"
                                    class="form-control {{ $errors->has('limite_mensal_templates') ? 'is-invalid' : '' }}"
                                    name="limite_mensal_templates"
                                    value="{{$establishment->limite_mensal_templates}}"
                                    placeholder="Limite mensal"
                                    required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exports" class="form-label col-3">Exportações</label>
                            <div class="col-9">
                                <input
                                    id="limite_mensal_exports"
                                    type="tel"
                                    class="form-control {{ $errors->has('limite_mensal_exports') ? 'is-invalid' : '' }}"
                                    name="limite_mensal_exports"
                                    value="{{$establishment->limite_mensal_exports}}"
                                    placeholder="Limite mensal"
                                    required />
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <a href="{{route('admin.establishments.view', ['establishmentId' => $establishment->establishment_id])}}" class="btn btn-link">Voltar</a>
                        <button type="submit" class="btn btn-primary pull-right">Salvar</button>
                    </div>
                </form>
            </div>

        </div>

        
    </div>

@endsection
