<?php

namespace Rbac\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;

class RbacAccionesController extends AppController {

    //public $name = 'RbacAcciones';
    //public $uses = array('Rbac.RbacAccion', 'Rbac.PermisosVirtualHost','Rbac.Configuracion','Rbac.RbacUsuario','Rbac.RbacPerfil');
    //public $components = array('Rbac.ControllerList');
    public function beforeFilter(EventInterface $event) {
	    parent::beforeFilter($event);
	    $this->data = $this->getRequest()->getData();
	    $session = $this->request->getSession();
	    if (!$session->check('Auth')) {
	        $session->write('redirect',$this->getRequest()->getUri('path'));
	        $this->Flash->error('Su sesión ha caducado! Vuelva a iniciar sesión');
	    }	
	}
	
	public function beforeRender(EventInterface $event) {
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
	
    public function index() {
        $orders = ['controller' => 'ASC', 'action' => 'DESC'];
    	
    	$hideController = array('Configuraciones');  //,Ejemplos
    	
    	if ($this->getRequest()->is('post')|| $this->getRequest()->getSession()->check("#".strtolower($this->getRequest()->getParam('controller')))) {
    	    $misesion = $this->getRequest()->getSession()->read("#".strtolower($this->getRequest()->getParam('controller')));
    	    if (empty($this->getRequest()->getData()) && isset($misesion))
    	        $data = $misesion;
	        else
	            $data = $this->getRequest()->getData();
    		// Resultado de busqueda
	        $rbacAcciones = $this->RbacAcciones->find()->where(['controller NOT IN'=>$hideController,'action like' => '%' . trim($data['action']) . '%',
	                'controller like' => '%' . trim($data['controller']). '%'])->group(['controller','action'])->order($orders);
    		$result = $this->paginate($rbacAcciones);
                       
    		$this->set('rbacAcciones', $result->toArray());
        } else {
            $rbacControllerActions = $this->RbacAcciones->find()->where(['controller NOT IN'=>$hideController])->group(['controller','action'])->order($orders)->toArray();            

            //Busco los controladores y acciones que aun no han sido cargadas en la DB y las agrego
            $ControllerList = $this->loadComponent('Rbac.ControllerList');
            $aControllers = $ControllerList->get($rbacControllerActions);

            // Lista antes de sincronizar...
            $this->set('rbacNuevos', $aControllers);        		        	        	
           
			// Lista de acciones sincronizados
            $this->set('rbacAcciones', $rbacControllerActions);
        }
        
        $this->set('action', trim(@$data['action']));
        $this->set('controller', trim(@$data['controller']));
        
    }

    public function switchAccion() {
        $this->viewBuilder()->setLayout(null);
        $accion_id = $this->data['accion_id'];
        $atributo_id = $this->data['atributo_id'];
        $valor = $this->data['valor'];
        
        
        $rbacAccion = $this->RbacAcciones->get($accion_id);

        $result = TRUE;

        if (!$rbacAccion) $result = FALSE;
        
        /*$this->RbacAccion->id = $accion_id;
        $this->RbacAccion->set($atributo_id, $valor);*/
        $data['id'] = $accion_id;
        $data[$atributo_id] = $valor;
        
        $rbacAccion = $this->RbacAcciones->patchEntity($rbacAccion, $data);
        //debug($rbacAccion); die;
        if (!$this->RbacAcciones->save($rbacAccion)) {
            $result = FALSE;
        } /*else {
        	$permisosVirtualHost = $this->loadModel('Rbac.PermisosVirtualHost');
        	$permiso = $permisosVirtualHost->find('all')->where(['permiso' => $atributo_id])->first();
            if (isset($permiso) && !empty($permiso)) {
            	$permiso_id = $permiso['id'];
            	$perfiles = $this->RbacAccion->RbacPerfil->find('all', array('conditions' => array('permiso_virtual_host_id' => $permiso_id)));
            } else {
            	$perfiles = $this->RbacAccion->RbacPerfil->find('all');
            }
			           
        }*/

        $this->set('data', array('result' => $result));
        $this->render('/Element/ajaxreturn');
    }
    
    public function eliminar($id) {
        $this->viewBuilder()->setLayout(null);
    	if ($id) {
    		//$rbacAccion = $this->RbacAccion->findById($id)->toArray();
    		$rbacAccion = $this->RbacAcciones->get($id);
    		
    		if (isset($rbacAccion) && $rbacAccion['accion_default_id'] != $id) {
    			if ($this->RbacAcciones->delete($rbacAccion)) {
    				$this->Flash->success('La Acción con identificador ' . $id . ' ha sido eliminada correctamente.');
    			} else {
    				$this->Flash->error('No pudo eliminar esta accion con identificador ' . $id . ' correctamente.');
    			}
    		} else {
    			$this->Flash->error('La acción ' . $id . ' no puede ser eliminada debido que esta asociada a un perfil');
    		}
    	}
    	$this->redirect(array('action' => 'index'));
    }
    
    public function sincronizar() {
    
        $this->viewBuilder()->setLayout(null);
    	$result = FALSE;
    	$miArray = $this->data['miArray'];
    	$i = 0;
    	//debug($miArray);
    	$vh = $this->getVirtualHost();
 		
    	$perfilDefault = $this->getRequest()->getSession()->read('PerfilDefault');
    	
    	if ($perfilDefault == 1 && $vh == 'carga_administracion') {
	    	foreach ($miArray as $item) {
	    		$datos = explode(';', $item);
	    		//$data['id'] = NULL;
	    		$data['controller'] = $datos[0];
	    		$data['action'] = $datos[1];
	    		$data['carga_administracion'] = 1;
	    		$rbacAccion = $this->RbacAcciones->newEntity($data);
	    		//$rbacAccion = $this->RbacAcciones->patchEntity($rbacAccion, $data);
	    		
	    		if ($this->RbacAcciones->save($rbacAccion)) {
	    			$accion_id = $rbacAccion->id;
	    			/*$ins_perfilxaccion = $this->RbacPerfil->query("INSERT INTO rbac_acciones_rbac_perfiles
		        				(rbac_accion_id,rbac_perfil_id) VALUES (" . $accion_id . ",1)");*/
	    			
	    			//$conn = ConnectionManager::get('default');
	    			/*$stmt = $conn->execute("INSERT INTO rbac_acciones_rbac_perfiles
		        				(rbac_accion_id,rbac_perfil_id) VALUES (" . $accion_id . ",1)");*/  			
	    			//$results = $stmt ->fetch('assoc');
	    			$this->RbacAcciones->getConnection()->execute("INSERT INTO rbac_acciones_rbac_perfiles
		        				(rbac_accion_id,rbac_perfil_id) VALUES (". $accion_id .",1)");
	    			$result = TRUE;
	    		} else {
	    			$result = FALSE;
	    			$this->Flash->error('Error, no pudo grabar correctamente.');
	    			break;
	    		}
	    		
	    	}
	    	/*if ($data) {
	    		if (!$this->RbacAccion->saveAll($data)) {
	    			$result = false;
	    			$this->Session->setFlash('Error, no pudo grabar correctamente.', 'flash_custom_error');
	    		} else {
	    			$result = true;
	    			$this->Session->setFlash('Ha sido grabado correctamente', 'flash_custom');
	    		}
	    	}*/
    	} else {
    		foreach ($miArray as $item) {
    			$datos = explode(';', $item);
    			$data[$i]['controller'] = $datos[0];
    			$data[$i]['action'] = $datos[1];
    			/*if ($datos[1] == '_null')
    			 $data[$i]['RbacAccion']['solo_lectura'] = 1;
    			else*/
    			$data[$i]['carga_administracion'] = 1;
    			//debug($data);
    			$i++;
    		}
    		if ($data) {
    		    $rbacAccion = $this->RbacAcciones->newEntity($data);
    			//$rbacAccion = $this->RbacAcciones->patchEntity($rbacAccion, $data);
    			if (!$this->RbacAcciones->saveAll($rbacAccion)) {
    				$result = FALSE;
    				$this->Flash->error('Error, no pudo grabar correctamente.');
    			} else {
    				$result = TRUE;
    				$this->Flash->success('Ha sido grabado correctamente', 'flash_custom');
    			}
    		}
    	}
    	$this->set('data', $result);
    	$this->render('/Element/ajaxreturn');
    
    }

    private function getVirtualHost()
    {
    	if (Configure::read('debug') == 2)
    	{
    		//$vh = VH_DEFAULT;
    		$vh = $this->getRequest()->getSession()->read('vh_default');
    	} else {
    		$vh = null;
    		if (strstr(get_include_path(), 'solo_lectura')) { $vh = 'solo_lectura'; }
    		if (strstr(get_include_path(), 'carga_publica')) { $vh = 'carga_publica'; }
    		if (strstr(get_include_path(), 'carga_login_publica')) { $vh = 'carga_login_publica'; }
    		if (strstr(get_include_path(), 'carga_login_interna')) { $vh = 'carga_login_interna'; }
    		if (strstr(get_include_path(), 'carga_administracion')) { $vh = 'carga_administracion'; }
    	}
    
    	return $vh;
    }      

}
