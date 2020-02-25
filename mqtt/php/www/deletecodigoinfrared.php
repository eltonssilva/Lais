<?php
// Tamberm serve para TV
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "0";
$id_dispositivo = $_GET['id_dispositivo'];
$query = "DELETE FROM `controle_ir` WHERE `controle_ir`.`id` = {$id}";
if(mysqli_query($con, $query)) {
header("location:tabelacodigo.php?id={$id_dispositivo}");
} else {
echo "Impossivel Deletar!";
}



mysqli_close($con);
?>