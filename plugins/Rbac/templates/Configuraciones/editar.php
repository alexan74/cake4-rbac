<div class="col-md-12">        
     <form class="form-horizontal" id="ConfiguracionesEditForm" name="ConfiguracionesAddForm" role="form" action="/rbac/configuraciones/editar/<?php echo $configuracion->id; ?>" method="POST">
                                         
                <div class="form-group">
                    <label for="clave" class="col-sm-2 control-label">Clave</label>
                    <div class="col-sm-10">                        
                        <input type="hidden" value="<?php echo $configuracion->id; ?>" name="id" >
                        <input type="text" placeholder="Clave" class="form-control" value="<?php echo $configuracion->clave; ?>" name="clave" >
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="apellido" class="col-sm-2 control-label">Valor</label>
                    <div class="col-sm-10">                        
                        <input type="text" value="<?php echo $configuracion->valor; ?>" placeholder="Valor" class="form-control" name="valor" >
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
            
       validar_form();
        
    }              
        
    function validar_form() {

        $('#ConfiguracionesEditForm').validate({
           rules: {               
               'data[Configuracion][clave]':{                  
                   required: true
               },
               'data[Configuracion][valor]':{
                   required: true
               }
           },
           messages: {
               'data[Configuracion][clave]': {
                   required: "La clave es obligatoria"
               },
               'data[Configuracion][valor]': {
                   required: "El valor es obligatorio"
               }
           },
           highlight: function(element) {
               $(element).closest('.control-group').removeClass('success').addClass('error');
           }                     
       });
    }

    function guardar(){
        if($('#ConfiguracionesEditForm').valid()){            
            $('#ConfiguracionesEditForm').submit();                           
        }        
    }
            
</script>