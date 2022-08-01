@extends('layouts.app_logged')

@section('content')

    <div class="container-fluid">
        <div class="content-header">
            <h1>Empresas</h1>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-5">
                <div class="card card-bg card-bg-solid transition-dark-bottom">
                    <div class="card-image">
                        <img src="{{asset('assets/images/stock-7.jpg')}}" alt="">
                    </div>
                    <div class="card-body card-body-jumbotron">
                        <div class="d-flex flex-column">
                            <h3 class="text-white mb-0 display-4">{{ $establishment->name }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-7">
                <div class="box">
                    <div class="box-header">
                        <h3>Dados</h3>
                    </div>
                    <div class="box-body">
                        <div class="mb-10">
                            <div class="text-partition">
                                <b>Geral</b>
                            </div>
                            <dl class="row">
                                <dt class="col-md-3">Criada em:</dt>
                                <dd class="col-md-9">{{ \Carbon\Carbon::parse($establishment->created_at)->format('d/m/Y \à\s H:i')}}</dd>

                                <dt class="col-md-3">Atualizada em:</dt>
                                <dd class="col-md-9">{{ \Carbon\Carbon::parse($establishment->updated_at)->format('d/m/Y \à\s H:i')}}</dd> 

                                <dt class="col-md-3">Slug:</dt>
                                @if ($establishment->slug)
                                    <dd class="col-md-9">{{$establishment->slug}}</dd>  
                                @else
                                    <dd class="col-md-9">--</dd>
                                @endif

                                <dt class="col-md-3">E-mail:</dt>
                                @if ($establishment->email)
                                    <dd class="col-md-9">{{$establishment->email}}</dd>
                                @else
                                    <dd class="col-md-9">--</dd>
                                @endif

                                <dt class="col-md-3">Telefone:</dt>
                                @if ($establishment->phonenumber)
                                    <dd class="col-md-9">{{$establishment->phonenumber}}</dd>
                                    @else
                                        <dd class="col-md-9">--</dd>
                                @endif 

                                <dt class="col-md-3">Site:</dt>
                                @if ($establishment->site_url)
                                    <dd class="col-md-9">{{$establishment->site_url}}</dd>
                                @else
                                    <dd class="col-md-9">--</dd>
                                @endif 

                                <dt class="col-md-3">Cidade:</dt>
                                @if ($establishment->city)
                                    <dd class="col-md-9">{{$establishment->city}}</dd>
                                @else
                                    <dd class="col-md-9">--</dd>
                                @endif 

                                <dt class="col-md-3">Estado:</dt>
                                @if ($establishment->state)
                                    <dd class="col-md-9">{{$establishment->state}}</dd>
                                @else
                                    <dd class="col-md-9">--</dd>
                                @endif 

                                <dt class="col-md-3">País:</dt>
                                @if ($establishment->country)
                                    <dd class="col-md-9">{{$establishment->country}}</dd>
                                @else
                                    <dd class="col-md-9">--</dd>
                                @endif                         
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">

        <div class="box">
            <div class="box-header">
                <h3>Usuários ({{ $users->total() }})</h3>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Criado em</th>
                            <th>Perfil</th>
                            <th>Status</th>
                        </tr>

                        @foreach ($users as $item)
                            <tr>
                                <td>{{$item->user_id}}</td>
                                <td><a href="{{route('admin.users.view', ['userId' => $item->user_id])}}">{{$item->name}}</a></td>
                                <td>{{$item->email}}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y \à\s H:i')}}</td>
                                <td>{{$item->userRole->label}}</td>
                                <td>{{($item->status === 1) ? "Ativo" : "Inativo"}}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="box-footer">{{$users->links()}}</div>
        </div>
            </div>
        </div>
        
    </div>

@endsection
