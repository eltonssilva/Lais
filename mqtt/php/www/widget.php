<?php
header("Content-Type: text/html; charset=UTF-8",true);

//include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");
//protegePagina(); // Chama a função que protege a página


function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

// Opens a connection to a MySQL server
$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME ) 
		or die("Could not connect: " . mysql_error());
					  
////**************************

// Select all the rows in the markers table
$bem_imei = $_GET['pin']; // Parametro passado pelo javascripo informado o codigo do veiculo

//echo $id_m . '<br>';
//echo $id_cliente . '<br>';
//echo $cliente. '<br>';
$query = '';


		if (0 == 0)
		{
		$query = "SELECT `widget`.* FROM `servidor`, `widget` where `widget`.`habilitado` = '1' and pin = '{$_GET['pin']}' order by ordem asc";
		//$query = "SELECT `widget`.* FROM `servidor`, `widget` where 1=1  order by ordem asc";
	//	echo $query;
		}

//echo $query;

//mysqli_set_charset('utf8');
mysqli_set_charset($cnx,"utf8");
$res = mysqli_query($cnx, $query);
if (!$res) {
  die('Invalid query: ' . mysql_error());
}

recordSetToJson($res);

function recordSetToJson($result) {
 $rs = array();
 while($row = mysqli_fetch_assoc($result)) {
    // you don´t really need to do anything here.
    $rs[] = $row;
  }
 echo json_encode($rs,  JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
 //return json_encode($rs);
}

mysqli_close($cnx);
?>
