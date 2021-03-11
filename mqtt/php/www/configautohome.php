<?php
require_once("usuario/dados_bd.php");
include("segurancaconfig.php"); // Inclui o arquivo com o sistema de segurança
include("noderedEdit.php");
include("tagoio.php");

protegePagina(); // Chama a função que protege a página
$con2 = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";
if (!is_numeric($id))
{
return;
}
$habilitado_t = 'true';
//echo "Usuario";
//echo $_SESSION['usuarioLoginadmin'];

if(isset($_POST['btn'])) 
	{
		$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
		$nome = $_POST['nome'];
		$pin = trim(strtolower ($_POST['pin']));
		$usuario = $_POST['usuario'];
		$senha = $_POST['senha'];
		$usu_bb = $_POST['usu_bb'];
		$se_bb = $_POST['se_bb'];
		$email = $_POST['email'];
		$chavedispositivo = $_POST['chavedispositivo'];
		$firmware = $_POST['firmware'];
		$ip = $_POST['ip'];
		$user_gbridge = $_POST['user_gbridge'];
		$usermqtt_gh = $_POST['usermqtt_gh'];
		$senhamqtt_gh = $_POST['senhamqtt_gh'];
		$userid_gh = $_POST['userid_gh'];
		$senha_user_gh = $_POST['senha_user_gh'];
		$apikey_gh = $_POST['apikey_gh'];
		$apikey_id = $_POST['apikey_id'];
		$nora = $_POST['nora'];
		

		
		$query = "SELECT * FROM `servidor` where id =1";
		$studentData = mysqli_query($con, $query);

		$recStudent = mysqli_fetch_array($studentData);
		$pin_old = $recStudent['pin'];
	 	$usu_bb_old = $recStudent['usu_bb'];
		$se_bb_old = $recStudent['se_bb'];
		
		if (trim($senha) == "")
		{
		$query = "update `servidor` set nome = '{$nome}', pin = '{$pin}', ip = '{$ip}', usuario = '{$usuario}', usu_bb='{$usu_bb}', se_bb='{$se_bb}', email='{$email}',  chavedispositivo='{$chavedispositivo}', user_gbridge='{$user_gbridge}', firmware='{$firmware}' , usermqtt_gh='{$usermqtt_gh}' , senhamqtt_gh='{$senhamqtt_gh}' , userid_gh='{$userid_gh}' , bearertoken='{$nora}' ,senha_user_gh='{$senha_user_gh}' , apikey_gh='{$apikey_gh}' , apikey_id='{$apikey_id}' where id = '1'";
		echo "Não Houve Modificação na Senha de Usuario";
		}
		else 
		{
		$query = "update `servidor` set nome = '{$nome}', pin = '{$pin}', ip = '{$ip}', usuario = '{$usuario}', senha = '".  md5($senha) ."',
		 usu_bb='{$usu_bb}', se_bb='{$se_bb}', email='{$email}',  chavedispositivo='{$chavedispositivo}', user_gbridge='{$user_gbridge}', firmware='{$firmware}' , usermqtt_gh='{$usermqtt_gh}' , senhamqtt_gh='{$senhamqtt_gh}' , userid_gh='{$userid_gh}' , bearertoken='{$nora}' , senha_user_gh='{$senha_user_gh}' , apikey_gh='{$apikey_gh}' , apikey_id='{$apikey_id}' where id = '1'";
		}

		// Criar o Arquivo do
		$txt = 
		'{
			"nome" : "' . $nome . '",
			"pin" : "' . $pin . '",
			"ip" : "' . $ip . '"
		}';

		$endereco = "/home/node/app/configs/";
		$file_name = "config.json";
		$myfile = fopen($endereco . $file_name, 'w') or die('Unable to open file!');
		fwrite($myfile, $txt);
		fclose($myfile);
		

	
	//	echo $query;
		if(mysqli_query($con, $query))
				{
			//	$output = shell_exec("sudo mosquitto_passwd  /etc/mosquitto/pwfile" . $usu_bb . $se_bb);
			if (($usu_bb_old != $usu_bb) || ($se_bb_old != $se_bb) )
			{
				$nova_senha_mqtt = nova_senha_mqtt($usu_bb, $se_bb);
				$padrao_senha_mqtt = nova_senha_mqtt("autodomumhomekit", "$homekit_#123456$");
			//	echo	$nova_senha_mqtt;
			//	echo  $padrao_senha_mqtt;
			$shell_senha1 = "sed -i '3d' /etc/mosquitto/config/pwfile";
			$shell_senha2 = "echo '" . $nova_senha_mqtt . "' >> /etc/mosquitto/config/pwfile";
			//$shell_senha3 = "sudo sed -i 's/{$se_bb_old}/{$se_bb}/g' /home/pi/wiringPi/wiringPi/myscript.js";
			//$shell_senha4 = "sudo sed -i 's/{$usu_bb_old}/{$usu_bb}/g' /home/pi/wiringPi/wiringPi/myscript.js";
		//	echo $shell_senha3;
			$output = shell_exec($shell_senha1);
			$output = shell_exec($shell_senha2);
	//		$output = shell_exec($shell_senha3);
	//		$output = shell_exec($shell_senha4);
			}
			
			
			
			if ($pin_old != $pin)
			{
			$shell_pin = "sudo sed -i 's/{$pin_old}/{$pin}/g' /home/pi/.node-red/projects/AutoDomum_Local/flow_Autodomum.json";


			$output = shell_exec($shell_pin);
		//	echo $shell_pin;
			}
				$msg = "Alteração Salva";
				} 
		else 
				{
				$msg = "Erro na Atualização";
				}
	mysqli_close($con);
	updateFluxo();  //Atualiza o Fluxo NodeRed
	updateFluxoTago();
	}

$query = "SELECT * FROM `servidor` where id =1";
$studentData = mysqli_query($con2, $query);
#mysqli_close($con);
$recStudent = mysqli_fetch_array($studentData);

		if($recStudent['habilitado'] == 1)
		{
			$habilitado_t = 'checked';
		}else 
		{
			$habilitado_t = '';
		}
		
mysqli_close($con2);		

?>

<html>
<head>
<link href="/css/main.css" rel="stylesheet" type="text/css"/> 
<link href="/css/w3.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn').click(function () {
     //       window.opener.location.reload(true);
     //       window.close();
        });
    });
</script>

<div class="form">
<h5>Depois de Modificar click no botão "Atualizar" e depois "Fecha"</h5>

<form class="w3-container w3-card-4" method="POST">

<label class="w3-label w3-text-blue"><b>Nome</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['nome']; ?>" name="nome"/> <br/>
<label class="w3-label w3-text-blue"><b>Número Serial</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo  strtoupper ($recStudent['pin']); ?>" name="pin"/> <br/>
<label class="w3-label w3-text-blue"><b>IP</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo  strtoupper ($recStudent['ip']); ?>" name="ip"/> <br/>
<label class="w3-label w3-text-blue"><b>Usuario</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['usuario']; ?>" name="usuario"/> <br/>
<label class="w3-label w3-text-blue"><b>Senha</b></label>
<input type='text' class='w3-input w3-border' value="" name="senha"/> <br/>
<label class="w3-label w3-text-blue"><b>Usuario MQTT</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['usu_bb']; ?>" name="usu_bb"/> <br/>
<label class="w3-label w3-text-blue"><b>Senha MQTT</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['se_bb']; ?>" name="se_bb"/> <br/>
<label class="w3-label w3-text-blue"><b>E-mail</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['email']; ?>" name="email"/> <br/>
<label class="w3-label w3-text-blue"><b>Chave Dispositivo</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['chavedispositivo']; ?>" name="chavedispositivo"/> <br/>
<!-- <label class="w3-label w3-text-blue"><b>UserMqtt Gbridge</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['usermqtt_gh']; ?>" name="usermqtt_gh"/> <br/>
<label class="w3-label w3-text-blue"><b>Chave Gbridge</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['user_gbridge']; ?>" name="user_gbridge"/> <br/>
<label class="w3-label w3-text-blue"><b>Senha MQTT Gbridge </b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['senhamqtt_gh']; ?>" name="senhamqtt_gh"/> <br/>
<label class="w3-label w3-text-blue"><b>User ID Gbridge <?php echo "- (Usuario: " . strtoupper ($recStudent['pin']) . " )"; ?> </b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['userid_gh']; ?>" name="userid_gh"/> <br/> -->
<!-- <label class="w3-label w3-text-blue"><b>Senha Usuario Gbridge <?php echo "- (Usuario: " . strtoupper ($recStudent['pin']) . " )"; ?> </b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['senha_user_gh']; ?>" name="senha_user_gh"/> <br/>

<label class="w3-label w3-text-blue"><b>ID ApiKey Gbridge</b></label> -->
<!-- <input type='text' class='w3-input w3-border' value="<?php echo $recStudent['apikey_id']; ?>" name="apikey_id"/> <br/> -->

<label class="w3-label w3-text-blue"><b>TAGO.io</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['apikey_gh']; ?>" name="apikey_gh"/> <br/>

<label class="w3-label w3-text-blue"><b>Token Google Home (Nora)</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['bearertoken']; ?>" name="nora"/> <br/>

<label class="w3-label w3-text-blue"><b>Firmware</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['firmware']; ?>" name="firmware"/> <br/>
<input type="submit" class= "w3-btn w3-blue" id='btn' name='btn' value='Salva' /><br><p>
<?php echo $msg; ?>
</form>
</div>

<a href="javascript: void(0);" onclick="window.open('system_restart.php', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=150');"><img src="/png/64/system_restart.png">Redefinir Sistema</a>
<a href="javascript: void(0);" onclick="window.open('/config/configdispositivo.php');"><img src="/png/64/configdevice.png">Configurar Dispositivos</a>
<!-- <a href="javascript: void(0);" onclick="window.open('/config/reboot.php');"><img src="/png/64/reboot.png">Reiniciar Sistema</a> -->
<!-- <a href="javascript: void(0);" onclick="window.open('/config/googlehomesicroniza.php');"><img src="/png/64/googlehome.png">Sincroniza Google Home</a> -->
<a href="javascript: void(0);" onclick="window.open('/config/baixaconfiguracao.php', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=600');"><img src="/png/64/data-configuration.png">Adicionar Dispositivo</a>
</body>
</html>

<?php

function nova_senha_mqtt($username_new, $password_new)
{
$username= $username_new;
$password= $password_new;
$salt=gerarSenha(12, 8);
$salt_base64=base64_encode($salt);
$hash=hash("sha512",$password . $salt, true);
$hash_base64=base64_encode($hash);
$novo_pwfile = $username.":$6$".$salt_base64."$".$hash_base64."";
return $novo_pwfile;
}



function gerarSenha($tamanho=12, $forca=0) {
    $vogais = 'aeiouy';
    $consoantes = 'bdghjmnpqrstvz';
    if ($forca >= 1) {
        $consoantes .= 'BDGHJLMNPQRSTVWXZ';
    }
    if ($forca >= 2) {
        $vogais .= "AEIOUY";
    }
    if ($forca >= 4) {
        $consoantes .= '0123456789';
    }
    if ($forca >= 8 ) {
        $vogais .= 'LMY0';
    }
 
    $senha = '';
    $alt = time() % 2;
    for ($i = 0; $i < $tamanho; $i++) {
        if ($alt == 1) {
            $senha .= $consoantes[(rand() % strlen($consoantes))];
            $alt = 0;
        } else {
            $senha .= $vogais[(rand() % strlen($vogais))];
            $alt = 1;
        }
    }
    return $senha;
}
		
?>