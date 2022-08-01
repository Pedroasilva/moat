@extends('layouts.app_logged')

@section('content')

    <div class="container-fluid">
        <div class="content-header">
            <h1>Usuários</h1>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="info-box">
                    <div class="info-box-content">
                        <div class="info-box-text">
                            Total
                        </div>
                        <div class="info-box-icon">
                            <div class="info-box-number">
                                {{ $items->total() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-header">
                <h3>Detalhes</h3>
                {{-- <div class="box-actions">
                    <a href="{{route('admin.users.create')}}" class="btn btn-success"> <i class="fe fe-plus"></i> Adicionar</a>
                </div> --}}
            </div>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Data</th>
                            <th>Atualizado</th>
                            <th>Perfil</th>
                            <th>Empresa</th>
                            <th>Status</th>
                        </tr>

                        @foreach ($items as $item)
                            <tr>
                                <td>{{$item->user_id}}</td>
                                <td><a href="{{route('admin.users.view', ['userId' => $item->user_id])}}">{{$item->name}}</a></td>
                                <td>{{$item->email}}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y \à\s H:i')}}</td>
                                <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y \à\s H:I')}}</td>
                                <td>{{$item->userRole->label}}</td>
                                <td>#{{$item->companyData->establishment_id}} - {{$item->companyData->name}}</td>
                                <td>{{($item->status === 1) ? "Ativo" : "Inativo"}}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="box-footer">{{$items->links()}}</div>
        </div>
        
    </div>

@endsection
