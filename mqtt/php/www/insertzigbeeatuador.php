<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");


error_reporting(0);
$endereco = $_SERVER[HTTP_HOST];

$con  = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query2 = "SELECT ip FROM `servidor` where 1=1";
mysqli_set_charset($con, 'utf8');
$data2 = mysqli_query($con, $query2);
while($rec2 = mysqli_fetch_array($data2)) 
{ 
$ip = $rec2['ip'];
}


/*
if ($endereco == $ip)  // 
{
	$endereco = $ip;
}
else 
{
	$posicao = strpos($endereco, ':');
	$endereco = substr($endereco, 0 , $posicao );
}
*/
//echo $endereco;





$msg = "";
$id = $_GET['id'];



if(isset($_POST['btnSubmit'])) 
{
		
		$serialzigbee= $_POST['serialzigbee'];
		$carga= $_POST['carga'];
		$dispositivo = $_POST['dispositivo'];
		$acao = $_POST['selectacao'];
		$modelo = $_POST['modelo'];
		$arr = explode("-",$dispositivo);
		$id_widget =  $arr[0];
		$topico = $arr[1];

	
$query =  "INSERT INTO `zigbeedevice` (`id`, `serialzigbee`, `carga`,  `acao`,  `topico`, `id_widget`, `habilitado`, `modelo`) VALUES (NULL, '{$serialzigbee}', ' ',  '{$acao}',  '{$topico}', '{$id_widget}', '1', '{$modelo}');";

	//	echo $query ;
		if(mysqli_query($con, $query))
				{
				$msg = "Alteração Salva";
				} 
		else 
				{
				$msg = "Erro na Atualização";
				}

}



$query = "SELECT id, Descricao, username_iphone, setPubTopic0 FROM widget WHERE tipo_geral = 17 OR tipo_geral = 2 OR tipo_geral = 3 OR tipo_geral = 4  OR tipo_geral = 9 OR tipo_geral = 7 OR tipo_geral = 1 OR tipo_geral = 14  OR tipo_geral = 20  OR tipo_geral = 10 OR tipo_geral = 24";
mysqli_set_charset($con, 'utf8');
$studentData = mysqli_query($con, $query);
//$recStudent = mysql_fetch_array($studentData);
mysqli_close($con);


// $query = "SELECT id, Descricao, username_iphone, setPubTopic0 FROM widget WHERE tipo_geral = 23";
// mysqli_set_charset($con, 'utf8');
// $cena = mysqli_query($con, $query);
// //$recStudent = mysql_fetch_array($studentData);
// mysqli_close($con);
?>

<html>
<head>
<link href="/css/main.css" rel="stylesheet" type="text/css"/> 
<link href="/css/w3.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<script src="js/jquery.min.js"></script>
<script src="/js/jquery-1.7.2.min.js"></script>
<script src="/jsjquery.validate.min.js"></script>
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
		var tipo_dispositivo =  $("#dispositivo").val();
		var root_topico = data.substring(traco2+2,barra2);
		var semi_topico = data.substring(barra2+1,barra3);
		
		
		tipo_dispositivo = tipo_dispositivo.substring(tipo_dispositivo.length - 12, tipo_dispositivo.length - 10);
			
    
	   
				   if ( root_topico == "housezigbee")
				   {
							$("#serialzigbee").val(semi_topico);
					}
				   

	  });
	  

	


    $(document).ready(function () {
	//	$( "#btnSubmit" ).prop( "disabled", true );
        $('#btn').click(function () {
            window.opener.location.reload(true);
            window.close();
             }); 


			$('#modelo').click(function () {

					$('#selectacao option').each(function() 
					{
        			$(this).remove();
					});


					 const tipoAcao = $("#modelo").val();
					 if (tipoAcao == "ZW-EU-0"){
							$("#acao").show();
							$("#imgdispositivo").attr("src","/png/dispositivos/ZW-EU-02.jpg");
							$("#selectacao").append('<option value=state_right>Rele Direito</option>');
							$("#selectacao").append('<option value=state_left>Rele Esquerdo</option>');
								
					 }else if(tipoAcao == "ZNLDP12LM")
					 {
							$("#acao").show();
							$("#imgdispositivo").attr("src","/png/dispositivos/ZNLDP12LM.jpg");
							$("#selectacao").append('<option value=state>Lampada Dimmer</option>');

					 }else if(tipoAcao == "ADomoZig")
					 {
							$("#acao").show();
							$("#imgdispositivo").attr("src","/png/dispositivos/DNCKATSW002.jpg");
							$("#selectacao").append('<option value=state_l1>Relé 1</option>');
							$("#selectacao").append('<option value=state_l2>Relé 2</option>');
							$("#selectacao").append('<option value=state_l3>Relé 3</option>');
							$("#selectacao").append('<option value=state_l4>Relé 4</option>');
							$("#selectacao").append('<option value=state_l5>Relé 5</option>');
							$("#selectacao").append('<option value=state_l6>Relé 6</option>');
							$("#selectacao").append('<option value=state_l7>Relé 7</option>');
							$("#selectacao").append('<option value=state_l8>Relé 8</option>');
							$("#selectacao").append('<option value=state_l9>Relé 9</option>');
							$("#selectacao").append('<option value=state_l10>Relé 10</option>');
							$("#selectacao").append('<option value=state_l11>Relé 11</option>');
							$("#selectacao").append('<option value=state_l12>Relé 12</option>');
					 }else if(tipoAcao == "AduroSmart81849")
					 {
							$("#acao").show();
							$("#imgdispositivo").attr("src","/png/dispositivos/81849.jpg");
							$("#selectacao").append('<option value=state>Relé 1</option>');

					 }else if(tipoAcao == "AduroSmart81855")
					 {
							$("#acao").show();
							$("#imgdispositivo").attr("src","/png/dispositivos/81855.jpg");
							$("#selectacao").append('<option value=state>Relé 1</option>');

					 }else if(tipoAcao == "AU-A1ZBPIAB")
					 {
							$("#acao").show();
							$("#imgdispositivo").attr("src","/png/dispositivos/AU-A1ZBPIAB.jpg");
							$("#selectacao").append('<option value=state>Relé 1</option>');

					 }else if(tipoAcao == "BW-SS7")
					 {
							$("#acao").show();
							$("#imgdispositivo").attr("src","/png/dispositivos/BW-SS7.jpg");
							$("#selectacao").append('<option value=state>Relé 1</option>');

					 }else if(tipoAcao == "BASICZBR3")
					 {
							$("#acao").show();
							$("#imgdispositivo").attr("src","/png/dispositivos/BASICZBR3.jpg");
							$("#selectacao").append('<option value=state>Relé 1</option>');

					 }else if(tipoAcao == "BW-SS7")
					 {
							$("#acao").show();
							$("#imgdispositivo").attr("src","/png/dispositivos/BW-SS7.jpg");
							$("#selectacao").append('<option value=state>Relé 1</option>');

					 }else if(tipoAcao == "zemismartWallSwitch")
					 {
							$("#acao").show();
							$("#imgdispositivo").attr("src","/png/dispositivos/zemismartWallSwitch.png");
							$("#selectacao").append('<option value=state_top>Sessão 1 (Réle Superior)</option>');
							$("#selectacao").append('<option value=state_center>Sessão 2 (Réle do Meio)</option>');
							$("#selectacao").append('<option value=state_bottom>Sessão 3 (Réle Inferior)</option>');

					 }
					 else if(tipoAcao == "ZBMINI")
					 {
							$("#acao").show();
							$("#imgdispositivo").attr("src","/png/dispositivos/ZBMINI.jpg");
							$("#selectacao").append('<option value=state>Relé 1</option>');

					 }
					 else if(tipoAcao == "GENERICO")
					 {
							$("#acao").show();
							$("#imgdispositivo").attr("src","/png/dispositivos/GENERICO.jpg");
							$("#selectacao").append('<option value=state>Relé 1</option>');

					 }



					 
        });
 
    });
	
</script>

<h5>Depois de Modificar click no botão "Atualizar" e depois "Fecha"</h5><b>
<form class="w3-container w3-card-4" method="POST" name="frm" id="frm">

<br>

<label class="w3-label w3-text-blue"><b>Cena/Codigo</b></label>
        <select class="w3-input w3-border" name="dispositivo" id="dispositivo">
                    <?php 
                    while($rec = mysqli_fetch_array($studentData)) { 
                         echo "<option value=" . $rec['id'] . "-" .  $rec['setPubTopic0'] . ">" . $rec['Descricao'] . "</option>"; 
                     } 
                     ?>
         </select>
		 
				 <br>
<label class="w3-label w3-text-blue"><b>Serial Zigbee</b></label>
<input type="text" class="w3-input w3-border" value= "";  name="serialzigbee" id="serialzigbee"  maxlength=26/>
<br>
<!-- <label class="w3-label w3-text-blue"><b>Tipo de Ação</b></label>

<input type="text" class="w3-input w3-border" value= "";  name="acao" id="acao"  maxlength=16/>
<br> -->

<label class="w3-label w3-text-blue"><b>Modelo Dispositivo</b></label>
<select class="w3-input w3-border" name="modelo" id="modelo">
	<option value="ADomoZig" selected>ADomoZig</option>
	<option value="ZNLDP12LM">ZNLDP12LM</option>
	<option value="ZW-EU-0">ZW-EU-02</option> 
	<option value="AduroSmart81849">AduroSmart 81849</option>
	<option value="AduroSmart81855">AduroSmart 81855</option>
	<option value="AU-A1ZBPIAB">Aurora Lighting AU-A1ZBPIAB</option>
	<option value="BW-SS7">BlitzWolf BW-SS7</option>
	<option value="BASICZBR3">SONOFF BASICZBR3</option>
	<option value="BW-SS7">BlitzWolf BW-SS7</option>
	<option value="ZBMINI">SONOFF ZBMINI</option>
	<option value="zemismartWallSwitch">Interruptor ZemiSmart</option>
	<option value="GENERICO">Dispositivo Generico</option>
</select>



<div class="tipoestado" name="acao" id="acao>
<label class="w3-label w3-text-blue"><b>Tipo de Ação</b></label>

<table>
  <tr>
    <th>
		<img name="imgdispositivo" id="imgdispositivo" src="/png/dispositivos/DNCKATSW002.jpg" alt="some text" width=150 height=150>
    </th>
    <th>
		<select name="selectacao" id="selectacao" class="w3-input w3-border selectestado">
		<option value=state_l1 selected>Relé 1</option>
		<option value=state_l2 >Relé 2</option>
		<option value=state_l3 >Relé 3</option>
		<option value=state_l4 >Relé 4</option>
		<option value=state_l5 >Relé 5</option>
		<option value=state_l6 >Relé 6</option>
		<option value=state_l7 >Relé 7</option>
		<option value=state_l8 >Relé 8</option>
		<option value=state_l9 >Relé 9</option>
		<option value=state_l10 >Relé 10</option>
		<option value=state_l11 >Relé 11</option>
		<option value=state_l12 >Relé 12</option>
		</select>
    </th>
  </tr>
</table>



</select> 
</div>


<br>


<input type="submit" class="w3-btn w3-blue" id='btnSubmit' name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php 
echo $msg; 

?>
</form>

</body>
</html>