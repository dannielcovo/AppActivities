<?php
/**
 * Created by PhpStorm.
 * User: dannielcovo
 * Date: 27/01/19
 * Time: 20:50
 */

namespace App\Tenant;
use \App\Tenant;
trait TenantModels {

	//chama meu scopo Tenance para cada select
	protected static function boot () {
		parent::boot (); // TODO: Change the autogenerated stub
		static::addGlobalScope(new TenantScope());

		//evento eloquente: todo model criado mostra uma isntancia
		//na criaca da tabela vai adicionar aotomaticamente o id do usuario
		static::creating(function($model){
			$tenant = \Tenant::getTenant();
			if($tenant){
				$userId = auth ()->user()->id;
				$model->user_id = $userId;
			}
		});
	}

}