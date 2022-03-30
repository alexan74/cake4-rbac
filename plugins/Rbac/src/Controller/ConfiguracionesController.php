<?php
namespace Rbac\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Exception\InternalErrorException;
use Cake\Http\Exception\MethodNotAllowedException;

class ConfiguracionesController extends AppController
{
   
    public function beforeFilter(EventInterface $event) { 
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
                $this->viewBuilder()->setLayout('admin');
            } else {
                $this->viewBuilder()->setLayout('Rbac.login');
            }
        }
    }

    public function index()
    {
        $limit = 10;
        $this->paginate = array('limit' => $limit);
        //$this->set('configuraciones', $this->paginate('Configuraciones'));
        /*$this->set('clave', null);
        $this->set('valor', null);*/
        if ($this->getRequest()->is('post') || $this->getRequest()->getSession()->check("#".strtolower($this->getRequest()->getParam('controller')))) {
            $misesion = $this->getRequest()->getSession()->read("#".strtolower($this->getRequest()->getParam('controller')));
            if (empty($this->getRequest()->getData()) && isset($misesion))
                $data = $misesion;
            else
                $data = $this->getRequest()->getData();
            
            $result = $this->Configuraciones->find()->where(['clave like' => '%' . $data['clave'] . '%',
                                                            'valor like' => '%' . $data['valor'] . '%']);
                
            //$this->set('configuraciones', $this->paginate($result));
            //$this->set('clave', $data['clave']);
            //$this->set('valor',  $data['valor']);        
        }
        $this->set('configuraciones', $this->paginate(@$result));
        $this->set('clave', @$data['clave']);
        $this->set('valor', @$data['valor']);
    }

    public function agregar()
    {

        if ($this->getRequest()->is('post')) {
            $configuracion = $this->Configuraciones->newEntity($this->getRequest()->getData());
            //$configuracion = $this->Configuraciones->patchEntity($configuracion, $this->getRequest()->getData());
            if ($this->Configuraciones->save($configuracion)) {
                $this->Flash->success('Se ha creado exitosamente', 'flash_custom');
                //return $this->redirect(['plugin' => 'rbac', 'controller' => 'configuraciones', 'action' => 'index']);
                return $this->redirect($this->referer());
            } else {
                $this->Flash->error('Error, no se pudo agregar');
            }
        }
    }

    public function editar($id = null)
    {

        if (!$id) {
            $this->Flash->error('Accion inválida');
            $this->redirect(array('action' => 'index'));
        }

        $configuracion = $this->Configuraciones->findById($id)->firstOrFail();

        
        if (!$configuracion) {
            $this->Flash->error('Accion inválida');
            $this->redirect(array('action' => 'index'));
        } elseif ($configuracion->clave == 'encuesta principal') {
            $this->loadModel('Encuestas');
            $encuestas = $this->Encuestas->find()->order(['titulo'=>'ASC']);
            $this->set(compact('encuestas'));
        }

        if ($this->getRequest()->is('post', 'put')) {

            $configuracion = $this->Configuraciones->patchEntity($configuracion, $this->getRequest()->getData());

            if ($this->Configuraciones->save($configuracion)) {
                $this->Flash->success('Se ha actualizado exitosamente.');
                //return $this->redirect(array('action' => 'index'));
                //return $this->redirect(['plugin' => 'rbac', 'controller' => 'configuraciones', 'action' => 'index']);
                return $this->redirect($this->referer());
            } else {
                $this->Flash->error('No se puede actualizar');
            }
        }

        if (!$this->getRequest()->getData()) {

            $this->set('configuracion', $configuracion);
        }

    }

    public function eliminar($id)
    {

        if ($this->getRequest()->is('post')) {
            throw new MethodNotAllowedException();
        }

        $configuracion = $this->Configuraciones->get($id);

        if ($this->Configuraciones->delete($configuracion)) {
            $this->Flash->success('La configuración ha sido eliminado correctamente.', 'flash_custom');
            $this->redirect(array('action' => 'index'));
        }

    }

}
