<?php
// Tamberm serve para TV
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "0";
$marca = isset($_REQUEST['marca']) ? $_REQUEST['marca'] : "0";
$query = "DELETE FROM `autohome`.`equipamento_infrared` WHERE `equipamento_infrared`.`id` = {$id}";

if(mysqli_query($con, $query)) {
//header("location:main.php");
} else {
echo "Impossivel Deletar!";
}
$query = "DELETE FROM `autohome`.`controle_ir` WHERE `controle_ir`.`dispositivo` = {$id}";
if(mysqli_query($con, $query)) {

$query = "UPDATE `autohome`.`widget` SET `setPrimaryColor3` = '0', `label` = '', `label2` = '' WHERE `widget`.`setPrimaryColor3` = {$id};";
mysqli_query($con, $query);


$query =   "UPDATE `widget` SET `label` = '', `label2` = '' WHERE REPLACE(`widget`.`username_iphone`, ':', '') = '{$marca}'";
mysqli_query($con, $query);
mysqli_close($con);
header("location:main.php");
} else {
echo "Impossivel Deletar!";
}


?>