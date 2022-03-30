<?php

namespace Rbac\Controller;

use Cake\Http\Exception\InternalErrorException;
use Cake\Event\EventInterface;


class RbacPermisosController extends AppController {

    
    public function beforeFilter(EventInterface $event) {
        parent::beforeFilter($event);
        $session = $this->request->getSession();
        if (!$session->check('Auth')) {
            $session->write('redirect',$this->getRequest()->getUri('path'));
            $this->Flash->error('Su sesión ha caducado! Vuelva a iniciar sesión');
        }
        
	}
	
	public function initialize():void {
		parent::initialize();
		$this->loadComponent('Paginator');
		$this->permisos = $this->loadModel('Rbac.PermisosVirtualHosts');
	}
	
	public function beforeRender(EventInterface $event) {
		parent::beforeRender($event);
		//$this->viewBuilder()->setLayout('admin');
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
	
	
	public function index() {
        $this->paginate = array('limit' => 10);
        //$permisos = $this->loadModel('PermisosVirtualHosts');
        $query = $this->permisos->find('all');
        $this->set('rbacPermisos', $this->paginate($query));
    }

    public function agregar() {
        if ($this->getRequest()->is('post')) {
            $data = $this->permisos->newEntity($this->getRequest()->getData());
            if ($this->permisos->saveAll($data)) {
            	$this->Flash->success('Ha sido Grabado correctamente');
            	//return $this->redirect(array('action' => 'index'));
            	return $this->redirect($this->referer());
            } else {
            	$this->Flash->error('Error, no pudo grabar correctamente');
        	}  
        }
    }

    public function editar($id = null) {
        if (!$id)
            throw new InternalErrorException(__('Accion inválida'));

        $rbacPermiso = $this->permisos->findById($id);

        if (!$rbacPermiso)
            throw new InternalErrorException(__('Accion inválida'));

        if ($this->getRequest()->is('post', 'put')) {
            $this->permisos->id = $id;
            $data =  $this->permisos->patchEntity($rbacPermiso,$this->getRequest()->getData());
            if ($this->permisos->saveAll($data)) {
                $this->Flash->success('El Permiso se ha actualizado correctamente.');
                //return $this->redirect(array('action' => 'index'));
                return $this->redirect($this->referer());
            } else {
                $this->Flash->error('El Permiso no se puede actualizar.');
            }
        }
        
        if (!$this->getRequest()->getData()) $this->getRequest()->withData('data',$rbacPermiso);

    }

    public function eliminar($id) {
        $permisos = $this->permisos->get($id);
        if ($this->permisos->delete($permisos)) {
        	//$this->getRequest()->getSession()->setFlash('Este permiso ha sido eliminado correctamente.', 'flash_custom');
            $this->Flash->success('Este permiso ha sido eliminado correctamente.');
        } else {
        	//$this->getRequest()->getSession()->setFlash('No pudo eliminar este permiso correctamente.', 'flash_custom_error');
            $this->Flash->error('No pudo eliminar este permiso correctamente.');            
        }
        $this->redirect(array('action' => 'index'));
    }
    
    public function actualizarCaptcha(){
    	//$permisos = $this->loadModel('PermisosVirtualHosts');
        //debug($this->getRequest()->getData()); die;
        $permiso = $this->permisos->get($this->getRequest()->getData('id'));
        $data = $this->permisos->patchEntity($permiso, $this->getRequest()->getData());	
    	$this->permisos->save($data);
    	$this->set('data', array('result' => TRUE));
    	$this->render('/Element/ajaxreturn');
    }
    
    public function actualizarContrasenia(){
    	//$permisos = $this->loadModel('PermisosVirtualHosts');
        $permiso = $this->permisos->get($this->getRequest()->getData('id'));
        $data = $this->permisos->patchEntity($permiso, $this->getRequest()->getData());	
    	$this->permisos->save($data);
    	$this->set('data', array('result' => TRUE));
    	$this->render('/Element/ajaxreturn');
    	 
    }
    
    public function actualizarURL(){
    	$permiso = $this->permisos->get($this->getRequest()->getData('pk'));
    	$data['id'] = $this->getRequest()->getData('pk');
    	$data['url'] = empty($this->getRequest()->getData('value'))?NULL:$this->getRequest()->getData('value');
    	$data = $this->permisos->patchEntity($permiso, $data);
    	$this->permisos->save($data);
    	$this->set('data', array('result' => TRUE));
    	$this->render('/Element/ajaxreturn');
    }
}
