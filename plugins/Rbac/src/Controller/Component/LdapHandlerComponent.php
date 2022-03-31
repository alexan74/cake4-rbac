<?php
namespace Rbac\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\Exception\InternalErrorException;
use Cake\ORM\TableRegistry;

class LdapHandlerComponent extends Component implements LoginInterface{

	/**
	 * Configuracion del servidor LDAP
	 * URL server			: $this->config['hostname']
	 * DN base 				: $this->config['base']
	 * 
	 * @link /config/local_config.php
	 */
	private $config 		= NULL;	
	
	/**
	 * Acceso local al controlador que invoco a la componente. 
	 */
	private $Controller 	= NULL;
	
	
	/**
	 * Metodo de inicializacion de la componente. 
	 * Sobre-escritura del metodo del Framework Cake.
	 */
	
    public function initialize(array $config):void {
        $this->Controller = $this->_registry->getController();		
    	$this->params = $this->Controller->getRequest()->getParam('params');
    	$this->config = TableRegistry::getTableLocator()->get('Rbac.RbacLdapConfig');
    	$this->RbacVhLocalConfig = TableRegistry::getTableLocator()->get('Rbac.RbacVhLocalConfig');
    }
	
	/**
	 * El metodo verifica que el nombre de usuario(trigrama) existe y esta activo. 
	 * Si el nombre de usuario existe y esta activo, verifica que la correspondencia de la contraseña. 
	 * @param string $trigrama
	 * @param string $password
	 * @return boolean, TRUE si la autenticacion es correcta, FALSE en caso contrario.
	 */
	public function autenticacion($trigrama, $password){
        $result = false;
       
        $ldapConnection = @ldap_connect($this->config->hostname);

        if (!$ldapConnection) {throw new InternalErrorException("El servidor LDAP ". $this->config->hostname ." no responde.");}
              
        $ldapSearch = @ldap_search($ldapConnection, $this->config->base, "(&(uid=$trigrama)(accountstatus=active))",array("dn", "cn"));
        
        if (!$ldapSearch) {throw new InternalErrorException("El usuario $trigrama no existe o no está activo.");}
        
        $ldapUserInfo = @ldap_get_entries($ldapConnection, $ldapSearch);               
        
        if ($ldapUserInfo["count"] == 0) {
            throw new InternalErrorException("Error al tratar de obtener el DN del usuario $trigrama.");
        } else {
            $result = @ldap_bind($ldapConnection, $ldapUserInfo[0]["dn"], $password);            
            if($result)
            	return $this->getUsuario($trigrama);
        }
        return $result;
	}

	/**
	 * El metodo devuelve los datos del usuario registrado en el servidor LDAP. 
	 * @param string trigrama.
	 * Retorna un arreglo con el siguiente formato: 
	 * 			data[trigrama],
	 * 			data[nombres], 
	 * 			data[apellidos].
	 * Si el trigrama no existe ó no esta activo retorna NULL.
	 * 
	 * @return array
	 */
	public function getUsuario($trigrama){
        $data = NULL;
        
        $ldapConnection = ldap_connect($this->config->hostname);

        if (!$ldapConnection) {throw new InternalErrorException("El servidor LDAP ". $this->config['hostname'] ." no responde.");}

        $ldapSearch = ldap_search($ldapConnection, $this->config->base, "(&(uid=$trigrama)(accountstatus=active))",array("cn"));
        if (!$ldapSearch) {throw new InternalErrorException("El usuario $trigrama no existe o no est&aacute; activo.");}
        
        $ldapUserInfo = ldap_get_entries($ldapConnection, $ldapSearch);

        if ($ldapUserInfo["count"] == 0) {
            throw new InternalErrorException("Error al tratar de obtener el DN del usuario $trigrama.");
        } else {
        	$temp = explode(',',$ldapUserInfo[0]['cn'][0]);
        	$data = array();
        	$data['usuario'] = $trigrama;
        	$data['nombres'] = trim($temp[1]);
        	$data['apellidos'] = trim($temp[0]);
        }
        return $data;
	}
	
	public function getArea($trigrama){
		$data = NULL;
	
		$ldapConnection = ldap_connect($this->config->hostname);
	
		if (!$ldapConnection) {throw new InternalErrorException("El servidor LDAP ". $this->config->hostname ." no responde.");}
	
		$ldapSearch = ldap_search($ldapConnection, $this->config->base, "(&(uid=$trigrama)(accountstatus=active))",array("cn"));
		if (!$ldapSearch) {throw new InternalErrorException("El usuario $trigrama no existe o no est&aacute; activo.");}
	
		$ldapUserInfo = ldap_get_entries($ldapConnection, $ldapSearch);
	
		if ($ldapUserInfo["count"] == 0) {
			throw new InternalErrorException("Error al tratar de obtener el DN del usuario $trigrama.");
		} else {
			$temp = explode(',',$ldapUserInfo[0]['dn']);
			$temp2 = explode('=',$temp[1]);
			$data = array();								
			$data = strtoupper (trim($temp2[1]));			
		}
	
		return $data;
	}
	
	
	
}