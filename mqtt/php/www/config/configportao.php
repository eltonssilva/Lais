<?php
require_once("../usuario/dados_bd.php");
include("../segurancaconfig.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
$endereco = $_SERVER[HTTP_HOST];

$conip  = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query2 = "SELECT ip FROM `servidor` where 1=1";
mysqli_set_charset('utf8');
$data2 = mysqli_query($conip, $query2);
mysqli_close($conip);
while($rec2 = mysqli_fetch_array($data2)) 
{ 
$ip = $rec2['ip'];
}


if ($endereco == $ip)  // 
{
	$endereco = $ip;
}
else 
{
	$posicao = strpos($endereco, ':');
	$endereco = substr($endereco, 0 , $posicao );
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/materialize.css?id=9">
	<link rel="stylesheet" href="../css/personalizar.css?id=8">
	<script language="JavaScript" src="../js/materialize.js"></script>
	<script language="JavaScript" src="../js/utils.js"></script>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/jquery-1.7.2.min.js"></script>
	<script src="../js/config_dispositivo.js"></script>
	<script src="http://<?php echo $endereco; ?>:4555/socket.io/socket.io.js"></script>
	<script type="text/javascript">
	
				var socket = io('http://<?php echo $endereco; ?>:4555', {transports: ['websocket', 'polling', 'flashsocket']});
	  socket.on('notificacao', function (data) 
	  {

var traco1 =   data.indexOf('-', 0);
var traco2 =   data.indexOf('-', traco1 + 1);
var barra2 =   data.indexOf('/', traco2 + 3);
var barra3 =   data.indexOf('/', barra2 + 1);
if (barra3 == -1) {barra3 = data.length;}

var id = data.substring(0,traco1);
var valor = data.substring(traco1+1,traco2);
var semi_topico = data.substring(barra2+1,barra3);
var txt = $("#feedback");
    
	   
	   if ( semi_topico == "atviamqtt")
	   {
	   	//$("#codigo433mhz1").text("Codigo Controle: " + valor);
		txt.val( valor  +"\n"+ txt.val() + "");
	   }
	    });
		

		
	
    $(document).ready(function () {
		var txt = $("#feedback");
		
		var numeroserial = "<?php echo $_GET['sn']; ?>";
		$('.voltar').click(function () {
			 window.open('configdispositivo.php',"_self");
             }); 
			 
		$('.btnivertabertura').click(function () {
				prepara_mqtt("26", "/house/garage/" + numeroserial);
             }); 
			 
		$('.btnsensor').click(function () {
			prepara_mqtt("27", "/house/garage/" + numeroserial);
        }); 
			 
			 			 
		$('.btnAbrir').click(function () {
				prepara_mqtt("22", "/house/garage/" + numeroserial);
             }); 
			 
		$('.btnParar').click(function () {
				prepara_mqtt("23", "/house/garage/" + numeroserial);
             }); 
			 
		$('.btnFechar').click(function () {
				prepara_mqtt("24", "/house/garage/" + numeroserial);
             }); 
			 
		$('.btnReset').click(function () {
				prepara_mqtt("16", "/house/garage/" + numeroserial);
             }); 
			 
		$('.btnInverter_Sentido').click(function () {
				prepara_mqtt("25", "/house/garage/" + numeroserial);
             }); 			 
			 			 
			 
		$('.Reset').click(function () {
				prepara_mqtt("16", "/house/garage/" + numeroserial);
             }); 
			 
		$('.btn1').click(function () {
			var comando_mqtt_ = $(".comandos_select").val();
				prepara_mqtt(comando_mqtt_, "/house/garage/" + numeroserial);
             }); 
			 
		$('.btn_limpar').click(function () {
				txt.val("");
             }); 
			 
			 
    });

</script>
</head>
<body>

<a class="waves-effect waves-light btn-small blue accent-3 btn btnivertabertura">Abrir/Fechar/Parar</a>
<a class="waves-effect waves-light btn-small blue accent-3 btn btnInverter_Sentido">Inverter Sentido</a>
<a  class="waves-effect waves-light btn-small blue accent-3 btn btnAbrir">Abrir</a>
<a class="waves-effect waves-light btn-small blue accent-3 btn btnParar">Parar</a>
<a class="waves-effect waves-light btn-small blue accent-3 btn btnFechar">Fechar</a>
<a class="waves-effect waves-light btn-small blue accent-3 btn Reset">Reset</a>
<a class="waves-effect waves-light btn-small blue accent-3 btn btnsensor">Inverter Sensor</a>
<div class="selecao">
  <label>Comando</label>
  <select class="browser-default comandos_select">
    <option value="" disabled selected>Selecione o Comando</option>
    <option value="01">Wifi</option>
    <option value="02">Usuario-Senha da Rede de Dispositivo</option>
    <option value="03">Porta Dispositivo</option>
	<option value="04">IP do Servidor</option>
	<option value="05">Verifica IP do Servidor</option>
	<option value="29">Verifica IP Dispositivo</option>
	<option value="06">Serial Dispostivio</option>
	<option value="07">Habilitar OTA</option>
	<option value="08">Verificar Configuração OTA</option>
	<option value="09">Habilitar Alexa</option>
	<option value="10">Nome Alexa</option>
	<option value="11">Checar Nome Alexa</option>
	<option value="12">Primeiro Uso</option>
	<option value="13">Verificar Primeiro Uso</option>
	<option value="14">Senha de Configuração do Dispositivo</option>
	<option value="15">Verifica Configurações Gerais</option>
	<option value="16">Reset</option>
	<option value="22">Abrir</option>
	<option value="23">Parar</option>
	<option value="24">Fechar</option>
	<option value="25">Inverter Sentido</option>
	<option value="26">Abrir_Parar_Fechar</option>
	<option value="27">Inverter Sensor</option>

  </select>
  </div>
  <div class="row">
        <div class="input-field col s7">
          <input  value="" id="senha_dispositivo" type="text" class="validate senha_dispositivo">
          <label for="disabled">Senha Dispositivo</label>
        </div>
      </div>
	  <div class="row">
        <div class="input-field col s7">
          <input  value="" id="parametro" type="text" class="validate parametro">
          <label for="disabled">Parametros de Comandos</label>
        </div>
      </div>
	  
	  	  <div class="row">
        <div class="input-field col s7">
		 <textarea rows = "8" cols = "60" id="feedback"  name = "feedback" class="validate feedback"> </textarea>
          <label for="disabled">Respostas do Dispositivo</label>
        </div>
      </div>  
	  
	  	  <div class="row">
        <div class="input-field col s7">
	  <a class="waves-effect waves-light btn-small blue accent-3 btn1 ">Enviar</a> <a class="waves-effect waves-light btn-small blue accent-3 btn2  btn_limpar">Limpar</a>
        </div>
      </div>
	  	  <div class="row">
        <div class="input-field col s7">
	  <a class="btn-floating btn-large waves-effect blue accent-3 voltar"><img class="imag" src="../png/baseline_keyboard_arrow_left_white_48dp.png"></a>
        </div>
      </div>   	  
	  
</body>

</html>