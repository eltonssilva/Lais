<?php
require_once("usuario/dados_bd.php");

echo $DB_SERVER . "<br>";
echo $DB_USER . "<br>";
echo $DB_PASS . "<br>";

$con2 = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con2);
$query2 = "SELECT * FROM `ambiente` where id = '1'";
//mysql_set_charset('utf8');
//echo	$query2;

mysqli_set_charset($con2,"utf8");
$res = mysqli_query($con2, $query2);
if (!$res) {
  die('Invalid query: ' . mysql_error());
}

//data2 = mysql_query($query2);
mysqli_close($con2);
while($rec2 = mysqli_fetch_array($res)) 
{ 
echo $desc_ambiente = $rec2['Descricao'];
}
?>