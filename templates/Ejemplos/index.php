<div class="well">
	<h3 class='sub-header'>
		<span class="fa fa-book fa-lg"></span>                      
    	Ejemplo DITICHTML
    	<a href="/admin/" class="btn btn-success pull-right"><span class="glyphicon glyphicon-home"></span> Ir al Home</a>
    </h3>
    <div class="clear"><br /></div>
    <div class="col-md-4">
        <form autocomplete="off"  class="form-horizontal" name="formCons" id="formCons" action="/ejemplos/" method="POST">
            <div class="box box-primary">
            	<div class="box-header with-border">
                   <h3 class="box-title">Búsqueda de Ejemplos</h3>
            	</div>
                <div class="form-group">                    
                    <div class="col-sm-12">                        
                        <input type="text" id="titulo" name="titulo" placeholder="Titulo" class="form-control" value="<?php echo $titulo;?>" >
                    </div>
                </div>                
                <div class="form-group">                    
                    <div class="col-sm-12">                        
                        <input type="text" id="descripcion" name="descripcion" placeholder="Descripcion" class="form-control" value="<?php echo $descripcion;?>" >
                    </div>
                </div>                
                <div style="margin-top: 15px" class="text-center">
                    <button type="submit" class="btn btn-success">Buscar</button>                    
                    <button type="button" class="btn btn-warning" onclick="limpiar()">Limpiar</button>
                </div>
                <div class="clear"><br /></div>  
            </div>
        </form>
    </div>
    <div class="col-md-8">
    	<div class="box box-primary">
            <div class="box-header with-border">
             	<h3 class="box-title">Consulta de Ejemplos</h3>
            </div>
            
            <?php 
            	$columnas =
            			array(
            				array(
    							'titulo'=>'#',
    							'campo'=>'id',
            					'oculto'=>false),
    						array(
    							'titulo'=>'Título',
    							'campo'=>'titulo',
    							'orden'=>'asc',
    							'href'=>array('Noticia.url','_blank'),
    							'tamaño' => 20,
            					'oculto'=>false),
    						array(
    							'titulo'=>'Descripción',
    							'campo'=>'descripcion',
    							'orden'=>'asc',
    							'tamaño' => 20,
            					'oculto'=>false),
    					);  		
    			$botones =
    				array(
    					'ver'		=> array('/ejemplos/ver/','popup','Formulario'),
    					'editar' 	=> array('#'),
    					'eliminar' 	=> array('#')
    				);
    			$this->DiticHtml->tabla('Ejemplos', $ejemplos, $columnas, $botones);
    		?>
    	</div>
    </div>
    <hr />
    <div class="col-md-12">
		DESCRIPCION:<br />
		<pre>
$columnas =
	array(
		array(
			'titulo'=>'#',
			'campo'=>'id',
			'oculto'=>false),
		array(
			'titulo'=>'Título',
			'campo'=>'titulo',
			'orden'=>'asc',
			'href'=>array('Noticia.url','_blank'),
			'tamaño' => 20,
			'oculto'=>false),
		array(
			'titulo'=>'Descripción',
			'campo'=>'descripcion',
			'orden'=>'asc',
			'tamaño' => 20,
			'oculto'=>false),
	);  		
$botones =
	array(
		'ver'		=> array('/ejemplos/ver/','popup','Formulario'),
		'editar' 	=> array('#'),
		'eliminar' 	=> array('#')
	);
$this->DiticHtml->tabla('Ejemplos', $ejemplos, $columnas, $botones);  Genera la tabla de datos con paginación y pueden ordernar tambien
		</pre>
		<br />
		SINTAXIS:<br />
		<pre>
$this-&gt;DiticHtml-&gt;tabla(modelo,datos,columnas,botones); 
		</pre>
		<br />
		DEFINICION:<br />
		<pre>	
<b>modelo</b> Nombre de modelo de la tabla para cargar sus datos

<b>datos</b> obtiene datos de la bd para mostrar en la tablacon paginacion y puede ordenar columnas
	ejemplo: 
		- $this-&gt;paginate = array('limit'=&gt;5);
		- $data = $this-&gt;paginate( 'Noticia' );
		- $this-&gt;set('noticias',$data);  -> en la vista llama a la variable $noticias (datos)

<b>columnas</b>

Los parametros de columnas son:
	titulo: titulo de columna
	campo: campo de la tabla
	orden: puede ser asc o desc o nulo
	tamaño: numero de caracteres a mostrar
	oculto: (true o false)
	estilo: atributos de css para la cabecera de la tabla (Ej. width:100px;display:block; etc)
	href: array(url,destino):
		- url (campo url de la tabla)
		- destino puede ser _blank, _self, _parent, _top o nulo
	imagen: array(width, height, url)
		- widht (medida de ancho o nulo)
		- height (media de altura o nulo)
		- url (ruta de imagen)
	formato: (si/no o logica o checkbox).  logica puede mostrar "Activo o No Activo"
	fecha: true o false (carga dato de la fecha y la convierte en formato d/m/Y)
	fecha_hora: true o false (carga dato de la fecha y hora y la convierte en formato d/m/Y H:i:s)
	css: nombre de la clase (CSS) para cada celda o columna de la tabla
	campo_multiple: (true o false) puede mostrar varios datos de un campo de una tabla relacionada por ejemplo modelo.descripcion

<b>botones</b>
	
los parametros de botones son:
		- ver: array(ruta, controlador, popup [true o false], titulo)  
		- editar: array(ruta, controlador, titulo)
		- eliminar:  array(ruta_eliminar, texto_eliminar, controlador, field)
			
Si quiere ver popup, desde el controlador en la accion ver, agregar la función.
	
	 $this-&gt;getRequest()-&gt;getSession()-&gt;write('mipopup',true);
					
		</pre>
		<br />REQUERIMIENTO:<br />
		<pre>
			
Requiere archivos para la tabla
	- bootbox.min.js (modal popup)
	- bootstrap.min.js
	- bootstrap.css
	- jquery-ui.css
	- jquery.js
	- jquery-ui.js
		</pre>
	  </div>
	  
	
    
    
    
</div>
<!-- DataTables -->
<?php //echo $this->Html->css('AdminLTE./plugins/datatables.net-bs/css/dataTables.bootstrap.min', ['block' => 'css']); ?>
<?php //echo $this->Html->script('AdminLTE./plugins/datatables.net/js/jquery.dataTables.min', ['block' => 'script']); ?>
<?php //echo $this->Html->script('AdminLTE./plugins/datatables.net-bs/js/dataTables.bootstrap.min', ['block' => 'script']); ?>
<script type="text/javascript">
$(function () {
 //$('#tabla').DataTable();
});
function limpiar()
{
  document.location.href = "/Ejemplos/?inicio=1";
}
</script>