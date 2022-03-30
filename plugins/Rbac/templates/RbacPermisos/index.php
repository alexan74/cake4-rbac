<div class="well">
    <h3 class='sub-header'>
    <span class="fa fa-key"> </span>             
    Permisos VirtualHost
    <!--<a title="Agregar Permiso" href="/rbac/rbac_permisos/agregar/" class="btn btn-success pull-right">        
    <span class="glyphicon glyphicon-plus-sign"></span> Agregar Permiso</a>--> 
    </h3>
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>                        
                        <th class="text-center"><?php echo $this->Paginator->sort('PermisosVirtualHosts.permiso', 'Permiso', array('Model' => 'PermisosVirtualHosts')); ?></th>
                        <th class="text-center"><?php echo $this->Paginator->sort('PermisosVirtualHosts.url', 'URL', array('Model' => 'PermisosVirtualHosts')); ?></th>                                       
                        <th class="text-center">Captcha</th>
                        <th class="text-center">Contraseña</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rbacPermisos as $rbacPermiso): 
                    //debug ($rbacPermiso);
                    ?>
                        <tr>                                                       
                            <td><?php echo $rbacPermiso['permiso']; ?></td>
                            <td>
                            <a href="#" id="<?php echo $rbacPermiso['id']; ?>" class="url"><?php echo $rbacPermiso['url']; ?></a>                                                
                            </td>
                            <td class="text-center">
                            <?php if($rbacPermiso['permiso'] != 'solo_lectura' &&  
                            		 $rbacPermiso['permiso'] != 'carga_publica') { ?>
                              <input name="captcha" id="<?php echo $rbacPermiso['id']; ?>" type="checkbox" 
                              name="data[captcha]" <?php echo ($rbacPermiso['captcha'] == 1)? ' checked' : ''; ?>  >
                              <?php } else{ ?>
                              --
                              <?php }?>
                            </td>
                            <td class="text-center">
                              <?php if($rbacPermiso['permiso'] != 'solo_lectura' &&  
                            		 $rbacPermiso['permiso'] != 'carga_publica') { ?>
                               <input name="contrasenia" id="<?php echo $rbacPermiso['id']; ?>" type="checkbox" 
                               name="data[contrasenia]" <?php echo ($rbacPermiso['contrasenia'] == 1)? ' checked' : ''; ?> >
                               <?php }else{?>
                               --
                               <?php }?>
                            </td>                                             
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="clear:both;"></div>
        </div>
    	<div style="text-align:center; width:100%;">		        
            <?php
            $pager_params = $this->Paginator->params();
            if ($pager_params['pageCount'] > 1) {
                echo $this->Paginator->prev('<b class="boton-anterior">ANTERIOR</b>', array('escape' => false, 'class' => 'btn btn-paginador'), null, array('escape' => false, 'class' => 'btn btn-paginador prev disabled'));
                echo $this->Paginator->counter(' ( {:page} / {:pages} ) ');
                echo $this->Paginator->next('<b class="boton-siguiente">SIGUIENTE</b>', array('escape' => false, 'class' => 'btn btn-paginador'), null, array('escape' => false, 'class' => 'btn btn-paginador next disabled'));
            }
            $total = $this->Paginator->counter('Total de registros: '.$pager_params['count']);
        	echo '<div align="center" style="clear:both">' . $total . '</div>';
            ?>  		        
        </div>
	</div>
	<div class="clear"><br /></div>
</div>

<script type="text/javascript">
    $(function() {
        $('.alert-success, .alert-danger').fadeOut(3000);

        //$('input[type="checkbox"]').checkbox();
        
        $('input[type="checkbox"]').click(function() {
        	var valor = $(this).is(":checked");        	
        	var atributo_id = $(this).attr('id');  
        	var name = $(this).attr('name'); 
        	valor = (valor)?1:0;                     	   
            
            
      	    switch (name) {
				case 'captcha':
					actualizarCaptcha(atributo_id,valor);
					break;
				case 'contrasenia':
					 actualizarContrasenia(atributo_id,valor);					 
					break;	
				default:
					break;
			}
			
                    	
       });

       $('.url').editable({
        	title: 'Ingrese URL',
            type:  'text',
            emptytext: 'URL de inicio',
            pk:    
            	function() {
            	    var id =  $(this).attr('id'); 
                    return id;
                },
            name:  'url',
            url:   "/rbac/rbac_permisos/actualizarURL/",              
       });
        
    });
       

    function actualizarCaptcha(permiso_id,valor) {
            	
    		$.ajax({        
    	        url: "/rbac/rbac_permisos/actualizarCaptcha/",
    	        type: 'POST',
    	        dataType: 'json',
    	        data: {'id': permiso_id,'captcha': valor},
    	        success: function (data) {
    	            //console.log(data);
    	        }
    		});    	
    	
    }

    function actualizarContrasenia(permiso_id,valor) {
    	
    		$.ajax({        
    	        url: "/rbac/rbac_permisos/actualizarContrasenia/",
    	        type: 'POST',
    	        dataType: 'json',
    	        data: {'id': permiso_id,'contrasenia': valor},
    	        success: function (data) {
    	            //console.log(data);
    	        }
    		});    	
    }
    
</script>