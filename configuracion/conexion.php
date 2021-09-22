<?php
$bd_conexion = pg_connect("host='" . $bd_servidor . "' port='" . $bd_puerto . "' user='" . $bd_usuario . "' password='" . $bd_clave . "' dbname='" . $bd_nombre . "'") or die("No se pudo establecer la conexion con el sistema.");
?>