<!-- Entorno flotante -->
        <?php  
				
            $session = $this->getRequest()->getSession();
            $vh_default = $session->read('vh_default');
        	$vhAll = unserialize($session->read('vh'));
        	?>
        	<style>
	            #fl_menu {position:absolute; top:50%; left:0; z-index:9999;}
	            #f1_menu .btn-info { width:250px; }
	            #fl_menu .menu{display:none; clear: both}
	            #fl_menu .menu .menu_item{display:block; width:250px;}
	            #fl_menu .menu a.menu_item:hover{}
	            #fl_menu .btn-group > .btn:first-child:not(:last-child):not(.dropdown-toggle) {
				    border-radius: 4px;
				    width:250PX;   
				}
				
				#slidable { display:none; }
				#slide.glyphicon { line-height: 1.42857; }
        	</style>  
            <div id="fl_menu">
                <div class="btn-group" id="slidable" style="float:left;">
					<?php 
                    if (isset($vhAll)) {
                    	foreach ($vhAll as $vh) { 
                            if ($vh['permiso'] == $vh_default) {
                                 break;
                            }
                    	}
                    } 
                    ?> 

                    <button type="button" class="btn btn-info"><?php echo 'Entorno:&nbsp;<b>' . $vh_default . '</b>'; ?></button>                
                    <div class="menu">
                    <?php 
                    	if (isset($vhAll)) {
                    		foreach ($vhAll as $vh) {
	                            if ($vh['permiso'] != $vh_default) {?>                                    
	                                <a type="button" class="btn btn-danger menu_item" href="/rbac/rbac_usuarios/cambiarEntorno/<?php echo $vh['permiso'] ?>" >
	                                    <?php echo '<b>' . $vh['permiso'] . '</b>'; ?>
	                                </a>
	                            <?php } 
                    		}
                    	} ?> 
                    </div> 
                </div>
                <span id="slide" class="btn btn-info glyphicon glyphicon-chevron-right" style="float:right;width:auto;"></span>    
            </div>
            <script>
                //config
                $float_speed = 1500; //milliseconds
                $float_easing = "easeOutQuint";
                $menu_fade_speed = 500; //milliseconds
                $closed_menu_opacity = 0.75;

                //cache vars
                $fl_menu = $("#fl_menu");
                $fl_menu_menu = $("#fl_menu .menu");
                $fl_menu_label = $("#fl_menu .label");
                var menuPosition;
                $(window).load(function() {
                	$("#slide").click(function() {
                 		$('#slidable').toggle( "slow" , function() {
                     		if ($('#slidable').is(":visible")) {
                     			$('#slide').removeClass('glyphicon-chevron-right');
    							$('#slide').addClass('glyphicon-chevron-left');
                     		} else {
	                 			$('#slide').removeClass('glyphicon-chevron-left');
								$('#slide').addClass('glyphicon-chevron-right');
                     		}
                 		});
                		//$('#slidable').show('slow');
                  	});
                    menuPosition = $('#fl_menu').position().top;
                    FloatMenu();
                    $fl_menu.hover(
                            function() { //mouse over
                                $fl_menu_label.fadeTo($menu_fade_speed, 1);
                                $fl_menu_menu.fadeIn($menu_fade_speed);
                            },
                            function() { //mouse out
                                $fl_menu_label.fadeTo($menu_fade_speed, $closed_menu_opacity);
                                $fl_menu_menu.fadeOut($menu_fade_speed);
                            }
                    );
                });

                $(window).scroll(function() {
                    FloatMenu();
                });

                function FloatMenu() {
                    var scrollAmount = $(document).scrollTop();
                    var newPosition = menuPosition + scrollAmount;
                    if ($(window).height() < $fl_menu.height() + $fl_menu_menu.height()) {
                        $fl_menu.css("top", menuPosition);
                    } else {
                        $fl_menu.stop().animate({top: newPosition}, $float_speed, $float_easing);
                    }
                }
            </script>
              