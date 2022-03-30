<?php 
if(isset($user)){?>
<h2 class="sub-header"><small>
    <?php if($user['seed'] == NULL)
    	    echo "Nuevo Usuario |";
          else 
          	echo "Recuperar contraseña |";
    ?>
<?php echo $user['nombre'].' '.$user['apellido'].' ('.$user['usuario'].')';?></small></h2>
<div class="row-fluid" style="margin-top: 30px;">
    <div class="col-md-8">
        <fieldset>
            <form class="form-horizontal" id="RbacPerfilesChangePass" name="RbacPerfilesChangePass" role="form" action="/rbac/rbac_usuarios/recuperarPass/<?php echo $token;?>/" method="POST">
                <div class="form-group">
                    <label for="nombre" class="col-sm-4 control-label">Nueva contraseña</label>
                    <div class="col-sm-8">                        
                        <input type="password" name="contraseniaNueva" id="contraseniaNueva" placeholder="Nueva contraseña" class="form-control" >
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
                        <button type="button" class="btn btn-success" onclick="cambiar()">Guardar</button>
                    </div>
                </div>                
            </form>
        </fieldset>
    </div>
</div>
<?php }else{ ?>
	<h2 class="sub-header"><small>Recuperar contraseña | No se encontro el usuario solicitado</small></h2>
<?php } ?>
<script type="text/javascript">    
    $(function () {        
        inicialize();
    });
    
    function inicialize()
    {
    	$.validator.addMethod('alfanumerico', function(value, element, param) {
            var vsExprReg = /(([\d]+[A-Za-z]+)|[A-Za-z]+[\d]+$)/;
            return vsExprReg.test(value);                     	    	   
    	});
    	
        $('#RbacPerfilesChangePass').validate({
           rules: {              
               'contraseniaActual':{                   
                   required: true
               },
               'contraseniaNueva':{
                   minlength: 8,
                   maxlength: 24,
                   alfanumerico:true,
                   required: true
               },
               'contraseniaNuevaConfirm':{
                   minlength: 8,
                   maxlength: 24,
                   alfanumerico:true,
                   required: true
               }
           },
           messages: {
               'contraseniaNueva': {
                   alfanumerico: "La contraseña debe ser tener al menos un número y una letra",
                   minlength: "Por favor, ingrese al menos 8 caracteres",
               	   maxlength: "Como máximo solo puede ingresar 24 caracteres"
               },
               'contraseniaNuevaConfirm': {
                   alfanumerico: "La contraseña debe ser tener al menos un número y una letra",
                   minlength: "Por favor, ingrese al menos 8 caracteres",
                   maxlength: "Como máximo solo puede ingresar 24 caracteres"
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
        	if ($('#contraseniaNueva').val()!=$('#contraseniaNuevaConfirm').val()) {
    			var validator = $( "#RbacPerfilesChangePass" ).validate();
                validator.showErrors({
                    "contraseniaNuevaConfirm": "La contraseña ingresada no es igual"
                });
        	} else {
	            bootbox.confirm("¿Está seguro de que desea cambiar contraseña de usuario?", function(result) {
	                if (result)
	                {
	                    $('#RbacPerfilesChangePass').submit();
	                    //alert('lalala');
	                }
	           });
        	}
        }
    }
    
</script>