<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Mailer\Mailer;

class AdminController extends AppController {
	
	public $name = 'Admin';

    /*public $uses = array('Rbac.RbacUsuario', 'Rbac.Configuracion', 'Rbac.RbacToken', 'Rbac.PermisosVirtualHost',
    		             'Rbac.RbacVhLocalConfig','UsuarioDivisionPolitica','DivisionPolitica');*/
    		            
    //public $components = array('Rbac.LdapHandler', 'Rbac.DbHandler', 'Email');
    
	/*public $helpers = [
			'Paginator' => ['templates' => 'paginator-templates'],
	];*/
    
    public function _null() {
    }

	
    public function beforeFilter(EventInterface  $event)
    {
        parent::beforeFilter($event);
        $session = $this->request->getSession();
        if (!$session->check('Auth')) {
            $session->write('redirect',$this->getRequest()->getUri('path'));
            $this->Flash->error('Su sesión ha caducado! Vuelva a iniciar sesión');
        }
    }
	
    
    public function beforeRender(EventInterface  $event) {
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
    }

    /**
     * Muestra el listado de usuario existentes
     */
    public function index() {
        /*$Mailer = new Mailer();
        
        $Mailer->setEmailFormat('html')
        ->setTo('alexan_kid@hotmail.com')
        ->setSubject('prueba')
        ->viewBuilder()
        ->setTemplate('prueba', 'default');
        
        $Mailer->deliver();*/
    }
    
}