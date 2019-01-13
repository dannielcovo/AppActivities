@extends('../layouts.layout')
@section('content')
    <?php
    ?>
    <div class="row col-md-12 list-activities">
        <h1>Atividades</h1>
        <a class="btn btn-primary btn-create" type="submit" href="{{route('activities.create')}}">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Cadastrar Atividade</a>
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
                <td>Ações</td>
            </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                    <tr class="{{$activity->status == 'Concluído' ? 'done' : ''}}">
                        <td>{{$activity->id}}</td>
                        <td>{{$activity->name}}</td>
                        <td>{{date ('d/m/Y', strtotime($activity->begin_date))}}</td>
                        <td>{{date ('d/m/Y', strtotime($activity->final_date))}}</td>
                        <td>{{$activity->status}}</td>
                        <td>{{$activity->situation}}</td>
                        <td class="actions">

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
		console.log('entrou');
		event.preventDefault();
		$('#form-delete').attr('action', "/activities/"+id);
		if(confirm('Deseja Excluir esse usuário?')) {
			$('#form-delete').submit();
		}
	}


</script>