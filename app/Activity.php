<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

	public function allActivity(){
		$activity = DB::select ("select activities.id, name, status, begin_date, final_date, situation, description, status_id from activities JOIN statuses on activities.status_id = statuses.id");
		return $activity;
	}

	public function search(Array $data){
		return $this->where(function ($query) use ($data){
			if(isset($data['status']))
				$query->where('status_id', $data['status']);
			if(isset($data['situation']))
				$query->where('situation', $data['situation']);
		})
		->get();
	}

}

