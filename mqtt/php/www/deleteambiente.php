<?php
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "0";
$query = "DELETE FROM `autohome`.`ambiente` WHERE `ambiente`.`id` = {$id}";
if(mysqli_query($con, $query)) {
header("location:insertambiente.php");
} else {
echo "Impossivel Deletar!";
}
$query = "UPDATE `autohome`.`widget` SET `ambiente` = '1' WHERE `widget`.`ambiente` = {$id};";
mysqli_query($con, $query);
mysqli_close($con);
?>