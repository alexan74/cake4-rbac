<h3 class="sub-header">
	<span class="glyphicon glyphicon-user"></span>		
	<small>Editar Permiso</small>
	  <a class="btn btn-default navbar-right" href="/rbac/RbacPermisos/">
		<span class="glyphicon glyphicon-arrow-left"></span>
		Volver a la lista</a>
</h3>
<div class="col-md-10">       
	<form accept-charset="utf-8" class="form-horizontal" id="EditForm" name="EditForm" role="form" action="/rbac/RbacPermisos/editar/<?php echo $this->data['PermisosVirtualHost']['id']; ?>" method="POST">            
    	<div class="form-group">
        	<label for="permiso" class="col-sm-2 control-label">Permiso</label>
            <div class="col-sm-10">                        
            	<input type="hidden" class="form-control" name="data[PermisosVirtualHost][id]" value="<?php echo $this->data['PermisosVirtualHost']['id']; ?>">
            	<input id="permiso" type="text" placeholder="Permiso" class="form-control" name="data[PermisosVirtualHost][permiso]" value="<?php echo $this->data['PermisosVirtualHost']['permiso']; ?>">
            </div>
        </div>   
        <div class="form-group">
        	<label for="url" class="col-sm-2 control-label">Url</label>
            <div class="col-sm-10">
            	<input id="url" type="text" placeholder="Url" class="form-control" name="data[PermisosVirtualHost][url]"  value="<?php echo $this->data['PermisosVirtualHost']['url']; ?>" >                        
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
	});
	
	function inicialize(){
		          											        
	    $('#EditForm').validate({
	           rules: {               
	               'data[PermisosVirtualHost][url]':{
	                   //lettersonly: true,
	                   minlength: 2,
	                   required: true
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
        if($('#EditForm').valid()){            
            $('#EditForm').submit();                           
        }        
    }
</script>