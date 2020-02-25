<?php
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "0";
$query = "DELETE FROM usuario_widget WHERE id = {$id}";
echo $query;
if(mysqli_query($con, $query)) {
header("location:usuario_ambiente.php");
} else {
echo "Impossivel Deletar!";
}
mysqli_close($con);
?>