<?php
//require_once("directcall_token.php");

function directcall_envia_sms($destino_get,$texto_get, $client_secret_)

	{


/*
 * Exemplo de como enviar um sms pela API módulo de sms
 * Author: Team Developers DirectCall
 * Data: 2013-03-14
 * Referencia: http://doc.directcallsoft.com/pages/viewpage.action?pageId=524534
 */
 
// $destino_get = $_POST["destino"]; // Pega o numero de destino
// $texto_get = $_POST["texto"];  // Pega o texto de envio

// URL que será feita a requisição
$urlSms = "https://api.directcallsoft.com/sms/send";

// Numero de origem
$origem = "5598991683770";

// Numero de destino
$destino = $destino_get;

// Tipo de envio, podendo ser "texto" ou "voz"
$tipo = "texto"; 

// Texto a ser enviado
$texto = $texto_get;

// Incluir o access_token
//$access_token = $access_token_get;
$access_token = access_token_get($client_secret_);

// Formato do retorno, pode ser JSON ou XML
$format = "json";

// Dados em formato QUERY_STRING
$data = http_build_query(array('origem'=>$origem, 'destino'=>$destino, 'tipo'=>$tipo, 'access_token'=>$access_token, 'texto'=>$texto));

$ch = 	curl_init();
		curl_setopt($ch, CURLOPT_URL, $urlSms);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$return = curl_exec($ch);
		
		curl_close($ch);
		
		// Converte os dados de JSON para ARRAY
		$dados = json_decode($return, true);
		
		// Imprime o retorno
	//	echo "API: ".			$dados['api']."\n";
	//	echo "MODULO: ".		$dados['modulo']."\n";
	//	echo "STATUS: ".		$dados['status']."\n";
	//	echo "CODIGO: ".		$dados['codigo']."\n";
	//	echo "MENSAGEM: ".		$dados['msg']."\n";
	//	echo "CALLERID: ".		$dados['callerid']."\n";
		
}


function enviar_email($emailenviar ,$texto, $assunto)

	{
	   $assunto = '=?UTF-8?B?'.base64_encode($assunto).'?=';
	   $texto = utf8_decode($texto);
		$link = "http://www.tracerbr.com.br";
		$resp_auto =  "<br><br><br> <font size=2> Por favor não responda essa mensagem. Esse é um e-mail automático da TracerBr! Qualquer duvida entre diretamente em nosso site <a target='_blank' href='" .  $link . "'> www.tracerbr.com.br </a></font> <br>";
		$resp_auto = utf8_decode($resp_auto);
		$output = shell_exec('sendEmail -f alerta@tracerbr.com.br -t "' . $emailenviar . '" -u "' . $assunto . '" -m "' . $texto . $resp_auto . '" -s smtp.zoho.com:587 -xu alerta@tracerbr.com.br -xp comida05 -o tls=yes');
	}
	
function access_token_get($client_secret_) 

	{
		/**
 * Exemplo de como requisitar o access_token que é a chave para ultilizar a API
 * Author: Team Developers DirectCall
 * Data: 2013-03-14
 * Referencia: http://doc.directcallsoft.com/pages/viewpage.action?pageId=524516
 */
 


// URL que será feita a requisição
$url = "https://api.directcallsoft.com/request_token";

// CLIENT_ID que é fornecido pela DirectCall
$client_id = "tracerbr@tracerbr.com.br";

// CLIENT_SECRET que é fornecido pela DirectCall
//$client_secret = "3688576";
$client_secret = $client_secret_;

// Dados em formato QUERY_STRING
$data = http_build_query(array('client_id' => $client_id, 'client_secret' => $client_secret));

$ch = 	curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$return = curl_exec($ch);
		
		curl_close($ch);
		
		// Converte os dados de JSON para ARRAY
		$dados = json_decode($return, true);
		
		//Token
	return	$access_token_get = $dados['access_token'];
}
	
	
?>