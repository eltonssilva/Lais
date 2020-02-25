<?php

header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");
//include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
//protegePagina(); // Chama a função que protege a página
//echo "Olá, " . $_SESSION['usuarioLogin'];

//usuario_habilitado.php

$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);

$habilitado = $_POST['habilitado'];
$somente_local = $_POST['somente_local'];
$administrador = $_POST['administrador'];
$id = $_POST['id'];



$query = "UPDATE `autohome`.`usuario` SET `administrador` = '$administrador', `habilitado` = '$habilitado', `somente_local` = '$somente_local' WHERE `usuario`.`id` = '$id';";

echo $query;

// UPDATE `autohome`.`usuario` SET `habilitado` = '1', `somente_local` = '1' WHERE `usuario`.`id` = 36;
mysqli_set_charset('utf8');
$data = mysqli_query($con, $query);



mysqli_close($con);




?>