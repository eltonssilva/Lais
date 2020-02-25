<?php
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "0";
$query = "DELETE FROM `autohome`.`ifttt` WHERE `ifttt`.`id` = {$id}";

if($id == "d1")
{
$query = "DELETE FROM `autohome`.`ifttt` WHERE `ifttt`.`tipo_acao` = '1'";	
}
else if($id == "d2")
{
$query = "DELETE FROM `autohome`.`ifttt` WHERE `ifttt`.`tipo_acao` = '2'";
}
else if($id == "d3")
{
$query = "DELETE FROM `autohome`.`ifttt` WHERE `ifttt`.`tipo_acao` = '3'";
}

if(mysqli_query($con, $query)) {
header("location:main.php");
} else {
echo "Impossivel Deletar!";
}
mysqli_close($con);
?>