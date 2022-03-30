<?php 
$session = $this->getRequest()->getSession();
$accionesPermitidas = ($session->check('permitidas'))?$session->read('permitidas'):null;
$usuario_activo = ($session->check('RbacUsuario'))?$session->read('RbacUsuario'):null;
?>
<div class="table-responsive">      
    <table class="table table-hover table-bordered">
        <thead>
            <tr>                        
                <th>Perfil</th>  
                <th>Permiso Virtual Host</th>  
                <th>Perfil default</th>  
                <?php if((isset($accionesPermitidas['rbac_perfiles']['editar']) && $accionesPermitidas['rbac_perfiles']['editar'])
                    || (isset($accionesPermitidas['rbac_perfiles']['eliminar']) && $accionesPermitidas['rbac_perfiles']['eliminar'])) { ?>
                <th class="text-center">Acciones</th>
                <?php } ?>                                                                      
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rbacPerfiles as $rbacPerfil): ?>
                <tr>                            
                    <td><?php echo $rbacPerfil->descripcion; ?></td>                            
                    <td><?php echo $rbacPerfil->permisos_virtual_host->permiso; ?></td>
                    <td><?php echo ($rbacPerfil->es_default == 1) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>' ; ?></td>
                    <td>
                        <div class="text-center" >
                        <?php if(isset($accionesPermitidas['rbac_perfiles']['editar']) && $accionesPermitidas['rbac_perfiles']['editar']) {?>
                            <a href="/rbac/rbac_perfiles/editar/<?php echo $rbacPerfil->id; ?>" type="button" class="editar btn btn-success btn-xs" title="Editar Perfil"><span class="glyphicon glyphicon-pencil"></span></a>
                        <?php } ?>                                        
                        <?php if(isset($accionesPermitidas['rbac_perfiles']['eliminar']) && $accionesPermitidas['rbac_perfiles']['eliminar']) {?>
                            <button onClick="eliminar(<?php echo $rbacPerfil->id; ?>)" type="button" class="btn btn-danger btn-xs" title="Eliminar"><span class="glyphicon glyphicon-remove"></span></button>
                        <?php } ?>    
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>          