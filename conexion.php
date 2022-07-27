<?php
$host='localhost';
$user='root';
$password='root';
$db='ventas_cbs_mexico';

$conection= @mysqli_connect($host,$user,$password,$db);
//mysqli_close($conection);
if(!$conection){
    echo "Error en la conexion!";
}

?>