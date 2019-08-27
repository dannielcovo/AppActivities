<?php
namespace App;

use App\Tenant\TenantModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Activity extends Model
{
	use TenantModels;

    protected $fillable = [
    	'name',
		'description',
		'begin_date',
		'final_date',
		'status_id',
		'situation',
		'user_id'
	];

	// adiciono meu tenance scoop

	const ACTIVITY_STATUS = ['Pendente', 'Em Desenvolvimento', 'Em Teste', 'Concluído'];

	public function status(){
		return $this->belongsTo (Status::class);
	}

	public function allActivity(){
		$activity = Activity::with('status')
			->get();
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

