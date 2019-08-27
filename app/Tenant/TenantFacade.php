<?php
/**
 * Created by PhpStorm.
 * User: dannielcovo
 * Date: 28/01/19
 * Time: 18:53
 */

namespace App\Tenant;

use Illuminate\Support\Facades\Facade;

class TenantFacade extends Facade{
	protected static function getFacadeAccessor () {
		return TenantManager::class;
	}
}
