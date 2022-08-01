@extends('layouts.app_logged')

@section('content')

    <div class="container-fluid">
        <div class="content-header">
            <h1>Empresas</h1>
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
                <div class="box-actions">
                    <a href="{{route('admin.establishments.create')}}" class="btn btn-success"> <i class="fe fe-plus"></i> Adicionar</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Usuários</th>
                            <th>Criada em</th>
                            <th>Atualizado em</th>
                        </tr>

                        @foreach ($items as $item)
                            <tr>
                                <td>{{$item->establishment_id}}</td>
                                <td><a href="{{route('admin.establishments.view', ['establishmentId' => $item->establishment_id])}}">{{$item->name}}</a></td>
                                <td>{{ sizeof($item->users) }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y \à\s H:i')}}</td>
                                <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y \à\s H:i')}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="box-footer">{{$items->links()}}</div>
        </div>
        
    </div>

@endsection
