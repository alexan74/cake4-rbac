<?php use Cake\Core\Configure; ?>
<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->charset(); ?>
<title>ADMINISTRACION <?php echo Configure::read('Tema.titulo'); ?></title>
<?php
echo $this->Html->meta('icon');
echo $this->Html->css('AdminLTE./bootstrap/css/bootstrap.min');
echo $this->Html->css('font-awesome.min');
echo $this->Html->css('ionicons.min');
echo $this->Html->css('AdminLTE./css/AdminLTE.min');
echo $this->Html->css('AdminLTE./css/skins/skin-'. Configure::read('Tema.skin') .'.min');
echo $this->Html->css('jquery-ui');
echo $this->Html->css('signin');

echo $this->Html->script('jquery.min');
echo $this->Html->script('jquery.easing.1.3');
echo $this->Html->script('jquery-ui');
echo $this->Html->script('jquery.validate.min');
echo $this->Html->script('bootbox.min');
echo $this->Html->script('bootstrap-tooltip');
echo $this->Html->script('jquery-validate.bootstrap-tooltip.min');

echo $this->fetch('css');
echo $this->fetch('script');
?>
</head>
<body>
	<div class="container">
		<?php echo $this->Flash->render(); ?> 
		<?php echo $this->fetch('content'); ?>
	</div>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        $('.alert-success, .alert-danger').fadeOut(20000);
    });
</script>
</html>