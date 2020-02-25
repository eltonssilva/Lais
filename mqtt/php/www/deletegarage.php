<?php
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "0";
$query = "DELETE FROM `autohome`.`rx433mhz_garage` WHERE `rx433mhz_garage`.`id` = {$id}";

if($id == "d1")
{
$query = "DELETE FROM `autohome`.`rx433mhz_garage` WHERE 1=1";
}


if(mysqli_query($con, $query)) {
header("location:main.php");
} else {
echo "Impossivel Deletar!";
}
mysqli_close($con);
?>