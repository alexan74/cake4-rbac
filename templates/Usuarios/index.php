<?php  
	$session = $this->getRequest()->getSession();
	$accionesPermitidas = @$session->read('permitidas');
?>
<span id="mensajes"></span>
<div class="well">
    <h3 class='sub-header'>
    <span class="fa fa-users fa-lg"></span>                      
    Usuarios
    <?php if(!empty($accionesPermitidas['usuarios']['agregar'])) {?>
    <a href="/usuarios/agregar/" class="btn btn-success pull-right">        
    <span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>
  	<?php } ?>   
    </h3>
    <div style="display:none;" class="alert alert-error" id="errores"></div>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="block collapsed">
              <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Búsqueda
            </a>
          </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
		    <form autocomplete="off"  class="form-horizontal" name="formCons" id="formCons" action="/usuarios/" method="POST">  
	            <div style="display: none;" class="alert alert-error" id="errores"></div>      
	            <div class="form-group">                    
	                <div class="col-sm-6 col-sm-offset-3">                        
	                    <input type="text" id="nombre" name="nombre" placeholder="Nombre" class="form-control" value="<?php echo $nombre;?>" >                
	                </div>
	            </div>                
	            <div class="form-group">                    
	                <div class="col-sm-6 col-sm-offset-3">                        
	                    <input type="text" id="apellido" name="apellido" placeholder="Apellido" class="form-control" value="<?php echo $apellido;?>" >                
	                </div>
	            </div>                
	            <div class="form-group">                    
	                <div class="col-sm-6 col-sm-offset-3">                        
	                    <input type="text" id="login" name="usuario" placeholder="Usuario" class="form-control" value="<?php echo $usuario;?>" >                
	                </div>
	            </div>
	            <div style="margin-top: 15px" class="text-center">
	                <button type="submit" class="btn btn-primary">
	                <span class="glyphicon glyphicon-search"></span>
	                Buscar</button>                    
	                <button type="button" class="btn btn-warning" onclick="limpiar()">
	                <span class="glyphicon glyphicon-trash"></span>
	                Limpiar</button>                                                                                                                                
	            </div>     
		    </form>
		  </div>
		  
		</div>
	  </div>
	</div>
         
	             
    <div class="col-md-12">    
    <?php
    if (!empty($rbacUsuarios) && count($rbacUsuarios)) {
	    $columnas =
	    array(
	       array(
	            'titulo' => '#',
	            'campo'  => 'id',
	            'oculto' => true),
	        array(
	            'titulo' => 'Nombre',
	            'campo'  => 'nombre',
	            'oculto' => false),
	        array(
	            'titulo' => 'Apellido',
	            'campo'  => 'apellido',
	            'oculto' => false),
	        array(
	            'titulo' => 'Usuario',
	            'campo'  => 'usuario',
	            'oculto' => false),
	        
	    );
	    $botones =
	    array(
	        //'ver'    =>array('/usuarios/ver/','ver', true, 'VER'),   // array(ruta, controlador, popup (true/false), titulo)
	        'editar'   => array('/usuarios/editar/','usuarios'),    //array(ruta, controlador, titulo)
	        'eliminar' => array('/usuarios/eliminar/', 'Está seguro que desea eliminar el registro','usuario','usuario'),
	        // array(ruta_eliminar, texto_eliminar, controlador, field)
	    );
	    $this->DiticHtml->tabla(array('rbac_usuarios'), $rbacUsuarios, $columnas, $botones);
	
    } else {
        echo '<div class="centro"><h4>No hay resultado que mostrar</h4></div>';
    }
	?>
	</div>
	<div class="clear"></div> 		        
</div>

<script type="text/javascript">
function limpiar(){
    document.location.href = "/usuarios/?inicio=1"; 
}
</script>