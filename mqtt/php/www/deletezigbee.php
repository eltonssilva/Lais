<?php
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "0";


$query = "DELETE FROM `autohome`.`zigbee2mqtt` WHERE `zigbee2mqtt`.`serialzigbee` = '{$serialzigbee}'";
//echo $query;
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Deletar!";
}

$query = "DELETE FROM `autohome`.`zigbeedevice` WHERE `zigbeedevice`.`id` = '{$id}'";
if(mysqli_query($con, $query)) {
header("location:main.php");
} else {
echo "Impossivel Deletar!";
}

mysqli_close($con);
?>