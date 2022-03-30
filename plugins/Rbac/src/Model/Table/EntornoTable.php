<?php
namespace Rbac\Model\Table;

use Cake\ORM\Table;


class EntornoTable extends Table{

	public $vh_default = 'carga_administracion';
	public $vh = array('solo_lectura', 
			           'carga_publica',
			           'carga_login_publica',
			           'carga_login_interna',
			           'carga_administracion');
	
	public function initialize(array $config):void
	{
		parent::initialize($config);
		$this->setTable(FALSE);
	}
	
	public function getEntornos(){
	   return $this->vh;	
	}
	
	public function getEntornoDefault(){
		
		if($this->getEntornoEnVhApache())
			return $this->getEntornoEnVhApache();
		else
			return $this->getEntornoDebugActivo();
		
	}
	
	private function getEntornoEnVhApache(){
						
		if (strstr(get_include_path(), 'solo_lectura')) {
			$vh = 'solo_lectura'; 
		}elseif(strstr(get_include_path(), 'carga_publica')) { 
			$vh = 'carga_publica'; 
		}elseif(strstr(get_include_path(), 'carga_login_publica')) { 
			$vh = 'carga_login_publica'; 
		}elseif(strstr(get_include_path(), 'carga_login_interna')) { 
			$vh = 'carga_login_interna'; 
		}elseif(strstr(get_include_path(), 'carga_administracion')) { 
			$vh = 'carga_administracion'; 
		}else{
			$vh = false;
		} 
				
		return $vh;
	}
	
	private function getEntornoDebugActivo(){
		
		return $this->vh_default;
		
	}

}