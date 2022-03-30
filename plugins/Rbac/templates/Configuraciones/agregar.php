<div class="col-md-12">        
     <form class="form-horizontal" id="ConfiguracionesAddForm" name="ConfiguracionesAddForm" role="form" action="/rbac/configuraciones/agregar/" method="POST">
                                         
                <div class="form-group">
                    <label for="clave" class="col-sm-2 control-label">Clave</label>
                    <div class="col-sm-10">                        
                        <input type="text" id="clave" placeholder="Clave" class="form-control" name="clave" >
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="apellido" class="col-sm-2 control-label">Valor</label>
                    <div class="col-sm-10">                        
                        <input type="text" id="valor" placeholder="Valor" class="form-control" name="valor" >
                    </div>
                </div>
                                                    
                                              
                <div class="form-group pull-right">
                    <div class="col-sm-offset-2 col-sm-10">                                        
                        <button type="submit" class="btn btn-primary">
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
    	    
       validar_form();
        
    }              
        
    function validar_form() {

        $('#ConfiguracionesAddForm').validate({
           rules: {                              
               'clave':{
                   required: true
               },
               'valor':{
                   required: true
               }
           },
           messages: {
               'clave': {
                   correo: "La clave es obligatoria"
               },
               'valor': {
                   correo: "El valor es obligatorio"
               }
           },
           highlight: function(element) {
               $(element).closest('.control-group').removeClass('success').addClass('error');
           }
           
          
       });
    }
            
   
    
</script>