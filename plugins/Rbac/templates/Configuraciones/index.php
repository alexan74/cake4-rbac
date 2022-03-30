<?php
$session = $this->getRequest()->getSession();
$accionesPermitidas = @$session->read('permitidas');
$usuario_activo = @$session->read('RbacUsuario');
?>
<div class="col-md-12 well">
    <h3 class='sub-header'>
    <span class="fa fa-wrench"> </span>             
    Configuraciones
    <?php if(!empty($accionesPermitidas['configuraciones']['agregar'])) {?>
    <a title="Agregar Configuración" data-title="Agregar Configuración"  id="configuracion" href="/rbac/configuraciones/agregar/" class="btn btn-success pull-right add">        
    <span class="glyphicon glyphicon-plus-sign"></span> Agregar Configuraciónn</a>
    <?php } ?>
    </h3>
    <!--<div style="display:none;" class="alert alert-error" id="errores"></div>-->
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
			 <form autocomplete="off" id="formConfiguracion" class="form-inline" action="/rbac/configuraciones/index" method="POST">                
			  	<div style="display:none;" class="alert alert-error" id="errores"></div>
			    <input type="text" id="clave" name="clave" placeholder="Clave" class="input-small" value="<?php echo $clave;?>" >
			    <input type="text" id="valor" name="valor" placeholder="Valor" class="input-small" value="<?php echo $valor;?>" > 
      
			    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Buscar</button>
			    <button type="button" class="btn btn-warning" id="btnLimpiar" ><span class="glyphicon glyphicon-trash"></span> Limpiar</button>
			</form>
		  </div>       
      	</div>
      </div>   
	</div>        
	<div id="listado" class="col-md-12">   
	   <?php echo $this->element("Rbac.Configuraciones/listado") ?>
	</div>
	
	<!-- overlayed element -->
	<div id="dialogModalConfiguracion">
    	<!-- the external content is loaded inside this tag -->
   		<div id="contentWrapConfiguracion"></div>
	</div>
	
	
</div>  
	
<script type="text/javascript">
	$("#btnLimpiar").on("click",function(e){
	    e.preventDefault();
	    /*$('#formConfiguracion')[0].reset();  
	    $("#formConfiguracion").trigger("submit");*/
	    window.location.href = "/rbac/configuraciones/?inicio=1";
	});
	
</script>