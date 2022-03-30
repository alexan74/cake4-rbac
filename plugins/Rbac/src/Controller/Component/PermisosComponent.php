<?php
namespace Rbac\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Event\EventListenerInterface;
use Cake\Http\Exception\InternalErrorException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;


class PermisosComponent extends Component implements EventListenerInterface {

	var $name = 'Permisos';	

	/**
	 * Acceso local al controlador que invoco a la componente.
	*/
	private $RbacUsuario = NULL;
	private $RbacAccion = NULL;
	private $controllerPermiso = NULL;
	private $Controller = NULL;
	private $Vh = NULL;
	public $params = NULL;

		
	/*public function beforeFilter(Event $event) {
	   parent::beforeFilter($event);
		//$this->Verificar();
	}*/
	
	public function initialize(array $config):void {		

	    //$this->loadComponent('Flash');
	    TableRegistry::getTableLocator()->get('Rbac.RbacVh');
		TableRegistry::getTableLocator()->get('Rbac.RbacAcciones');

		$this->Controller = $this->_registry->getController();
		$this->Verificar();

	}
	

	public function implementedEvents():array {
		$_events = parent::implementedEvents();
		$events['Component.initialize'] = 'Verificar';
		return array_merge($_events, $events);
	}

	
	public function Verificar(){
	    
		if (session_id() === "") session_start();
		$session = $this->Controller->getRequest()->getSession();
			/*
			 * 1) Rbac toma accion, controlador y virtual host y valida.
			*/
				
			$RbacVhLocalConfig = $this->Controller->loadModel('Rbac.RbacVhLocalConfig');
			$RbacVh = $this->Controller->loadModel('Rbac.RbacVh');
			$RbacAccion = $this->Controller->loadModel('Rbac.RbacAcciones');
			
			$controlador = Inflector::camelize($this->Controller->getRequest()->getParam('controller'));
			
			$accion = $this->Controller->getRequest()->getParam('action');
			
			if (Configure::read('debug') != 1){
				$virtualHost = $RbacVhLocalConfig->getVirtualHost();
				$session->write('vh_default',$virtualHost);
			}else{
				if($controlador == 'Api' || $controlador == 'api'){
					$virtualHost = 'carga_publica';				
				}else{
					if(!$session->check('vh_default'))
					{
						$virtualHost = $RbacVh->traerVirtualHost();	
						$session->write('vh_default', $virtualHost);
						
					} else {
						$virtualHost = $session->read('vh_default');
					}
					$todosVirtualHost = $RbacVh->traerTodosVirtualHost();
					$session->write('vh', serialize($todosVirtualHost->toArray()));
				}
				
			}
						
			$isPublicAction = $RbacAccion->isPublicAction($controlador, $accion);
			
			//si es publica tanto vh o accion
			if(!$isPublicAction)
			{
				/*
				 *  2) Rbac se fija si el usuario ya esta logeado y con perfil en session
				*/
				
				//Veo si el usuario tiene session y ademas si es distinto de login				
				if (is_null($session->read('RbacUsuario')))
				{									
				    if(($accion != 'login') && ($accion != 'recuperar') && ($accion != 'recuperarPass'))
					{												
					    return $this->Controller->redirect(array('plugin' => 'rbac', 'controller' => 'rbac_usuarios', 'action' => 'login'));							
					} 
										
				} else {
				    $usuario = $session->read('RbacUsuario');
				    $perfilDefault = @$session->read('PerfilDefault');;
					$accionesPermitidasPorPerfiles = $session->read('RbacAcciones');
					if(!empty($accionesPermitidasPorPerfiles) && isset($perfilDefault))
					{
						//tomo las acciones permitidas para el perfil de usuario					    
					    if (isset($accionesPermitidasPorPerfiles[$perfilDefault])) {
    					    $accionesPermitidas = $accionesPermitidasPorPerfiles[$perfilDefault];
    						//tomo $controlador en formato especifico, la accion ya la tengo en $accion
    						//$controlador =  $Conversor->camelCaseToUnderscore($this->getRequest()->getParam('controller'));
    					    //$controlador = Inflector::underscore($this->Controller->getRequest()->getParam('controller'));
    					    $controlador = Inflector::underscore($this->Controller->getRequest()->getParam('controller'));
    						//if ($controlador == 'configuraciones') $controlador = 'configuracion';		
    					    //veo si el usuario tiene permiso para esa accion sobre en el virtual host
    						$tienePermiso = (bool) FALSE;
    						
    						if(isset($accionesPermitidas[$controlador][$accion][$virtualHost]))
    							$tienePermiso = (bool) ($accionesPermitidas[$controlador][$accion][$virtualHost] == 1);
    						
    						if (substr($accion,0,2)=='__') {
    						    $tienePermiso = (bool) TRUE;
    						}
    						
    						/*$sesion_controllers = $session->read('permisos');
    						if (array_key_exists(strtolower($controlador),$sesion_controllers['controller'])) {
    						    $tienePermiso = (bool) TRUE;
    						}*/
    						
    						if((!$tienePermiso && !$RbacAccion->isValidActionVH($controlador,$accion,$virtualHost))) { //if(!$tienePermiso && $accion != 'login'){
    						    throw new InternalErrorException('El usuario no tiene permiso para acceder a la funcionalidad requerida...');
    						    $this->Controller->redirect(array('controller' => 'rbac_usuarios', 'action' => 'login'));
    						} else {
    						    
    						}
					    } else {
					        //$this->Flash->error(__('El usuario no tiene permiso para acceder a la funcionalidad requerida'));
					        //throw new MissingActionException('El usuario no tiene permiso para acceder a la funcionalidad requerida.');
					        throw new InternalErrorException('El usuario no tiene permiso para acceder a la funcionalidad requerida.');
					        $this->Controller->redirect(array('controller' => 'rbac_usuarios', 'action' => 'login'));
					    }
					    
					} else {
						//$this->Session->delete('RbacAcciones');
					}
					
				}		
			}else{
				if($virtualHost == 'solo_lectura'){
					//$Vh = TableRegistry::get('RbacVh');
					//$this->Vh =  ClassRegistry::init('Rbac.RbacVh');
					$permiso = $RbacVh->findByPermiso($virtualHost)->toArray();
					$url = $permiso[0]['url'];
				
					if(($controlador == 'RbacUsuarios') && ($accion =='login'))
						return $this->Controller->redirect(Configure::read('App.fullBaseUrl').$url);
				
					
				}
				
			}
		/*} elseif ($this->params['action'] != 'login'){
			//throw new InternalErrorException('El usuario no tiene permiso para acceder a la funcionalidad requerida.');
			return $this->Controller->redirect(['plugin' => 'rbac', 'controller' => 'rbac_usuarios', 'action' => 'login']);
		}*/
	}	

	/**
	 * El metodo verifica que el nombre de usuario existe y esta activo.
	 * Si el nombre de usuario existe y esta activo, verifica que la correspondencia de la contraseña.
	 * @param string $usuario
	 * @param string $password
	 * @return boolean, TRUE si la autenticacion es correcta, FALSE en caso contrario.
	 */
	public function autenticacion($usuario, $password){
		

		if ($this->modelo->autenticacion($usuario, $password))
		{
			return $this->getUsuario($usuario);
		} else {
			return false;
		}
	}

	/**
	 * El metodo devuelve los datos del usuario registrado en el servidor LDAP.
	 * @param string trigrama.
	 * Retorna un arreglo con el siguiente formato:
	 * 			data[usuario],
	 * 			data[nombres],
	 * 			data[apellidos].
	 * Si el trigrama no existe ó no esta activo retorna NULL.
	 *
	 * @return array
	 */
	public function getUsuario($usuario){
		$data = NULL;
		$usuario = $this->modelo->findByUsuario($usuario);

		if (count($usuario) == 0)
		{
		    throw new InternalErrorException("El usuario " . $usuario . " no fue encontrado .");
		} else {
			$data = array();
			$data['usuario'] = $usuario['RbacUsuario']['usuario'];
			$data['nombres'] = $usuario['RbacUsuario']['nombre'];
			$data['apellidos'] = $usuario['RbacUsuario']['apellido'];
		}

		return $data;
	}
	

	/**
	 * Devuelve true si el virtual host no requiere login es decir publico para cualquiera
	 * @param string $virtualHost
	 * @return boolean
	 */
	private function isVHPublic($virtualHost){
		return (($virtualHost == 'solo_lectura') || ($virtualHost == 'carga_publica'));
	}

}