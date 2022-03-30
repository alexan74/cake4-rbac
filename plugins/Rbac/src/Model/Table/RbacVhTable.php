<?php

namespace Rbac\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class RbacVhTable extends Table {
    
    //public $useTable = 'permisos_virtual_hosts';
    
    public function initialize(array $config):void
	{
		parent::initialize($config);
		
		$this->setTable('permisos_virtual_hosts');
		//$this->table('permisos_virtual_hosts');
	
	}
    
    public function traerVirtualHost()
    {
        $virtualHost = $this->findByActivo(1)->toArray();
        return $virtualHost[0]['permiso'];        
    }
    
    public function traerTodosVirtualHost()
    {
        $todosVirtualHost = $this->find('all',['fields'=>'permiso']);        
        
        return $todosVirtualHost;
    }
}