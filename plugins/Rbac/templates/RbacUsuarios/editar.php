<div class="col-md-12">       
    <form accept-charset="utf-8" class="form-horizontal" id="RbacUsuarioEditForm" name="RbacUsuarioEditForm" role="form" action="/rbac/RbacUsuarios/editar/<?php echo $rbacUsuario->id; ?>" method="POST">                  
         <div class="form-group">
            <label for="login" class="col-sm-3 control-label">Usuario</label>
            <div class="col-sm-9">                        
                <input type="hidden" class="form-control" name="id" value="<?php echo $rbacUsuario->id; ?>" readonly>                                               
                <input required="required" type="text" placeholder="Usuario" class="form-control" name="usuario" value="<?php echo $rbacUsuario->usuario; ?>" readonly>
                
            </div>
        </div>                                                      
        <div class="form-group">
            <label for="nombre" class="col-sm-3 control-label">Nombre</label>
            <div class="col-sm-9">                        
                <input type="text" placeholder="Nombre" class="form-control" name="nombre"  value="<?php echo $rbacUsuario->nombre; ?>" >
            </div>
        </div>                              
        <div class="form-group">
            <label for="apellido" class="col-sm-3 control-label">Apellido</label>
            <div class="col-sm-9">                        
                <input type="text" placeholder="Apellido" class="form-control" name="apellido" value="<?php echo $rbacUsuario->apellido; ?>" >
            </div>
        </div>  
        <div class="form-group">
            <label for="correo" class="col-sm-3 control-label">Correo</label>
            <div class="col-sm-9">                        
                <input type="text" id="correo" placeholder="Correo" class="form-control" name="correo" value="<?php echo $rbacUsuario->correo; ?>">
            </div>
        </div> 
        <?php //echo $this->Form->control('rbac_perfiles._ids', ['options' => $RbacPerfiles]); ?>             
        <div class="form-group">                                        
            <input type="hidden" id="rbac-perfil-ids" value="" name="RbacPerfil[_ids][]">
            <label for="rbac-perfiles-ids" class="col-sm-3 control-label">Perfil</label>                                
             <div class="col-sm-5">                                        
                <select required="required" id="rbac-perfiles-ids" name="rbac_perfiles[_ids][]" class="form-control" multiple="multiple" >
                 <?php foreach ($rbacPerfiles as $id => $perfil): ?>                            
                    <?php if(in_array($id, $rbacPerfilesIds)){?>                            
                        <option value="<?php echo $id; ?>" selected="selected"><?php echo $perfil; ?></option>
                    <?php }else{ ?>
                        <option value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                    <?php } ?>
                <?php endforeach; ?>
                </select>      
             </div>     
        </div> 
        <div class="form-group">                                                            
            <label for="RbacUsuarioPerfilDefault" class="col-sm-3 control-label">Perfil Default</label>
             <div class="col-sm-5">
                <select required="required" id="RbacUsuarioPerfilDefault" name="perfil_default_id" class="form-control">   
                <?php //$perfilDefault =   $this->request->getSession->read('PerfilDefault');?>                       
                    <?php foreach ($rbacPerfiles as $id=>$perfil): ?>
                      <?php if(in_array($id, $rbacPerfilesIds)){?>
                      <?php if($rbacUsuario['perfil_default_id']!=$id){?>
                        <option value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                        <?php }else{ ?>
                        <option selected="selected" value="<?php echo $id; ?>"><?php echo $perfil; ?></option>
                        <?php } ?>
                        <?php } ?>
                    <?php endforeach; ?>                                                      
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
        inicialize();
        //$('#optionsRadios').change();       
    });
    
    function inicialize(){
                                
        //$("#RbacPerfiles option").each(function() {           
            //if($(this).attr('selected')== 'selected')
               //$('#RbacUsuarioPerfilDefault').append('<option value="'+$(this).val()+'" >'+$(this).text()+'</option>');
            //else          
               //$("#RbacUsuarioPerfilDefault").find("option[value='"+$(this).val()+"']").remove();                                     
        //});
        
        $('#rbac-perfiles-ids').multiselect({
             enableFiltering: true,          
             enableCaseInsensitiveFiltering: true,
             filterPlaceholder: 'Buscar',
             onChange: function(element, checked) {
                 if(checked){
                     //agregar en el select                     
                     $('#RbacUsuarioPerfilDefault').append('<option value="'+element.val()+'" >'+element.text()+'</option>');
                 }else{
                     $("#RbacUsuarioPerfilDefault").find("option[value='"+element.val()+"']").remove();                                                                                 
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
        $('#RbacUsuarioEditForm').validate({
               rules: {               
                   'data[RbacUsuario][usuario]':{
                       //lettersonly: true,
                       minlength: 3,
                       maxlength: 45,
                       required: true
                   },
                   'correo':{
                       correo: true,
                       required: true,
                   },
                   'data[RbacPerfil]':{
                       required: true
                   }
               },
               messages: {
                   'correo': {
                       correo: "Ingrese correo valido"
                   }
               },
               highlight: function(element) {
                   $(element).closest('.control-group').removeClass('success').addClass('error');
               }
               /*,
               success: function(element) {
                   element
                   .text('OK!').addClass('valid')
                   .closest('.control-group').removeClass('error').addClass('success');
               }*/
          });       
                          
    }              

    function guardar(){
        if($('#RbacUsuarioEditForm').valid()){            
            $('#RbacUsuarioEditForm').submit();                           
        }        
    }
</script>