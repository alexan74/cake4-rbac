<?php
namespace App\View\Helper;

use Cake\Utility\Inflector;
use Cake\View\Helper;



class DiticHtmlHelper extends Helper
{
    public $name       = 'DiticHtml';
    public $components = array('Session');
    public $helpers    = array('Session', 'Paginator', 'Form');

    protected function p($txt)
    {
        print $txt . chr(10);
    }

    public function wysiwyg($fieldName, $valor, $id, $options)
    {
        $perfilDefault                 = $this->getView()->getRequest()->getSession()->read('PerfilDefault');
        $accionesPermitidasPorPerfiles = $this->getView()->getRequest()->getSession()->read('RbacAcciones');
        $accionesPermitidas            = $accionesPermitidasPorPerfiles[$perfilDefault];
        $output                        = '';
        if ($fieldName) {
            if (!isset($id)) {
                $id = 'wysiwyg';
            }
            $output .= '<div class="' . $id . '">';
            if (isset($options['botones'])) {
                $botones = $options['botones'];
                //if (count($botones)>0) {
                foreach ($botones as $boton) {
                    if ($boton === 'negrita') {
                        $output .= '<a class="btn btn-default" id="negrita"></a>';
                    }
                    if ($boton === 'italica') {
                        $output .= '<a class="btn btn-default" id="italica"></a>';
                    }
                    if ($boton === 'subrayada') {
                        $output .= '<a class="btn btn-default" id="subrayada"></a>';
                    }
                    if ($boton === 'izquierda') {
                        $output .= '<a class="btn btn-default" id="izquierda"></a>';
                    }
                    if ($boton === 'centro') {
                        $output .= '<a class="btn btn-default" id="centro"></a>';
                    }
                    if ($boton === 'derecha') {
                        $output .= '<a class="btn btn-default" id="derecha"></a>';
                    }
                    if ($boton === 'lista') {
                        $output .= '<a class="btn btn-default" id="lista"></a>';
                    }
                    if ($boton === 'listaizquierda') {
                        $output .= '<a class="btn btn-default" id="listaizquierda"></a>';
                    }
                    if ($boton === 'listaderecha') {
                        $output .= '<a class="btn btn-default" id="listaderecha"></a>';
                    }
                    if ($boton === 'aumentar') {
                        $output .= '<a class="btn btn-default" id="aumentar"></a>';
                    }
                    if ($boton === 'achicar') {
                        $output .= '<a class="btn btn-default" id="achicar"></a>';
                    }
                    if ($boton === 'imagen') {
                        $output .= '<a class="btn btn-default" id="imagen"></a>';
                    }
                    if ($boton === 'html') {
                        $output .= '<a class="btn btn-default" id="html"></a>';
                    }
                    if ($boton === 'linea') {
                        $output .= '<a class="btn btn-default" id="linea"></a>';
                    }
                }
                //}
            }

            $output .= '<textarea name="' . $fieldName . '" style="height:600px;" class="form-control" id="' . $id . '" ';
            if (isset($options['cols'])) {
                $output .= 'cols="' . $options['cols'] . '" ';
            }

            if (isset($options['rows'])) {
                $output .= 'rows="' . $options['rows'] . '" ';
            }

            if (isset($options['modo'])) {
                if ($options['modo'] == 'sololectura') {
                    $output .= 'readonly ';
                }

                if ($options['modo'] == 'desactivado') {
                    $output .= 'disabled ';
                }

                if ($options['modo'] == 'oculto') {
                    $output .= 'hidden ';
                }

            }
            $output .= '>';
            if (!empty($valor)) {
                $output .= $valor;
            }

            $output .= '</textarea></div>';

            $output .= "
            <script type='text/javascript'>
                $(function () {

                    $('textarea#{$id}').htmlarea({});";
            if (isset($options['altura'])) {
                $output .= "$('.{$id} iframe').height('" . $options['altura'] . "px');";
            }

            if (isset($options['ancho'])) {
                $output .= "$('.{$id} iframe').width('" . $options['ancho'] . "px');";
            }

            $output .= "
                    $('.{$id} iframe').contents().find('body')
                    .css('font-family','Helvetica')
                    .css('color','#333333')
                    .css('font-size','14px')
                    .css('width','98%')
                    .css('overflow-x','none');
                    $('div.{$id} a#html ,button#html').click(function() {
                        $('#{$id}').htmlarea('toggleHTMLView');
                    });
                    $('div.{$id} a#negrita,button#negrita').click(function() {
                        $('#{$id}').htmlarea('bold');
                    });
                    $('div.{$id} a#italica,button#italica').click(function() {
                        $('#{$id}').htmlarea('italic');
                    });
                    $('div.{$id} a#subrayada,button#subrayada').click(function() {
                        $('#{$id}').htmlarea('underline');
                    });
                    $('div.{$id} a#izquierda,button#izquierda').click(function() {
                        $('#{$id}').htmlarea('justifyLeft');
                    });
                    $('div.{$id} a#centro, button#centro').click(function() {
                        $('#{$id}').htmlarea('justifyCenter');
                    });
                    $('div.{$id} a#derecha, button#derecha').click(function() {
                        $('#{$id}').htmlarea('justifyRight');
                    });
                    $('div.{$id} a#lista,button#lista').click(function() {
                        $('#{$id}').htmlarea('unorderedList');
                    });
                    $('div.{$id} a#listaizquierda,button#listaizquierda').click(function() {
                        $('#{$id}').htmlarea('outdent');
                    });
                    $('div.{$id} a#listaderecha,button#listaderecha').click(function() {
                        $('#{$id}').htmlarea('indent');
                    });
                    $('div.{$id} a#aumentar,button#aumentar').click(function() {
                        $('#{$id}').htmlarea('increaseFontSize');
                    });
                    $('div.{$id} a#achicar,button#achicar').click(function() {
                        $('#{$id}').htmlarea('decreaseFontSize');
                    });
                    $('div.{$id} a#imagen,button#imagen').click(function() {
                        $('#{$id}').htmlarea('image');
                    });
                    $('div.{$id} a#linea,button#linea').click(function() {
                        $('#{$id}').htmlarea('insertHorizontalRule');
                    });
                    $('#{$id}').htmlarea('updateHtmlArea', $('{$id}').val());
                });
            </script>
            ";
            $this->p($output);
        }

    }

    public function leerCampo($fila, $campo, $columna = null)
    {
        $niveles = explode('.', $campo);
        $actual  = $fila;
        for ($i = 0; $i < count($niveles); $i++) {
            if (!empty($niveles[$i]) && !empty($actual[$niveles[$i]])) {
                $actual = $actual[$niveles[$i]];
            } else {
                if (!empty($columna['campo_multiple']) && $columna['campo_multiple'] == 1) {

                    $arreglo = array();
                    foreach ($actual as $valor) {
                        $arreglo[] = $valor[$niveles[$i]];
                    }

                    $arr    = implode("<br>", array_values($arreglo));
                    $actual = $arr;
                } else {
                    $actual = '';
                }
                //if (!empty($columna['fecha']) && $columna['fecha'] == 1)
            }
        }

        return $actual;
    }

    public function tabla($modelo, $datos, $columnas, $botones = null, $ancho_acciones = null, $return = false)
    {
        /*$plugin                        = $this->getView()->getRequest()->getParam('plugin');
        $controlador                   = $this->getView()->getRequest()->getParam('controller');
        $action                        = $this->getView()->getRequest()->getParam('action');
        $puede_cargar_path             = $this->getView()->getRequest()->getSession()->read('puede_cargar_path');
        $puede_publico_path            = $this->getView()->getRequest()->getSession()->read('puede_publico_path');*/
        $perfilDefault                 = $this->getView()->getRequest()->getSession()->read('PerfilDefault');
        $accionesPermitidasPorPerfiles = $this->getView()->getRequest()->getSession()->read('RbacAcciones');
        $accionesPermitidas            = $accionesPermitidasPorPerfiles[$perfilDefault];
        $output                        = '';
        $id                            = null;
        $popup[]                       = null;
        $url                           = array();
        if ($modelo && $datos) {
            $output = '<div class="table-responsive">';
            if (count($columnas)) {
                $output .= '<table class="table table-bordered table-hover dataTable" id="tabla">';
                $output .= '<thead><tr>';
                
                /**
                *COLUMNAS DE LA CABECERA DE LA TABLA
                *-----------------------------------
                */
                foreach ($columnas as $columna) {
                    if (empty($columna['oculto'])) {
                        if (isset($columna['estilo'])) {
                            $style = 'style="' . $columna['estilo'] . '"';
                        } else {
                            $style = '';
                        }

                        if (isset($columna['orden'])) {
                            $output .= '<th class="sorting_'.$this->Paginator->sortDir().'" ' . $style . '>' . $this->Paginator->sort($columna['campo'], $columna['titulo'], array('Model' => $modelo, 'direction' => $columna['orden'])) . '</th>';
                        } else {
                            $output .= '<th ' . $style . '>' . $columna['titulo'] . '</th>';
                        }
                    }
                }
                $ancho = (!empty($ancho_acciones)) ? $ancho_acciones . 'px' : 'auto';
                if (count($botones)) {
                    $output .= '<th style="text-align:center;width:' . $ancho . '">Acciones</th>';
                }

                $output .= '</tr></thead>';
                $output .= '<tbody>';

                foreach ($datos as $dato) {
                    $descripcion     = '';
                    $titulo_ver      = null;
                    $titulo_eliminar = null;
                    $output .= '<tr id="headerTable">';
                    foreach ($columnas as $columna) {
                        $campo = $columna['campo'];
                        $campo_array = explode('.', $campo);
                        $baja_logica = null;
                        if ($campo === 'id') {
                            $id = $this->leerCampo($dato, $campo);
                        /*} elseif (!empty($campo_array) && $campo_array[1] === 'baja_logica') {
                            $baja_logica = $this->leerCampo($dato, $campo);*/
                        }
                        
                        /**
                         * COLUMNAS DE LA TABLA
                         * --------------------
                         */
                        if (empty($columna['oculto'])) {
                            $output .= '<td ' . $style;
                            if (isset($columna['css'])) {
                                $output .= ' class="' . $columna['css'] . '"';
                            }

                            $output .= '>';

                            if (isset($columna['href'])) {
                                $url = $this->leerCampo($dato, $columna['href'][0]);
                            }

                            $valor_campo = $this->leerCampo($dato, $campo, $columna);

                            if (is_array($valor_campo)) {
                                $valor_campo = '';
                            }
                            if (isset($columna['tamaño']) && is_numeric($columna['tamaño'])) {
                                $valor_campo = substr($valor_campo, 0, $columna['tamaño']);
                            }
                            if (isset($columna['href'])) {
                                if (isset($url)) {
                                    $output .= '<a href="' . $url . '" ';
                                    if (isset($columna['destino'][1])) {
                                        $output .= 'target="' . $columna['href'][1] . '" ';
                                    }

                                    $output .= '>' . $valor_campo . '</a>';
                                } else {
                                    $output .= $valor_campo;
                                }
                            } elseif (isset($columna['imagen']) && $columna['imagen']) {
                                $width  = '';
                                $height = '';
                                if (isset($columna['width']) && $columna['width']) {
                                    $width = 'width="' . $columna['width'] . '"';
                                }
                                if (isset($columna['height']) && $columna['height']) {
                                    $height = 'height="' . $columna['height'] . '"';
                                }
                                if (isset($columna['download']) && $columna['download'] !== '') {
                                    $output .= '<img src="' . $columna['download'] . $valor_campo . '" ' . $width . ' ' . $height . ' border="0" />';
                                } else {
                                    $output .= '<img src="' . $valor_campo . '" ' . $width . ' ' . $height . ' border="0" />';
                                }
                            } elseif (isset($columna['fecha']) && $columna['fecha']) {
                                if (!empty($valor_campo)) {
                                    $output .= trim(date("d/m/Y", strtotime($valor_campo)));
                                }

                            } elseif (isset($columna['fecha_hora']) && $columna['fecha_hora']) {
                                if (!empty($valor_campo)) {
                                    $output .= trim(date("d/m/Y H:i:s", strtotime($valor_campo)));
                                }

                            } elseif (isset($columna['formato'])) {
                                if ($columna['formato'] === 'si/no') {
                                    if (!is_array($valor_campo) && $valor_campo == 1) {
                                        $valor_campo = 'si';
                                    } else {
                                        $valor_campo = 'no';
                                    }
                                }
                                if ($columna['formato'] === 'logica') {
                                    if (!is_array($valor_campo) && $valor_campo == 1) {
                                        $valor_campo = 'Activo';
                                    } else {
                                        $valor_campo = "No Activo";
                                    }
                                }
                                if (isset($columna['formato']) && $columna['formato'] === 'checkbox') {
                                    $output .= '<input id="' . $columna['campo'] . '" dataid="' . $id . '" class="switch" type="checkbox"
                                    data-on-color="success" data-on-text="SI" data-off-text="NO" data-off-color="danger"';
                                    if (isset($valor_campo) && $valor_campo == 1) {
                                        $output .= ' checked';
                                    }
                                    $output .= ' />';
                                }
                            } else {
                                $output .= $valor_campo;
                            }

                            $output .= '</td>';
                        }
                    }
                    
                    /**
                     * BOTONES DE ACCIÓN
                     * -----------------
                     */
                    if (count($botones) && isset($id)) {
                        $output .= '<td style="text-align:center;">';
                        if (isset($botones['editar']) && is_array($botones['editar'])) {
                            $url = (!empty($botones['editar'][0]))?explode('/', $botones['editar'][0]):'';
                            $titulo = (!empty($botones['editar'][1]))?$botones['editar'][1]:'Editar';
                            if (!empty($url)) {
                                if (count($url) > 4) {
                                    $ruta =  Inflector::underscore(strtolower($url[2]));
                                } elseif (count($url) > 1) {
                                    $ruta =  Inflector::underscore(strtolower($url[1]));
                                } else {
                                    $ruta =  Inflector::underscore(strtolower($url[0]));
                                }
                                if ((isset($accionesPermitidas[$ruta]) && $accionesPermitidas[$ruta]['editar'])) {
                                    $output .= '<a href="' . $botones['editar'][0] . $id . '" type="button" title="'.$titulo.'" data-title="'.$titulo.'" class="editar btn btn-success btn-xs" title="Editar"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;';
                                }
                            }
                               
                        }

                        if (isset($botones['ver'])) {
                            if (isset($botones['ver'][2])) {
                                $titulo_ver = $botones['ver'][2];
                            }
                            $url = (!empty($botones['ver'][0]))?explode('/', $botones['ver'][0]):'';
                            if (!empty($url)) {
                                if (count($url) > 4) {
                                    $ruta =  Inflector::underscore(strtolower($url[2]));
                                } elseif (count($url) > 1) {
                                    $ruta =  Inflector::underscore(strtolower($url[1]));
                                } else {
                                    $ruta =  Inflector::underscore(strtolower($url[0]));
                                }
                            }

                            if (isset($accionesPermitidas[$ruta]['ver']) && $accionesPermitidas[$ruta]['ver']) {
                                if ($botones['ver'][0] && empty($botones['ver'][1])) {
                                    $popup['ver'] = false;
                                    $output .= '<a href="' . $botones['ver'][0] . $id . '" type="button" class="btn btn-primary btn-xs" title="Ver"><span class="glyphicon glyphicon-eye-open"></span></a>&nbsp;';
                                } elseif ($botones['ver'][0] && isset($botones['ver'][1]) && $botones['ver'][1] == 'popup') {
                                    $popup['ver'] = true;
                                    if (isset($botones['ver'][2])) {
                                        $titulo_ver = $botones['ver'][2];
                                    }

                                    $output .= '<button onClick="ver(\'' . $botones['ver'][0] . $id . '\')" type="button" class="btn btn-primary btn-xs" title="Ver"><span class="glyphicon glyphicon-eye-open"></span></button>&nbsp;';
                                }

                            }
                        }

                        if (isset($botones['ficha'])) {
                            $url = explode('/', $botones['ficha']);
                            if (isset($accionesPermitidas[$url[1]]['ficha']) && $accionesPermitidas[$url[1]]['ficha']) {
                                if (isset($num_credencial) && $num_credencial) {
                                    $output .= '<a target="_blank" href="' . $botones['ficha'] . $id . '" type="button" class="btn btn-success btn-xs" title="Exportar Ficha"><span class="glyphicon glyphicon-file"></span></a>&nbsp;';
                                }
                            }
                        }
                        if (isset($botones['eliminar'])) {
                            if (!empty($botones['eliminar'][2])) {
                                $descripcion = $this->leerCampo($dato, $botones['eliminar'][2]);
                            }  
                            
                            $url = explode('/', $botones['eliminar'][0]);

                            if (count($url) > 4) {
                                $ruta =  Inflector::underscore(strtolower($url[2]));
                            } elseif (count($url) > 1) {
                                $ruta =  Inflector::underscore(strtolower($url[1]));
                            } else {
                                $ruta =  Inflector::underscore(strtolower($url[0]));
                            }

                        }
                        if (!empty($botones['eliminar'][1])) {
                            $titulo_eliminar = $botones['eliminar'][1];
                        }
                        //if (isset($baja_logica) && $baja_logica == 0) {
                        if (isset($accionesPermitidas[$ruta]['eliminar']) && $accionesPermitidas[$ruta]['eliminar']) {
                            if (isset($botones['eliminar'][2]) && $botones['eliminar'][2] === 'descripcion') {
                                $output .= '<button onClick="eliminar(\'' . $id . ',\'' . $descripcion . '\')" type="button" class="btn btn-danger btn-xs" title="Eliminar"><span class="glyphicon glyphicon-remove"></span></button>';
                            } else {
                                if ($descripcion) {
                                    $output .= '<button onClick="eliminar(\'' . $botones['eliminar'][0] . '\',' . $id . ',\'' . $descripcion . '\')" type="button" class="btn btn-danger btn-xs" title="Eliminar"><span class="glyphicon glyphicon-remove"></span></button>';
                                } else {
                                    $output .= '<button onClick="eliminar(\'' . $botones['eliminar'][0] . '\',' . $id . ')" type="button" class="btn btn-danger btn-xs" title="Eliminar"><span class="glyphicon glyphicon-remove"></span></button>';
                                }
                            }
                        }
                        //}

                        $output .= '</td>';
                    }
                    $output .= '</tr>';
                }
                $output .= '</table>';

                
                /**
                 * CUADRO DE DIALOGO (MODAL)
                 * -------------------------
                 */
                if (isset($id) && (isset($popup['ver']) || isset($popup['imprimir']) || isset($popup['historial']))) {
                    $div = '
                            <div class="modal fade" id="myModal">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><br />';
                    if (isset($titulo_ver)) {
                        $div .= '<h4 class="modal-title">';
                        $div .= $titulo_ver . ' ';
                        $div .= '</h4>';
                        //$div .= $id.'</h4>';
                    }
                    $div .= '
                                  </div>
                                  <div class="modal-body">
                                    <div id="datos"></div>
                                  </div>
                                  <div class="modal-footer" style="clear:both;">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                  </div>
                                </div>
                              </div>
                            </div>';
                }
            }
            $output .= '</div>';
            //$output .= '<br />';
            
            /**
             * PAGINACION
             * ----------
             */
            $pager_params = $this->Paginator->params();
            //debug($pager_params);
            $output .= '<div class="row row-centered bloque-centrado">';
            if ($pager_params['pageCount'] > 1) {              
                $output .= '<ul class="pagination">';                
                $output .= '<li>';
                $output .= $this->Paginator->first('PRIMERO', array('escape' => false, 'class' => 'pag-ajax'), null, array('escape' => false, 'class' => 'prev disabled'));
                $output .= $this->Paginator->prev('ANTERIOR', array('escape' => false, 'class' => 'pag-ajax'), null, array('escape' => false, 'class' => 'prev disabled'));
                $output .= '</li>';
                $output .= '<li>';
                //$output .= $this->Paginator->numbers(array('separator' => ' '));
                $output .= $this->Paginator->numbers(array('class' => 'numbers', 'first' => false, 'last' => false));
                $output .= '</li>';
                $output .= '<li>';
                $output .= $this->Paginator->next('SIGUIENTE', array('escape' => false, 'class' => 'pag-ajax'), null, array('escape' => false, 'class' => 'next disabled'));
                $output .= $this->Paginator->last('ULTIMO', array('escape' => false, 'class' => 'pag-ajax'), null, array('escape' => false, 'class' => 'next disabled'));
                $output .= '</li>';
                $output .= '</ul>';
                
            }
            $total = $this->Paginator->counter('Total de registros: '.$pager_params['count']);
            $output .= '<div align="center">' . $total . '</div>';
            $output .= '</div>';
            $output .= '<div class="clear"><br /></div>';
            if (isset($div)) {
                $output .= $div;
            }
            
            /**
             * CODIGOS DE JAVASCRIPT
             * --------------------
             */
            $output .= '<script type="text/javascript">
                         $(document).ready(function() {

                             $(".pag-ajax").on( "click", function(event) {
                                 $("#content").loading();
                                 window.history.pushState("object or string", "Consulta OMC", $(this).attr("href"));
                                 event.preventDefault();
                                 $( "#content" ).load( $(this).attr("href"), function( response, status, xhr ) {
                                      $("#content").loading("stop");
                                      if ( status === "error" ) {
                                              login_popup();
                                      }
                                  });
                              });  });';
            if (isset($botones['eliminar'])) {
                $output .= '
                         function eliminar(url,id,valor) {

                            bootbox.confirm("¿';
                if (isset($titulo_eliminar)) {
                    $output .= $titulo_eliminar;
                } else {
                    $output .= 'Está seguro de eliminar el registro';
                }

                if (isset($descripcion)) {
                    $output .= ': "+valor+"?"';
                } else {
                    $output .= ' # "+id+"?"';
                }

                $output .= ', function(result) {
                                if (result) {

                                    document.location.href = url+id;
                                }
                            });
                        }
                         function aviso_activo(url) {

                            bootbox.confirm("Si guarda los datos editados estos quedaran activos"
                                , function(result) {
                                if (result) {
                                    document.location.href = url;
                                }
                            });
                        }';
            }
            $output .= '
                         function ver(url) {
                            $("div#cargando").show();
                            $.ajax({
                                 type: "POST",
                                 url: url,
                                 success: function(data) {
                                      $("#datos").html(data);
                                      $("div#cargando").hide();
                                      $("#myModal").modal("show");
                                 }
                            });
                        }';
            $output .= '
                         function editar(url) {
                            $.ajax({
                                 type: "POST",
                                 url: url,
                                 success: function(data) {
                                      $("#datos").html(data);
                                 }
                            });';
            if (isset($div)) {
                $output .= '$("#myModal").modal("show");';
            }
            $output .= '}
                    </script>';
            if ($return) {return ($output);} else { $this->p($output);}
        }
    }
    
    public function autocomplete($nombre, $valor, $id, $url, $placeholder = null, $destino1 = null, $destino2 = null, $opciones = null)
    {
        $perfilDefault                 = $this->getView()->getRequest()->getSession()->read('PerfilDefault');
        $accionesPermitidasPorPerfiles = $this->getView()->getRequest()->getSession()->read('RbacAcciones');
        $accionesPermitidas            = $accionesPermitidasPorPerfiles[$perfilDefault];
        $output                        = '';
        if (isset($nombre) && isset($id)) {
            $output = '<input type="text" name="' . $nombre . '" id="' . $id . '" value="' . $valor . '" class="form-control ui-autocomplete-input" placeholder="' . $placeholder . '"/>';
            if ($id) {
                $output .= '<script type="text/javascript">
                $("#' . $id . '").autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "' . $url . '",
                            type: "POST",
                            dataType: "json",
                            data: {' . $nombre . ': request.term},
                            success: function (data) {
                                response($.map(data, function(item) {
                                    return {
                                        label: item.label,
                                        value: item.value
                                    };
                                }));
                            }
                        });
                    },
                    minLength: 1,';
                if (isset($destino1)) {
                    $output .= '
                        select: function(event, ui) {
                            $("#' . $destino1 . ').val(ui.item.label.split(",")[1].trim().split(" ")[0].trim());';
                    if (isset($destino2)) {
                        $output .= '$("#' . $destino2 . ').val(ui.item.label.split(",")[0].trim());';
                    }
                    $output .= '};';
                }
                $output .= '});
                    </script>';
            } else {
                $output = '<script type="text/javascript">$("#' . $id . ').autocomplete("destroy");</script>';
            }
            $this->p($output);
        }
    }
    public function array_controles($nombre, $id, $valores)
    {
        $output = '';
        if (isset($nombre) && isset($id)) {
            $numfila = 0;
            if (isset($valores)) {
                if (count($valores) > 0) {
                    foreach ($valores as $key => $dato) {
                        $array_datos .= "{'" . $nombre . "_#index#_" . $key . "':'" . $dato . "'},";
                        $numfila++;
                    }
                }
            }

            $output = '
                <input id="' . $nombre . "_#index#_" . $key . '" name="data[' . $nombre . '][#index#][' . $key . ']" type="text" />
                <script type="text/javascript">
                    $(function () {
                        $("#' . $id . '").sheepIt({
                            separator: "",
                            allowRemoveLast: true,
                            allowRemoveCurrent: true,
                            allowRemoveAll: true,
                            allowAdd: true,
                            allowAddN: true,
                            maxFormsCount: 20,
                            minFormsCount: 1,';
            if ($numfila == 0) {
                $output .= 'iniFormsCount: 1,';
            } else {
                $output .= 'iniFormsCount: ' . ($numfila - 1) . ',
                            indexFormat:"#index#",';
            }

            if (count($valores) > 0) {
                $output .= 'data: [' . $array_datos . ']
                        });
                </script>';
            }

        }
    }

    // Transforma todos los valores del array que tengan formato y-m-d a d/m/y
    public function fechas_a_dmy($item_info)
    {

        foreach ($item_info as $modelo => $datos) {
            foreach ($datos as $keyname => $keyvalue) {
                if (!is_array($keyvalue)) {
                    // Si el valor tiene formato YYYY-mm-dd, lo pasa a d/m/YYYY
                    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $keyvalue)) {
                        $item_info[$modelo][$keyname] = date("d/m/Y", strtotime($keyvalue));
                    }
                }
            }
        }
        return $item_info;
    }

}
