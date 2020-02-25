<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");


//$_POST['servidor']
//$result = GetDeviceSpecificInfor('c4ca4238a0b92387', 'a97f3afb1f2f49e372a5600e3e5af626');


function SaveDates($result)
{
	// Tipo 0 - Limpa Todos os device_id_kappelt (Zera) do Banco de dados
	// Tipo 1 - Save Token
	// Tipo 2 - Save Date Device
	
		global $DB_SERVER;
		global $DB_USER;
		global $DB_PASS;
		global $DB_NAME;
		global $id;
		
	
			$id =  $Jsonresult[0]['id'];
			$Jsonresult = json_decode($result, TRUE);;
		   $numeroserial =  $Jsonresult[0]['numeroserial'];
		   $chavelocal =  $Jsonresult[0]['chavelocal'];
		 //  $chavedispositivo =  $Jsonresult[0]['chavedispositivo'];
		   $chavedispositivo = gerarSerial(12,4);
		   $nome =  $Jsonresult[0]['nome'];
		   $email =  $Jsonresult[0]['email'];
		   $userid_gh =  $Jsonresult[0]['userid_gh'];
		   $user_gbridge =  "u" . $Jsonresult[0]['userid_gh'];
		   $apikey_gh =  $Jsonresult[0]['apikey_gh'];
		   $apikey_id =  $Jsonresult[0]['apikey_id'];
		   $usermqtt_gh =  $Jsonresult[0]['usermqtt_gh'];
		   $senha =  $Jsonresult[0]['senha'];
		   $senhamqtt_gh =  $Jsonresult[0]['senhamqtt'];

		
	
				$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
				$query = "UPDATE `servidor` SET 
				`pin` = '{$numeroserial}', 
				`chavelocal` = '{$chavelocal}',
				`chavedispositivo` = '{$chavedispositivo}',
				`nome` = '{$nome}',
				`email` = '{$email}',
				`userid_gh` = '{$userid_gh}',
				`user_gbridge` = '{$user_gbridge}',
				`apikey_gh` = '{$apikey_gh}',
				`apikey_id` = '{$apikey_id}',
				`usermqtt_gh` = '{$usermqtt_gh}',
				`senha_user_gh` = '{$senha}',
				`senhamqtt_gh` = '{$senhamqtt_gh}'
				WHERE `servidor`.`id` = 1;";
				
		//		echo $query;
					if(mysqli_query($cnx, $query)) 
					{
					//	header("location:sincronizargooglehome.php?id={$id}");
					} 
					else 
					{
						echo "Erro!";
					}

					mysqli_close($cnx);

}




function GetDeviceSpecificInfor($pin, $token)
{

	$url = 'https://www.autodomo.com.br/post_get/gettoken.php';
$data = array('pin' => $pin, 'token' => $token);
	$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    	)
	);
    $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
//	$Jsonresult = json_decode($result);
//	return  $Jsonresult->{'access_token'};
//	if ($result === FALSE) { echo "Erro"; }
	$status_line = $http_response_header[0];
    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
    $status = $match[1];
    if ($status == 200)
    {
    	SaveDates($result);
    	echo "Configuração Atualizada";
    }
    else 
    {
    	echo "Erro de Configuração";
		}
    	
}

function gerarSerial($tamanho, $forca) {
	$vogais = '0123456789';
	$consoantes = 'abcdefghijklmnopqrstuvwxyz';
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
			$vogais .= '';
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


