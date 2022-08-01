@extends('layouts.app_logged')

@section('content')

    <div class="container-fluid">
        <div class="content-header">
            <h1>Usuários</h1>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-bg card-bg-solid transition-dark-bottom">
                    <div class="card-image">
                        <img src="{{asset('assets/images/stock-4.jpg')}}" alt="">
                    </div>
                    <div class="card-body card-body-jumbotron">
                        <div class="d-flex flex-column">
                            <h3 class="text-white mb-0 display-4">{{ $user->name }}</h3>
                            <small class="text-white-50">{{ $user->userRole->label }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="box">
                    <div class="box-header">
                        <h3>Dados</h3>
                        {{-- <div class="box-actions">
                        </div> --}}
                    </div>
                    <div class="box-body">
                        <div class="mb-10">
                            <div class="text-partition">
                                <b>Geral</b>
                            </div>
                            <dl class="row">
                                <dt class="col-md-3">Criado em:</dt>
                                <dd class="col-md-9">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y \à\s H:i')}}</dd>

                                <dt class="col-md-3">Atualizado em:</dt>
                                <dd class="col-md-9">{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y \à\s H:i')}}</dd>

                                <dt class="col-md-3">Nome:</dt>
                                @if ($user->name)
                                    <dd class="col-md-9">{{$user->name}}</dd>
                                @else
                                    <dd class="col-md-9">--</dd>
                                @endif

                                <dt class="col-md-3">E-mail:</dt>
                                @if ($user->name)
                                <dd class="col-md-9">{{$user->email}}</dd>
                                @else
                                    <dd class="col-md-9">--</dd>
                                @endif

                                <dt class="col-md-3">Status:</dt>
                                <dd class="col-md-9">
                                    {{($user->status === 1) ? "Ativo" : "Inativo"}}
                                
                                    @if (Auth::user()->user_id !== $user->user_id && !$user->isAdministrator())
                                            @if ($user->status === 0)
                                                <a href="{{route('admin.users.unblock', ['userId' => $user->user_id])}}" class="btn btn-sm btn-primary">Ativar usuário</a>
                                            @else
                                                <a href="{{route('admin.users.block', ['userId' => $user->user_id])}}" class="btn btn-sm btn-danger">Bloquear usuário</a>
                                            @endif 
                                    @endif
                                </dd>
                            </dl>
                        </div>
                        <div class="mb-10">
                            <div class="text-partition">
                                <b>Empresa</b>
                            </div>
                            <dl class="row">
                                <dt class="col-md-2">Empresa:</dt>
                                <dd class="col-md-10"><a href="{{route('admin.establishments.view', ['establishmentId' => $user->establishment])}}">{{$user->companyData->name}}</a></dd>

                                <dt class="col-md-2">Perfil:</dt>
                                <dd class="col-md-10">{{$user->userRole->label}}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-6">
                <div class="box">
                    <div class="box-header">
                        <h3>Logs</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Ação</th>
                                    <th>Data</th>
                                    <th>Empresa</th>
                                </tr>

                                @foreach ($user->logs->reverse() as $log)
                                    <tr>
                                        <td>{{$log->log}}</td>
                                        <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y \à\s H:i')}}</td>
                                        <td>{{$log->establishmentOwner->name}}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>

@endsection
