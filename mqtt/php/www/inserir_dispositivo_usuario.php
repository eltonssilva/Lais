<?php
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "0";

$comprimento = strrpos($id, "-");
//echo $id;
//echo $comprimento;
$id_widget = substr($id, 0, $comprimento);
$id_usuario = substr($id, $comprimento + 1);

$query = "SELECT id FROM `usuario_widget` WHERE id_usuario = '{$id_usuario}' AND id_widget = '{$id_widget}';";
$ambiente_data = mysqli_query($con, $query);
$row = mysqli_num_rows($ambiente_data);
//echo $row;

if ($row > 0)
{
	header("location:usuario_ambiente.php");
	return;
}

$query = "INSERT INTO `usuario_widget` (`id`, `id_usuario`, `id_widget`, `habilitado`) VALUES (NULL, '{$id_usuario}', '{$id_widget}', '1');";
//echo $query;
if(mysqli_query($con, $query)) {
header("location:usuario_ambiente.php");
} else {
echo "Impossivel Deletar!";
}
mysqli_close($con);
?>