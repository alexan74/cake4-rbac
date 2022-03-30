<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Core\Exception;
use Cake\Event\EventInterface;
use Cake\Http\Exception\InternalErrorException;
use Cake\Routing\Router;
use Cake\Mailer\Mailer;

class UsuariosController extends AppController {
	
	public $name = 'Usuarios';

    
	/*public $helpers = [
			'Paginator' => ['templates' => 'paginator-templates'],
	];*/
    
    public function _null() {
    }

	
    public function beforeFilter(EventInterface $event)
    {
         parent::beforeFilter($event);
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
                if ($this->getRequest()->getParam('action') != 'recuperar') {
                    $this->viewBuilder()->setLayout('admin');
                }
            } else {
                $this->viewBuilder()->setLayout('Rbac.login');
            }
        }
    }
    
    public function initialize():void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    /**
     * Muestra el listado de usuario existentes
     */
    public function index() {
    	$limite = 20;
		
    	$this->loadModel('Rbac.RbacUsuarios');
    	if ($this->getRequest()->is('post')) {
    	
    		$query = $this->RbacUsuarios->find('all')->where(['usuario like' => '%' . trim($this->getRequest()->getData('usuario')) . '%',
    				'nombre like'                                                    => '%' . trim($this->getRequest()->getData('nombre')) . '%',
    				'apellido like'                                                  => '%' . trim($this->getRequest()->getData('apellido')) . '%']);
    	
    		$this->paginate = array('contain' => array('RbacPerfiles', 'PerfilDefault'), 'limit' => $limite);
    		$this->set('rbacUsuarios', $this->paginate($query));
    	
    		$this->set('usuario', trim($this->getRequest()->getData('usuario')));
    		$this->set('nombre', trim($this->getRequest()->getData('nombre')));
    		$this->set('apellido', trim($this->getRequest()->getData('apellido')));
    		// $this->viewBuilder()->setLayout(null);	
    	} else {
			$query = $this->RbacUsuarios->find('all');
    		$this->paginate = array('contain' => array('RbacPerfiles', 'PerfilDefault'), 'limit' => $limite);
    		$this->set('rbacUsuarios', $this->paginate($query));
    		$this->set('usuario', null);
    		$this->set('nombre', null);
    		$this->set('apellido', null);
    	}
    	$total = $this->RbacUsuarios->find('all',array('contain' => array('RbacPerfiles', 'PerfilDefault')))->count();
    	/*$this->set("limite", $limite);
    	$this->set("total", $total);*/
    	$this->getRequest()->getSession()->write(compact('total'));
    	
    }

    /**
     * Agrega un usuario nuevo
     */
    public function agregar()
    {
        $this->loadModel('Rbac.Configuraciones');
        $configuracionLDAP = $this->Configuraciones->findByClave('Mostrar LDAP')->toArray();
        $this->set('LDAP', $configuracionLDAP);
        $this->loadModel('Rbac.RbacUsuarios');
        if ($this->request->is('post')) {
            try {
                $rbacUsuario = $this->RbacUsuarios->newEntity($this->request->getData(),['associated'=>['RbacPerfiles','PerfilDefault']]);
                //$rbacUsuario = $this->RbacUsuarios->patchEntity($rbacUsuario, $this->request->getData(),['associated'=>['RbacPerfiles','PerfilDefault']]);
                $params = Configure::read('params');
                $seed = md5(rand(0, 9999));
                $rbacUsuario['seed'] = $seed;
                if (!empty($rbacUsuario['password'])) {
                    $rbacUsuario['password'] = hash('sha256', $seed.$rbacUsuario['password']);
                }
                $this->RbacUsuarios->getConnection()->begin();
                if ($this->RbacUsuarios->save($rbacUsuario)) {
                    if (!$this->request->getData('valida_ldap')) {
                        $id                              = $rbacUsuario->id;
                        $token                           = $this->generateToken();
                        $this->loadModel('Rbac.RbacToken');
                        $data['token']      = $token;
                        $data['usuario_id'] = $id;
                        $data['validez']    = 1440;
                        $rbacToken = $this->RbacToken->newEntity($data); 
                        
                        $datos               = array();
                        $datos['subject']    = 'Confirmación de nuevo usuario';
                        $datos['url']        = Router::url('/', true) . "rbac/rbac_usuarios/recuperarPass/" . $token;
                        $datos['aplicacion'] = $params['aplicacion'];
                        $datos['template']   = 'nuevo_usuario_noldap';
                        $datos['email']      = $this->request->getData('correo');
                        $error=0;
                        if ($this->RbacToken->save($rbacToken)) {
                            if ($this->_sendEmail($datos)) {
                                $this->RbacUsuarios->getConnection()->commit();
                                $this->Flash->success('Se ha enviado la información para crear la clave de su usuario ingresando a la dirección ' . $this->request->getData('correo'));
                            } else {
                                $this->RbacUsuarios->getConnection()->rollback();
                                $this->Flash->error('No pudo enviar confirmación de nuevo usuario');
                                $error=1;
                            }
                        } else {
                            $this->RbacUsuarios->getConnection()->rollback();
                            $this->Flash->error('No pudo generar token antes de enviar confirmacion del nuevo usuario');
                            $error=1;
                        }
                        if (!$error) {
                            if ($this->getRequest()->getSession()->check('pag_' . strtolower($this->getRequest()->getParam('controller'))))
                            {
                                $page = $this->getRequest()->getSession()->read('pag_' . strtolower($this->getRequest()->getParam('controller')));
                                $this->getRequest()->getSession()->delete('pag_' .strtolower( $this->getRequest()->getParam('controller')));
                                return $this->redirect('/'.strtolower( $this->getRequest()->getParam('controller')).'/index?page=' . $page);
                            } else {
                                return $this->redirect(array('action' => 'index'));
                            }
                        }
                    } else {
                        $this->Flash->success('Se ha creado el usuario ' . $this->request->getData('usuario'));
                        $this->RbacUsuarios->getConnection()->commit();
                        return $this->redirect(array('action' => 'index'));
                        /*$datos               = array();
                        $datos['subject']    = 'Nuevo usuario';
                        $datos['url']        = Router::url('/', true);
                        $datos['aplicacion'] = $params['aplicacion'];
                        $datos['template']   = 'nuevo_usuario_ldap';
                        $datos['email']      = $this->request->getData('correo');
                        if ($this->_sendEmail($datos)) {
                            $this->Flash->success('Se ha enviado la información para crear la clave de su usuario ingresando a la dirección ' . $this->request->getData('usuario'));
                        } else {
                            $this->Flash->error('No pudo enviar confirmación de nuevo usuario');
                        }*/
                    }
                } else {
                    $this->RbacUsuarios->getConnection()->rollback();
                    $error_msg = '';
                    if (!empty($rbacUsuario->invalid('usuario'))) $error_msg .= 'Ya esta registrado usuario, ';
                    if (!empty($rbacUsuario->invalid('correo'))) $error_msg .= 'Ya esta registrado correo, ';
                    $this->Flash->error('Error, '.$error_msg.' No se puede actualizar');
                    return $this->redirect(array('action' => 'index'));
                }
            } catch (Exception $e) {
                $this->RbacUsuarios->getConnection()->rollback();
                $this->Flash->success(__($e->getMessage()));
                return $this->redirect(array('action' => 'index'));
            }
        }
        $rbacPerfiles = $this->RbacUsuarios->RbacPerfiles->find('list', ['keyField' => 'id', 'valueField' => 'descripcion'])->toArray();
        $this->set('rbacPerfiles', $rbacPerfiles);
    }

    /**
     * Edita un usuario existente
     * @param int $id
     * @throws Exception
     */
    public function editar($id = null){
        if (!$id)
            throw new InternalErrorException(__('Accion inválida, no encuentra la id de usuario antes de editar'));
        $this->loadModel('Rbac.RbacUsuarios');
        $rbacUsuario = $this->RbacUsuarios->get($id, [
            'contain' => ['RbacPerfiles'],
        ]);
        //debug($rbacUsuario);die;
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            //debug($this->getRequest()->getData());die;
            $rbacUsuario = $this->RbacUsuarios->patchEntity($rbacUsuario, $this->getRequest()->getData(), ['associated' => ['RbacPerfiles'],
            ]);
            //debug($rbacUsuario);die;
            if ($this->RbacUsuarios->save($rbacUsuario)) {
                $this->Flash->success(__('Ha sido grabado correctamente.'));
                if ($this->getRequest()->getSession()->check('pag_' . strtolower($this->getRequest()->getParam('controller'))))
                {
                    $page = $this->getRequest()->getSession()->read('pag_' . strtolower($this->getRequest()->getParam('controller')));
                    $this->getRequest()->getSession()->delete('pag_' .strtolower( $this->getRequest()->getParam('controller')));
                    return $this->redirect('/'.strtolower( $this->getRequest()->getParam('controller')).'/index?page=' . $page);
                } else {
                    return $this->redirect(array('action' => 'index'));
                }
            }
            $this->Flash->error(__('Error, no pudo grabar correctamente.'));
        }
        $rbacPerfiles = $this->RbacUsuarios->RbacPerfiles->find('list', ['keyField' => 'id', 'valueField' => 'descripcion'])->toArray();

        foreach ($rbacUsuario['rbac_perfiles'] as $perfil) {
            $rbacPerfilesIds[] = $perfil['id'];
        }

        $this->set(compact('rbacUsuario', 'rbacPerfiles', 'rbacPerfilesIds'));
    }  

    /**
     * Elimina un usuario
     * @param int $id identificador del usuario a eliminar
     * @param $ususario_activo // que indica si el usuario eliminado es el usuario activo elimina los datos
     * de la sesión y redirije al login
     * @throws Exception
     */
	 public function eliminar($id, $usuario_activo = null)
     {

        if ($this->getRequest()->is('post')) {
            throw new InternalErrorException();
        }
        $this->loadModel('Rbac.RbacUsuarios');
        $rbacUsuario = $this->RbacUsuarios->get($id);
        /*$rbacUsuario = $this->RbacUsuarios->get($id, [
            'contain' => ['RbacPerfiles'],
        ]);*/
        
        
        if ($usuario_activo == 1) {
            if ($this->RbacUsuarios->delete($rbacUsuario)) {
                $this->getRequest()->getSession()->destroy();
                $this->redirect(array('action' => 'login'));
            }
        } else {
            if ($this->RbacUsuarios->delete($rbacUsuario)) {
               $this->Flash->success('El Usuario ha sido eliminado correctamente.', 'flash_custom');
                $this->redirect(array('action' => 'index'));
            }
        }
     }
     
     /**
      * Permite modificar la contraseña del usuario
      */
     public function changePass()
     {
         $this->loadModel('Rbac.RbacUsuarios');
         $usuario = $this->getRequest()->getSession()->read('RbacUsuario');
         $error=0;
         if ($this->getRequest()->is('post')) {
             
             $this->RbacUsuarios->recursive = -1;
             //$user = $this->RbacUsuarios->findById($usuario['id'])->toArray();
             $user = $this->RbacUsuarios->get($usuario['id']);
             $seed = $user['seed'];
             $contrasenia = $user['password'];
             
             $contraseniaActual = $this->getRequest()->getData('contraseniaActual');
             $contraseniaActualEncrypt = hash('sha256', $seed . $contraseniaActual);
             
             if ($contrasenia != $contraseniaActualEncrypt) {
                 $this->Flash->error('La contraseña actual no es correcta.');
                 $error = 1;
                 $this->redirect(array('action' => 'changePass'));
             }
             
             $contraseniaNueva = $this->getRequest()->getData('contraseniaNueva');
             $contraseniaNuevaConfirm = $this->getRequest()->getData('contraseniaNuevaConfirm');
             
             if ($contraseniaNueva != $contraseniaNuevaConfirm) {
                 $this->Flash->error('La confirmación de nueva contraseña es incorrecta.');
                 $error = 1;
                 $this->redirect(array('action' => 'changePass'));
             }
             
             if (!$error) {
                 $user['password'] = hash('sha256', $seed . $contraseniaNueva);
                 //$user['contraseniaOld'] = $contrasenia;
                 
                 if ($this->RbacUsuarios->save($user)) {
                     $this->Flash->success('La contraseña fue modificada correctamente.');
                     //cesar verrr
                     //debo obtener el perfil actual y segun eso redireccionar
                     
                     $this->redirect(array('controller' => 'usuarios', 'action' => 'index'));
                 }
             }
         } else {
             $this->RbacUsuarios->recursive = -1;
             $user = $this->RbacUsuarios->findById($usuario['id'])->toArray();
             //debug($user);
             $this->set(compact('user'));
         }
         
     }
     
     private function _sendEmail($datos)
     {
      
         $mailer = new Mailer();
         
         $mailer->setEmailFormat('html')
            ->setTo($datos['email'])
            ->setSubject($datos['subject'])
            ->viewBuilder()->setTemplate($datos['template'])
            ->setViewVars(['url' => $datos['url']]);
         
         $mailer->deliver();
         
         if (!$mailer) {
             return FALSE;
         } else {
             return TRUE;
         }            
         
     }
     
}
