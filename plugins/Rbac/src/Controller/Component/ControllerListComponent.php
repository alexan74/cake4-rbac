<?php

namespace Rbac\Controller\Component;

use Cake\Controller\Component;


class ControllerListComponent extends Component {

    /**
     * Return an array of user Controllers and their methods.
     * The function will exclude ApplicationController methods
     * @return array
     */
	
	public function getControllers() {
		$files = scandir('../src/Controller/');
		$results = [];
		$ignoreList = [
				'.',
				'..',
				'Component',
				'AppController.php',
		];
		foreach($files as $file){
			if(!in_array($file, $ignoreList)) {
				$controller = explode('.', $file)[0];
				array_push($results, str_replace('Controller', '', $controller));
			}
		}
		return $results;
	}
	
	public function getActions($controllerName) {
		$className = 'App\\Controller\\'.$controllerName.'Controller';
		$class = new \ReflectionClass($className);

   		$actions = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
		
		$results = [$controllerName => []];
		$ignoreList = ['beforeFilter', 'afterFilter', 'initialize', 'beforeRender'];
		foreach($actions as $action){
			if($action->class == $className && !in_array($action->name, $ignoreList)){
				array_push($results[$controllerName], $action->name);
			}
		}
		return $results;
	}
	
	private function searcharray($value, $key, $array) {
	    foreach ($array as $k => $val) {
	        if ($val[$key] == $value) {
	            return $k;
	        }
	    }
	    return null;
	}
    public function get($listControlleDB) {
        $aCtrlClasses = $this->getControllers();
        $i = 0;
        $controllerAcciones = array();
        //debug($listControlleDB);
        foreach ($aCtrlClasses as $controller) {
            $this->controller = $this->_registry->getController();
            $sesion = $this->controller->getRequest()->getSession();
            //$sesion_controllers = $sesion->read('permisos');
            
            
            //if (!array_key_exists(strtolower($controller),$sesion_controllers['controller'])) {
            //if ($controller != 'AppController') {
                // Load the controller            	
                //App::import('Controller', str_replace('Controller', '', $controller));
                // Load its methods / actions
                $aMethods = $this->getActions($controller);
                //$controller = str_replace("Controller", '', $controller);
                //debug($aMethods); die;
                foreach ($aMethods as $idx => $method) {
                    if ($method == '_' && $method != '_null') {
                     unset($aMethods[$idx]);
                    }
                    /*if ($method == '_') {
                        unset($aMethods[$idx]);
                    } else {
                        foreach ($method as $key => $item) {
                            if ($item != '_null' && substr($item,0,2)=='__') {
                                unset($aMethods[$idx][$key]);
                                break(1);
                            }
                            
                        }
                    }*/
                }
                //debug($aMethods);
                // Load the ApplicationController (if there is one)
                /*App::import('Controller', 'AppController');
                $parentActions = get_class_methods('AppController');
                $controllers[$controller] = array_diff($aMethods, $parentActions);*/
                
                $controllers[$controller] = $aMethods;
                
                foreach ($controllers[$controller] as $controllerAccion) {
                    for ($n=0;$n<count($controllerAccion);$n++) {
                        if (substr($controllerAccion[$n],0,2)!='__' && !$this->existeEnDB($controller, $controllerAccion[$n], $listControlleDB)) {
                            //debug("No existio - ".$controllerAccion[$n]);
                            $controllerAcciones[$i]['id'] = '';
                            $controllerAcciones[$i]['controller'] = $controller;
                            $controllerAcciones[$i]['action'] = $controllerAccion[$n];
                            $i++;
                        }
                    }
  
                }
            //}
        }
	    //debug($controllerAcciones); die;
        return ( $controllerAcciones);
    }

    function existeEnDB($controller, $controllerAccion, $listControlleDB) {
        $existe = FALSE;
        
        foreach ($listControlleDB as $value) {
            
            if ($value['controller'] == $controller && $value['action'] == $controllerAccion) {
               $existe = TRUE;
               break;
            }
           
        }
        return $existe;
    }

}
