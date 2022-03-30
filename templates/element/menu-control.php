<?php
$session = $this->request->getSession();
$accionesPermitidas = @$session->read('permitidas');
?>
<aside class="control-sidebar control-sidebar-dark">
    <section class="sidebar">
       <ul class="sidebar-menu">                             
       	<li class="header">MENU SISTEMA</li>
        <?php if (isset($accionesPermitidas['rbac_acciones']['index']) && $accionesPermitidas['rbac_acciones']['index']) {?>
        <li class="treeview"><a class="menu-ajax" href="<?php echo $this->Url->build('/'); ?>rbac/rbac_acciones/index" class="menu"><i class="fa fa-list"> </i>Acciones</a></li>
        <?php }; ?>
        <?php if (isset($accionesPermitidas['configuraciones']['index']) && $accionesPermitidas['configuraciones']['index']) {?>
        <li class="treeview"><a class="menu-ajax" href="<?php echo $this->Url->build('/'); ?>rbac/configuraciones/index" class="menu"><i class="fa fa-wrench"> </i>Configuraciones</a></li>
        <?php }; ?>                
        <?php if (isset($accionesPermitidas['rbac_perfiles']['index']) && $accionesPermitidas['rbac_perfiles']['index']) {?>
        <li class="treeview"><a class="menu-ajax" href="<?php echo $this->Url->build('/'); ?>rbac/rbac_perfiles/index" class="menu"><i class="fa fa-share-alt"> </i>Perfiles</a></li>
        <?php }; ?>
        <?php if (isset($accionesPermitidas['rbac_usuarios']['index']) && $accionesPermitidas['rbac_usuarios']['index']) {?>
        <li class="treeview"><a class="menu-ajax" href="<?php echo $this->Url->build('/'); ?>rbac/rbac_usuarios/index" class="menu"><i class="fa fa-users"> </i>Usuarios</a></li>
        <?php }; ?>                
        <?php if (isset($accionesPermitidas['rbac_permisos']['index']) && $accionesPermitidas['rbac_permisos']['index']) {?>
        <li class="treeview"><a class="menu-ajax" href="<?php echo $this->Url->build('/'); ?>rbac/rbac_permisos/index" class="menu"><i class="fa fa-key"> </i>Permiso VH</a></li>
        <?php }; ?>
        </ul>
     </section>
</aside>