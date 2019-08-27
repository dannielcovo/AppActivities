@extends('../layouts.app')
@section('content')
    <div class="row col-md-12 list-activities">
        <h1>Atividades</h1>
        <div class="row">
            <form id="form-search" method="GET">
                <div class="col-md-offset-3 col-md-3">
                    <div class="form-group">
                        {{--<label for="situation">Situação</label>--}}
                        <select name="status" class="form-control">
                            <option selected  value="">Selecione um Status</option>
                            <option {{old('status', $status) == '1' ? 'selected': ''}} value="1">Pendente</option>
                            <option {{old('status', $status) == '2' ? 'selected': ''}} value="2">Em Desenvolvimento</option>
                            <option {{old('status', $status) == '3' ? 'selected': ''}} value="3">Em Teste</option>
                            <option {{old('status', $status) == '4' ? 'selected': ''}} value="4">Concluído</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="situation" placeholder="Escolha a Situação"  class="form-control">
                            <option value="" selected >Selecione uma Situação</option>
                            <option {{old('situation', $situation) == 'ativo' ? 'selected': ''}}  value="ativo">Ativo</option>
                            <option {{old('situation', $situation) == 'inativo' ? 'selected': ''}}  value="inativo">Inativo</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button class="btn btn-primary btn-create" type="submit" href="" style="width: 100%">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>  Filtrar
                        </button>
                     </div>
                </div>
            </form>
        </div>

        <form id="form-delete" style="display: none" method="post">
            {{csrf_field ()}}
            {{method_field ('DELETE')}}
        </form>
        <table class="table table-striped">
            <thead>
            <tr>
                <td>Id</td>
                <td>Nome</td>
                <td>Data Inicial</td>
                <td>Data Final</td>
                <td>Status</td>
                <td>Situação</td>
                <td class="text-center">Ações</td>
            </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                    @switch($activity->status_id)
                        @case(1)
                            @php $status = 'Pendente' @endphp
                        @break
                        @case(2)
                        @php $status = 'Em Desenvolvimento' @endphp
                        @break
                        @case(3)
                        @php $status = 'Em Teste' @endphp
                        @break
                        @case(4)
                        @php $status = 'Concluído' @endphp
                        @break
                    @endswitch
                    <tr class="{{$status == 'Concluído' ? 'done' : ''}}">
                        <td>{{$activity->id}}</td>
                        <td>{{$activity->name}}</td>
                        <td>{{date ('d/m/Y', strtotime($activity->begin_date))}}</td>
                        <td>{{date ('d/m/Y', strtotime($activity->final_date))}}</td>
                        <td>{{$status}}</td>
                        <td>{{$activity->situation}}</td>
                        <td class="actions text-right">
                            <a class="btn btn-info see" data-description="{{$activity->description}}" data-name="{{$activity->name}}" id="see_description" data-toggle="modal" data-target="#modalDescription" title="Ver" >
                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Ver
                            </a>
                            <a class="btn btn-primary" title="Editar" href="{{route ('activities.edit', $activity->id)}}" {{$activity->status == 'Concluído' ? 'disabled' : ''}}>
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Editar
                            </a>
                            <a class="btn btn-danger delee-intem" onclick="DeleteActivity({{$activity->id}})" title="Excluir" href="{{route ('activities.destroy', $activity->id)}}">
                                <span class="glyphicon glyphicon-remove-circle"  aria-hidden="true"> </span> Excluir
                            </a>
                        </td>
                    </tr>
                @empty
                    <p> Não possui Clientes cadastrados</p>
                @endforelse
            </tbody>
        </table>
        <div class="col-md-12 text-center">
            <a class="btn btn-primary btn-create" type="submit" href="{{route('activities.create')}}">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Cadastrar Atividade
            </a>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalDescription" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="">Descrição da Atividade</h4>
                        <span class="modal-name-activity"></span>
                        <span class="modal-date-activity"></span>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

<script>

	DeleteActivity = function (id) {
		event.preventDefault();
		$('#form-delete').attr('action', "/activities/"+id);
		if(confirm('Deseja Excluir essa Atividade?')) {
			$('#form-delete').submit();
		}
	}

</script>