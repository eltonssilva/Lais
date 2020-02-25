<?php
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "0";
$query = "DELETE FROM `autohome`.`nivel` WHERE `nivel`.`id` = {$id}";
if(mysqli_query($con, $query)) {
//header("location:insertnivel.php");
} else {
echo "Impossivel Deletar!";
}
$query = "UPDATE `autohome`.`ambiente` SET `codigo` = '1' WHERE `ambiente`.`codigo` = {$id};";
mysqli_query($con, $query);
echo $query;
mysqli_close($con);
?>