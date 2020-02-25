<?php
header("Content-Type: text/html; charset=UTF-8",true);

//include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");
//protegePagina(); // Chama a função que protege a página



// Opens a connection to a MySQL server


					  
////**************************

// Select all the rows in the markers table

$casa = ($_POST['casa']); // Parametro passado pelo javascripo informado o codigo do veiculo
$imei = ($_POST['imei']); // Parametro passado pelo javascripo informado o codigo do veiculo
$email =($_POST['email']); // Parametro passado pelo javascripo informado o codigo do veiculo
$fone = ($_POST['fone']); // Parametro passado pelo javascripo informado o codigo do veiculo
$token = ($_POST['token']); // Parametro passado pelo javascripo informado o codigo do veiculo

// echo $casa;
// echo $imei;
// echo $email;
// echo $fone;
// echo $token;

if (($imei == "") || ($casa == ""))
{
  $msg = '{"Status":"NK3","Habilitado":"0","Somente_local":"0","Administrador":"0"}';
  echo $msg;
  return;
}

$query = '';


		if (0 == 0)
		{
		$query = "SELECT count(*) quant, id, habilitado, somente_local, administrador FROM `usuario` where imei = '{$imei}' and email = '{$email}';";
		//$query = "SELECT `widget`.* FROM `servidor`, `widget` where 1=1  order by ordem asc";
		//echo $query;
		}

$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);

while($rec = mysqli_fetch_array($data)) { 

$quant = $rec['quant'];
$id = $rec['id'];
$habilitado = $rec['habilitado'];
$somente_local = $rec['somente_local'];
$administrador = $rec['administrador'];

//echo $quant . "-" . $id;
}

if ($quant == '0')
{
	$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
	mysqli_set_charset($con, 'utf8');


		$query = "INSERT INTO `autohome`.`usuario` (`id`, `email`,  `casa`, `administrador`,  `imei`,  `token`, `fone`, `data_criacao`, `ultimo_Acesso`, `habilitado`, `somente_local`) VALUES (NULL, '{$email}', '{$casa}', '0', '{$imei}',  '{$token}', '{$fone}', NOW(), NOW(), '0', '0');";
	//	echo $query;
		if(mysqli_query($con, $query))
				{
        $msg = '{"Status":"OK1","Habilitado":"0","Somente_local":"0","Administrador":"0"}';
				} 
		else 
				{
        $msg = '{"Status":"NK1","Habilitado":"0","Somente_local":"0","Administrador":"0"}';
				}
		mysqli_close($con);
}
else
{
		
	$con4 = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
	mysqli_set_charset($con4, 'utf8');
		$query = "UPDATE `autohome`.`usuario` SET `imei` = '{$imei}',  `token` = '{$token}', `email` = '{$email}', `casa` = '{$casa}', `fone` = '{$fone}', ultimo_Acesso= NOW() WHERE `usuario`.`id` = '{$id}'";
		if(mysqli_query($con4, $query))
				{;
      $msg = '{"Status":"OK2","Habilitado":"'. $habilitado . '","Somente_local":"' . $somente_local . '","Administrador":"' .  $administrador . '"}';
				} 
		else 
				{
        $msg = '{"Status":"NK2","Habilitado":"0","Somente_local":"0","Administrador":"0"}';
				}
		mysqli_close($con4);
}

//mysqli_set_charset('utf8');




echo $msg;
// echo json_encode($msg,  JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);


?>