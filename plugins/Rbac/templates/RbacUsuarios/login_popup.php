<form id="formLoginPopup" class="form-signin well" role="form" action="/rbac/rbac_usuarios/login/" method="POST">
    <h3 class=" Icon">
       <!--Icono de usuario-->
       <span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Login       
    </h3>
    <br> 
     <div class="input-group input-group-lg">
        <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-user"></i></span>
        <input id="usuario_login" type="text" aria-describedby="sizing-addon1" name="data[RbacUsuario][usuario]" class="form-control" placeholder="Usuario" required autofocus>
    </div>
    <br>        
    <div class="input-group input-group-lg">
       <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-lock"></i></span>
       <input id="password" type="password" aria-describedby="sizing-addon1" name="data[RbacUsuario][password]" class="form-control" placeholder="Contraseña" required>
   </div>
     
    <!--<label class="checkbox"> <input type="checkbox" value="remember-me">Recordarme </label>-->
    <br>
    <?php if(isset($captcha) and $captcha == 'Si'){ ?>
	    <div id="captcha">
	        <img class="form-control" src="/files/captcha.php" style="height: 100px !important" alt="verificacion" height="70" border="1" vspace="5" onclick="location.href = '/login/';"/><br>    
	        <input type="hidden" id="valor">
	        <input class="form-control" type="text" size="10"  placeholder="Ingrese las letras" name="captcha"><br>
	    </div>
    <?php } ?>
    <br>             
    <button class="btn btn-lg btn-primary btn-block" id="btn_login" type="submit">Ingresar</button>
    <br />        
    <?php if(isset($noLDAP)){ ?>
        <a href="/rbac/rbac_usuarios/recuperar"><span class="label label-danger">Recuperar contraseña</span></a>
    <?php } ?>
</form>  

<script type="text/javascript">
	$("#formLoginPopup").on("submit",function(e){            
         e.preventDefault();
         $.ajax({
            type: "POST",
            url: "/rbac/rbac_usuarios/login",
            dataType: 'html',
            timeout: 4000,            
            data: { 'data[RbacUsuario][usuario]':$("#usuario_login").val(),'data[RbacUsuario][password]':$("#password").val()
            },
            beforeSend: function(){
                dialog =  bootbox.dialog({
                     message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i>Por favor espere mientras se procesan los datos...</div>',
                     closeButton: false
                 });                
            },
            success:function(data) {                 
                 //$("#listado").html(data);
                 location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {                
                bootbox.alert("Ocurrio un problema , verifique las conexiones ");                   
            },
            complete : function(xhr, status) {
                 $('#divDialog').dialog('close');                                     
                 dialog.modal('hide');
            },
        });
    });
</script>