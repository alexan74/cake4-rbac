<?php
namespace Rbac\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RbacPerfiles Model
 *
 * @property \App\Model\Table\PermisosVirtualHostsTable|\Cake\ORM\Association\BelongsTo $PermisosVirtualHosts
 * @property \App\Model\Table\RbacAccionesTable|\Cake\ORM\Association\BelongsTo $RbacAcciones
 * @property \App\Model\Table\RbacAccionesTable|\Cake\ORM\Association\BelongsToMany $RbacAcciones
 * @property \App\Model\Table\RbacUsuariosTable|\Cake\ORM\Association\BelongsToMany $RbacUsuarios
 *
 * @method \App\Model\Entity\RbacPerfil get($primaryKey, $options = [])
 * @method \App\Model\Entity\RbacPerfil newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RbacPerfil[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RbacPerfil|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RbacPerfil|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RbacPerfil patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RbacPerfil[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RbacPerfil findOrCreate($search, callable $callback = null, $options = [])
 */
class RbacPerfilesTable extends Table
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

        $this->setTable('rbac_perfiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('PermisosVirtualHosts', [
        	'className' => 'Rbac.PermisosVirtualHosts',
            'foreignKey' => 'permiso_virtual_host_id',
        	//'propertyName' => 'PermisosVirtualHosts',
        ]);
        /*
        $this->belongsTo('Rbac.RbacAcciones', [
            'foreignKey' => 'accion_default_id'
        ]);
        */
        
        
        $this->belongsToMany('RbacAcciones', [
				'className' => 'Rbac.RbacAcciones',
				'joinTable' => 'rbac_acciones_rbac_perfiles',
				'foreignKey' => 'rbac_perfil_id',
				'targetForeignKey' => 'rbac_accion_id',				
		]
		);
        
        $this->belongsToMany('RbacUsuarios', [
            'foreignKey' => 'rbac_perfil_id',
            'targetForeignKey' => 'rbac_usuario_id',
            'joinTable' => 'rbac_perfiles_rbac_usuarios'
        ]);
        
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
            ->scalar('descripcion')
            ->maxLength('descripcion', 100)
            ->requirePresence('descripcion', 'create')
            ->notEmptyString('descripcion');
            //->add('descripcion', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('es_default')
            ->maxLength('es_default', 1)
            ->allowEmptyString('es_default');

        $validator
        ->allowEmptyString('usa_area_representacion');

        $validator
        ->allowEmptyString('perfil_publico');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules):RulesChecker
    {
        $rules->add($rules->isUnique(['descripcion']));
        $rules->add($rules->existsIn(['permiso_virtual_host_id'], 'PermisosVirtualHosts'));
        $rules->add($rules->existsIn(['accion_default_id'], 'RbacAcciones'));

        return $rules;
    }

    /*
     * Devuelve los virtual host que no tienen un perfil default designado
     */
    
    public function getHostVirtualDisponiblesDefault()
    {   
        $virtualHostNoPermitidos = $this->find('list',array('conditions'=>array('es_default'=>'1'),'fields'=>'permiso_virtual_host_id'))->toArray();
        
        $q = "SELECT id,permiso FROM permisos_virtual_hosts";
        $virtualHosts = $this->PermisosVirtualHosts->find('all')->toArray();
        foreach ($virtualHosts as $key => $v) 
        {
        	if($this->buscarInArray($v['id'], $virtualHostNoPermitidos)){
                unset($virtualHosts[$key]);
            }
        }
        //debug($virtualHosts);
        return $virtualHosts;
        
    }
    
    private function buscarInArray($valor, $arrs)
    {
        foreach ($arrs as $key => $v) 
        {   
            if($v == $valor)
            {
                return true;
            }
        }
        return false;
        
    }
}

