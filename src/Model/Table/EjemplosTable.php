<?php
namespace App\Model\Table;

use Cake\ORM\Table;


class EjemplosTable extends Table
{

    
    public function initialize(array $config):void
    {
        parent::initialize($config);

        $this->setTable('ejemplos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

    }
}
