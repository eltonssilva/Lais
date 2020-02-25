<?php
/**
 * @author Chris Schalenborgh <chris.s@kryap.com>
 * @version 0.1
 */

include('Pushover.php');
header("Content-Type: text/html; charset=UTF-8",true);
require_once("../usuario/dados_bd.php");
require_once("../usuario/antisql.php");

$codigo = $_GET['codigo'];


$con = mysql_connect($DB_SERVER, $DB_USER, $DB_PASS);
mysql_select_db($DB_NAME, $con);
$query = "SELECT `rx433mhz_violacao`.id, codigo, topico, descricao, user_key, token_key, device, `rx433mhz_violacao`.mensagem, `pushover`.id pushover_id, email FROM `rx433mhz_violacao`,`pushover` WHERE codigo = '{$codigo}' and `pushover`.habilitado = '1'";
mysql_set_charset('utf8');
$data = mysql_query($query);
$user_key = "";
$token_key = "";
$device = "";
$descricao = "";
$mensagem = "";
$email = "";

while($rec = mysql_fetch_array($data)) {
$user_key = $rec['user_key'];
$token_key = $rec['token_key']; 
$device = $rec['device'];
$descricao = $rec['descricao'];
$mensagem = $rec['mensagem'];
$email = $rec['email'];

$push = new Pushover();
$push->setToken($token_key);
$push->setUser($user_key);

$push->setTitle($descricao);
$push->setMessage($mensagem);
$push->setUrl('www.tecnotend.com.br');
$push->setUrlTitle('Tecnotend');

$push->setDevice($device);
$push->setPriority(2);
$push->setRetry(60); //Used with Priority = 2; Pushover will resend the notification every 60 seconds until the user accepts.
$push->setExpire(300); //Used with Priority = 2; Pushover will resend the notification every 60 seconds for 3600 seconds. After that point, it stops sending notifications.
$push->setCallback('http://chris.schalenborgh.be/');
$push->setTimestamp(time());
$push->setDebug(true);
$push->setSound('bike');

$go = $push->send();

echo '<pre>';
print_r($go);
echo '</pre>';

$output = shell_exec('sendEmail -f alerta@tracerbr.com.br -t "' . $email . '" -u "Alerta AutoHome" -m "' . $mensagem . '" -s smtp.zoho.com:587 -xu alerta@tracerbr.com.br -xp comida05 -o tls=yes');

sleep(1);
}



?>