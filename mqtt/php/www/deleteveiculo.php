<?php
require_once("usuario/dados_bd.php");
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página


$con =  mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "0";
$query = "delete from veiculos_lpr where id=".$id;
if(mysqli_query($con, $query)) {
header("location:main.php");
} else {
echo "Impossivel Deletar!";
}
mysqli_close($con);
?>