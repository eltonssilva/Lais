<?php
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");
/**
* Sistema de segurança com acesso restrito
*
* Usado para restringir o acesso de certas páginas do seu site
*
* @author Thiago Belem <contato@thiagobelem.net>
* @link http://thiagobelem.net/
*
* @version 1.0
* @package SistemaSeguranca
*/
//  Configurações do Script
// ==============================
$_SG['conectaServidor'] = true;    // Abre uma conexão com o servidor MySQL?
$_SG['abreSessao'] = true;         // Inicia a sessão com um session_start()?
$_SG['caseSensitive'] = false;     // Usar case-sensitive? Onde 'thiago' é diferente de 'THIAGO'
$_SG['validaSempre'] = true;       // Deseja validar o usuário e a senha a cada carregamento de página?
// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.
$_SG['servidor'] = $DB_SERVER;    // Servidor MySQL
$_SG['usuario'] = $DB_USER;          // Usuário MySQL
$_SG['senha'] = $DB_PASS;                // Senha MySQL
$_SG['banco'] = $DB_NAME;            // Banco de dados MySQL
$_SG['paginaLogin'] = 'loginconfig.php'; // Página de login
$_SG['tabela'] = 'servidor';       // Nome da tabela onde os usuários são salvos
// ==============================
// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================
// Verifica se precisa fazer a conexão com o MySQL
//if ($_SG['conectaServidor'] == true) {
 $_SG['link'] = mysqli_connect($_SG['servidor'], $_SG['usuario'], $_SG['senha'], $_SG['banco']);
//  mysqli_select_db($_SG['banco'], $_SG['link']) or die("MySQL: Não foi possível conectar-se ao banco de dados [".$_SG['banco']."].");
//}
// Verifica se precisa iniciar a sessão
if ($_SG['abreSessao'] == true)
  session_start();
/**
* Função que valida um usuário e senha
*
* @param string $usuario - O usuário a ser validado
* @param string $senha - A senha a ser validada
*
* @return bool - Se o usuário foi validado ou não (true/false)
*/
function validaUsuario($usuario, $senha) {
  global $_SG;
  $cS = ($_SG['caseSensitive']) ? 'BINARY' : '';
  // Usa a função addslashes para escapar as aspas
  $nusuario = addslashes($usuario);
  $nsenha = addslashes($senha);
  // Monta uma consulta SQL (query) para procurar um usuário
  $sql = "SELECT `id`, `nome` FROM `".$_SG['tabela']."` WHERE ".$cS." `usuarioadmin` = '".$nusuario."' AND ".$cS." `senhaadmin` = '" . md5($nsenha) ."' LIMIT 1";
  $query = mysqli_query($_SG['link'], $sql);
  $resultado = mysqli_fetch_assoc($query);
  // Verifica se encontrou algum registro
  if (empty($resultado)) {
    // Nenhum registro foi encontrado => o usuário é inválido
    return false;
  } else {
    // Definimos dois valores na sessão com os dados do usuário
    $_SESSION['usuarioIDadmin'] = $resultado['id']; // Pega o valor da coluna 'id do registro encontrado no MySQL
    $_SESSION['usuarioNomeadmin'] = $resultado['nome']; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
    // Verifica a opção se sempre validar o login
    if ($_SG['validaSempre'] == true) {
      // Definimos dois valores na sessão com os dados do login
      $_SESSION['usuarioLoginadmin'] = $usuario;
      $_SESSION['usuarioSenhaadmin'] = $senha;
    }
    return true;
  }
}
/**
* Função que protege uma página
*/
function protegePagina() {
  global $_SG;
  if (!isset($_SESSION['usuarioIDadmin']) OR !isset($_SESSION['usuarioNomeadmin'])) {
    // Não há usuário logado, manda pra página de login
    expulsaVisitante();
  } else if (!isset($_SESSION['usuarioIDadmin']) OR !isset($_SESSION['usuarioNomeadmin'])) {
    // Há usuário logado, verifica se precisa validar o login novamente
    if ($_SG['validaSempre'] == true) {
      // Verifica se os dados salvos na sessão batem com os dados do banco de dados
      if (!validaUsuario($_SESSION['usuarioLoginadmin'], $_SESSION['usuarioSenhaadmin'])) {
        // Os dados não batem, manda pra tela de login
        expulsaVisitante();
      }
    }
  }
}
/**
* Função para expulsar um visitante
*/
function expulsaVisitante() {
  global $_SG;
  // Remove as variáveis da sessão (caso elas existam)
  unset($_SESSION['usuarioIDadmin'], $_SESSION['usuarioNomeadmin'], $_SESSION['usuarioLoginadmin'], $_SESSION['usuarioSenhaadmin']);
  // Manda pra tela de login
  header("Location: ".$_SG['paginaLogin']);
}