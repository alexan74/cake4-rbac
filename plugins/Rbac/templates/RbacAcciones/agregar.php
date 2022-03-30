<div class='container well' >
	<h3 class="sub-header">
	<span class="glyphicon glyphicon-th-list"></span>
	<small>Nueva Acción </small>
	 <a class="btn btn-default navbar-right" href="/rbac/RbacAcciones/">
		<span class="glyphicon glyphicon-arrow-left"></span>
		&nbsp;Volver a la lista</a>
		
	</h3>
    <div class="col-md-10">
        <fieldset>
            <form class="form-horizontal" id="RbacAccionesAddForm" name="RbacAccionesAddForm" role="form" action="/rbac/RbacAcciones/agregar/" method="POST">
                <div class="form-group">            
                    <label for="controlador" class="col-sm-2 control-label">Controlador</label>                
                    <div class="col-sm-10">                        
                        <input type="text" required="required" id="RbacAccionController" placeholder="Ingrese el nombre del controlador" class="form-control" name="data[RbacAccion][controller]">
                    </div>
                </div>
                <div class="form-group">            
                    <label for="accion" class="col-sm-2 control-label">Acción</label>                
                    <div class="col-sm-10">                        
                        <input type="text" required="required" id="RbacAccionAction" placeholder="Ingrese el nombre de la acción" class="form-control" name="data[RbacAccion][action]">
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
        </fieldset>
    </div>
</div>