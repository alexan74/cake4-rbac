<div class="col-md-12 well">
    <h3 class='sub-header'>
    <span class="fa fa-users fa-lg"></span>                      
    Acciones
	<button type="button" class="btn btn-success pull-right" onclick="sincronizar()">
    	<span class="glyphicon glyphicon-refresh"></span> Sincronizar
    </button>
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
        		<form autocomplete="off" class="form-horizontal" name="formCons" id="formCons" action="/rbac/rbac_acciones/index" method="POST">
	                <div class="form-group">
	                    <div class="col-sm-12 ">                        
	                        <input type="text" id="controller" name="controller" class="form-control" placeholder="Controlador" value="<?php echo $controller;?>" >
	                    </div>
	                </div>
	                <div class="form-group">
	                    <div class="col-sm-12 ">                        
	                        <input type="text" id="action" name="action" class="form-control" placeholder="Acción" value="<?php echo $action;?>" >
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
        <div class="table-responsive">
            <table class="table table-hover table-bordered tree">
                <thead>
                    <tr> 
                        <th>Controlador<?php //echo $this->Paginator->sort('RbacAccion.controller','Controlador', array('Model'=>'Rbac,RbacAccion'));?></th>
                        <th>Acción<?php //echo $this->Paginator->sort('RbacAccion.action','Acción', array('Model'=>'Rbac.RbacAccion'));?></th>
                        <th data-placement="top" title="Solo lee datos o consulta sin ABM" >Sólo Lectura</th>                                                               
                        <th data-placement="top" title="Permite envio de datos de la interfaz pública (consultas o envió de datos)" >Carga Pública</th>                         
                        <th data-placement="top" title="Para sitios web con carga para usuarios registrados y las operaciones EXCLUSIVAS de los usuarios.">Carga Login Pública</th>                         
                        <th data-placement="top" title="Para sitios web con carga para usuarios registraods y operaciones de administracion del sitio. Ej. Contenidos y Administracion de Usuarios">Carga Login Interna</th>
                        <th data-placement="top" title="Solo para uso de Super Usuarios. Para administracion interna, instalacion y actualizacion de modulos, etc.">Carga Administración</th>
                        <th data-placement="top" title="Heredado">Heredado</th>
                        <th>Opción</th>
                        
                        <!-- th class="text-center">Acciones</th -->
                    </tr>
                </thead>
                <tbody >
                    <?php 
                    $i=1;
                    $num = 0;
                    $aux = '';
                    $controlador='';
                   
                    foreach ($rbacAcciones as $rbacAccion): ?>
                    	<?php if (similar_text($rbacAccion['controller'],'Rbac')!=4) { ?>
                        	<?php if ($rbacAccion['action'] == '_null') $aux = $rbacAccion['controller']; ?>                 
                            <tr id="headerTable" 
                            	<?php if ($aux == $rbacAccion['controller'] && $rbacAccion['action'] == '_null') {
                            		echo 'class="treegrid-'.$i.'"';
                            		$controlador = $rbacAccion['controller'];
                            		$i++;
                            	} elseif ($aux == $rbacAccion['controller']) { 
    								echo 'class="treegrid-parent-'.($i-1).'"';
    								$controlador='';
    							} else {
    								$controlador = $rbacAccion['controller'];
    							}?>>    
                                <td><?php echo $controlador; ?></td>
                                <td><?php echo ($rbacAccion['action']!='_null')?$rbacAccion['action']:''; ?></td>                            
                                <td class="<?php echo $num; ?>">
                                	<input id="solo_lectura" type="checkbox" name="data[<?=$i-1?>][solo_lectura]" value="1"
                               			parentid="<?php echo ($i-1);?>" dataid="<?php echo $rbacAccion['RbacAccion']['id']; ?>"
                               			<?php echo ($rbacAccion['solo_lectura'] == 1)? ' checked' : ''; ?>
                                		<?php echo ($rbacAccion['heredado'])?' disabled':''; ?>
                                	>
                                </td>
                                <td class="<?php echo $num; ?>">
                                	<input id="carga_publica" type="checkbox" name="data[<?=$i-1?>][carga_publica]" value="1"
                                		parentid="<?php echo ($i-1);?>" dataid="<?php echo $rbacAccion['id']; ?>"
                               			<?php echo ($rbacAccion['carga_publica'] == 1)? ' checked' : ''; ?>
                                		<?php echo ($rbacAccion['heredado'])?' disabled':''; ?>
                                	>
                                </td>
                                <td class="<?php echo $num; ?>">
    								<input id="carga_login_publica" type="checkbox" name="data[<?=$i-1?>][carga_login_publica]" value="1"
    									parentid="<?php echo ($i-1);?>" dataid="<?php echo $rbacAccion['id']; ?>"
                               			<?php echo ($rbacAccion['carga_login_publica'] == 1)? ' checked' : ''; ?>
                                		<?php echo ($rbacAccion['heredado'])?' disabled':''; ?>
                                	>		                            	
                                </td>
                                <td class="<?php echo $num; ?>">
                                	<input id="carga_login_interna" type="checkbox" name="data[<?=$i-1?>][carga_login_interna]" value="1"
                                		parentid="<?php echo ($i-1);?>" dataid="<?php echo $rbacAccion['id']; ?>"
                               			<?php echo ($rbacAccion['carga_login_interna'] == 1)? ' checked' : ''; ?>
                                		<?php echo ($rbacAccion['heredado'])?' disabled':''; ?>
                                	>
                                </td>
                                <td class="<?php echo $num; ?>">
                                	<input id="carga_administracion" type="checkbox" name="data[<?=$i-1?>][carga_administracion]" value="1"
                                		parentid="<?php echo ($i-1);?>" dataid="<?php echo $rbacAccion['id']; ?>"
                               			<?php echo ($rbacAccion['carga_administracion'] == 1)? ' checked' : ''; ?>
                                		<?php echo ($rbacAccion['heredado'])?' disabled':''; ?>
                                	>
                                </td>
                                <td class="<?php echo $num; ?>">
                                	<?php if ($rbacAccion['action'] != '_null') { ?>
                                	<input id="heredado" type="checkbox" name="data[<?=$i-1?>][heredado]" value="1"
                               			parentid="<?php echo ($i-1);?>" dataid="<?php echo $rbacAccion['id']; ?>"
                                		<?php echo ($rbacAccion['heredado'] == 1)? ' checked' : ''; ?>
                                	>
                                	<?php } ?>
                                </td>
                                <td>
                                	<?php //if ($aux != $rbacAccion['RbacAccion']['controller'] || $rbacAccion['RbacAccion']['action'] == '_null') { ?>
                                	<button class="btn btn-danger" onclick="eliminar(<?php echo $rbacAccion['id']; ?>,'<?php echo $rbacAccion['action'];?>');">Borrar</button>
                                	<?php //} ?>
                                </td>
                                <?php $num++; ?>
                                <!-- >td id="acciones-1595">
                                    <div class="text-center">                                    
                                        <a href="/rbac/RbacAcciones/editar/<?php //echo $rbacAccion['RbacAccion']['id']; ?>" type="button" class="btn btn-primary btn-xs" title="Editar"><span class="glyphicon glyphicon-edit"></span></a>                                    
                                        <button onClick="eliminar(<?php //echo $rbacAccion['RbacAccion']['id']; ?>)" type="button" class="btn btn-danger btn-xs" title="Eliminar"><span class="glyphicon glyphicon-remove"></span></button>
                                    </div>
                                </td  -->
                            </tr>
                        <?php } ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <!-- <div style="text-align:center; width:100%;">		        
    	        <?php
    	        /*$options = array('url'=> array('controller' => 'RbacAcciones' ) );
    			$this->Paginator->options($options);
    									
    
    	        $pager_params = $this->Paginator->params();
    	        //debug($pager_params);
    	        if($pager_params['pageCount'] > 1){
    				echo $this->Paginator->prev('<b>ANTERIOR</b>', array('escape'=> false,'class'=> 'btn btn-default'), null, array('escape'=> false,'class' => 'btn btn-default prev disabled'));
    	            echo $this->Paginator->counter(' ( {:page} / {:pages} ) ');
    	        	echo $this->Paginator->next('<b>SIGUIENTE</b>',array('escape'=> false,'class'=> 'btn btn-default'), null, array('escape'=> false,'class' => 'btn btn-default next disabled'));
    	        }*/
    	        ?>  		        
    	    </div>-->
        </div>
	</div>
</div>
<div class="modal fade" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			   	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><br />								      
				<h4 class="modal-title">Sincronización</h4>
			</div>
			<div class="modal-body">
				<div id="datos">
					<div class="col-md-12">
				                 
				        <div class="table-sincronizar">
				            <table class="table table-hover tree">
				                <thead>
				                    <tr> 
				                        <th>Controlador</th>
				                        <th>Accion</th>
				                        <th id="marcar"><a href="#" id="valores[]" style="text-decoration:underline;">RBAC</a></th>
				                    </tr>
				                </thead>
				                <tbody >
				                    <?php
				                    //debug($rbacNuevos);
				                    if (isset($rbacNuevos) && count($rbacNuevos)) { 
					                    foreach ($rbacNuevos as $rbac): 
					                    	if (isset($rbac['action']) && !empty($rbac['action'])) {
					                    		//foreach ($rbac['action'] as $accion):
					                    		?>
							                        <tr id="headerTable2">
							                            <td><?php echo $rbac['controller']; ?></td>	
							                            <?php //debug($rbac['action']);?>	                          
							                            <td><?php echo ($rbac['action']=='_null')?'NULO':$rbac['action']; //echo ($accion=='_null')?'NULO':$accion; ?></td>
							                            <td>
							                            	<!-- <input class="switch2" data-on-color="success" data-on-text="SI" data-off-text="NO" data-off-color="danger" data-action="<?php //echo $rbac['action']; ?>" data-controller="<?php //echo $rbac['controller']; ?>" type="checkbox">-->
							                            	<input class="checkbox" name="valores[]" type="checkbox" data-action="<?php echo $rbac['action']; ?>" data-controller="<?php echo $rbac['controller']; ?>" value="1" />
							                            </td>
							                        </tr>
						                    	<?php //endforeach;
						                    } 
						            	endforeach;
					                } else { ?>
										<tr><td colspan="3"><h3 style="text-align:center;">No hay nuevas acciones...</h3></td></tr>
									<?php } ?>
				                </tbody>
				            </table>
				        </div>
				    </div>
				    <?php if (isset($rbacNuevos) && count($rbacNuevos)) { ?>
				    <div class="col-md-12" style="text-align:left;">
				    	<button onClick="guardar()" type="button" class="btn btn-primary" title="Guardar"><span class="glyphicon glyphicon-check"> </span>Guardar</button>
				    </div>
				    <?php } ?>
				    <div style="clear:both;"></div>
				</div>
			</div>
			<div class="modal-footer" style="clear:both;">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	      	</div>
	    </div>
	</div>
</div>
<?php	
    //echo $this->Html->css('bootstrap-switch.min.css');
    //echo $this->Html->script('bootstrap-switch.min.js');
?>


<script type="text/javascript">
$(function() {

    $('.tree').treegrid({'initialState':'collapsed'});
    //$('#headerTable input[type="checkbox"]').checkbox();
    
    //$('#headerTable .switch').bootstrapSwitch();
    //desactivar_filas();
    
    $('#marcar a').click(function() {
    	var row = $(this).attr('id');
        $('input[name="'+row+'"]').each(function(){
            if(this.checked){
            	this.checked = false;
            }else{
            	this.checked = true;
            }
        })
   });
});

function desactivar_filas() {
	$('input#heredado').each(function() {
		var myFila = $(this).closest('td').attr('class');
		var myOpcion = ($(this).is(":checked"));
		$('td.'+myFila+' input').each(function() {
			if ($(this).attr('id') != 'heredado') {
				//$(this).checkbox({enabled: myOpcion});
				if (myOpcion) $(this).attr("disabled", false);
			}			
		});
	});
}

function desactivar_filas_here(mifila, opcion) {
	$('td.'+mifila+' input').each(function() {
		if ($(this).attr('id') != 'heredado') {	
			$(this).attr('disabled', opcion );
			/*if (opcion) {
				$(this).checkbox({enabled: false});
			} else {
				$(this).checkbox({enabled: true});	
			}*/
		}			
	});
	
}

$('#headerTable input[type="checkbox"]').click(function() {
	var valor = $(this).is(":checked");
	var accion_id = $(this).attr('dataid');
	var atributo_id = $(this).attr('id');
	var pariente = $(this).attr('parentid');
	var miFila = $(this).closest('td').attr('class');
	actualizar(accion_id,atributo_id,(valor)?1:0);
    //if (atributo_id != 'oculto') {
		if (atributo_id == 'heredado' && valor===true) {
			$('tr.treegrid-parent-'+pariente+' td.'+miFila+' input').each(function() {
				var myId = $(this).attr('id');
				if (myId != undefined && myId != 'heredado') {
					var myAccion = $(this).attr('dataid');
					var myValor = $('tr.treegrid-'+pariente+' td input#'+myId).is(":checked");
					var myId = $(this).attr('id');
					$(this).attr("checked",(myValor)?0:1);
					//$(this).checkbox({checked: (myValor)?1:0});
					actualizar(myAccion,myId,(myValor)?0:1);
					desactivar_filas_here(miFila,true);					
				}
			});
			//console.log('1');
	  	} else if (atributo_id == 'heredado' && valor===false) {
	  		desactivar_filas_here(miFila,false);
	  		//console.log('2');
	  	} else { 
	  		if ($(this).closest('tr').hasClass('treegrid-expanded')) {	
	  			$('tr.treegrid-parent-'+pariente+' td input#'+atributo_id).each(function() {
	  				var idFila = $(this).closest('td').attr('class');
	  				var myId = $(this).attr('id');
	  				if (myId != undefined && myId != 'heredado') {
		  				//alert(idFila+" - "+$('tr.treegrid-parent-'+pariente+' td.'+idFila).find('input#heredado').is(":checked"));
		  	  			if (!$('tr.treegrid-parent-'+pariente+' td.'+idFila).find('input#heredado').is(":checked")) {
			  				var myAccion = $(this).attr('dataid');
			  				$(this).attr("checked",valor);
			  				//$(this).checkbox({checked: valor});
							actualizar(myAccion,atributo_id,(valor)?1:0);
		  	  			}
	  				}
	  			});
	  			//console.log('3');
	  		} else {
	  			if (atributo_id != 'heredado') {
	  		  		var myAccion = $(this).attr('dataid');
	  				$(this).attr("checked",valor);
	  				//$(this).checkbox({checked: (valor)?1:0});
	  				actualizar(myAccion,atributo_id,(valor)?1:0);
	  			}
	  			//console.log('4');
	  		}
	  	}
    //}
});


function actualizar(accion_id,atributo_id,valor) {
	if (accion_id != null) {
		//setTimeout(function(){
    		$.ajax({        
    	        url: "/rbac/rbac_acciones/switchAccion/",
    	        type: 'POST',
    	        dataType: 'json',
    	        data: {'accion_id': accion_id, 'atributo_id': atributo_id, 'valor': valor},
    	        success: function (data) {
    	            //console.log(data);
    	        }
    		});
    	//},1000);
	}
}
    
function eliminar(id, accion){
    bootbox.confirm("Está seguro de eliminar la Acción "+accion+"?", function(result) {
        if (result)
        {
            document.location.href = "/rbac/RbacAcciones/eliminar/"+id;
        }  
    });
}

function sincronizar() {
	$("#myModal").modal("show");
	//$('#headerTable2 .switch2').bootstrapSwitch();
}

function guardar() {
	var atributo_id;
	var accion_id;
	var grabado;
	var miArray = [];
	$('#headerTable2 .checkbox:checked').each(function() {
		if (this.checked) {
			atributo_id = $(this).attr('data-controller');
			accion_id = $(this).attr('data-action');
			valor = $(this).val();
			var item = atributo_id+";"+accion_id+";"+valor;
			miArray.push(item);
		}
	});
	if (miArray) {	
		$.ajax({        
	        url: "/rbac/rbac_acciones/sincronizar/",
	        type: 'POST',
	        dataType: 'json',
	        data: {'miArray':miArray},
	        success: function (data) {
	            if (data) document.location.href = "/rbac/rbac_acciones/";
	        }
		});
	}
}

function limpiar(){   
    document.location.href = "/rbac/rbac_acciones/index";
}

</script>


