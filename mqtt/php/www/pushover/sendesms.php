<?php
/**
 * @author Chris Schalenborgh <chris.s@kryap.com>
 * @version 0.1
 */

header("Content-Type: text/html; charset=UTF-8",true);
require_once("../usuario/dados_bd.php");
require_once("../usuario/antisql.php");
require_once("directcall_sms.php");

$codigo = $_GET['codigo'];


$con = mysql_connect($DB_SERVER, $DB_USER, $DB_PASS);
mysql_select_db($DB_NAME, $con);
//$query = "SELECT `rx433mhz_violacao`.id, codigo, topico, descricao, user_key, token_key, device, `rx433mhz_violacao`.mensagem, `pushover`.id pushover_id, email FROM `rx433mhz_violacao`,`pushover` WHERE codigo = '{$codigo}' and `pushover`.habilitado = '1'";

//$query =  "SELECT `rx433mhz_violacao`.id, codigo, descricao, email, mensagem, proprietario FROM `rx433mhz_violacao`, email WHERE codigo = '$codigo' and `email`.habilitado = '1'";
$query =  "SELECT `rx433mhz_violacao`.id, codigo, descricao, numerosms, mensagem, proprietario, client_secret_ FROM `rx433mhz_violacao`, sms WHERE codigo = '$codigo' and `sms`.habilitado = '1'";

mysql_set_charset('utf8');
$data = mysql_query($query);
$codigo = "";
$descricao = "";
$numerosms = "";
$mensagem = "";
$proprietario = "";
$client_secret_ = "";

while($rec = mysql_fetch_array($data)) {
$codigo = $rec['codigo'];
$proprietario = $rec['proprietario']; 
$descricao = $rec['descricao'];
$mensagem = $rec['mensagem'];
$numerosms = $rec['numerosms'];
$client_secret_ = $rec['client_secret_'];

directcall_envia_sms($numerosms,$mensagem, $client_secret_);
//$output = shell_exec('sendEmail -f tracerbr@tracerbr.com.br -t "' . $email . '" -u "Alerta AutoHome" -m "' . $descricao . " - " . $mensagem . '" -s smtp.zoho.com:587 -xu tracerbr@tracerbr.com.br -xp comida05 -o tls=yes');
echo $output;
sleep(1);
}



?>