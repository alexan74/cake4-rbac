<?php

namespace Rbac\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Exception\MethodNotAllowedException;
use Cake\Http\Exception\InternalErrorException;

class RbacPerfilesController extends AppController
{

    public $order = 'descripcion ASC';

    public $accionesDefaultLogin = array(18, 19, 20, 21, 26);

    public $paginate = [
        'limit' => 10,
        'order' => [
            'RbacPerfiles.descripcion' => 'asc',
        ],
    ];

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $session = $this->request->getSession();
        if (!$session->check('Auth')) {
            $session->write('redirect',$this->getRequest()->getUri('path'));
            $this->Flash->error('Su sesión ha caducado! Vuelva a iniciar sesión');
        }
    }

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);        
        if ($this->getRequest()->is('ajax')) {
            $this->viewBuilder()->setLayout(null);
        } else {
            if ($this->getRequest()->getParam('action') != 'login') {
                $this->viewBuilder()->setLayout('admin');
            } else {
                $this->viewBuilder()->setLayout('Rbac.login');
            }
        }
    }

    public function initialize():void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        //$this->loadComponent('Csrf');
    }

    public function index()
    {
        if ($this->getRequest()->is('post')) {
            $query = $this->RbacPerfiles->find('all')->where(['descripcion like' => '%' . $this->getRequest()->getData('descripcion') . '%'])->contain(['PermisosVirtualHosts']);
            $this->set('rbacPerfiles', $this->paginate($query));
            $this->set('descripcion', $this->getRequest()->getData('descripcion'));
            $this->render('/Element/RbacPerfiles/listado');
        } else {
            $query = $this->RbacPerfiles->find('all')->contain(['PermisosVirtualHosts']);
            $data  = $this->paginate($query);
            $this->set('rbacPerfiles', $data);
            $this->set('descripcion', null);
        }
    }

    public function agregar()
    {
        $this->set('PermisosVirtualHost', $this->RbacPerfiles->PermisosVirtualHosts->find('all')->toArray());
        $this->set('PermisosVirtualHostDisponiblesDefault', $this->RbacPerfiles->getHostVirtualDisponiblesDefault());
        if ($this->getRequest()->is('post')) {
            $this->addAccionesPerfil();
            $rbacPerfil = $this->RbacPerfiles->newEntity($this->getRequest()->getData(), ['associated' => ['RbacAcciones']]);
            //$rbacPerfil = $this->RbacPerfiles->patchEntity($rbacPerfil, $this->getRequest()->getData(), ['associated' => ['RbacAcciones']]);
            if ($this->RbacPerfiles->save($rbacPerfil)) {
                $this->Flash->success('Se ha creado exitosamente');          
                /* Actualizar las acciones por perfiles sin cerrar la sesion - alex */
                $usuario = $this->getRequest()->getSession()->read('RbacUsuario');
                $this->loadModel('Rbac.RbacUsuarios');
                $usr = $this->RbacUsuarios->findByUsuario($usuario['usuario'])->contain(['RbacPerfiles' => ['RbacAcciones']])->toArray();
                if (isset($usr->rbac_perfiles)){
                    $rbacAcciones = $this->generarListadoAccionesPorPerfiles($usr->rbac_perfiles);
                }
                /* ------- */   
                $this->redirect(array('action' => 'index'));
            } else {  
                $this->Flash->error('No pudo crear perfil');
            }
        }
    }

    public function editar($id = null)
    {
        if (!$id) {
            throw new InternalErrorException(__('Accion inválida'));
        }
        $rbacPerfil = $this->RbacPerfiles->findById($id)->contain(['PermisosVirtualHosts', 'RbacAcciones'])->first();
        //debug($rbacPerfil->permisos_virtual_host); die;
        if (!$rbacPerfil) {
            throw new InternalErrorException(__('Accion inválida'));
        }
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $this->addAccionesPerfil();
            
            $rbacPerfilNew = $this->RbacPerfiles->newEntity($this->getRequest()->getData(), ['associated' => ['RbacAcciones']]);
            //$rbacPerfilNew = $this->RbacPerfiles->patchEntity($rbacPerfil, $this->getRequest()->getData(), ['associated' => ['RbacAcciones']]);
            //debug($rbacPerfilNew); die;
            if ($this->RbacPerfiles->save($rbacPerfilNew)) {
                $this->Flash->success('Se ha actualizado exitosamente.');
                /* Actualizar las acciones por perfiles sin cerrar la sesiom - alex */
                $usuario = $this->getRequest()->getSession()->read('RbacUsuario');
                $this->loadModel('Rbac.RbacUsuarios');
                $usr = $this->RbacUsuarios->findByUsuario($usuario['usuario'])->contain(['RbacPerfiles' => ['RbacAcciones']])->toArray();
                if (!empty($usr[0]['rbac_perfiles'])){
                    $rbacAcciones = $this->generarListadoAccionesPorPerfiles($usr[0]['rbac_perfiles']);
                }
                /* ------- */
            } else {
                $this->Flash->error('No se puede actualizar el perfil');
            }
            return $this->redirect(['action' => 'index']);
        } else {
            
            $permisoVH = $rbacPerfil->permisos_virtual_host;
            $permiso = $permisoVH->permiso;
            //traigo los virtual host
            $this->set('PermisosVirtualHost', $this->RbacPerfiles->PermisosVirtualHosts->find('all')->toArray()); //todas
            $PermisosVirtualHostDisponiblesDefault = $this->RbacPerfiles->getHostVirtualDisponiblesDefault();
            if ($rbacPerfil->es_default == 1) {
                $selfVH                                   = array();
                $selfVH['PermisosVirtualHost']['id']      = $permisoVH['id'];
                $selfVH['PermisosVirtualHost']['permiso'] = $permisoVH['permiso'];
                $selfVH['PermisosVirtualHost']['url']     = $permisoVH['url'];
                $PermisosVirtualHostDisponiblesDefault[]  = $selfVH;
            }
            $this->set('PermisosVirtualHostDisponiblesDefault', $PermisosVirtualHostDisponiblesDefault); //los diponibles + el mismo arreglar
            //traigo las acciones que el perfil tiene asignadas de la tabla intermedia
            $accionesAsignadas = array();
            foreach ($rbacPerfil->rbac_acciones as $accion) {
                //traigo acciones que no sean null y que no sean las reservadas(acciones default para usuarios)
                if (($accion->action != '_null') && (!in_array($accion->id, $this->accionesDefaultLogin))) {
                    $this->accionesDefaultLogin[] = $accion->id;
                    $accionesAsignadas[]          = $accion;
                }
            }
            usort($accionesAsignadas, function ($a, $b) {
                return $a['controller'] <= $b['controller'];
            });
                //acciones asignadas al usuario
                $this->set('accionesAsignadas', $accionesAsignadas);
                $accionesPosibles = $this->RbacPerfiles->RbacAcciones->find()->where(['RbacAcciones.id NOT IN' => $this->accionesDefaultLogin, 'RbacAcciones.action <>' => "_null", 'RbacAcciones.' . $permiso => 1])->all();
                $this->set('accionesPosibles', $accionesPosibles);
                $this->set('rbacPerfil', $rbacPerfil);
        }
        
        
    }
    

    public function eliminar($id)
    {
        if ($this->getRequest()->is('post')) {
            throw new MethodNotAllowedException();
        }
        try {
            $rbacPerfil = $this->RbacPerfiles->findById($id)->contain(['RbacUsuarios'])->first();

            if (isset($rbacPerfil['rbac_usuarios']) && count($rbacPerfil['rbac_usuarios']) > 0) {
                $this->Flash->error('No se puede eliminar el perfil porque tiene usuarios asociados.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->RbacPerfiles->delete($rbacPerfil);
                $this->Flash->success('El perfil ha sido eliminado correctamente.');
                $this->redirect(array('action' => 'index'));
            }
        } catch (InternalErrorException $e) {
            $this->Flash->error('No se puede eliminar el perfil porque tiene usuarios asociados.');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function getAccionesByVirtualHost()
    {
        $this->viewBuilder()->setLayout(null);
        $virtualHost = $this->getRequest()->getData('virtualHost');
        $acciones    = $this->RbacPerfiles->RbacAcciones->getAccionesByVirtualHost($virtualHost);
        $data = array('acciones' => $acciones);
        $this->set('data', $data);
        $this->render('/Element/ajaxreturn');
    }

    /*
     * Alta de acciones a perfil dependiendo del virtual host
     */

    private function addAccionesPerfil()
    {
        //va a depender de si la opcion es por default es 1 o 0
        if ($this->getRequest()->getData('es_default') == 1) {
            //es un perfil default hay que asignarle todas las acciones del virtual host
            if (null !== $this->getRequest()->getData('permiso_virtual_host_id')) {
                $virtualHost = $this->RbacPerfiles->PermisosVirtualHosts->findById(5)->first()->toArray();
            } else {
                $virtualHost = $this->PermisosVirtualHost->findById($this->getRequest()->getData('permiso_virtual_host_id'))->first()->toArray();
            }
            $acciones = $this->RbacAcciones->getAccionesByVirtualHostNull($virtualHost['permiso']);
            foreach ($acciones as $accion) {
                //$this->getRequest()->data['rbac_acciones'][] = $accion['id'];
                //$this->getRequest()->withData('rbac_acciones[]', $accion['id']);
                $arr_acciones[] = $accion['id'];
            }
            
            $this->getRequest()->withData('rbac_acciones', $arr_acciones);
        }
        if (($this->getRequest()->getData('permiso_virtual_host_id') == 3) || ($this->getRequest()->getData('permiso_virtual_host_id') == 4) || ($this->getRequest()->getData('permiso_virtual_host_id') == 5)) {
            $arr_acciones['_ids'][] = 18;
            $arr_acciones['_ids'][] = 19;
            $arr_acciones['_ids'][] = 20;
            $arr_acciones['_ids'][] = 21;
            $arr_acciones['_ids'][] = 28;
            $arr_acciones['_ids'][] = 29;
            $this->getRequest()->withData('rbac_acciones', $arr_acciones['_ids']);
            /*$this->getRequest()->data['rbac_acciones']['_ids'][] = 18;
            $this->getRequest()->data['rbac_acciones']['_ids'][] = 19;
            $this->getRequest()->data['rbac_acciones']['_ids'][] = 20;
            $this->getRequest()->data['rbac_acciones']['_ids'][] = 21;
            $this->getRequest()->data['rbac_acciones']['_ids'][] = 28;
            $this->getRequest()->data['rbac_acciones']['_ids'][] = 29;*/
            
        }
        //debug($arr_acciones); die;
    }

    private function parcheEditAcciones()
    {
        $this->data['RbacAccion'] = explode(',', $this->data['RbacAccionAux']);
    }
    
    private function generarListadoAccionesPorPerfiles($perfilesAcciones){
        $rbacAcciones = array();
        foreach ($perfilesAcciones as $key => $perfil){      
            //solo cargo perfiles que tienen acceso a login, los otros no tienen sentido
            if(($perfil['permiso_virtual_host_id'] != 1) && ($perfil['permiso_virtual_host_id'] != 2)){
                $p['id'] = $perfil['id'];
                $p['descripcion'] = $perfil['descripcion'];
                $perfilesPorUsuario[] = $p;
            }
            foreach ($perfil->rbac_acciones as $accion)
            {
                $controller = $this->camelCaseToUnderscore($accion['controller']);
                $rbacAcciones[$perfil['id']][$controller][$accion['action']] = array(
                    'value' => 1,
                    'solo_lectura' => $accion['solo_lectura'],
                    'carga_publica' => $accion['carga_publica'],
                    'carga_login_publica' => $accion['carga_login_publica'],
                    'carga_login_interna' => $accion['carga_login_interna'],
                    'carga_administracion' => $accion['carga_administracion']
                );
            }
        }
        $this->getRequest()->getSession()->write('PerfilesPorUsuario', $perfilesPorUsuario);
        $this->getRequest()->getSession()->write('RbacAcciones', $rbacAcciones);
        return $rbacAcciones;
    }
    
    private function camelCaseToUnderscore($str)
    {
        $str[0] = strtolower($str[0]);
        //$func = create_function('$c', 'return "_" . strtolower($c[1]);');
        $func = function($c) {return "_" . strtolower($c[1]);};
        return preg_replace_callback('/([A-Z])/', $func, $str);
    }

}
