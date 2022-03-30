<li class="treeview">
    <a href="#">
        <i class="fa fa-book"></i> <span>Ejemplos</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-down pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li><a href="<?php echo $this->Url->build('/ejemplos?inicio=1'); ?>"><i class="fa fa-circle-o"></i> DiticHtml Helper</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/home'); ?>"><i class="fa fa-circle-o"></i> Home v1</a></li>
        <li><a href="<?php echo $this->Url->build('/pages/home2'); ?>"><i class="fa fa-circle-o"></i> Home v2</a></li>
        <li>
	        <a href="<?php echo $this->Url->build('/pages/widgets'); ?>">
	            <i class="fa fa-th"></i> <span>Widgets</span>
	            <span class="pull-right-container">
	                <small class="label pull-right bg-green">Nuevo</small>
	            </span>
	        </a>
	    </li>
	    <li class="treeview">
	        <a href="#">
	            <i class="fa fa-pie-chart"></i>
	            <span>Charts</span>
	            <span class="pull-right-container">
	                <i class="fa fa-angle-down pull-right"></i>
	            </span>
	        </a>
	        <ul class="treeview-menu">
	            <li><a href="<?php echo $this->Url->build('/pages/charts/chartjs'); ?>"><i class="fa fa-circle-o"></i> ChartJS</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/charts/morris'); ?>"><i class="fa fa-circle-o"></i> Morris</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/charts/flot'); ?>"><i class="fa fa-circle-o"></i> Flot</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/charts/inline'); ?>"><i class="fa fa-circle-o"></i> Inline charts</a></li>
	        </ul>
	    </li>
	    <li class="treeview">
	        <a href="#">
	            <i class="fa fa-laptop"></i>
	            <span>Elementos UI</span>
	            <span class="pull-right-container">
	                <i class="fa fa-angle-down pull-right"></i>
	            </span>
	        </a>
	        <ul class="treeview-menu">
	            <li><a href="<?php echo $this->Url->build('/pages/ui/general'); ?>"><i class="fa fa-circle-o"></i> General</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/ui/icons'); ?>"><i class="fa fa-circle-o"></i> Iconos</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/ui/buttons'); ?>"><i class="fa fa-circle-o"></i> Botones</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/ui/sliders'); ?>"><i class="fa fa-circle-o"></i> Sliders</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/ui/timeline'); ?>"><i class="fa fa-circle-o"></i> Timeline</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/ui/modals'); ?>"><i class="fa fa-circle-o"></i> Modals</a></li>
	        </ul>
	    </li>
	    <li class="treeview">
	        <a href="#">
	            <i class="fa fa-edit"></i> <span>Formularios</span>
	            <span class="pull-right-container">
	                <i class="fa fa-angle-down pull-right"></i>
	            </span>
	        </a>
	        <ul class="treeview-menu">
	            <li><a href="<?php echo $this->Url->build('/pages/forms/general'); ?>"><i class="fa fa-circle-o"></i> General</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/forms/advanced'); ?>"><i class="fa fa-circle-o"></i> Avanzado</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/forms/editors'); ?>"><i class="fa fa-circle-o"></i> Editores</a></li>
	        </ul>
	    </li>
	    <li class="treeview">
	        <a href="#">
	            <i class="fa fa-table"></i> <span>Tablas</span>
	            <span class="pull-right-container">
	                <i class="fa fa-angle-down pull-right"></i>
	            </span>
	        </a>
	        <ul class="treeview-menu">
	            <li><a href="<?php echo $this->Url->build('/pages/tables/simple'); ?>"><i class="fa fa-circle-o"></i> Tabla Simple</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/tables/data'); ?>"><i class="fa fa-circle-o"></i> Tabla con datos</a></li>
	        </ul>
	    </li>
	    <li>
	        <a href="<?php echo $this->Url->build('/pages/calendar'); ?>">
	            <i class="fa fa-calendar"></i> <span>Calendario</span>
	            <span class="pull-right-container">
	                <!--<small class="label pull-right bg-red">3</small>
	                <small class="label pull-right bg-blue">17</small>-->
	                <i class="fa fa-angle-down pull-right"></i>
	            </span>
	        </a>
	    </li>
	    <li class="treeview">
	        <a href="#">
	            <i class="fa fa-envelope"></i> <span>Correo</span>
	            <span class="pull-right-container">
	                <!--<small class="label pull-right bg-yellow">12</small>
	                <small class="label pull-right bg-green">16</small>
	                <small class="label pull-right bg-red">5</small>-->
	                <i class="fa fa-angle-down pull-right"></i>
	            </span>
	        </a>
	        <ul class="treeview-menu">
	            <li><a href="<?php echo $this->Url->build('/pages/mailbox/mailbox'); ?>">Bandeja de entrada <span class="label label-primary pull-right">13</span></a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/mailbox/compose'); ?>">Redactar</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/mailbox/read-mail'); ?>">Leer</a></li>
	        </ul>
	    </li>
	    <li class="treeview">
	        <a href="#">
	            <i class="fa fa-folder"></i> <span>Varios</span>
	            <span class="pull-right-container">
	                <i class="fa fa-angle-down pull-right"></i>
	            </span>
	        </a>
	        <ul class="treeview-menu">
	            <li><a href="<?php echo $this->Url->build('/pages/starter'); ?>"><i class="fa fa-circle-o"></i> Comienzo</a></li>
	            <!--<li><a href="<?php echo $this->Url->build('/pages/examples/invoice'); ?>"><i class="fa fa-circle-o"></i> Invoice</a></li>-->
	            <li><a href="<?php echo $this->Url->build('/pages/examples/profile'); ?>"><i class="fa fa-circle-o"></i> Perfil</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/examples/register'); ?>"><i class="fa fa-circle-o"></i> Registrar</a></li>
	            <!--<li><a href="<?php echo $this->Url->build('/pages/examples/lockscreen'); ?>"><i class="fa fa-circle-o"></i> Lockscreen</a></li>-->
	            <li><a href="<?php echo $this->Url->build('/pages/examples/404'); ?>"><i class="fa fa-circle-o"></i> 404 Error</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/examples/500'); ?>"><i class="fa fa-circle-o"></i> 500 Error</a></li>
	            <li><a href="<?php echo $this->Url->build('/pages/examples/blank'); ?>"><i class="fa fa-circle-o"></i> Pagina en blanco</a></li>
	            <!--<li><a href="<?php echo $this->Url->build('/pages/examples/pace'); ?>"><i class="fa fa-circle-o"></i> Pace Page</a></li>-->
	        </ul>
	    </li>
	    <li class="treeview">
	        <a href="#">
	            <i class="fa fa-sitemap"></i> <span>MultiNiveles</span>
	            <span class="pull-right-container">
	                <i class="fa fa-angle-down pull-right"></i>
	            </span>
	        </a>
	        <ul class="treeview-menu">
	            <li><a href="#"><i class="fa fa-circle-o"></i> Menu 1</a></li>
	            <li>
	                <a href="#">
	                <i class="fa fa-circle-o"></i> Menu 2
	                <span class="pull-right-container">
	                    <i class="fa fa-angle-down pull-right"></i>
	                </span>
	                </a>
	                <ul class="treeview-menu">
	                    <li><a href="#"><i class="fa fa-circle-o"></i> Submenu 2-1</a></li>
	                    <li>
	                        <a href="#">
	                            <i class="fa fa-circle-o"></i> Submenu 2-2
	                            <span class="pull-right-container">
	                                <i class="fa fa-angle-down pull-right"></i>
	                            </span>
	                        </a>
	                        <ul class="treeview-menu">
	                            <li><a href="#"><i class="fa fa-circle-o"></i> Submenu 2-2-1</a></li>
	                            <li><a href="#"><i class="fa fa-circle-o"></i> Submenu 2-2-2</a></li>
	                        </ul>
	                    </li>
	                </ul>
	            </li>
	            <li><a href="#"><i class="fa fa-circle-o"></i> Menu 3</a></li>
	        </ul>
	    </li>
	    <!--<li class="header">LABELS</li>-->
	    <li class="treeview">
	        <a href="#">
	            <i class="fa fa-share"></i> <span>Colores</span>
	            <span class="pull-right-container">
	                <i class="fa fa-angle-down pull-right"></i>
	            </span>
	        </a>
	        <ul class="treeview-menu">
		    	<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Importante</span></a></li>
    			<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Precaución</span></a></li>
   				<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Información</span></a></li>
   			</ul>
   		</li>
   		<li><a href="<?php echo $this->Url->build('/pages/documentation'); ?>"><i class="fa fa-book"></i> Manual del template</a></li>
		<li><a href="<?php echo $this->Url->build('/pages/debug'); ?>"><i class="fa fa-bug"></i> Debug</a></li>
    </ul>
</li>