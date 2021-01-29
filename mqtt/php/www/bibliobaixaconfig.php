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
		
	
			$id =  $Jsonresult['id'];
			$Jsonresult = json_decode($result, TRUE);;
		   $numeroserial =  $Jsonresult['numeroserial'];
		   $chavelocal =  $Jsonresult['chavelocal'];
		   $chavedispositivo =  $Jsonresult['chavedispositivo'];
		  // $chavedispositivo = gerarSerial(12,4);											//Para Gerar Chave Aleatoria
		   $nome =  $Jsonresult['nome'];
		   $email =  $Jsonresult['email'];
		   $userid_gh =  $Jsonresult['userid_gh'];
		   $user_gbridge =  "u" . $Jsonresult['userid_gh'];
		   $apikey_gh =  $Jsonresult['apikey_gh'];
		   $apikey_id =  $Jsonresult['apikey_id'];
		   $usermqtt_gh =  $Jsonresult['usermqtt_gh'];
		   $senha =  $Jsonresult['senha'];
		   $senhamqtt_gh =  $Jsonresult['senhamqtt'];

			if ($numeroserial != "")
			{
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
					echo "Configuração Atualizada\n";
					echo "REINICIE O SISTEMA MANUALMENTE";

			}else{
				echo "Não foi possivel baixar os dados.\n";
				echo "Verifique a validade do Token.\n";
				echo "Ou entre em contato com a AutoDomo\n";
	

			}
			
	


}




function GetDeviceSpecificInfor($pin, $token)
{

	$url = "https://us-central1-autodomo-73076.cloudfunctions.net/getLais?pin={$pin}&token={$token}";

  $result = file_get_contents($url);

	$status_line = $http_response_header[0];
    preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
    $status = $match[1];
    if ($status == 200)
    {
    	SaveDates($result);
    //	echo "Configuração Atualizada";
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


