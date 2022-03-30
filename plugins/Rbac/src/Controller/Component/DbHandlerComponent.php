<?php
namespace Rbac\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\InternalErrorException;
//use Cake\Http\Session;
//use Cake\Network\Session;

class DbHandlerComponent extends Component{
	
	private $controller 	= NULL;
	
	public function initialize(array $config):void {
		$this->controller = $this->_registry->getController();
	    $this->RbacUsuarios = TableRegistry::getTableLocator()->get('Rbac.RbacUsuarios');

		/*$this->params = $this->getRequest()->getParam();
		$this->modelo = $this->Controller->loadModel('Rbac.RbacUsuario');*/
		//$this->modelo = ClassRegistry::init('Rbac.RbacUsuario');
	}
	
	/**
	 * El metodo verifica que el nombre de usuario existe y esta activo. 
	 * Si el nombre de usuario existe y esta activo, verifica que la correspondencia de la contraseña. 
	 * @param string $usuario
	 * @param string $password
	 * @return boolean, TRUE si la autenticacion es correcta, FALSE en caso contrario.
	 */
	public function autenticacion($usuario, $password) {
	    //$RbacUsuarios = TableRegistry::getTableLocator()->get('RbacUsuarios');
	    //debug($RbacUsuarios->find()); die;
        if ($this->RbacUsuarios->autenticacion($usuario, $password)) {
        	return $this->getUsuario($usuario);            
        } else {
            return FALSE;
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
        
        $result = $this->RbacUsuarios->findByUsuario($usuario);
        $usuario = $result->toArray();

        if (count($usuario) == 0) {
            throw new InternalErrorException("El usuario ". $$usuario ." no fue encontrado .");                               
        } else {        	
        	$data = array();
        	$data['usuario'] = $usuario[0]['usuario'];
        	$data['nombres'] = $usuario[0]['nombre'];
        	$data['apellidos'] = $usuario[0]['apellido'];
        	$data['perfil_default_id'] = $usuario[0]['perfil_default_id'];
        }
        return $data;
	}
	
}
