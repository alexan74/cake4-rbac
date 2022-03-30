<div class='container well'>
	<h3 class="sub-header">
	<span class="glyphicon glyphicon-th-list"></span>
	<small>Editar Acción </small>
	 <a class="btn btn-default navbar-right" href="/rbac/RbacAcciones/">
		<span class="glyphicon glyphicon-arrow-left"></span>
		&nbsp;Volver a la lista</a>		
	</h3>
    <div class="col-md-10">
        <fieldset>
            <form accept-charset="utf-8" class="form-horizontal" id="RbacAccionEditForm" name="RbacAccionEditForm" role="form" action="/rbac/RbacAcciones/editar/<?php echo $this->data['RbacAccion']['id']; ?>" method="POST">
                <input type="hidden" value="POST" name="_method">
                <div class="form-group">            
                    <label for="controlador" class="col-sm-2 control-label">Controlador</label>                
                    <div class="col-sm-10">                        
                    <input type="hidden"  name="data[RbacAccion][id]" value="<?php echo $this->data['RbacAccion']['id']; ?>" >
                        <input type="text" required="required" placeholder="Ingrese el nombre del controlador" class="form-control" name="data[RbacAccion][controller]" value="<?php echo $this->data['RbacAccion']['controller']; ?>" >
                    </div>
                </div>
                <div class="form-group">            
                    <label for="accion" class="col-sm-2 control-label">Acción</label>                
                    <div class="col-sm-10">                        
                        <input type="text" required="required" placeholder="Ingrese el nombre de la acción" class="form-control" name="data[RbacAccion][action]" value="<?php echo $this->data['RbacAccion']['action']; ?>" >
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