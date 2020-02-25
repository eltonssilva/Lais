<?php
error_reporting(0);
$mobile = "n";
 
    $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    $ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
    $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
    $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
    $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
    $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
    $symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
    if ($iphone || $ipad || $android || $palmpre || $ipod || $berry || $symbian == true): $mobile = "s"; /*Se este dispositivo for portátil, faça/escreva o seguinte */
	 else : $mobile = "n";
	 endif;


// Inclui o arquivo com o sistema de segurança
require_once("seguranca.php");
// Verifica se um formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Salva duas variáveis com o que foi digitado no formulário
  // Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
  $usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
  $senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
 // echo "Usuario " . $usuario . " "  .  $senha;
  // Utiliza uma função criada no seguranca.php pra validar os dados digitados
  if (validaUsuario($usuario, $senha) == true) {
    // O usuário e a senha digitados foram validados, manda pra página interna
//    header("Location: main.php");
    
    	if ($mobile == "n")
	{
		header("Location: /main.php");
	}else 
	{
		header("Location: /main_m.php");
	}
	
  } else {
    // O usuário e/ou a senha são inválidos, manda de volta pro form de login
    // Para alterar o endereço da página de login, verifique o arquivo seguranca.php
    expulsaVisitante();
  }
}