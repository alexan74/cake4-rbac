<?php
namespace Rbac\Controller;

//use Rbac\Controller\AppController;
//use Rbac\Controller\Component\LoginManagerComponent;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\Exception\MissingDatasourceException;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Inflector;

class RbacUsuariosController extends AppController
{

    public $name = 'RbacUsuarios';
    public $data;
    
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $session = $this->request->getSession();
        if ($this->getRequest()->getParam('action') != 'login') {
            if (!$session->check('Auth')) {
                $session->write('redirect',$this->getRequest()->getUri('path'));
                $this->Flash->error('Su sesión ha caducado! Vuelva a iniciar sesión');
            }
        } 
        /*elseif ($this->getRequest()->getParam('action') == 'index' || $this->getRequest()->getParam('action') == 'editar') {
            $session = $this->getRequest()->getSession();
            if (!$session->check('Auth')) throw new NotFoundException('El usuario no tiene permiso para acceder a la funcionalidad requerida.');
        }*/
    }

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);        
        
        if ($this->getRequest()->is('ajax')) {
            $this->viewBuilder()->setLayout(null);
        } else {      
            if ($this->getRequest()->getParam('action') != 'login') {
                if ($this->getRequest()->getParam('action') != 'recuperar' && $this->getRequest()->getParam('action') != 'recuperarPass') {
                    $this->viewBuilder()->setLayout('admin');
                } else {
                    $this->viewBuilder()->setLayout('public');
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
        //$this->loadComponent('Csrf');
    }

    /**
     * Muestra el listado de usuario existentes
     */
    public function index()
    {
        $limite = 10;
        $this->paginate = array('contain' => array('RbacPerfiles', 'PerfilDefault'), 'limit' => $limite);
        if ($this->getRequest()->is('post') || $this->getRequest()->getSession()->check("#".strtolower($this->getRequest()->getParam('controller')))) {
            $misesion = $this->getRequest()->getSession()->read("#".strtolower($this->getRequest()->getParam('controller')));
            if (empty($this->getRequest()->getData()) && isset($misesion))
                $data = $misesion;
            else
                $data = $this->getRequest()->getData();
                
            $query = $this->RbacUsuarios->find('all')->where(['usuario like' => '%' . trim($data['usuario']) . '%',
                        'nombre like' => '%' . trim($data['nombre']) . '%',
                        'apellido like' => '%' . trim($data['apellido']) . '%']);

            
            $this->set('rbacUsuarios', $this->paginate($query));          
            //$this->render('/Element/RbacUsuarios/listado');
        } else {
            $this->set('rbacUsuarios', $this->paginate());             
            //$this->render('index');
        }
        $this->set('usuario', trim(@$data['usuario']));
        $this->set('nombre', trim(@$data['nombre']));
        $this->set('apellido', trim(@$data['apellido']));  
    }

    /**
     * Agrega un usuario nuevo
     */
    public function agregar()
    {
        $this->loadModel('Rbac.Configuraciones');
        $configuracionLDAP = $this->Configuraciones->findByClave('Mostrar LDAP')->toArray();
        $this->set('LDAP', $configuracionLDAP);
        if ($this->getRequest()->is('post')) {
            //$conn = ConnectionManager::get('default');
            try {    
                $rbacUsuario = $this->RbacUsuarios->newEntity($this->getRequest()->getData(),['associated'=>['RbacPerfiles','PerfilDefault']]);
                //$rbacUsuario = $this->RbacUsuarios->patchEntity($rbacUsuario, $this->getRequest()->getData(),['associated'=>['RbacPerfiles','PerfilDefault']]);
                $params = Configure::read('params');
                $seed = md5(rand(0, 9999));
                $rbacUsuario['seed'] = $seed;
                if (!empty($rbacUsuario['password'])) {
                    $rbacUsuario['password'] = hash('sha256', $seed.$rbacUsuario['password']);
                }
                $this->RbacUsuarios->getConnection()->begin();    
                if ($this->RbacUsuarios->save($rbacUsuario)) {
                    if (!$this->getRequest()->getData('valida_ldap')) {
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
                        $datos['email']      = $this->getRequest()->getData('correo');
                        $error=0;
                        if ($this->RbacToken->save($rbacToken)) {
                            if ($this->_sendEmail($datos)) {
                                $this->RbacUsuarios->getConnection()->commit();
                                $this->Flash->success('Se ha enviado la información para crear la clave de su usuario ingresando a la dirección ' . $this->getRequest()->getData('correo'));    
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
                            return $this->redirect(array('action' => 'index'));
                        }
                    } else {
                        $this->Flash->success('Se ha creado el usuario ' . $this->getRequest()->getData('usuario'));
                        $this->RbacUsuarios->getConnection()->commit();
                        return $this->redirect(array('action' => 'index'));
                        /*$datos               = array();
                        $datos['subject']    = 'Nuevo usuario';
                        $datos['url']        = Router::url('/', true);
                        $datos['aplicacion'] = $params['aplicacion'];
                        $datos['template']   = 'nuevo_usuario_ldap';
                        $datos['email']      = $this->getRequest()->getData('correo');
                        if ($this->_sendEmail($datos)) {
                            $this->Flash->success('Se ha enviado la información para crear la clave de su usuario ingresando a la dirección ' . $this->getRequest()->getData('usuario'));
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
            } catch (MissingDatasourceException $e) {
                $this->RbacUsuarios->getConnection()->rollback();
                //$conn->rollback();
                $this->Flash->success(__($e->getMessage()));
                return $this->redirect(array('action' => 'index'));
                //return $this->redirect($this->referer());
            }
        }
        $rbacPerfiles = $this->RbacUsuarios->RbacPerfiles->find('list', ['keyField' => 'id', 'valueField' => 'descripcion'])->toArray();
        $this->set('rbacPerfiles', $rbacPerfiles);
    }

    
    public function editar($id = null)
    {
        
        try {
            $rbacUsuario = $this->RbacUsuarios->get($id, [
                'contain' => ['RbacPerfiles'],
            ]);
            if ($this->getRequest()->is(['patch', 'post', 'put'])) {
                $rbacUsuario = $this->RbacUsuarios->patchEntity($rbacUsuario, $this->getRequest()->getData(), ['associated' => ['RbacPerfiles'],]);
                //$rbacUsuario = $this->RbacUsuarios->patchEntity($rbacUsuario, $this->getRequest()->getData());
                if ($this->RbacUsuarios->save($rbacUsuario)) {
                    $this->Flash->success('Se ha actualizado exitosamente.');                  
                } else {
                    $error = '';
                    if (!empty($rbacUsuario->invalid('usuario'))) $error .= 'Ya esta registrado usuario, ';
                    if (!empty($rbacUsuario->invalid('correo'))) $error .= 'Ya esta registrado correo, ';
                    $this->Flash->error('Error, '.$error.' No se puede actualizar');  
                }  
                return $this->redirect(['action' => 'index']);
            }
            $rbacPerfiles = $this->RbacUsuarios->RbacPerfiles->find('list', ['keyField' => 'id', 'valueField' => 'descripcion'])->toArray();
            
            foreach ($rbacUsuario['rbac_perfiles'] as $perfil) {
                $rbacPerfilesIds[] = $perfil['id'];
            }
            
            $this->set(compact('rbacUsuario', 'rbacPerfiles', 'rbacPerfilesIds'));
        } catch (RecordNotFoundException $e) {
           
            $this->Flash->error(__('Error, no encuentra la id de usuario antes de editar.'));
            return $this->redirect(['action' => 'index']);
            //return $this->redirect($this->referer());
        }

        
    }

    /**
     * Elimina un usuario
     * @param int $id identificador del usuario a eliminar
     * @param int $ususario_activo  indica si el usuario eliminado es el usuario activo elimina los datos
     * de la sesión y redirije al login
     */
    public function eliminar($id, $usuario_activo = 0)
    {
        $rbacUsuario = $this->RbacUsuarios->get($id, [
            'contain' => ['RbacPerfiles'],
        ]);
        
        if ($usuario_activo == 1) {
            if ($this->RbacUsuarios->delete($rbacUsuario)) {
                $this->getRequest()->getSession()->destroy();
                $this->redirect(array('action' => 'login'));
            }
        } else {
            if ($this->RbacUsuarios->delete($rbacUsuario)) {
                $this->Flash->success('El Usuario ha sido eliminado correctamente.', 'flash_custom');
                $this->redirect(array('action' => 'index'));
                //return $this->redirect($this->referer());
            }
        }
    }

    public function login($noredirect=null)
    {
        $this->viewBuilder()->setLayout('Rbac.login');
        $session = $this->getRequest()->getSession();
        if (!empty($noredirect)) {
            /*$session->write('redirect',$this->referer());
            $this->Flash->error('Su sesión ha caducado! Vuelva a iniciar sesión');*/
            $session->delete('redirect');
            return $this->redirect('/login/');
        }
        
        $this->loadModel('Rbac.Configuraciones');
        $configCaptcha        = $this->Configuraciones->findByClave('Mostrar Captcha');
        $configuracionCaptcha = $configCaptcha->toArray();
        $this->set('captcha', $configuracionCaptcha[0]['valor']);
    	$session->delete("conditions");

        if ($this->getRequest()->is('Post')) {
            $this->data = $this->getRequest()->getData('data');
            //validación de captcha
            if ($configuracionCaptcha[0]['valor'] == 'Si') {
                if (strtolower($session->read('hash')) != strtolower($this->data['captcha'])) {
                    $session->destroy();
                    /*$this->set('captcha', $configuracionCaptcha[0]);
                    $this->set('noLDAP', $configuracionNoLDAP[0]);*/
                    $this->Flash->error('Validación errónea...');
                    return FALSE;
                }
            }

            //validacion de usuario
            if (isset($this->data['RbacUsuario']['usuario']) && isset($this->data['RbacUsuario']['password'])) {
                $usuario  = $this->data['RbacUsuario']['usuario'];
                $password = $this->data['RbacUsuario']['password'];

                /*if ($this->RbacUsuarios->autenticacion($usuario, $password)) {
                    $this->loadComponent('Rbac.LoginManager');
                    $this->LoginManager->setUserAndPassword($usuario, $password);*/
    
                    /*
                     * Si el perfil por default utiliza area/representación
                     */
                    $usr = $this->RbacUsuarios->findByUsuario($usuario)->contain(['RbacPerfiles' => ['RbacAcciones']])->first();
                    if (isset($usr->id)) {
                        //Existe el usuario en la DB, ahora verifico que tipo de validacion de usuario utiliza
                       
                        if ($usr->valida_ldap) {
                            $this->loadComponent('Rbac.LdapHandler');
                            $result = $this->LdapHandler->autenticacion($usuario, $password);
                            $area   = $this->LdapHandler->getArea($usuario);
                            $session->write('Area', $area);
                            
                        } else {
                            $this->loadComponent('Rbac.DbHandler');
                            $result = $this->DbHandler->autenticacion($usuario, $password);
                        }
    					//$result = $usr;                        
                    } else {
                        //no existe usuario en BD
                        //$this->Flash->error('Validación de usuario y clave errónea.', 'flash_custom_error');
                        $result = FALSE;
                    }
                    if ($result != FALSE) {
    
                        $result['id']          = $usr->id;
                        $result['valida_ldap'] = $usr->valida_ldap;
                        
                        
                        //$perfilDefault                 = (!$session->check('PerfilDefault') ? $usr->perfil_default_id : $session->read('PerfilDefault'));
                        if ($session->check('PerfilDefault')) {
                            if ($usr->perfil_default_id != $session->read('PerfilDefault')) {
                                $perfilDefault = $session->read('PerfilDefault');
                            } else {
                                $perfilDefault = $usr->perfil_default_id;
                            }
                        } else {
                            $perfilDefault = $usr->perfil_default_id;
                        }
                        
                        $this->generarListadoAccionesPorPerfiles($usr->rbac_perfiles);
    
                        $session->write('RbacUsuario', $result);
                        $session->write('PerfilDefault', $perfilDefault);
    
                        $this->loadModel('Rbac.RbacVhLocalConfig');
                        $session->write('virtualHost', $this->RbacVhLocalConfig->getVirtualHost());
                        $session->write('Auth.User', $result);
    
                        if ($this->getRequest()->is('ajax')) {
                            $this->layout = null;
                        }
                        if ($session->check('redirect')) {
                            $redirect = $session->read('redirect');
                            $session->delete('redirect');
                            $this->redirect($redirect);
                        } else  
                            $this->redirect($this->getUrlRedirect($perfilDefault));
                    } else {
                        // $this->getRequest()->getSession()->destroy(); //por que sino no puedo cambiar de perfil
                        $session->delete('PerfilDefault');
                        $session->delete('RbacUsuario');
                        $this->Flash->error('Validación de trigrama y clave errónea.');
                        //return $this->Controller->redirect(['plugin' => 'rbac', 'controller' => 'rbac_usuarios', 'action' => 'login']);
                    }
                /*} else {
                    $session->delete('RbacUsuario');
                    $session->delete('PerfilDefault');
                    $this->Flash->error('Validación de trigrama y clave errónea.');
                }*/
            }
        } else {
            if ($this->getRequest()->is('ajax')) {
                $this->viewBuilder()->setLayout(null);
                $this->render('login_popup');
            }

            $vh_default = $session->read('vh_default');
            if ($vh_default == 'solo_lectura') {
                $this->redirect(array('plugin' => null, 'controller' => 'Home'));
            } else {
                $session->delete('RbacUsuario'); //por que sino no puedo cambiar de perfil
                //$session->delete('PerfilDefault');
                $session->delete('Auth');
            }
            
        }
        //$this->render('Rbac.login');
    }
    
    private function logout() {
        $session = $this->getRequest()->getSession();
        $session->delete('redirect');
        return $this->redirect(array('controller' => 'rbac_usuarios', 'action' => 'login'));
    }

	/**
 	* @param array $perfilesAcciones
 	* @return array $rbacAcciones
 	*/
    private function generarListadoAccionesPorPerfiles($perfilesAcciones)
    {

        $rbacAcciones = array();
        $this->loadModel('Rbac.RbacPerfiles');

        foreach ($perfilesAcciones as $key => $perfil) {

            //solo cargo perfiles que tienen acceso a login, los otros no tienen sentido
            if (($perfil->permiso_virtual_host_id != 1) && ($perfil->permiso_virtual_host_id != 2)) {
                $p['id']              = $perfil->id;
                $p['descripcion']     = $perfil->descripcion;
                $perfilesPorUsuario[] = $p;
            }

            foreach ($perfil->rbac_acciones as $accion) {

                $controller = Inflector::underscore($accion['controller']);

                $rbacAcciones[$perfil->id][$controller][$accion->action] = array(
                    'value'                => 1,
                    'solo_lectura'         => $accion['solo_lectura'],
                    'carga_publica'        => $accion['carga_publica'],
                    'carga_login_publica'  => $accion['carga_login_publica'],
                    'carga_login_interna'  => $accion['carga_login_interna'],
                    'carga_administracion' => $accion['carga_administracion'],
                );
            }
        }

        $this->getRequest()->getSession()->write('PerfilesPorUsuario', $perfilesPorUsuario);
        $this->getRequest()->getSession()->write('RbacAcciones', $rbacAcciones);

        //return $rbacAcciones;
    }

	/**
 	* Permite al usuario logueado cambiar de Perfil.
 	* @param int $perfil
 	*/
    public function cambiarPerfil($perfil)
    {
        $this->getRequest()->getSession()->delete('redirect');
        $usuario       = $this->getRequest()->getSession()->read('RbacUsuario');
        $perfiles      = $this->getRequest()->getSession()->read('PerfilesPorUsuario');
        $perfil_valido = FALSE;
        $acciones      = $this->getRequest()->getSession()->read('RbacAcciones');

        if (isset($perfiles)) {
            foreach ($perfiles as $p) {
                if ($p['id'] == $perfil) {
                    $perfil_valido = TRUE;
                    break;
                }
            }
        }
        if ($perfil_valido) {
            $this->getRequest()->getSession()->delete('RbacUsuario');
            $this->getRequest()->getSession()->write('PerfilDefault', $perfil);
            //$inicio = $acciones[$perfil]['inicio'];
            $url = $this->getUrlRedirect($perfil);
            $this->redirect($url);
        } else {
            $this->Flash->error('Perfil inválido o Sesión expirada, consulte con el administrador');
            $this->redirect(array('controller' => 'rbac_usuarios', 'action' => 'login'));
        }
    }

	/**
 	* Buscar el/los usuarios de LDAP que coincidan con las letras ingresadas
 	*/
    public function autocompleteLdap()
    {

        $this->layout = null;
        $term         = $this->getRequest()->getData('usuario');
        $data         = $this->RbacUsuarios->get_trigrama_autocomplete($term);
        $this->set('data', $data);
        $this->render('/Element/ajaxreturn');
    }

	/**
 	* Permite modificar la contraseña del usuario
 	*/
    public function changePass()
    {

        $usuario = $this->getRequest()->getSession()->read('RbacUsuario');
        if ($this->getRequest()->is('post')) {
            $this->RbacUsuarios->recursive = -1;
            $user = $this->RbacUsuarios->get($usuario['id']);
            $seed = $user['seed'];
            $contrasenia = $user['password'];
            $contraseniaActual = $this->getRequest()->getData('contraseniaActual');
            $contraseniaActualEncrypt = hash('sha256', $seed . $contraseniaActual);
            if ($contrasenia != $contraseniaActualEncrypt) {
                $this->Flash->error('La contraseña actual no es correcta.');
            }

            $contraseniaNueva = $this->getRequest()->getData('contraseniaNueva');
            $contraseniaNuevaConfirm = $this->getRequest()->getData('contraseniaNuevaConfirm');

            if ($contraseniaNueva != $contraseniaNuevaConfirm) {
                $this->Flash->error('La confirmación de nueva contraseña es incorrecta.');
            }

            $user['RbacUsuario']['password'] = hash('sha256', $seed . $contraseniaNueva);
            //$user['RbacUsuario']['contraseniaOld'] = $contrasenia;

            if ($this->RbacUsuarios->saveAll($user)) {
                $this->Flash->success('La contraseña fue modificada correctamente.');
                //$this->redirect(array('controller' => 'rbac_usuarios', 'action' => 'index'));
                $this->redirect($this->referer());
            }
        } else {
            $this->RbacUsuarios->recursive = -1;
            $user = $this->RbacUsuarios->findById($usuario['id']);
			$this->set('user', $user->toArray());
        }	
    }

	/**
 	* Permite recuperar la contraseña a un usuario no LDAP
 	*/
    public function recuperar()
    {
        //$this->ViewBuilder()->setLayout('Rbac.login');
        if ($this->getRequest()->is('post')) {
            if (strtolower($this->getRequest()->getSession()->read('hash')) == strtolower($this->getRequest()->getData('captcha'))) {
                //$usuario = $this->RbacUsuarios->find('first', array('conditions' => array('correo' => $this->getRequest()->getData('correo'))))->toArray();
                $usuario = $this->RbacUsuarios->find()->where(['correo' => $this->getRequest()->getData('correo')])->first();
                    //->contain(['RbacPerfiles' => ['RbacAcciones']])   
                if (!empty($usuario)) {
                    $params = Configure::read('params');
                    //$url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
                    $token = $this->generateToken();
                    $data['token'] = $token;
                    $data['usuario_id'] = $usuario->id;
                    $data['validez'] = 1440;
                    $datos = array();
                    $datos['subject'] = 'Recuperar contraseña';
                    $datos['url'] = Router::url('/', true) . "rbac/rbac_usuarios/recuperarPass/" . $token;
                    $datos['aplicacion'] = $params['aplicacion'];
                    $datos['template'] = 'recuperar_contrasenia';
                    $datos['email'] = $this->getRequest()->getData('correo');
                    if ($this->_sendEmail($datos)) {
                        $this->loadModel('Rbac.RbacToken');
                        $rbacToken = $this->RbacToken->newEntity($data);
                        //$rbacToken = $this->RbacToken->patchEntity($rbacToken, $data);
                        if ($this->RbacToken->save($rbacToken)) {
                            $this->Flash->success(
                                'Se ha enviado la información para recuperar la clave al usuario ingresado a la dirección ' . $this->getRequest()->getData('correo')
                            );   
                        }
                    } else {
                        $this->Flash->error($this->Email->smtpError);
                    }
                } else {
                    $this->Flash->error('No encuentra correo para enviar la informacón de recuperar contraseña');
                    $this->redirect(array('controller' => 'rbac_usuarios', 'action' => 'login'));
                }
            }
        }
    }

	/**
 	* Permite recuperar el password a partir del token enviado por mail al usuario
 	* @param $token
 	*/
    public function recuperarPass($token)
    {
        $this->loadModel('Rbac.RbacToken');
        $result = $this->RbacToken->find()->where(['token' => $token])->first();
        if (!empty($result)) {
            $fecha_actual   = strtotime('now');
            $fecha_creacion = strtotime($result->created);
            $minutos        = ($fecha_actual - $fecha_creacion) / 60;
            //debug($minutos); die;
            if ($minutos < strtotime($result->validez)) {
                $id   = $result->usuario_id;
                $user = $this->RbacUsuarios->get($id);
                if ($this->getRequest()->is('post')) {
                    $this->RbacUsuarios->recursive = -1;
                    $seed = $user->seed;
                    $contraseniaNueva        = $this->getRequest()->getData('contraseniaNueva');
                    $contraseniaNuevaConfirm = $this->getRequest()->getData('contraseniaNuevaConfirm');
                    $usuario['id']       = $id;
                    $usuario['password'] = hash('sha256', $seed . $contraseniaNueva);
                    $usuario['usuario'] = $user->usuario;
                    $usuario['correo'] = $user->correo;
                    $usuario = $this->RbacUsuarios->patchEntity($user, $usuario);
                    if ($this->RbacUsuarios->save($usuario)) {
                        $this->Flash->success('Ha sido restablecido correctamente'); 
                        $this->redirect(array('controller' => 'rbac_usuarios', 'action' => 'login'));
                    } else {
                        $this->Flash->error('No pudo cambiar contraseña. Por favor contacto con el administrador'); 
                    }
                } 
                $this->set(compact('user','token'));
            } else {
                $this->redirect(array('controller' => 'rbac_usuarios', 'action' => 'login', 1));
            }
        } else {
            $this->redirect(array('controller' => 'rbac_usuarios', 'action' => 'login', 1));
        }
    }

	/**
	 * Verifica si un usuario existe en LDAP.
 	* @return boolean true si el usuario existe en LDAP
 	*/
    public function validarLoginLdap()
    {

        $this->layout = null;
        $result       = FALSE;
        $usuario      = $this->RbacUsuarios->validar_trigrama_ldap($this->getRequest()->getData('usuario'));
        if ($usuario['result']) {

            $result = TRUE;
        }
        $data = array('result' => $result);
        $this->set('data', $data);
        $this->render('/Element/ajaxreturn');
    }

	/**
 	* Verifica si un usuario existe en la tabla rbac_usuarios de la DB.
 	* @return boolean true si el usuario existe en la DB
 	*/
    public function validarLoginDB()
    {
        //$this->layout = null;
        $result      = FALSE;
        $rbacUsuario = $this->RbacUsuarios->findByUsuario($this->getRequest()->getData('usuario'))->toArray();

        if (count($rbacUsuario) > 0) {
            $result = TRUE;
        }
        $data = array('result' => $result);
        $this->set('data', $data);

        $this->render('/Element/ajaxreturn');
    }

	/*
 	* Funcion solo disponible en ambiente local y desarrollo
 	*/
    public function cambiarEntorno($vh)
    {

        //$config_vh =  ClassRegistry::init('Rbac.VH');
        $config_vh = TableRegistry::get('Rbac.RbacVh');

        switch ($vh) {
            case 'solo_lectura':
                $config_vh->vh_default = 'solo_lectura';
                break;
            case 'carga_publica':
                $config_vh->vh_default = 'carga_publica';
                break;
            case 'carga_login_publica':
                $config_vh->vh_default = 'carga_login_publica';
                break;
            case 'carga_login_interna':
                $config_vh->vh_default = 'carga_login_interna';
                break;
            case 'carga_administracion':
                $config_vh->vh_default = 'carga_administracion';
                break;
        }

        $session = $this->getRequest()->getSession();
        //cambio el ambiente default al seleccionado por el usuario
        $session->write('vh_default', $config_vh->vh_default);
        $session->delete('RbacUsuario');
        $session->delete('redirect');
        //Si es ambiente de desarrollo y es solo_lectura o carga_publica redirecciono
        if (($config_vh->vh_default == 'solo_lectura') || ($config_vh->vh_default == 'carga_publica')) {
            //limpio session
			$this->loadModel('Rbac.PermisosVirtualHosts');
            switch ($config_vh->vh_default) {
                case 'solo_lectura':
                    $url = $this->PermisosVirtualHosts->findByPermiso('solo_lectura')->toArray();
                    break;
                case 'carga_publica':
                    $url = $this->PermisosVirtualHosts->findByPermiso('carga_publica')->toArray();
                    break;
                default:
                    $url = '';
                    break;
            }
            
            //voy a la home publica siempre
            $this->redirect(Configure::read('App.fullBaseUrl') . $url[0]['url']);

        } else {
            //voy a login siempre
            $this->redirect(array('action' => 'login'));
        }

        //vemos si tenemos perfil en session
        if (!is_null($session->read('PerfilDefault'))) {
            $this->redirect($this->getUrlRedirect($this->getRequest()->getSession()->read('PerfilDefault')));
        } else {
            $this->redirect(array('action' => 'login'));
        }

    }

	/*
 	* Descripcion: Dado un Perfil, devuelve la url de redireccion segun virtual host y accion de inicio
 	*/

    private function getUrlRedirect($perfilId)
    {
        if (Configure::read('debug')) {
            //obtenemos la url de la bs segun virtualhost
            $RbacVhLocalConfig   = $this->loadModel('Rbac.RbacVhLocalConfig');
            $PermisosVirtualHosts = $this->loadModel('Rbac.PermisosVirtualHosts');
            if (!empty($RbacVhLocalConfig->getVirtualHost())) {
                $b                   = $PermisosVirtualHosts->findByPermiso($RbacVhLocalConfig->getVirtualHost())->toArray();
                $baseUri             = $b[0]['url'];
            } else {
                $baseUri = Configure::read('app.fullBaseUrl');
            }
        } else {
            $baseUri = Configure::read('app.fullBaseUrl');
        }
        $RbacPerfil = $this->loadModel('Rbac.RbacPerfiles');
        $perfil     = $RbacPerfil->findById($perfilId)->toArray();
        $RbacAccion = $this->loadModel('Rbac.RbacAcciones');
        $accion     = $RbacAccion->findById($perfil[0]['accion_default_id'])->toArray();
        if (!empty($accion[0]['controller'])) {
            $pg = '';
            if (similar_text('Rbac', $accion[0]['controller']) == 4) {
                $pg = 'rbac/';
            }
        } else {
            throw new NotFoundException('Perfil inválido o Sesión expirada, consulte con el administrador');
        }
        return $baseUri . '/' . $pg . $accion[0]['controller'] . '/' . $accion[0]['action'];
    }

}
