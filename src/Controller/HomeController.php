<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Event\EventInterface;

class HomeController extends AppController
{

    public function beforeFilter(EventInterface $event):void {
     	parent::beforeFilter($event);
     	$this->Auth->allow();
    	//if (!$session->check('Auth')) throw new NotFoundException('El usuario no tiene permiso para acceder a la funcionalidad requerida.');*/  
    }
    
    public function _null() {
    }
    
    public function index(){
        $this->ViewBuilder()->setLayout('public');
    }


}
