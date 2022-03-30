<?php //$this->extend('Rbac.public'); use Cake\Core\Configure;
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title><?php echo Configure::read('Tema.titulo'); ?></title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('jquery-ui');
        echo $this->Html->css('public');

        echo $this->Html->script('jquery.min');
	    echo $this->Html->script('jquery.form');
	    echo $this->Html->script('jquery.easing.1.3');
	    echo $this->Html->script('jquery-ui');
	    echo $this->Html->script('jquery.validate.min');
        echo $this->Html->script('bootbox.min');
        echo $this->Html->script('bootstrap.min');
        
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');

        $vh_default = $this->getRequest()->getSession()->read('vh_default');
        $vhAll = unserialize($this->getRequest()->getSession()->read('vh'));
        ?>
       
    </head>
    <body>

        <div id="content">
            <?php echo $this->Flash->render(); ?>
            <?php echo $this->fetch('content'); ?>	
        </div>

        <?php 
        /*if (Configure::read('debug') == 2) {
	        	echo $this->element('Rbac.entorno'); 
	    }*/
	    ?>
    </body>
</html>