<?php
namespace Rbac\Model\Table;

use Cake\ORM\Table;
use Cake\Core\Configure;
//use Cake\Http\Session;


class RbacVhLocalConfigTable extends Table{

	//public $useTable = FALSE;
	
    public function initialize(array $config):void
	{
		parent::initialize($config);
	
		$this->setTable(false);
	
	}

	/**
	 * @ Obtiene tipo de permiso del Virtual Host
	 * @return <NULL, string>
	 */
	public function getVirtualHost(){
		
		if (Configure::read('debug') == 1){
			//$vh = VH_DEFAULT;
			//$session = new Session();
			//$session = $this->getRequest()->getSession();
			//$vh = $session->read('vh_default');
			$vh = "carga_administracion";

		} else {
			$vh = null;
			if (strstr(get_include_path(), 'solo_lectura')) {
				$vh = 'solo_lectura';
			}
			if (strstr(get_include_path(), 'carga_publica')) {
				$vh = 'carga_publica';
			}
			if (strstr(get_include_path(), 'carga_login_publica')) {
				$vh = 'carga_login_publica';
			}
			if (strstr(get_include_path(), 'carga_login_interna')) {
				$vh = 'carga_login_interna';
			}
			if (strstr(get_include_path(), 'carga_administracion')) {
				$vh = 'carga_administracion';
			}
		}

		return $vh;
	}


}