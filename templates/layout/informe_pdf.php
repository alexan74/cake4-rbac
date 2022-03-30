<?php
header("Content-type: application/pdf");
header( "Content-Disposition: inline; filename=".$archivo.".pdf" );
echo $content_for_layout;
?>