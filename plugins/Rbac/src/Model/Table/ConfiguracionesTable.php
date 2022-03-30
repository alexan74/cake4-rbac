<?php
namespace Rbac\Model\Table;

use Cake\ORM\Table;


class ConfiguracionesTable extends Table {
	
	 public function initialize(array $config):void
    {
        parent::initialize($config);

        $this->setTable('configuracion');
    }

	public $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'allowEmpty' => true
			)
		),
		'clave' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true
			)			
		),
		'valor' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'required' => true
			)
		)				
	);
}