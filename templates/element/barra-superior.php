<?php
use Cake\Core\Configure;
$session = $this->request->getSession();
$accionesPermitidas = @$session->read('permitidas');
$usuario = @$session->read('RbacUsuario');
$perfilDefault = @$session->read('PerfilDefault');
$perfilesPorUsuario = @$session->read('PerfilesPorUsuario');
?>
<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>

  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <?php //echo $this->Html->image('user2-160x160.jpg', array('class' => 'user-image', 'alt' => 'User Image')); ?>
          <i class="glyphicon glyphicon-user"></i>
          <span class="hidden-xs"><?php echo $usuario['usuario'];?></span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <?php //echo $this->Html->image('user2-160x160.jpg', array('class' => 'img-circle', 'alt' => 'User Image')); ?>
			<a href="<?php echo $this->Url->build('/'); ?>usuarios/edit/<?php echo $usuario['id'];?>">
			<span class="glyphicon glyphicon-user"></span>
            <br />
            <?php echo $usuario['nombres']." ".$usuario['apellidos'];?>
            <br />
            <small>Usuario <?php echo $usuario['usuario'];?></small>
            </a>
          </li>
          <?php if (!empty($perfilesPorUsuario)) { ?>
	          <li class="dropdown-submenu user-body">
	               <a href="#">
	                <?php foreach ($perfilesPorUsuario as $perfil) { 
	                  if ($perfilDefault == $perfil['id']) {
	                    echo 'Perfil:&nbsp;<b>'.$perfil['descripcion'].'</b>';   						           
	                  }							    
	                } ?>	
	                <?php if (count($perfilesPorUsuario)>1) { ?>      					
	                <b class="caret"></b> 					   
	              </a>
	              <ul class="dropdown-menu">
	                    <?php foreach ($perfilesPorUsuario as $perfil) {
	                      if ($perfilDefault != $perfil['id']) { ?>
	                        <li><a href="<?php echo $this->Url->build('/'); ?>rbac/rbac_usuarios/cambiarPerfil/<?php echo $perfil['id'] ?>">
	                          <?php echo '<b>' . $perfil['descripcion'] . '</b>'; ?>
	                        </a></li>
	                      <?php }
	                    } ?>
	              </ul>
	              <?php } else { ?>
	          	  </a>
	          	  <?php } ?>
	          </li>
	       <?php } ?>
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
            	<?php if (isset($accionesPermitidas['usuarios']['changePass']) && $usuario['valida_ldap'] == 0) { ?>
              		<a href="<?php echo $this->Url->build('/'); ?>usuarios/changePass/" class="btn btn-default btn-flat">Cambiar contraseña</a>
         		<?php } ?>      
            </div>
            <div class="pull-right">
              <a href="<?php echo $this->Url->build('/'); ?>rbac/rbac_usuarios/login/1" class="btn btn-default btn-flat">Salir</a>
            </div>
          </li>
        </ul>
      </li>
      <!-- Control Sidebar Toggle Button -->
      <?php if ((isset($accionesPermitidas['rbac_acciones']['index']) ||
             isset($accionesPermitidas['rbac_perfiles']['index']) ||
             isset($accionesPermitidas['rbac_usuarios']['index']) ||
          isset($accionesPermitidas['configuracion']['index']))) { ?> 
             <!-- && ($this->request->getSession()->read('virtualHost')=='carga_administracion')) { ?>-->
      <li style="background-color:#000">
        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
      </li>
      <?php } ?>
    </ul>
  </div>
</nav>
<script>
	$(function() {
		/*$('.submenu').click(function(e) {
			e.preventDefault();
			$(".dropdown-menu").attr('disabled','disabled');
			$('.submenu .dropdown-menu').toggle();
		});*/
	});
</script>