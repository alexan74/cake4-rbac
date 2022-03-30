<?php
namespace Rbac\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Mailer\Email;
//use Cake\Http\Session;
//use Cake\Network\Session;

class DiticEmailComponent extends Component{

	var $name 				= 'DiticEmail';
	
	var $config			= NULL;
/**
	 * Acceso al controlador que llama a la componente 
	 */
	var $controller 		= NULL;
	
	/**
	 * Metodo de inicializacion de la componente. 
	 * Sobre-escritura del metodo del Framework Cake.
	 */
	public function initialize(Controller $controller):void {
		$this->controller = $controller;
	}

	
	public function enviarCon($datos){
	    $email = New Email();
	    if(isset($datos['body'])){
	        $email->setHeaders(['X-Mailer' => 'DITIC - Componente de Correo Electrónico'])
	        ->setTo($datos['email'])
	        ->setSubject($datos['subject'])
	        ->setEmailFormat('text')
	        ->send($datos['body']);
	    }else{
	        $email->setHeaders(['X-Mailer' => 'DITIC - Componente de Correo Electrónico'])
	        ->setTo($datos['email'])
	        ->setSubject($datos['subject'])
	        ->setTemplate($datos['template'])
	        ->setViewVars(['url' => $datos['url'], 'aplicacion' => $datos['aplicacion']])
	        ->setEmailFormat('html')
	        ->send();
	    } 
	    if (!$email) {
	        return FALSE;
	    } else {
	        return TRUE;
	    }
	}
}