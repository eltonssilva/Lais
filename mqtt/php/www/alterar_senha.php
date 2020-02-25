<!DOCTYPE html>
<html dir="ltr" lang="pt-BR" style=""><head>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>AutoHome</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<link href="/css/main.css" rel="stylesheet" type="text/css"/> 
<link href="/css/w3.css" rel="stylesheet" type="text/css"/> 
</head>
<body>
<?php
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página


//Variavel $cliente setada na sessão no include de segurança

$nova=$_POST["nova"];
$repita=$_POST["repita"];
$usuario = $_POST["usuario"];
$usuariologin = $_SESSION['usuarioLogin'];

//echo "Senha " . $nova . " " . $repita . " " . $usuario;

$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
if (!$con)
  {
	die('Could not connect: ' . mysqli_error());
  }


if ($nova != "" && $repita != "")
{

	
	if($nova != $repita)
	{
		echo "Error: As duas Senha não são iguais  <p> ";
		echo '<button class="w3-btn w3-blue" onclick="' . "window.location.href='/main.php'" . '">Voltar</button>';
		die('</body></html>');
	}
	
		$query ="UPDATE servidor set usuario = '{$usuario}', senha = '".  md5($nova) ."' WHERE usuario = '{$usuariologin}'";
	//	$mudou = mysql_query("UPDATE cliente set senha = '".md5($nova . $salgadinho)."' WHERE id = '$cliente'", $con);
		$mudou = mysqli_query($con, $query);
	//	echo $query;
	
	if (!$mudou)
		{
			die('Error: ' . mysqli_error());
		}
		else
		{
			$_SESSION['usuarioLogin'] = $usuario;
		echo "Senha Alterada com sucesso. <p> ";
		echo '<button class="w3-btn w3-blue" onclick="' . "window.location.href='/main.php'" . '">Voltar</button>';
	//	die('</body></html>');
			
		}
} else {
	echo "Existem campos obrigatórios em branco! <p>";
	echo '<button class="w3-btn w3-blue" onclick="' . "window.location.href='/main.php'" . '">Voltar</button>';
}

mysqli_close($con);
?>
</body></html>