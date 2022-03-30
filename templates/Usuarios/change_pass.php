<?php
$session = $this->getRequest()->getSession();
$accionesPermitidas = @$session->read('permitidas');
?>
<div class="well">
	<h3 class="sub-header">
		<span class="glyphicon glyphicon-wrench"></span>
		Cambio contraseña
		<?php if (isset($accionesPermitidas['rbac_usuarios']['index']) && $accionesPermitidas['rbac_usuarios']['index']) { ?>
		<a class="btn btn-success pull-right" href="/usuarios/">
			<span class="glyphicon glyphicon-arrow-left"></span>
			Ir a Usuarios
		</a>
		<?php } ?>
	</h3>
    <div class="col-sm-8 col-sm-offset-2">
    	<div class="box box-primary">
    	<div class="box-header with-border">
          <h3 class="box-title"><b>Usuario: </b><?php echo $user[0]['apellido'].', '.$user[0]['nombre'] .' ('.$user[0]['usuario'].')';?></h3>
        </div>
	        <fieldset>
	            <form class="form-horizontal" id="RbacPerfilesChangePass" name="RbacPerfilesChangePass" role="form" action="/usuarios/changePass/" method="POST">
	                <div class="form-group" id="contrasenia-group">
	                    <label for="a" class="col-sm-4 control-label">Ingrese contraseña actual</label>
	                    <div class="col-sm-8">
	                        <input type="password" class="form-control" name="contraseniaActual" id="contraseniaActual" placeholder="Ingrese contraseña actual">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="nombre" class="col-sm-4 control-label">Nueva contraseña</label>
	                    <div class="col-sm-8">                        
	                        <input type="password" name="contraseniaNueva" id="contraseniaNueva" placeholder="Nueva contraseña" class="form-control">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="apellido" class="col-sm-4 control-label">Repita nueva contraseña</label>
	                    <div class="col-sm-8">
	                        <input type="password" name="contraseniaNuevaConfirm" id="contraseniaNuevaConfirm" placeholder="Repita nueva contraseña" class="form-control" >
	                    </div>
	                </div>
	                <div class="form-group">
	                    <div class="col-sm-offset-4 col-sm-10">
	                        <button type="button" class="btn btn-primary" onclick="cambiar()">Guardar</button>
	                    </div>
	                </div>                
	            </form>
	        </fieldset>
		</div>
    </div>
    <div style="clear:both;"></div>
</div>
<script type="text/javascript">    
    $(function () {        
        inicialize();
    });
    
    function inicialize()
    {
        $('#RbacPerfilesChangePass').validate({
           rules: {              
               'contraseniaActual':{                   
                   required: true
               },
               'contraseniaNueva':{
                   required: true
               },
               'contraseniaNuevaConfirm':{
                   required: true
               }
           },
           highlight: function(element) {
               $(element).closest('.control-group').removeClass('success').addClass('error');
           },
           success: function(element) {
               element
               .text('OK!').addClass('valid')
               .closest('.control-group').removeClass('error').addClass('success');
           }
       });        
    }
    
    function cambiar()
    {
        if($('#RbacPerfilesChangePass').valid())
        {
        	<?php if ($user[0]['password']) { ?>
            bootbox.confirm("¿Está seguro de que desea cambiar contraseña de usuario?", function(result) {
                if (result)
                {
                    $('#RbacPerfilesChangePass').submit();
                    //alert('lalala');
                }
           });
           <?php } else { ?>
           		$('#RbacPerfilesChangePass').submit();
           <?php } ?> 
        }
    }
    
</script>