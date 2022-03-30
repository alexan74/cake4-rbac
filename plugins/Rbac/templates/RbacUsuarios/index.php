<div class="well">
	<h3 class='sub-header'>
	    <span class="fa fa-users fa-lg"></span>                      
	    Usuarios
	    <a title="Agregar Usuario" data-title="Agregar Usuario" id="rbac_usuario" href="/rbac/rbac_usuarios/agregar/" class="btn btn-success pull-right add">
	    <span class="glyphicon glyphicon-plus-sign"></span> Agregar Usuario</a> 
	</h3>
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
            <div style="display:none;" class="alert alert-error" id="errores"></div>
             <div class="col-md-12 well">
                 <form autocomplete="off" id="formRbacUsuario" class="form-inline" action="/rbac/rbac_usuarios/" method="POST">                 
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre" class="input-small" value="<?php echo $nombre;?>" >
                    <input type="text" id="apellido" name="apellido" placeholder="Apellido" class="input-small" value="<?php echo $apellido;?>" > 
                    <input type="text" id="login" name="usuario" placeholder="Usuario" class="input-small" value="<?php echo $usuario;?>" >
                            
                     <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                     <button type="button" class="btn btn-warning" id="btnLimpiar" ><span class="glyphicon glyphicon-trash"></span> Limpiar</button>
                </form>       
            </div>      
          </div>
        </div>
      </div>         
	</div>
	    
	<div id="listado" class="col-md-12">   
	   <?php echo $this->element("Rbac.RbacUsuarios/listado") ?>
	</div>
	
	<!-- overlayed element -->
	<div id="dialogModalRbacUsuario">
	     <!-- the external content is loaded inside this tag -->
	   <div id="contentWrapRbacUsuario"></div>
	</div>
</div>
<script type="text/javascript">

$("#btnLimpiar").on("click",function(e){
    e.preventDefault();
    /*$('#formRbacUsuario')[0].reset();  
    $("#formRbacUsuario").trigger("submit");*/
    window.location.href = "/rbac/rbac_usuarios/?inicio=1";
})
</script>