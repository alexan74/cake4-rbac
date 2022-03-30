<?php
if (!empty($rbacUsuarios)) {
    $columnas =
    array(
        0 => array(
            'titulo' => '#',
            'campo'  => 'id',
            'oculto' => true),
        1 => array(
            'titulo' => 'Nombre',
            'campo'  => 'nombre',
            'oculto' => false),
        2 => array(
            'titulo' => 'Apellido',
            'campo'  => 'apellido',
            'orden'  => 'asc',
            'oculto' => false),
        3 => array(
            'titulo' => 'Usuario',
            'campo'  => 'usuario',
            'orden'  => 'asc',
            'oculto' => false),
        4 => array(
            'titulo' => 'Perfil Default',
            'campo'  => 'perfil_default.descripcion',
            'orden'  => 'asc',
            'oculto' => false),
        5 => array(
            'titulo'         => 'Perfil/es',
            'campo'          => 'rbac_perfiles.descripcion',
            'orden'          => 'asc',
            'oculto'         => false,
            'campo_multiple' => true),
    );
    $botones =
    array(
        //'ver'=>array('//TipoContratos/ver/','popup'),
        'editar'   => array('/rbac/rbac_usuarios/editar/','Editar Usuario'),
        'eliminar' => array('/rbac/rbac_usuarios/eliminar/', 'Está seguro que desea eliminar el usuario', 'usuario', 'RbacUsuario'),
    );
    $this->DiticHtml->tabla(array('RbacUsuario'), $rbacUsuarios, $columnas, $botones);

}
?>
<?php use Cake\Routing\Router;?>
<script type="text/javascript">
 $(document).ready(function() {
    //prepare the dialog
    var dialog = $( "#dialogModalRbacUsuario" ).dialog({
        autoOpen: false,
        width: 700,
        //height: 500,
        autoResize:true,
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
          //$("#formRbacUsuario").trigger("submit");
        }
    });
    dialog.data( "uiDialog" )._title = function(title) {
        title.html( this.options.title );
    }
    //respond to click event on anything with 'overlay' class

    var csrfToken = getCookie('csrfToken');
    $("#rbac_usuario,.editar").click(function(event){
        event.preventDefault();

        var link = $(this).attr("href");
        var title = $(this).data("title");
        
        $('#contentWrapRbacUsuario').load( link, function( response, status, xhr ) {

            xhr.setRequestHeader('X-CSRF-Token', csrfToken);
            if ( status == "error" ) {
                 //login_popup();
                 $('#dialogModalRbacUsuario').dialog('close');
                 window.top.location.href = '/login/1';
            }else{

                $('#dialogModalRbacUsuario').dialog('option', 'title',' <span class="glyphicon glyphicon-user "></span> '+title);
                $('#dialogModalRbacUsuario').dialog('open');  //open the dialog
            }
            
        });

    });
});
</script>
