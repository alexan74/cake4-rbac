<?php
namespace Rbac\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RbacAcciones Model
 *
 * @property \App\Model\Table\RbacPerfilesTable|\Cake\ORM\Association\BelongsToMany $RbacPerfiles
 *
 * @method \App\Model\Entity\RbacAccion get($primaryKey, $options = [])
 * @method \App\Model\Entity\RbacAccion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RbacAccion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RbacAccion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RbacAccion|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RbacAccion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RbacAccion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RbacAccion findOrCreate($search, callable $callback = null, $options = [])
 */
class RbacAccionesTable extends Table
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

        $this->setTable('rbac_acciones');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsToMany('RbacPerfiles', [
            'foreignKey'       => 'rbac_accion_id',
            'targetForeignKey' => 'rbac_perfil_id',
            'joinTable'        => 'rbac_acciones_rbac_perfiles',
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
            ->scalar('controller')
            ->maxLength('controller', 100)
            ->requirePresence('controller', 'create')
            ->notEmptyString('controller');

        $validator
            ->scalar('action')
            ->maxLength('action', 100)
            ->allowEmptyString('action');

        $validator
            ->integer('solo_lectura')
            ->allowEmptyString('solo_lectura');

        $validator
            ->integer('carga_publica')
            ->allowEmptyString('carga_publica');

        $validator
            ->integer('carga_login_publica')
            ->allowEmptyString('carga_login_publica');

        $validator
            ->integer('carga_login_interna')
            ->allowEmptyString('carga_login_interna');

        $validator
            ->integer('carga_administracion')
            ->allowEmptyString('carga_administracion');

        $validator
            ->integer('heredado')
            ->allowEmptyString('heredado');

        $validator
            ->integer('oculto')
            ->allowEmptyString('oculto');

        return $validator;
    }

    /**
     * Verifica los permisos para los virtual host, si tiene permiso para leer la accion devuelve verdadero,
     *  en caso contrario devuelve falso
     * @param string  $controlador
     * @param string  $accion
     * @param array['carga_administracion','carga_login_interna',
     *              'carga_login_publica','carga_publica','solo_lectura'] $virtualHost
     * @return boolean
     */
    public function isValidActionVH($controlador, $accion, $virtualHost)
    {

        $vh_valido = $this->find('all', array('recursive' => -1,
            'fields'                                          => array('RbacAccion.id'),
            'conditions'                                      => array('controller' => $controlador,
                'action'                                                                => $accion,
                "$virtualHost"                                                          => 1),
        )
        )->count();
        return $vh_valido > 0;
    }

    /**
     * Verifica los permisos para los virtual host publicos ('solo_lectura','carga_publica'),si  tiene permiso para leer
     * la accion devuelve verdadero en caso contrario retorna false
     * @param string $controlador
     * @param string $accion
     * @return boolean
     */
    public function isPublicAction($controlador, $accion)
    {

        $vh_valido = $this->find('all', array('recursive' => -1,
            'fields'                                          => array('RbacAccion.id'),
            'conditions'                                      => array('controller' => $controlador,
                'action'                                                                => $accion,
                'OR'                                                                    => array('solo_lectura' => 1, 'carga_publica' => 1)),
        )
        )->count();
        return $vh_valido > 0;
    }

    /**
     * Obtiene todas las acciones que estan permitidas en el virtual host
     * @param string $virtualHost
     * @return array
     */
    public function getAccionesByVirtualHost($virtualHost)
    {
        $acciones_vh = $this->find()->select(['RbacAcciones.id', 'RbacAcciones.controller', 'RbacAcciones.action'])->where(['RbacAcciones.action <>' => '_null',  "$virtualHost" => 1])->order(['RbacAcciones.controller' => 'ASC','RbacAcciones.action' => 'ASC']);

        return $acciones_vh->toArray();
    }

    /**
     * Obtiene todas las acciones que estan permitidas en el virtual host
     * @param string $virtualHost
     * @return array
     */
    public function getAccionesByVirtualHostNull($virtualHost)
    {

        $acciones_vh_null = $this->find('all',
            array(                
                'fields'     => array('RbacAcciones.id','RbacAcciones.controller','RbacAcciones.action'),
                'conditions' => array(
                    'oculto'       => '1',
                    //'NOT' => array('RbacAcciones.id' => array(17,18,19,20,21,26)),
                    "$virtualHost" => 1,
                ),
                'order'      => array('controller', 'action'),
            )
        )->toArray();
//debug($acciones_vh_null);die;
        return $acciones_vh_null;
        //$q = "SELECT id, controller, action FROM rbac_acciones WHERE {$virtualHost} = 1 ORDER BY controller, action ASC";
        //$r = $this->query($q);

        //return $r;
    }
}
