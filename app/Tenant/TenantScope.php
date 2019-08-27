<?php

namespace  App\Tenant;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

// é um modelo para eu tratar a tabela em banco de dados. Vai ser usado nas atividades
class TenantScope implements Scope{
	//toda consulta de atividade vai fazer um where para ver se o usuario é o mesmo que criou a tividade
	public function apply(Builder $builder, Model $model){
		$userId = auth()->user()->id;
		$builder->where ('user_id', $userId);
	}
}