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
		$estado = $_POST['estado'];
		$arr = explode("-",$dispositivo);
		$id_widget =  $arr[0];
		$topico = $arr[1];

	
$query =  "INSERT INTO `zigbeedevice` (`id`, `serialzigbee`, `carga`,  `acao`,  `topico`, `id_widget`, `habilitado`) VALUES (NULL, '{$serialzigbee}', '{$carga}',  '{$estado}',  '{$topico}', '{$id_widget}', '1');";

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



$query = "SELECT id, Descricao, username_iphone, setPubTopic0 FROM widget WHERE tipo_geral = 17 OR tipo_geral = 2 OR tipo_geral = 3 OR tipo_geral = 4  OR tipo_geral = 9 OR tipo_geral = 7 OR tipo_geral = 1 OR tipo_geral = 14 OR tipo_geral = 13  OR tipo_geral = 20   OR tipo_geral = 24  OR tipo_geral = 10";
mysqli_set_charset($con, 'utf8');
$studentData = mysqli_query($con, $query);
//$recStudent = mysql_fetch_array($studentData);
mysqli_close($con);
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
		var valorEstado = '{"linkquality":94,"state_bottom":"OFF","state_center":"OFF","state_top":"OFF"}';
		var valorEstadoJson = JSON.parse(valorEstado);
		tipo_dispositivo = tipo_dispositivo.substring(tipo_dispositivo.length - 12, tipo_dispositivo.length - 10);
			

	   
				   if ( root_topico == "housezigbee")
				   {
					$("#serialzigbee").val(semi_topico);
					$(".cargaselect").hide();
				//	$("#codigo433mhz1").text(valor);
				//	$("#tipocarga").text(tipo_dispositivo);
										
								var valorzigbee_json =  JSON.parse(valor);

								// Para Sensor de Porta
								  if (valorzigbee_json.hasOwnProperty('contact') && (tipo_dispositivo == '17' || tipo_dispositivo == '01' || tipo_dispositivo == '14' || tipo_dispositivo == '22'  || tipo_dispositivo == '15') ) 
								  {
									    $("#codigo433mhz1").text(" ");
										$("#carga").val("contact");
										$("#valorcarga").val(valorzigbee_json.contact);
										$( "#btnSubmit" ).prop( "disabled", false );
								  }

								  else if (valorzigbee_json.hasOwnProperty('state_top') && (tipo_dispositivo == '17' || tipo_dispositivo == '01' || tipo_dispositivo == '14' || tipo_dispositivo == '22'  || tipo_dispositivo == '15') ) 
								  {		
									    $("#cargaSelect").empty();
										$("#cargaSelect").show();
										$("#cargaSelect").append('<option value=state_top>Sessão 1 (Réle Superior)</option>');
										$("#cargaSelect").append('<option value=state_center>Sessão 2 (Réle do Meio)</option>');
										$("#cargaSelect").append('<option value=state_bottom>Sessão 3 (Réle Inferior)</option>');

										$("#carga").val("state_top");
										$("#valorcarga").val(valorzigbee_json.state_top);

									    $("#codigo433mhz1").text(" ");

									//	$("#valorcarga").val(valorzigbee_json.state_top);
										$("#btnSubmit").prop( "disabled", false );
								  }
								  // Para Sensor de Temperatura
								  else if (valorzigbee_json.hasOwnProperty('temperature') && (tipo_dispositivo == '03') ) 
								  {
									    $("#codigo433mhz1").text(" ");
										$("#carga").val("temperature");
										$("#valorcarga").val(valorzigbee_json.temperature);
										$( "#btnSubmit" ).prop( "disabled", false );
								  }
								  
								  // Para Sensor de Humidade
								  else if (valorzigbee_json.hasOwnProperty('humidity') && (tipo_dispositivo == '02') ) 
								  {
										$("#codigo433mhz1").text(" ");
										$("#carga").val("humidity");
										$("#valorcarga").val(valorzigbee_json.humidity);
										$( "#btnSubmit" ).prop( "disabled", false );
								  }
								  
								  // Para Sensor de Pressão
								  else if (valorzigbee_json.hasOwnProperty('pressure') && (tipo_dispositivo == '07') ) 
								  {
										$("#codigo433mhz1").text(" ");
										$("#carga").val("pressure");
										$("#valorcarga").val(valorzigbee_json.pressure);
										$( "#btnSubmit" ).prop( "disabled", false );
								  }

									// Para Sensor de Pressão
									else if (valorzigbee_json.hasOwnProperty('illuminance_lux') && (tipo_dispositivo == '04') ) 
								  {
										$("#codigo433mhz1").text(" ");
										$("#carga").val("illuminance_lux");
										$("#valorcarga").val(valorzigbee_json.illuminance_lux);
										$( "#btnSubmit" ).prop( "disabled", false );
								  }

									// Para Sensor de Pressão
									else if (valorzigbee_json.hasOwnProperty('occupancy') && (tipo_dispositivo == '13') ) 
								  {
										$("#codigo433mhz1").text(" ");
										$("#carga").val("occupancy");
										$("#valorcarga").val(valorzigbee_json.occupancy);
										$( "#btnSubmit" ).prop( "disabled", false );
								  }

									// Para Botão
									else if (valorzigbee_json.hasOwnProperty('click')  && (tipo_dispositivo == '17' || tipo_dispositivo == '01' || tipo_dispositivo == '10' || tipo_dispositivo == '14' || tipo_dispositivo == '22' || tipo_dispositivo == '09' || tipo_dispositivo == '15' || tipo_dispositivo == '20') ) 
								  {
										$("#codigo433mhz1").text(" ");
										$("#carga").val(valorzigbee_json.click);
										$("#valorcarga").val(valorzigbee_json.click);
										$( "#btnSubmit" ).prop( "disabled", false );
								  }
								  
									// Para Sensor Vibração
									else if (valorzigbee_json.hasOwnProperty('action')  && (tipo_dispositivo == '17' || tipo_dispositivo == '01' || tipo_dispositivo == '13' || tipo_dispositivo == '14' || tipo_dispositivo == '22'  || tipo_dispositivo == '15') ) 
								  {
										$("#codigo433mhz1").text(" ");
										$("#carga").val(valorzigbee_json.action);
										$("#valorcarga").val(valorzigbee_json.action);
										$( "#btnSubmit" ).prop( "disabled", false );
								  }
								  else
								  {
									  $("#codigo433mhz1").text("Não foi encontrada carga para o tipo de dispositivo selecionado");
									  $("#carga").val("");
										$("#valorcarga").val("");
										$( "#btnSubmit" ).prop( "disabled", true );
								  }

									$(".tipochaves").hide();
									// Para Limpar os Option do select abaico
									$('.tipoestado option').each(function() 
									{
        							$(this).remove();
									});

										// Para Habilitar o tipo de Ação
									if (tipo_dispositivo == '01' || tipo_dispositivo == '05' || tipo_dispositivo == '14' || tipo_dispositivo == '15' || tipo_dispositivo == '21'   || tipo_dispositivo == '22')
									{
										$(".tipoestado").show();
										$(".selectestado").append('<option value=X>Alternar</option>');
										$(".selectestado").append('<option value=1>Somente Ligar</option>');
										$(".selectestado").append('<option value=0>Somente Desligar</option>');
									}
									else if (tipo_dispositivo == '20')
									{
										$(".tipoestado").show();
										$(".selectestado").append('<option value=P100>Abrir</option>');
										$(".selectestado").append('<option value=P000>Fechar</option>');
										$(".selectestado").append('<option value=P101>Parar</option>');
										$(".selectestado").append('<option value=P102>Inverter</option>');
									}
									else if (tipo_dispositivo == '09')
									{
										$(".tipoestado").show();
										$(".selectestado").append('<option value=P100>Abrir</option>');
										$(".selectestado").append('<option value=P000>Fechar</option>');
										$(".selectestado").append('<option value=P050>Meia janela</option>');
										$(".selectestado").append('<option value=P101>Parar</option>');
									}
									else if (tipo_dispositivo == '10')
									{
										$(".tipoestado").show();
										$(".selectestado").append('<option value=XX!000!TOFF>Desligar</option>');
										$(".selectestado").append('<option value=XX!000!T16>Ligar em 16°C</option>');
										$(".selectestado").append('<option value=XX!000!T17>Ligar em 17°C</option>');
										$(".selectestado").append('<option value=XX!000!T18>Ligar em 18°C</option>');
										$(".selectestado").append('<option value=XX!000!T19>Ligar em 19°C</option>');
										$(".selectestado").append('<option value=XX!000!T20>Ligar em 20°C</option>');
										$(".selectestado").append('<option value=XX!000!T21>Ligar em 21°C</option>');
										$(".selectestado").append('<option value=XX!000!T22>Ligar em 22°C</option>');
										$(".selectestado").append('<option value=XX!000!T23>Ligar em 23°C</option>');
										$(".selectestado").append('<option value=XX!000!T24>Ligar em 24°C</option>');
										$(".selectestado").append('<option value=XX!000!T25>Ligar em 25°C</option>');
										$(".selectestado").append('<option value=XX!000!T26>Ligar em 26°C</option>');
										$(".selectestado").append('<option value=XX!000!T27>Ligar em 27°C</option>');
										$(".selectestado").append('<option value=XX!000!T28>Ligar em 28°C</option>');
										$(".selectestado").append('<option value=XX!000!T29>Ligar em 29°C</option>');
									}
									else
									{
									$(".tipoestado").hide();

									}
				 }
				   

	  });
	  

	


    $(document).ready(function () {
	//	$( "#btnSubmit" ).prop( "disabled", true );
        $('#btn').click(function () {
            window.opener.location.reload(true);
            window.close();
             }); 

          $('#btnSubmit').click(function () {
			//		alert("1223");
		   $("#codigo433mhz1").text("Codigo Controle: ");
            
			}); 

			$('#cargaSelect').click(function () {
				const tipoAcao = $("#cargaSelect").val();
                $("#carga").val(tipoAcao);
			}); 

 
    });
	

    

</script>
<h5>Depois de Modificar click no botão "Atualizar" e depois "Fecha"</h5><b>
<form class="w3-container w3-card-4" method="POST" name="frm" id="frm">

<label class="w3-label w3-text-blue"><b>Descrição do Dispositivo/Codigo</b></label>
        <select class="w3-input w3-border" name="dispositivo" id="dispositivo">
                    <?php 
                    while($rec = mysqli_fetch_array($studentData)) { 
                         echo "<option value=" . $rec['id'] . "-" .  $rec['setPubTopic0'] . ">" . $rec['Descricao'] . "</option>"; 
                     } 
                     ?>
         </select>
		 <br>
		 
<label class="w3-label w3-text-blue"><b>Serial Zigbee</b></label>
<input type="text" class="w3-input w3-border" value= "";  name="serialzigbee" id="serialzigbee"  maxlength=18/>
<br>
<label class="w3-label w3-text-blue"><b>Tipo de Carga</b></label>
<h6 id="codigo433mhz1"></h6>
<h6 id="tipocarga"></h6>

<select name="cargaSelect" id="cargaSelect" class="w3-input w3-border cargaSelect" >
</select> 
<br>
<input type="carga" class="w3-input w3-border" value= "";  name="carga" id="carga"  />
<br>
<label class="w3-label w3-text-blue"><b>Valor da Carga</b></label>
<input type="text" class="w3-input w3-border" value= "";  name="valorcarga" id="valorcarga"  maxlength=16/>
<br>

<div class="tipoestado" name="tipoportao" id="tipoportao" style="display:none;">
<label class="w3-label w3-text-blue tipoportao"><b>Estado</b></label>
 <select name="estado" id="estado_portao" class="w3-input w3-border selectestado" >
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