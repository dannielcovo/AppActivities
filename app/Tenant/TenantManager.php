<?php
/**
 * Created by PhpStorm.
 * User: dannielcovo
 * Date: 28/01/19
 * Time: 18:44
 */

namespace App\Tenant;

class TenantManager
{
	private $tenant;

	public function getTenant(){
		return $this->tenant;
	}

	/**
	 * @param mixed $tenant
	 */
	public function setTenant ($tenant) {
		$this->tenant = $tenant;
	}
}
