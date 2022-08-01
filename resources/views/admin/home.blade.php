@extends('layouts.app_logged')

@section('content')

    <div class="container-fluid">
        <div class="content-header">
            <h1>{{ config('app.name') }} Dashboard
                {{-- <small>Last logged in: 03:00 21, July</small> --}}
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="info-box">
                    <div class="info-box-content">
                        <div class="info-box-text">
                            <span class="info-box-number">
                                {{ sizeof($establishments) }}
                            </span>
                            Empresas
                        </div>
                        <div class="info-box-icon bg-success shadow-success">
                            <i class="fe fe-briefcase"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="info-box">
                    <div class="info-box-content">
                        <div class="info-box-text">
                            <span class="info-box-number">
                                {{ sizeof($users) }}
                            </span>
                            Usuários
                        </div>
                        <div class="info-box-icon bg-primary shadow-primary">
                            <i class="fe fe-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            @if (!is_null($usage['memory']))
            <div class="col-md-6 col-lg-3 offset-lg-3">
                <div class="info-box">
                    <div class="info-box-content">
                        <div class="info-box-text">
                            <span class="info-box-number">
                                {{ $usage['usedmemInGB'] }}
                            </span>
                            Uso de CPU
                        </div>
                        @php
                            $cpuClass = '';
                            if ($usage['memory'] >= 75) {
                                $cpuClass = 'danger';
                            } else if ($usage['memory'] < 75 && $usage['memory'] >= 45) {
                                $cpuClass = 'warning';
                            } else if ($usage['memory'] < 45 && $usage['memory'] >= 25) {
                                $cpuClass = 'primary';
                            } else if ($usage['memory'] < 25) {
                                $cpuClass = 'success';
                            }
                        @endphp
                        <div class="info-box-icon text-{{$cpuClass}}">
                            <i class="fe fe-cpu"></i>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-sm"><b>{{ $usage['memory'] }}%</b></span>
                        <span class="text-sm text-secondary">{{ \Carbon\Carbon::parse(now())->format('d/m/Y \à\s H:i')}}</span>
                    </div>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-{{$cpuClass}}" style="width: {{ $usage['memory'] }}%"></div>
                    </div>
                </div>
            </div>
            @endif
            
        </div>

        <div class="box">
            <div class="box-header">
                <h3> Últimas empresas criadas <i class="fe fe-briefcase"></i></h3>
                <div class="box-actions">
                    {{-- <a href="{{route('admin.establishments.create')}}" class="btn btn-success"> <i class="fe fe-plus"></i> Adicionar</a> --}}
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Criada em</th>
                        </tr>

                        @foreach ($establishments as $item)
                            <tr>
                                <td>{{$item->establishment_id}}</td>
                                <td><a href="{{route('admin.establishments.view', ['establishmentId' => $item->establishment_id])}}">{{$item->name}}</a></td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y \à\s H:i')}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h3>Últimos usuários cadastrados <i class="fe fe-users"></i></h3>
                <div class="box-actions">
                    {{-- <a href="{{route('admin.users.create')}}" class="btn btn-success"> <i class="fe fe-plus"></i> Adicionar</a> --}}
                </div>
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
                            <th>Empresa</th>
                            <th></th>
                        </tr>

                        @foreach ($users as $item)
                            <tr>
                                <td>{{$item->user_id}}</td>
                                <td><a href="{{route('admin.users.view', ['userId' => $item->user_id])}}">{{$item->name}}</a></td>
                                <td>{{$item->email}}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y \à\s H:i')}}</td>
                                <td>{{$item->userRole->label}}</td>
                                <td>#{{$item->companyData->establishment_id}} - {{$item->companyData->name}}</td>
                                <td>
                                    <a href="#" class="icon text-black-25"><i class="fas fa-ellipsis-v"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        
    </div>

@endsection
