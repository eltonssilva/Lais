<?php
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "0";
$query = "DELETE FROM `associar_widget` WHERE `associar_widget`.`id` = {$id}";
if(mysqli_query($con, $query)) {
header("location:agrupa_dispositivo.php");
} else {
echo "Impossivel Deletar!";
}
mysqli_close($con);
?>