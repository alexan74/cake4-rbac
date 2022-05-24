<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Mailer\Mailer;
use Cake\Event\EventInterface;


//use Rbac\Controller\Component\Permisos;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */

	public function initialize(): void
    {
      
        parent::initialize();
        //$this->loadComponent('RequestHandler');
        $this->loadComponent('RequestHandler', [
        		'enableBeforeRedirect' => false
        ]);
        
        $this->loadComponent('Flash');
        
        $this->loadComponent('Auth', [
        		'authorize' => 'Controller',
        		'loginAction' => [
        				'prefix' => false,
        				'plugin' => 'Rbac',
        				'controller' => 'RbacUsuarios',
        				'action' => 'login'
        		],
        		'loginRedirect' => [
        				'plugin' => '',
        				'controller' => 'Usuarios',
        				'action' => 'index'
        		],
        		'logoutRedirect' => [
        				'plugin' => 'Rbac',
        				'controller' => 'RbacUsuarios',
        				'action' => 'login'
        		],
                'EjemplosAction' => [
                    'plugin' => '',
                    'controller' => 'ejemplos'
                ],
        		'unauthorizedRedirect' => $this->referer()
        ]);
        
    	
    	$this->Auth->autoRedirect = false; // Set to false in order to save last_login time
    	$this->Auth->setConfig('authError', false);
    	$this->Auth->allow(['login', 'logout','recuperar','recuperarPass']);
    }
    
    public function beforeRender(EventInterface $event) {
 		parent::beforeRender($event);
		$this->viewBuilder()->setTheme('AdminLTE');
		//$this->viewBuilder()->setClassName('AdminLTE.AdminLTE');
 	}
    
 	function beforeFilter(EventInterface $event) {
    	parent::beforeFilter($event);
    	$session = $this->request->getSession();
    	//if (!$session->check('Auth')) $session->write('redirect',$this->referer());
    	$session->write('mipopup',false);
    	$this->loadComponent('Rbac.Permisos');    	
    	$perfilDefault = $session->read('PerfilDefault');
    	$accionesPermitidasPorPerfiles = $session->read('RbacAcciones');
    	if (isset($accionesPermitidasPorPerfiles[$perfilDefault])) {
    		$accionesPermitidas = $accionesPermitidasPorPerfiles[$perfilDefault];
    	} else {
    		$accionesPermitidas = NULL;
    	}
    	$session->write('permitidas',$accionesPermitidas);    	
    	//Borrar filtro de busqueda al cargar  ej.  ./controlador/?inicio=1
    	$inicio = $this->getRequest()->getQuery('inicio');
    	if (isset($inicio) && $inicio == 1) {
    		$session->delete("#".strtolower($this->request->getParam('controller')));
    		$session->delete("activo");
    		$this->redirect(array('action'=>'index'));
    	}    	
    	//---  Volver a la paginacion actual----
    	$accion = $this->getRequest()->getQuery('inicio');
    	if (isset($accion) && $accion=='index') {
    	    $session->delete('pag_'.strtolower($this->request->getParam('controller')));
    	    $passed = $this->request->getParam('pass');
    	    if (isset($passed['page'])) {
    	        $pagina = $passed['page'];
    	        $session->write('pag_'.strtolower($this->request->getParam('controller')),$pagina);
    	    } elseif (!empty($this->request->getQuery('page'))) {
    	        $pagina = $this->request->getQuery('page');
    	        $session->write('pag_'.strtolower($this->request->getParam('controller')),$pagina);
    	    } else {
    	        $session->write('pag_'.strtolower($this->request->getParam('controller')),1);
    	    }
    	}
    	 
    }
    
    public function isAuthorized($user) {
        if(isset($user['usuario']))
            return true;
            else
                return false;
    }
    
    public function generateToken($length = 24)
    {
        if (function_exists('openssl_random_pseudo_bytes')) {
            $token = base64_encode(openssl_random_pseudo_bytes($length, $strong));
            if ($strong == TRUE) {
                return strtr(substr($token, 0, $length), '+/=', '-_,');
            }
            
        }
        
        //php < 5.3 or no openssl
        $characters = '0123456789';
        $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz+';
        $charactersLength = strlen($characters) - 1;
        $token            = '';
        
        //select some random characters
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[mt_rand(0, $charactersLength)];
        }
        
        return $token;
    }
    
    public function _sendEmail($datos)
    {
        $mailer = new Mailer();
        
        $mailer->setEmailFormat('html')
        ->setTo($datos['email'])
        ->setSubject($datos['subject'])
        ->setViewVars(['url' => $datos['url']])
        ->viewBuilder()->setTemplate($datos['template']);
        
        $mailer->deliver();
        
        if (!$mailer) {
            return FALSE;
        } else {
            return TRUE;
        }
        
    }
    
}
