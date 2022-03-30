<div class="row-fluid" style="margin-top: 30px;">
    <div class="col-md-8 col-md-offset-2">
        <form class="form-signin well" role="form" id="RbacPerfilesChangePass" name="RbacPerfilesChangePass" action="/rbac/rbac_usuarios/recuperar/" method="POST">
            <h3 class="form-signin-heading">
                <i class="fa fa-arrow-circle-right"></i> Recuperar contraseña
            </h3>
            <br/>
            <input type="text" name="correo" id="correo" placeholder="Correo" class="form-control" />
            <br/>    
            <img class="form-control" style="height:100px;width:auto;"  src="/files/captcha.php" alt="verificacion" border="1" vspace="5" onclick="location.href = '/rbac/rbac_usuarios/recuperar';"/>
            <br/>    
            <input type="hidden" id="valor" />
            <input class="form-control" type="text" maxsize="10" placeholder="Ingrese las letras" name="captcha"  />
        
            <br/>
            <div style="text-align: center;">
                <button type="button" class="btn btn-success" onclick="enviar()">Enviar</button>
                <button type="button" class="btn btn-warning" onclick="location.href = '/rbac/rbac_usuarios/login'">Volver</button>    
            </div>
        </form>
	</div>
</div>   
<script type="text/javascript">
    $(function() {
        inicialize();
    });

    function inicialize()
    {

        $.validator.addMethod('correo', function(value, element, param) {
            return this.optional(element) || /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/.test(value);
        });


        $('#RbacPerfilesChangePass').validate({
            rules: {
                'correo': {
                    correo: true,
                    required: true
                },        
                'captcha': {
                    required: true
                }        
            },
            messages: {
                'correo': {
                    correo: "Ingrese un correo válido",
                    required: "Ingrese un correo"
                },
                'captcha': {                    
                    required: "Ingrese captcha"
                }
            },
            tooltip_options: {
                'correo': { 
                    placement: 'bottom'
                },
                'captcha': {
                    placement: 'top' 
                }
            }/*,
            highlight: function(element) {
                $(element).closest('.control-group').removeClass('success').addClass('error');
            },
            success: function(element) {
                element
                        .text('OK!').addClass('valid')
                        .closest('.control-group').removeClass('error').addClass('success');
            }*/
        });
    }

    function enviar()
    {
        if ($('#RbacPerfilesChangePass').valid())
        {
            if ($('#contraseniaNueva').val() != $('#contraseniaNuevaConfirm').val()) {
                var validator = $("#RbacPerfilesChangePass").validate();
                validator.showErrors({
                    "contraseniaNuevaConfirm": "Por favor repita la contraseña"
                });
            } else {
                $('#RbacPerfilesChangePass').submit();

            }
        }
    }

</script>