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


$servidor = $_POST['servidor']; // Codigo do Servidor do Cliente;
$timestamp = $_POST['timestamp']; // Datatime do dados;
$hash = $_POST['hash']; // hash enviado pelo cliente
//echo $hash .  "<br>";
$imei_cliente = $_POST['imei_cliente'];
$email = $_POST['email']; // Datatime do dados;






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
	//	echo $query .  "<br>";
		$dadosdobanco = mysqli_query($cnx, $query);
		
	
		
			$email='Abestado@naodeu.com.br';
		
		
			while($rec = mysqli_fetch_array($dadosdobanco)) 
			{
			  $habilitado = $rec['habilitado'];
			  $id_usuario = $rec['id'];
			  $administrador = $rec['administrador'];
			  $email = $rec['email'];
			}

		}
		
		if ($habilitado == 1)
		{
		  $md5 = $numeroserial . $timestamp . $chavedispositivo . $imei_cliente . $email . "salgadinhodelocal";
		//  echo $md5 . "<br>";
			$hash_do_bancodedados = md5($md5);
	//	  echo $hash_do_bancodedados  . "<br>";
		}
		
		

//	SELECT widget.id, widget.Descricao, widget.tipo_geral, 	 ambiente.Descricao ambiente, widget.setName0, widget.setName1, widget.setName2 FROM widget, usuario_widget, ambiente WHERE usuario_widget.id_widget = widget.id AND widget.ambiente = ambiente.id AND id_usuario = 15 AND usuario_widget.habilitado = 1

if(trim($chavedispositivo) == "") 
{
	$hash_do_bancodedados = $hash;
}


if ($hash == $hash_do_bancodedados)
	{
	status_remoto ($timestamp);
	}
else 
	{
	echo "NOK";
	}
	


function status_remoto ($timestamp)
	{

		global $DB_SERVER;
		global $DB_USER;
		global $DB_PASS;
		global $DB_NAME;
		
$timestamp = $timestamp - 1000000;   // 100 segudos de diferença
//$timestamp = 0;
		$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
		$query = "SELECT * FROM `historico_mqtt` WHERE data_ms > {$timestamp} ORDER BY `id` ASC";
		//$query = "SELECT `widget`.* FROM `servidor`, `widget` where 1=1  order by ordem asc";
	//	echo $query;


//echo $query;

//mysqli_set_charset('utf8');
mysqli_set_charset($cnx,"utf8");
$res = mysqli_query($cnx, $query);
if (!$res) {
  die('Invalid query: ' . mysqli_error());
}


$rows = array();
while($r = mysqli_fetch_assoc($res)) {
    $rows[] = $r;
}
//print json_encode($rows);

$JSONENCODER  = json_encode($rows);

//echo '<html><head><title>STOK</title></head></html>';
echo '{"Status":' . $JSONENCODER . '}';


mysqli_close($cnx);

}

mysqli_close($cnx);

?>
