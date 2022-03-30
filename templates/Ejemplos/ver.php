<h3 class="sub-header">
	<span class="fa fa-list-alt fa-lg"></span>		
	Ejemplo #<?php echo $ejemplo->id;?>
	<!-- <a class="btn btn-default navbar-right" href="/vinculos/">
		<span class="glyphicon glyphicon-arrow-left"></span>
		Volver a la lista</a>-->
</h3>

<div class="col-md-10">
	<div class="form-group">
    	<label for="nombre" class="col-sm-3 control-label">Titulo</label>
        <div class="col-sm-9">                        
        	<input type="text" readonly class="form-control" name="titulo"  value="<?php echo $ejemplo->titulo; ?>" >
        </div>
	</div> 
	<div class="form-group">
    	<label for="nombre" class="col-sm-3 control-label">Descripcion</label>
        <div class="col-sm-9">                        
        	<input type="text" readonly class="form-control" name="descripcion"  value="<?php echo $ejemplo->descripcion; ?>" >
        </div>
	</div>  
</div>
<div style="clear:both;"></div>