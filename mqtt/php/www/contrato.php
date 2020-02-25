<?php
header("Content-Type: text/html; charset=UTF-8",true);

//include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");
//protegePagina(); // Chama a função que protege a página


echo $DB_PASS;

// Opens a connection to a MySQL server
$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME ) 
		or die("Could not connect: " . mysql_error());
					  
////**************************

// Select all the rows in the markers table
$senha=md5(anti_injection($_POST["auth_pw"]) . $salgadinho);
$email = $_POST['auth_user']; // Parametro passado pelo javascripo informado o codigo do veiculo
$nome = $_POST['auth_user']; // Parametro passado pelo javascripo informado o codigo do veiculo

//echo $id_m . '<br>';
//echo $id_cliente . '<br>';
//echo $cliente. '<br>';
$query = '';


		if (0 == 0)
		{
		$query = "Select id, email, nome, data_termo, ok_termo from cliente where senha = '{$senha}' and (email='{$email}' or apelido='{$nome}')";
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
	if($result->num_rows > 0){
 $rs = array();
 while($row = mysqli_fetch_assoc($result)) {
    // you don´t really need to do anything here.
    $nome =  $row['nome'] . ";";
    $ok_termo =  $row['ok_termo'];
    echo "<html><head><title>{$nome}{$ok_termo}</title></head></html>";

  }
// echo json_encode($rs,  JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}else 
{
echo "<html>
<head>
<title>erro</title>
</head>
</html>";
}
}

mysqli_close($cnx);
?>
