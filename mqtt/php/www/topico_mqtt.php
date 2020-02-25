<?php
/**
 * @author Chris Schalenborgh <chris.s@kryap.com>
 * @version 0.1
 */

header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");

//INSERT INTO `autohome`.`historico_mqtt` (`id`, `topico`, `valor`) VALUES (NULL, '/house/test2', '45');

$valor = $_GET['valor'];
$topico = $_GET['topico'];
$id = "";
$timestamp_servidor = (microtime(true) * 10000);

$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query = "SELECT * FROM `historico_mqtt` where topico ='{$topico}';";
mysqli_set_charset('utf8');
$data = mysqli_query($con, $query);


$numero_linha=mysqli_num_rows($data);

if($numero_linha > 0) 
{
	while($rec = mysqli_fetch_array($data)) 
	{
	$id = $rec['id'];
	}
	
	$query =  " UPDATE `autohome`.`historico_mqtt` SET `data_ms` = $timestamp_servidor , `data` = now(), `valor` = '" . $valor . "' WHERE `historico_mqtt`.`id` = '" . $id . "'";
}else 
{

	$query = "INSERT INTO `autohome`.`historico_mqtt` (`id`, `topico`, `valor`, `data_ms`) VALUES (NULL, '" . $topico . "', '" . $valor . "', '" . $timestamp_servidor . "');";
}

//echo $query;

$data = mysqli_query($con, $query);
mysqli_close($con);

?>