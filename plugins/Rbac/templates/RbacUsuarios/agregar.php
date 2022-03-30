<div class="col-md-12">        
 	<form class="form-horizontal" id="RbacUsuariosAddForm" name="RbacUsuariosAddForm" role="form" action="/rbac/rbac_usuarios/agregar/" method="POST">
        <div class="form-group form-inline ldap">
            <label for="valida_ldap" class="col-sm-3 control-label">¿Valida LDAP?</label>
            <div class="col-sm-9">                                            
                <div class="radio">
                    <label>
                      <input type="radio" name="valida_ldap" id="optionsRadios" onclick="validaLdap(true)" value="1" checked>
                      Si
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="valida_ldap" id="optionsRadios"  onclick="validaLdap(false)" value="0">
                      No
                    </label>
                </div>
            </div>                            
        </div>
        <div class="form-group">
            <label for="usuario" class="col-sm-3 control-label">Usuario</label>
            <div class="col-sm-9">                        
                <input type="text" autocomplete="off" id="RbacUsuarioUsuario" placeholder="Ingrese el usuario" class="form-control" name="usuario">
            </div>
        </div>
        <div id="contrasenia-group">
            <div class="form-group">
                <label for="a" class="col-sm-3 control-label">Contraseña</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" name="password" id="contrasenia" placeholder="Contraseña" >                        
                </div>
            </div>                
            <div class="form-group">
                <label for="a" class="col-sm-3 control-label">Reingrese Contraseña</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" name="contrasenia2" id="contrasenia2" placeholder="Reingrese Contraseña" >                        
                </div>
            </div>  
        </div>
        <div class="form-group">
            <label for="nombre" class="col-sm-3 control-label">Nombre</label>
            <div class="col-sm-9">                        
                <input type="text" id="RbacUsuarioNombre" placeholder="Nombre" class="form-control" name="nombre" >
            </div>
        </div>
        <div class="form-group">
            <label for="apellido" class="col-sm-3 control-label">Apellido</label>
            <div class="col-sm-9">                        
                <input type="text" id="RbacUsuarioApellido" placeholder="Apellido" class="form-control" name="apellido" >
            </div>
        </div>
        <div class="form-group">
            <label for="correo" class="col-sm-3 control-label">Correo</label>
            <div class="col-sm-9">                        
                <input type="text" id="correo" placeholder="Correo" class="form-control" name="correo" >
            </div>
        </div>                       
        <div class="form-group">                                        
            <label for="RbacPerfiles" class="col-sm-3 control-label">Perfil</label>
             <div class="col-sm-5">
                <select required="required" id="rbac-perfiles-ids" name="rbac_perfiles[_ids][]" class="form-control" multiple="multiple" >
                                           
                    <?php foreach ($rbacPerfiles as $id =>$perfil): ?>
                        <option value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                    <?php endforeach; ?>
                </select>
             </div>     
        </div>          
        <div class="form-group">                                                            
            <label for="RbacUsuarioPerfilDefault" class="col-sm-3 control-label">Perfil Default</label>
             <div class="col-sm-5">
                <select required="required" id="perfil-default-id" name="perfil_default_id" class="form-control">                           
                    <?php //foreach ($RbacPerfiles as $perfil): ?>
                        <!-- option value="<?php //echo $perfil['RbacPerfil']['id']; ?>"><?php //echo $perfil['RbacPerfil']['descripcion']; ?></option -->
                    <?php //endforeach; ?>
                </select>
             </div>     
        </div>                                                     
        <div class="form-group pull-right">
            <div class="col-sm-offset-2 col-sm-10">                                        
                <button type="button" class="btn btn-primary" onclick="guardar()">
                <span class="glyphicon glyphicon-check"></span>
                Guardar</button>                      
            </div>
        </div>                
   </form>        
</div>

<script type="text/javascript">
    $(function () {     	    	        
        $('#optionsRadios').change();
        <?php if ($LDAP[0]['valor']=='No') { ?>
        	$('.ldap').hide();
        <?php } else { ?>
        	$('.ldap').show();
        <?php } ?>
        inicialize();  
    });
    
    function inicialize(){          	
    	$('#rbac-perfiles-ids').multiselect({
             enableFiltering: true,             
             enableCaseInsensitiveFiltering: true,             
             filterPlaceholder: 'Buscar',
             nonSelectedText: 'Lista de Perfiles', 
             onChange: function(element, checked) {
                 if(checked){
                     //agregar en el select                     
                     $('#perfil-default-id').append('<option value="'+element.val()+'" >'+element.text()+'</option>');
                 }else{
                     //eliminar del select
                     $("#perfil-default-id").find("option[value='"+element.val()+"']").remove();                 	 
                 }    	           
    	    }
           	//buttonWidth: '571px',    
             //buttonClass: 'btn-primary'
        });
        /*$('#optionsRadios').on('change', function(){            
            if($('#optionsRadios').is(':checked')){         	
         		$('#contrasenia-group').hide();         		
         	}else{
         		$('#contrasenia-group').show();
            }     	                
     	});*/
     	$('#contrasenia-group').hide();    	
     	$.validator.addMethod('correo', function(value, element, param) {
    	    return this.optional(element) || /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/.test(value);
    	});
       	validar_form();
       	validaLdap(true);    
    }              

    function validar_form() {
        $('#RbacUsuariosAddForm').validate({
           rules: {               
               'usuario':{
                   required: true
               },
               'correo': {
					correo: true,
					required: true
               },
               'rbac_perfiles[_ids]':{
                   required: true
               },
               'perfil_default_id':{
                   required: true
               }
           },
           messages: {
           	   'usuario': {
           	   		required: "Complete usuario"
               },
               'correo': {
                   correo: "Ingrese correo valido"
               }
           },
           highlight: function(element) {
               $(element).closest('.control-group').removeClass('success').addClass('error');
           }
       });
    }
    
    function guardar(){
    	if ($("input[name='valida_ldap']:checked").val()!=1 && $('#contrasenia').val()!=$('#contrasenia2').val()) {          
			var validator = $( "#RbacUsuariosAddForm" ).validate();
            validator.showErrors({
                "contrasenia2": "Por favor reingrese la contraseña"
            });
		} else {   
	        if($('#RbacUsuariosAddForm').valid()){
	            usuario = $("#RbacUsuarioUsuario").val();
	            //validar en BD                 
                $.ajax({
                    url: '/rbac/rbac_usuarios/validarLoginDB/',
                    cache: false,
                    type: 'POST',
                    dataType: 'json',
                    data: {usuario : usuario },
                    success: function (data) {                    
                        if(data.result)
                        {                            
                            var validator = $( "#RbacUsuariosAddForm" ).validate();
                            validator.showErrors({
                                "usuario": "El usuario ya existe."
                            });
                        } else {
                            if (!$('#RbacUsuariosAddForm').submit()) {
                            	window.top.location.href = '/index/';
                            }                            
                        }
                    }
                });  
	        }
		}        
    }
    
    function validaLdap(valida)
    {
        if(valida){            
             $('#contrasenia-group').hide();
             $('#RbacUsuarioUsuario').rules('remove','correo');             
             $('#contrasenia').rules('remove');
             $('#contrasenia2').rules('remove');                             
             $('#RbacUsuarioNombre').attr('readonly', true);
             $('#RbacUsuarioApellido').attr('readonly', true);         
             autocompleteLdap(true);
        }else{
             //$('#contrasenia-group').hide();            
             //$('#RbacUsuarioUsuario').rules('add','correo');
             $('#RbacUsuarioNombre').rules('add','required');
             $('#contrasenia').rules('add','required');
             $('#contrasenia2').rules('add','required');
             $('#RbacUsuarioNombre').removeAttr('readonly');
             $('#RbacUsuarioApellido').removeAttr('readonly');
             autocompleteLdap(false);        
        }
        $('#RbacUsuarioNombre').val('');
        $('#RbacUsuarioApellido').val('');
        $('#RbacUsuarioUsuario').val('');
        $("label[for=RbacUsuarioUsuario]").removeClass('error').hide();
    }
    
    
    function autocompleteLdap(autocomplete){   

      	if(autocomplete){   
          
       		$("#RbacUsuarioUsuario").autocomplete({
                source: function (request, response) {
                     
                    $.ajax({
                        url: "/rbac/rbac_usuarios/autocompleteLdap/",
                        type: 'POST',
                        dataType: 'json',
                        data: {usuario: request.term},
                        success: function (data) {                       
                            console.log(data);
                            response($.map(data.result, function(item) {
                                return {
                                    label: item.label,                                
                                    value: item.value
                                };
                            }));
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                            alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                        }   
                    });
                },
                minLength: 1,
                select: function(event, ui) {
                	var nombreCompleto = ui.item.label.split(",")[1].trim();
                	var nombre =  nombreCompleto.split('(');
                	                	                	
                    $('#RbacUsuarioNombre').val(nombre[0]);
                    $('#RbacUsuarioApellido').val(ui.item.label.split(",")[0].trim());
                }
            }); 
      	}else {
             $('#RbacUsuarioUsuario').autocomplete("destroy");
        }              
       
	}
    
</script>