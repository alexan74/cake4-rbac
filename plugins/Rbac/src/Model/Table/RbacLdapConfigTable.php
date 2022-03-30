<?php
namespace Rbac\Model\Table;

use Cake\ORM\Table;

class RbacLdapConfigTable extends Table {
    
    public $useTable = FALSE;
    
   /**
	 *
	 * @var $hostname
	 */
	public $hostname = 'ldap.mrec.ar';
		
	/**
	 *
	 * @var $base
	 */
	public $base = 'dc=mrec,dc=ar';
	
	
	public function initialize(array $config):void
	{
		parent::initialize($config);
	
		$this->setTable(FALSE);
	
	}
	
	public function getHostName(){
		return $this->hostName;
	}
	
}