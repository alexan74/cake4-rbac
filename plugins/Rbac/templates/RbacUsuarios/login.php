<?php use Cake\Core\Configure; ?>
<div class="cuadro-login">
    <img src="<?php echo $this->Url->image('encabezado_home.jpg');?>" class="img-responsive" title="ADMINISTRACION <?php echo Configure::read('Tema.titulo'); ?>" alt="ADMINISTRACION <?php echo Configure::read('Tema.titulo'); ?>">
    <?php //echo $this->Html->image('encabezado_home.jpg', ['class'=>'img-responsive', 'alt'=>'ADMINISTRACION '.Configure::read('Tema.titulo'), 'title'=>'ADMINISTRACION '.Configure::read('Tema.titulo')]); ?>
    <br />
    <form id="formLogin" class="form-signin well" role="form" action="/login/" method="POST">
            <h3 class=" Icon">
            
                        <!--Icono de usuario-->
                       <span class="glyphicon glyphicon-user"></span>
                     
                   
            </h3>
            <br> 
             <div class="input-group input-group-lg">
                <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-user"></i></span>
                <input id="usuario" type="text" aria-describedby="sizing-addon1" name="data[RbacUsuario][usuario]" class="form-control" placeholder="Usuario" required autofocus>
            </div>
            <br>        
            <div class="input-group input-group-lg">
               <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-lock"></i></span>
               <input id="password" type="password" aria-describedby="sizing-addon1" name="data[RbacUsuario][password]" class="form-control" placeholder="Contraseña" required>
           </div>
    
            
             
            <!--<label class="checkbox"> <input type="checkbox" value="remember-me">Recordarme </label>-->
            <br>
            <?php if($captcha == 'Si'){ ?>
            
            <div id="captcha">
                <img class="form-control" src="/files/captcha.php" style="height: 100px !important" alt="verificacion" height="70" border="1" vspace="5" onclick="location.href = '/login/';"/><br>    
                <input type="hidden" id="valor">
                <input class="form-control" type="text" size="10"  placeholder="Ingrese las letras" name="captcha"><br>
            </div>
            <?php } ?>
            <br>             
            <button class="btn btn-lg btn-primary btn-block" id="btn_login" type="submit">Ingresar</button>
            <br />        
            <?php if (!empty($authUrl)){?>
                    <a class="wow fadeInUp" href="<?php echo $authUrl;?>" data-wow-delay="0.4s"><i class="fa fa-google-plus"> <img src="<?php echo $this->Url->image('login_google.png');?>" alt=" Google"></i></a>
            <?php }?>
            <a href="/rbac/rbac_usuarios/recuperar"><span class="label label-danger">Recuperar contraseña</span></a>
    </form>
</div>    