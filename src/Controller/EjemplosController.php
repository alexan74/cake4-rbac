<?php
namespace App\Controller;

use Cake\Event\EventInterface;

class EjemplosController extends AppController
{
    public $name = 'Ejemplos';
    
    /*public $helpers = [
        'Paginator' => ['templates' => 'paginator-templates'],
    ];*/
    
    public function _null() {
    }
    
    public function initialize():void
    {
        parent::initialize();
        $this->loadComponent('Paginator');
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
	
	function index(){
	    $limite = 5;
        $conditions = array();
		
		if ($this->getRequest()->is('post') || $this->getRequest()->getSession()->check("#".strtolower($this->getRequest()->getParam('controller'))))
		{
		    $misesion = $this->getRequest()->getSession()->read("#".strtolower($this->getRequest()->getParam('controller')));
		    if (empty($this->getRequest()->getData()) && isset($misesion))
		        $data = $misesion;
	        else
	            $data = $this->getRequest()->getData();
		    
			$conditions = $this->getConditions();
			
			$this->set('titulo', trim($data['titulo']));
			$this->set('descripcion', trim($data['descripcion']));
		}
		else
		{				
		    $this->set('titulo', null);
			$this->set('descripcion', null);		
		}
		
		$this->paginate = array('conditions'=>$conditions,'limit'=>$limite);
		$data = $this->paginate( 'Ejemplos' );
		$this->set('ejemplos',$data);
		
	}
	
	private function getConditions()
	{
		$conditions = array();
	
		if(!empty($this->getRequest()->getData('titulo')))
		{
		    $conditions[] =  array('titulo like ' => '%'.trim($this->getRequest()->getData('titulo')).'%');
		}
	
		if(!empty($this->getRequest()->getData('descripcion')))
		{
		    $conditions[] =  array('descripcion like ' => '%'.trim($this->getRequest()->getData('descripcion')).'%');
		}
		
		return $conditions;
	}
	
	public function ver($id = null)
	{
		//$this->layout = 'admin';
	    $this->getRequest()->getSession()->write('mipopup',true);
		$this->set('ejemplo', $this->Ejemplos->get($id));
	}
	
	/*public function limpiar()
	{
		$this->Session->delete('mipost');
		$this->redirect(array('action'=>'index'));
	}*/
	
}