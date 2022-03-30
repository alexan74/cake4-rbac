<?php
$lines = explode("\n", $content);

foreach ($lines as $line) :
echo '<p> ' . $line . "</p>\n";
endforeach;
?>