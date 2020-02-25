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

//$servidor = $_POST['servidor']; // Codigo do Servidor do Cliente;
//$hash = $_POST['hash']; // hash enviado pelo cliente
//$imei_cliente = $_POST['imei_cliente'];
//$timestamp = $_POST['timestamp']; // Datatime do dados;
//$email = $_POST['email']; // Datatime do dados;

$servidor = $_REQUEST['servidor']; // Codigo do Servidor do Cliente;
$hash = $_REQUEST['hash']; // hash enviado pelo cliente
$imei_cliente = $_REQUEST['imei_cliente'];
$timestamp = $_REQUEST['timestamp']; // Datatime do dados;
$email = $_REQUEST['email']; // Datatime do dados;
$superdimin = $_REQUEST['superdimin'];

if ($superdimin)
{
	$administrador = "1";
	get_widget ($id_usuario);
	return;
}


$query = "SELECT pin, chavedispositivo FROM `servidor` where pin = '$servidor'";


$dadosdobanco = mysqli_query($cnx, $query);

$confirma1 = false;
$chavedispositivo;
$numeroserial;
$habilitado = 0;
$hash_do_bancodedados = "";
$id_usuario = 0;
$administrador = "0";

while($rec = mysqli_fetch_array($dadosdobanco)) {
$confirma1 = true;
$chavedispositivo = $rec['chavedispositivo'];
$numeroserial = $rec['pin'];
}




 
		if ($confirma1)
		{
		$query = "SELECT id, email, administrador, habilitado FROM `usuario` where imei = '$imei_cliente' AND email = '$email'";
		$dadosdobanco = mysqli_query($cnx, $query);
	//	echo $query;
		
			while($rec = mysqli_fetch_array($dadosdobanco)) 
			{
			  $habilitado = $rec['habilitado'];
				$id_usuario = $rec['id'];
			 $administrador = $rec['administrador'];
			}

		}
		
		if ($habilitado == 1)
		{
		  $md5 = $numeroserial . $timestamp . $chavedispositivo . $imei_cliente . $email . $habilitado . "salgadinhodelocal";
			$hash_do_bancodedados = md5($md5);
		//	echo $md5 .  "<br>";
		}
		
		

//	SELECT widget.id, widget.Descricao, widget.tipo_geral, 	 ambiente.Descricao ambiente, widget.setName0, widget.setName1, widget.setName2 FROM widget, usuario_widget, ambiente WHERE usuario_widget.id_widget = widget.id AND widget.ambiente = ambiente.id AND id_usuario = 15 AND usuario_widget.habilitado = 1

if(trim($chavedispositivo) == "") 
{
	$hash_do_bancodedados = $hash;
}

//echo $hash_do_bancodedados .  "<br>";
//echo $hash .  "<br>";
if (!$superdimin)
{
	if ($hash == $hash_do_bancodedados)
	{
	get_widget ($id_usuario);
	}
else 
	{
	echo "NOK";
	}
	
}



function get_widget ($id_usuario)
{

		global $DB_SERVER;
		global $DB_USER;
		global $DB_PASS;
		global $DB_NAME;
		global $administrador;
		
		$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
if($administrador == "1") 
{
$query = "SELECT `widget`.*, ambiente.Descricao ambiente_nome FROM widget, ambiente WHERE  widget.ambiente = ambiente.id ORDER BY widget.ambiente ASC";
}
else 
{
$query = "SELECT `widget`.*, ambiente.Descricao ambiente_nome FROM widget, usuario_widget, ambiente WHERE usuario_widget.id_widget = widget.id AND widget.ambiente = ambiente.id AND id_usuario = $id_usuario AND usuario_widget.habilitado = 1 ORDER BY widget.ambiente ASC";
}

// echo $query;
//mysqli_set_charset('utf8');
mysqli_set_charset($cnx,"utf8");
$res = mysqli_query($cnx, $query);
if (!$res) {
  die('Invalid query: ' . mysql_error());
}



 $rs = array();
 while($row = mysqli_fetch_assoc($res)) {
    // you don´t really need to do anything here.
    $rs[] = $row;
  }
$JSONENCODER  = json_encode($rs);

echo '{"Widget":' . $JSONENCODER . '}';

 //return json_encode($rs);

mysqli_close($cnx);
}
mysqli_close($cnx);

?>
