<?php

header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");
//include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
//protegePagina(); // Chama a função que protege a página
//echo "Olá, " . $_SESSION['usuarioLogin'];

$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query = "SELECT usu_bb, se_bb FROM `servidor`";
mysqli_set_charset('utf8');
$data = mysqli_query($con, $query);

$usu_bb = '';
$se_bb = '';

mysqli_close($con);
while($rec = mysqli_fetch_array($data)) 
{ 
$usu_bb = $rec['usu_bb'];
$se_bb = $rec['se_bb'];
}

$mensagem= $_POST['mensagem'];
$topico = $_POST['topico'];
$reter = $_POST['reter'];
$reterned = '';
$usuario = $usu_bb;
$senha = $se_bb;

//echo "SENHA" . $data  . " " . $se_bb . " " . $usuario;
if($reter==1) {$reterned = '-r';};
$output = shell_exec("mosquitto_pub -h mqttautodomo -d -u {$usuario} -P {$senha} -t '{$topico}' -m '{$mensagem}' -q 1 {$reterned}");
echo $output;

function encrypt($mensagem, $a_chave_do_usuario){
$salt = 'A3jdh$4D8gkb#2T7&sM40bn4A7fvv35cf=b48On=84c!623Vvf6vi37vb34@3kf%';
//salt = 'A3jdh$4D8gkb#2T7&sM40bn4A7fvv35cf=b48On=84c!623Vvf6vi37vb34@3kf%'
$key = substr(hash('sha256', $salt.$key.$salt), 0, 32);
$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB, $iv));
return $encrypted;
}

function decrypt($mensagem, $a_chave_do_usuario){
$salt = 'A3jdh$4D8gkb#2T7&sM40bn4A7fvv35cf=b48On=84c!623Vvf6vi37vb34@3kf%';
//salt = 'A3jdh$4D8gkb#2T7&sM40bn4A7fvv35cf=b48On=84c!623Vvf6vi37vb34@3kf%'
$key = substr(hash('sha256', $salt.$key.$salt), 0, 32);
$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($data), MCRYPT_MODE_ECB, $iv);
return $decrypted;
}

?>