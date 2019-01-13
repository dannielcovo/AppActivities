<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
    	'name',
		'description',
		'begin_date',
		'final_date',
		'status_id',
		'situation',
		'status_id'
	];

	const ACTIVITY_STATUS = ['Pendente', 'Em Desenvolvimento', 'Em Teste', 'Concluído'];
}

