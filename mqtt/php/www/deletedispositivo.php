<?php
require_once("usuario/dados_bd.php");
//require_once("bibliokappelt.php");
require_once("noderedEdit.php");
require_once("noderedEditCameras.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "0";


$query = "SELECT pin, chavedispositivo, usu_bb, se_bb FROM `servidor` where 1=1";


$dadosdobanco = mysqli_query($con, $query);


$usuario;
$senha;

while($rec = mysqli_fetch_array($dadosdobanco)) {
$confirma1 = true;
$chavedispositivo = $rec['chavedispositivo'];
$numeroserial = $rec['pin'];
$usuario = $rec['usu_bb'];
$senha = $rec['se_bb'];
}


if(($id != "d1") && ($id != "d2"))
{




$query = "SELECT username_iphone, device_id_kappelt FROM `widget` where id ={$id}";
$dispositivo = mysqli_query($con, $query);
//mysql_close($con);
		
while($rec = mysqli_fetch_array($dispositivo)) 
	{ 
		$username_iphone = $rec['username_iphone']; 
		$device_id_kappelt = $rec['device_id_kappelt']; 
	}
$complememto_nome = str_replace(":","",$username_iphone);
//echo $complememto_nome;
$output = shell_exec("rm " . $endereco . $complememto_nome . "_accessory.js");
echo	$output;
	
$topico = "/house/remover/" . $complememto_nome;
$reterned = '-r';
$comando = "1";


//$output = shell_exec("mosquitto_pub               -d -u {$usuario} -P {$senha} -t '{$topico}' -m '{$comando}'  -q 1 {$reterned}");
$output = shell_exec("mosquitto_pub -h mqttautodomo -d -u {$usuario} -P {$senha} -t '{$topico}' -m '{$comando}' -q 1 {$reterned}");


//$query = "delete from sms where id=".$id;
$query = "delete from widget where id= {$id} or id_ligado = {$id}";

//echo $query;



if(mysqli_query($con, $query)) {
//	$bearertoken = Get_BearerToken_FromKapellt();    // Apagado o delete dispositivo
//	DeleteDeviceSpecific($bearertoken, $device_id_kappelt);
} else {
echo "Impossivel Deletar!";
}


$query = "delete from rx433mhz where id_widget= {$id}";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Deletar!";
}

$query = "DELETE FROM `associar_widget` WHERE `associar_widget`.`id_agrupador` = {$id}";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Deletar!";
}

$query = "DELETE FROM `zigbeedevice` WHERE `zigbeedevice`.`id_widget` = {$id}";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Deletar!";
}

//

$query = "delete from rx433mhz_persiana where id_widget= {$id}";





if(mysqli_query($con, $query)) {
header("location:main.php");
} else {
echo "Impossivel Deletar!";
}



//$query = "delete from sms where id=".$id;
$query = "delete from rx433mhz_portas where id_widget= {$id}";

//echo $query;



if(mysqli_query($con, $query)) {
	updateFluxo();  //Atualiza o Fluxo NodeRed
	updateFluxoCameras();  //Atualiza o Fluxo NodeRed das Cameras Hikv
header("location:main.php");
} else {
echo "Impossivel Deletar!";
}

} 
else if($id == "d1")
	
{
	
$query = "SELECT username_iphone FROM `widget` where 1=1";
$dispositivo = mysqli_query($con, $query);


$query = "DELETE FROM `zigbeedevice` where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Deletar!";
}

$query = "delete from rx433mhz where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Deletar!";
}

$query = "DELETE FROM `associar_widget` where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Deletar!";
}

		
while($rec = mysqli_fetch_array($dispositivo)) 
	{ 
		$username_iphone = $rec['username_iphone']; 
		$complememto_nome = str_replace(":","",$username_iphone);
		$output = shell_exec("rm " . $endereco . $complememto_nome . "_accessory.js");
		echo	$output;
	}

	$topico = "/house/remover/01AAAAAAAA";
	$reterned = '-r';
	$comando = "1";

	
	//$output = shell_exec("mosquitto_pub               -d -u {$usuario} -P {$senha} -t '{$topico}' -m '{$comando}'  -q 1 {$reterned}");
	$output = shell_exec("mosquitto_pub -h mqttautodomo -d -u {$usuario} -P {$senha} -t '{$topico}' -m '{$comando}' -q 1 {$reterned}");
	
		

//$query = "delete from sms where id=".$id;
$query = "delete from widget where  1=1";

//echo $query;



if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Deletar!";
}

//$query = "delete from sms where id=".$id;
$query = "delete from rx433mhz where 1=1";

//echo $query;



if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Deletar!";
}

//$query = "delete from sms where id=".$id;
$query = "delete from rx433mhz_persiana where 1=1";

//echo $query;



if(mysqli_query($con, $query)) {
	updateFluxo();  //Atualiza o Fluxo NodeRed
	updateFluxoCameras();  //Atualiza o Fluxo NodeRed das Cameras Hikv
header("location:main.php");
} else {
echo "Impossivel Deletar!";
}



//$query = "delete from sms where id=".$id;
$query = "delete from rx433mhz_portas where 1=1";

//echo $query;


$query = "DELETE FROM `associar_widget` WHERE 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Deletar!";
}


if(mysqli_query($con, $query)) {
	updateFluxo();  //Atualiza o Fluxo NodeRed
	updateFluxoCameras();  //Atualiza o Fluxo NodeRed das Cameras Hikv
header("location:main.php");
} else {
echo "Impossivel Deletar!";
}

//$query = "delete from sms where id=".$id;
$query = "DELETE FROM `autohome`.`ifttt` WHERE 1=1";

//echo $query;



if(mysqli_query($con, $query)) {
	updateFluxo();  //Atualiza o Fluxo NodeRed
	updateFluxoCameras();  //Atualiza o Fluxo NodeRed das Cameras Hikv
header("location:main.php");
} else {
echo "Impossivel Deletar!";
}
	

}

else if($id == "d2")  // Purga todos os dispositivo do Banco de Dados
	
{
	$topico = "/house/remover/01AAAAAAAA";
	$reterned = '-r';
	$comando = "1";
	$output = shell_exec("mosquitto_pub -h mqttautodomo -d -u {$usuario} -P {$senha} -t '{$topico}' -m '{$comando}' -q 1 {$reterned}");

	updateFluxo();  //Atualiza o Fluxo NodeRed
	updateFluxoCameras();  //Atualiza o Fluxo NodeRed das Cameras Hikv
	header("location:main.php");
}

mysqli_close($con);
?>