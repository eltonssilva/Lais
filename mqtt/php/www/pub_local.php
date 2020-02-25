<?php
header("Content-Type: text/html; charset=UTF-8",true);

//include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");
//protegePagina(); // Chama a função que protege a página




// Opens a connection to a MySQL server
$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME ) 
		or die("Could not connect: " . mysql_error());
					  
////**************************

// Select all the rows in the markers table




$email = $_REQUEST['email']; // Datatime do dados;
$servidor = $_REQUEST['servidor']; // Codigo do Servidor do Cliente;
$timestamp = $_REQUEST['timestamp']; // Datatime do dados;
$topico = $_REQUEST['topico']; // topico para enviar o comando
$comando = $_REQUEST['comando']; // comando propriamente dito
$hash = $_REQUEST['hash']; // hash enviado pelo cliente
$imei_cliente = $_REQUEST['imei_cliente'];
$reter = $_REQUEST['reter'];
$timestamp_servidor = (microtime(true) * 10000);

//echo $timestamp . "<br>";
//echo $timestamp_servidor . "<br>";

$timestamp_servidor = $timestamp;

if ($timestamp_servidor > $timestamp) 
{
	$diferenca_timestamp = ($timestamp_servidor - $timestamp);
}
else 
{
	$diferenca_timestamp = ($timestamp - $timestamp_servidor);
}


$query = "SELECT pin, chavedispositivo, usu_bb, se_bb FROM `servidor` where pin = '$servidor'";


$dadosdobanco = mysqli_query($cnx, $query);

$confirma1 = false;
$chavedispositivo;
$numeroserial;
$habilitado = 0;
$hash_do_bancodedados = "";
$id_usuario = 0;
$administrador = "0";
$usuario;
$senha;

while($rec = mysqli_fetch_array($dadosdobanco)) {
$confirma1 = true;
$chavedispositivo = $rec['chavedispositivo'];
$numeroserial = $rec['pin'];
$usuario = $rec['usu_bb'];
$senha = $rec['se_bb'];
}


 
		if ($confirma1)
		{
		$query = "SELECT id, email, administrador, habilitado FROM `usuario` where imei = '$imei_cliente' AND email = '$email'";
	//	echo $query;
		$dadosdobanco = mysqli_query($cnx, $query);
		
			while($rec = mysqli_fetch_array($dadosdobanco)) 
			{
			  $habilitado = $rec['habilitado'];
			  $id_usuario = $rec['id'];
			  $administrador = $rec['administrador'];
			}

		}
		
		if ($habilitado == 1)
		{
		  $md5 = $numeroserial . $timestamp . $chavedispositivo . $imei_cliente . $email . "salgadinhodelocal";
//		  echo $md5 . "<br>";
			$hash_do_bancodedados = md5($md5);
//		  echo $hash_do_bancodedados  . "<br>";
		}
		
		

//	SELECT widget.id, widget.Descricao, widget.tipo_geral, 	 ambiente.Descricao ambiente, widget.setName0, widget.setName1, widget.setName2 FROM widget, usuario_widget, ambiente WHERE usuario_widget.id_widget = widget.id AND widget.ambiente = ambiente.id AND id_usuario = 15 AND usuario_widget.habilitado = 1

if(trim($chavedispositivo) == "") 
{
	$hash_do_bancodedados = $hash;
}



if (($hash == $hash_do_bancodedados) && ($diferenca_timestamp <= 10000000))
	{
	pub_local ($usuario, $senha, $topico, $comando, $reter);
	}
else 
	{
	echo "NOP";
	echo '<html><head><title>NOK</title></head></html>';
	}
	


function pub_local ($usuario, $senha, $topico, $comando, $reter)
{

if($reter==1) {$reterned = '-r';};
//$output = shell_exec("mosquitto_pub               -d -u {$usuario} -P {$senha} -t '{$topico}' -m '{$comando}'  -q 1 {$reterned}");
$output = shell_exec("mosquitto_pub -h mqttautodomo -d -u {$usuario} -P {$senha} -t '{$topico}' -m '{$comando}' -q 1 {$reterned}");
//echo $output;
echo "OKP";
echo '<html><head><title>OKP</title></head></html>';
}
mysqli_close($cnx);

?>
