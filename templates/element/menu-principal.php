<?php
$session = $this->request->getSession();
$usuario = @$session->read('RbacUsuario');
$perfilDefault = @$session->read('PerfilDefault');
?>
<aside class="main-sidebar">
    <section class="sidebar"> 
        <ul class="sidebar-menu">
            <li class="header">MENU PRINCIPAL</li>
            <li class="treeview">
                <a href="/admin/index">
                    <i class="fa fa-home"></i> <span>Home</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Usuarios</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-down pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo $this->Url->build('/usuarios?inicio=1'); ?>"><i class="fa fa-circle-o"></i> Consulta</a></li>
                    <li><a href="<?php echo $this->Url->build('/usuarios/agregar'); ?>"><i class="fa fa-circle-o"></i> Nuevo usuario</a></li>
                </ul>
            </li>
            <?php if(!empty($usuario) && $perfilDefault==1) { 
            	echo $this->element('menu-ejemplos');
           	} ?>
		</ul>
    </section>
</aside>
<div style="clear:both;"></div>