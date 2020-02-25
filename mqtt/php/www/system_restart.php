<?php
require_once("usuario/dados_bd.php");
include("segurancaconfig.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página


if(isset($_POST['btn'])) 
{
	
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query = "delete from associar_widget where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "SELECT * FROM `servidor` where id =1";
$studentData = mysqli_query($con, $query);

$recStudent = mysqli_fetch_array($studentData);
$pin_old = $recStudent['pin'];
$usu_bb_old = $recStudent['usu_bb'];
$se_bb_old = $recStudent['se_bb'];
$usu_bb = "autodomum";
$se_bb = "123456";
$pin = "c4ca000000000000";

		
$query = "delete from controle_ir where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}


$query = "delete from ambiente where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}




$query = "delete from email where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}


$query = "delete from equipamento_infrared where id>0";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from historico_alerta where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from cena where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from ifttt where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from historico_mqtt where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from nivel where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from zigbeedevice where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from usuario_admin where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from power where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}


$query = "delete from programacao where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from pushover where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from rx433mhz where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}


$query = "delete from rx433mhz_portas where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from rx433mhz_violacao where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from sensores_instalado where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from sensoriamento where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from sms where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from usuario where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from usuario_widget where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "delete from usuario_widget where 1=1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}

$query = "UPDATE `servidor` SET nome='Tecnotend', pin='c4ca000000000000', usuario='autodomum', senha='e10adc3949ba59abbe56e057f20f883e', usuarioadmin='admin', senhaadmin='e10adc3949ba59abbe56e057f20f883e', usu_bb='autodomum',  se_bb='123456',   email='autodomum@autodomum.com.br',  chavelocal='', chavedispositivo='', 
firmware='1.06',  user_gbridge='',  userid_gh='',  apikey_gh='',  bearertoken='',  apikey_id='',  usermqtt_gh='',  senha_user_gh='',  senhamqtt_gh='' WHERE id = 1";
if(mysqli_query($con, $query)) {
} else {
echo "Impossivel Redefinir Erro 90001!";
}



		
$output = shell_exec("rm " . $endereco . "*_accessory.js");




			if (($usu_bb_old != $usu_bb) || ($se_bb_old != $se_bb) )
			{			
			$nova_senha_mqtt = nova_senha_mqtt($usu_bb, $se_bb);
			$padrao_senha_mqtt = nova_senha_mqtt("autodomumhomekit", "$homekit_#123456$");
			$shell_senha1 = "sudo sed -i '2d' /etc/mosquitto/pwfile";
			$shell_senha2 = "sudo echo '" . $nova_senha_mqtt . "' >> /etc/mosquitto/pwfile";
			$shell_senha3 = "sudo sed -i 's/{$se_bb_old}/{$se_bb}/g' /home/pi/wiringPi/wiringPi/myscript.js";
			$shell_senha4 = "sudo sed -i 's/{$usu_bb_old}/{$usu_bb}/g' /home/pi/wiringPi/wiringPi/myscript.js";
			$output = shell_exec($shell_senha1);
			$output = shell_exec($shell_senha2);
			$output = shell_exec($shell_senha3);
			$output = shell_exec($shell_senha4);
			}
			
			if ($pin_old != $pin)
			{
			$shell_pin = "sudo sed -i 's/{$pin_old}/{$pin}/g' /home/pi/.node-red/flows_raspberrypi.json";
			$output = shell_exec($shell_pin);
		//	echo $shell_pin;
			}
			
		//	$shell_hamachi1 = "sudo systemctl stop logmein-hamachi";
		//	$shell_hamachi1 = "cd /var/lib/logmein-hamachi";
		//	$shell_hamachi1 = "sudo rm *";
		//	$shell_hamachi1 = "sudo systemctl start logmein-hamachi";
		//	$shell_hamachi1 = "sudo hamachi login";
		//	$shell_hamachi1 = "sudo hamachi attach eltonss.eng@gmail.com";
		//	$shell_hamachi1 = "sudo hamachi set-nick {$pin}";
			

$query = "delete from widget where 1=1";
if(mysqli_query($con, $query)) {
echo '<script type="text/javascript">';
echo "window.close();";
echo '</script>';
} else {
echo "Impossivel Redefinir Erro 90002!";
}

		

echo "Redefinido";
		
mysqli_close($con);
}

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
   //         window.opener.location.reload(true);
    //        window.close();
        });
    });
</script>

<div class="form">
<h5>Tem certeza que deseja redefinir o Sistema</h5>

<form class="w3-container w3-card-4" method="POST">


<input type="submit" class= "w3-btn w3-blue" id='btn' name='btn' value='Redefinir Sistema' /><br><p>
<?php echo $msg; ?>
</form>
</div>

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