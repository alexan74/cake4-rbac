<?php
namespace Rbac\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PermisosVirtualHosts Model
 *
 * @method \App\Model\Entity\PermisosVirtualHost get($primaryKey, $options = [])
 * @method \App\Model\Entity\PermisosVirtualHost newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PermisosVirtualHost[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PermisosVirtualHost|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PermisosVirtualHost|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PermisosVirtualHost patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PermisosVirtualHost[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PermisosVirtualHost findOrCreate($search, callable $callback = null, $options = [])
 */
class PermisosVirtualHostsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config):void
    {
        parent::initialize($config);

        $this->setTable('permisos_virtual_hosts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator):Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('permiso')
            ->maxLength('permiso', 250)
            ->requirePresence('permiso', 'create')
            ->notEmptyString('permiso');

        $validator
            ->scalar('url')
            ->maxLength('url', 128)
            ->allowEmptyString('url');

        $validator
            ->allowEmptyString('activo');

        $validator
            ->allowEmptyString('captcha');

        $validator
            ->allowEmptyString('contrasenia');

        return $validator;
    }
}
