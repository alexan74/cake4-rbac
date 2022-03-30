<?php
if (!empty($configuraciones)) {
    $columnas =
    array(
       array(
            'titulo' => '#',
            'campo'  => 'id',
            'oculto' => true),
        array(
            'titulo' => 'Clave',
            'campo'  => 'clave',
            'oculto' => false),
        array(
            'titulo' => 'Valor',
            'campo'  => 'valor',
            'orden'  => 'asc',
            'oculto' => false),

    );
    $botones = array('editar'   => array('/rbac/configuraciones/editar/','Editar Configuración'), //array(ruta, titulo)
                     'eliminar' => array('/rbac/configuraciones/eliminar/', 'Está seguro que desea eliminar esta configuración', 'clave' ),
                     // array(ruta_eliminar, texto_eliminar, field, valor)
    );
    $this->DiticHtml->tabla(array('Configuracion'), $configuraciones, $columnas, $botones);

}
?>


<script type="text/javascript">
 $(document).ready(function() {
    //prepare the dialog
    var dialog = $( "#dialogModalConfiguracion" ).dialog({
        autoOpen: false,
        width: 500,
        height: 280,
        show: {
            effect: "slide",
            duration: 10
            },
        hide: {
            effect: "slide",
            duration: 10
            },
        modal: true,
        close: function(event, ui) {
          //location.reload();
          //$("#formConfiguracion").trigger("submit");
        }
    });
    dialog.data( "uiDialog" )._title = function(title) {
        title.html( this.options.title );
    }
    //respond to click event on anything with 'overlay' class

    var csrfToken = getCookie('csrfToken');
    $("#configuracion,.editar").click(function(event){
        
		event.preventDefault();
        var link = $(this).attr("href");
        var title = $(this).data("title");
        $("#content").loading(); 
        $('#contentWrapConfiguracion').load( link, function( response, status, xhr ) {

            xhr.setRequestHeader('X-CSRF-Token', csrfToken);
            if ( status == "error" ) {
                 //login_popup();
                 $('#dialogModalConfiguracion').dialog('close');
                 window.top.location.href = '/login/1';
            }else{

                $('#dialogModalConfiguracion').dialog('option', 'title',' <span class="fa fa-wrench"></span> '+title);
                $('#dialogModalConfiguracion').dialog('open');  //open the dialog
            }
            $("#content").loading('stop'); 
        });
		
    });
});
</script>
