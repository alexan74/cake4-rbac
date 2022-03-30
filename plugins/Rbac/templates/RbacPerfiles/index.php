<div class="well">
    <h3 class='sub-header'>
    <span class="fa fa-share-alt fa-lg"></span>                      
    Perfiles
    <a href="/rbac/rbac_perfiles/agregar/" class="btn btn-success pull-right">        
    <span class="glyphicon glyphicon-plus-sign"></span> Agregar Perfil</a>
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
        <div id="collapseOne" class="panel-collapse collapse<?php if (!empty($descripcion)) { echo ' in'; } ?>" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">  
          	<form autocomplete="off" id="formPerfil" class="form-inline" action="/rbac/RbacPerfiles/" method="POST">
                <input type="text" id="descripcion" style="width: 300px;" name="descripcion" placeholder="Perfil" class="input-small" value="<?php echo $descripcion ?>" >
				<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Buscar</button> 
                <button type="button" class="btn btn-warning" id="btnLimpiar" ><span class="glyphicon glyphicon-trash"></span> Limpiar</button>
			</form>
          </div>
        </div>
      </div>
	</div>
	<div id="listado" class="col-md-12">   
	   <?php echo $this->element("Rbac.RbacPerfiles/listado") ?>
	</div>         
</div>

<script type="text/javascript">
var csrfToken = getCookie('csrfToken');
    
function eliminar(id){
    bootbox.confirm("Está seguro de eliminar el Perfil #"+id+"?", function(result) {
        if (result)        {
            document.location.href = "/rbac/rbac_perfiles/eliminar/"+id;
        }  
    });
}

$("#btnLimpiar").on("click",function(e){
     e.preventDefault();
    $('#formPerfil')[0].reset();  
    $("#formPerfil").trigger("submit");
})

$("#formPerfil").on("submit",function(e){
         e.preventDefault();
         $.ajax({
            type: "POST",
            url: "/rbac/rbac_perfiles/",
            dataType: 'html',
            timeout: 4000,
            data: { descripcion: $("#descripcion").val()
            },
            beforeSend: function(){
            	xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                dialog =  bootbox.dialog({
                     message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i>Por favor espere mientras se procesan los datos...</div>',
                     closeButton: false
                 });                
            },
            success:function(data) {                 
                 $("#listado").html(data);                                     
            },
            error: function (jqXHR, status, errorThrown) {
                if ( status == "error" ) { 
               		//bootbox.alert("Ocurrio un problema , verifique las conexiones ");
                	window.top.location.href = '/login/';
               	}
            },
            complete : function(xhr, status) {
                dialog.modal('hide');
            },

        });

    });

</script>