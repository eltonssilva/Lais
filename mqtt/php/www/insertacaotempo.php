<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";

if(isset($_POST['btnSubmit'])) 
	{
		$radiotipogeral;
		$dataacao;
		$dataacaotododia;
		$timeacao;
		$tipogeral = $_POST['tipogeral'];
		
		if ($tipogeral == '1' || $tipogeral == '15')
		{
			$radiotipogeral = $_POST['radiotipogeral01'];
			$dataacao = $_POST['dataacao01'];
			$dataacaotododia = $_POST['dataacaotododia01'];
			$timeacao = $_POST['timeacao01'];
		}
		
		if ($tipogeral == '5')
		{
			$radiotipogeral = $_POST['radiotipogeral05'];
			$dataacao = $_POST['dataacao05'];
			$dataacaotododia = $_POST['dataacaotododia05'];
			$timeacao = $_POST['timeacao05'];
		}
		
		if ($tipogeral == '14')
		{
			$radiotipogeral = $_POST['radiotipogeral14'];
			$dataacao = $_POST['dataacao14'];
			$dataacaotododia = $_POST['dataacaotododia14'];
			$timeacao = $_POST['timeacao14'];
		}
		
				if ($tipogeral == '9')
		{
			$radiotipogeral = $_POST['sliderpersiana'];
			$dataacao = $_POST['dataacao09'];
			$dataacaotododia = $_POST['dataacaotododia09'];
			$timeacao = $_POST['timeacao09'];
		}
		
						if ($tipogeral == '10')
		{
			$radiotipogeral = $_POST['temperatura10'];
			$dataacao = $_POST['dataacao10'];
			$dataacaotododia = $_POST['dataacaotododia10'];
			$timeacao = $_POST['timeacao10'];
		}
		
		if ($tipogeral == '11')
		{
			$radiotipogeral = $_POST['tv11'];
			$dataacao = $_POST['dataacao11'];
			$dataacaotododia = $_POST['dataacaotododia11'];
			$timeacao = $_POST['timeacao11'];
		}
		
						if ($tipogeral == '20')
		{
			$radiotipogeral = $_POST['radiotipogeral20'];
			$dataacao = $_POST['dataacao20'];
			$dataacaotododia = $_POST['dataacaotododia20'];
			$timeacao = $_POST['timeacao20'];
		}
		
		
		if ($tipogeral == '21')
		{
			$radiotipogeral = $_POST['radiotipogeral21'];
			$dataacao = $_POST['dataacao21'];
			$dataacaotododia = $_POST['dataacaotododia21'];
			$timeacao = $_POST['timeacao21'];
		}
		
						if ($tipogeral == '22')
		{
			$radiotipogeral = $_POST['radiotipogeral22'];
			$dataacao = $_POST['dataacao22'];
			$dataacaotododia = $_POST['dataacaotododia22'];
			$timeacao = $_POST['timeacao22'];
		}
		

		
		
		$dispositivo_atuador = $_POST['dispositivo_atuador'];
		
		$arr = explode(":",$dispositivo_atuador);
		$id = $arr[0];
		$tipo_geral= $arr[1];
		$hora = substr($timeacao, 0, 2);
		$minuto = substr($timeacao, 3, 2);
		$periodo = substr($timeacao, 6, 2);
		$mes = substr($dataacao, 0, 2);
		$dia = substr($dataacao, 3, 2);
		$ano = substr($dataacao, 6, 4);
		$data_convertida;
		

		
		$data_convertida = $hora . ":" . $minuto . ":00";
		if ($periodo == "PM")
		{
			$hora24 = $hora + 12;
			if ($hora24 == 24) $hora24 = 00;
			$data_convertida = $hora24 . ":" . $minuto . ":00";
			
		
		}
		
		
		$data_inicio = 	$ano ."-". $mes  ."-".  $dia  . " " .  $data_convertida;
		if ($dataacaotododia == "1")
		{
			$data_inicio = 	'1979-05-05 ' . $data_convertida;
		}
		
//		echo $tipogeral . "-" . $radiotipogeral . "-" . $dataacao  . "-" . $dataacaotododia . "-" . $timeacao . "-" . $id  . "-" . $tipo_geral . "-" . $hora  . "-" . $minuto . "-" . $periodo;


	
	$query =  "INSERT INTO `ifttt` (`id`, `username_iphone`, `compara_sensor`, `valor_sensor`,  `id_widget_atuador`,        `valor_atuador`,            `data_inicio`,          `data_fim`,          `data_executado`,    `tipo_acao`, `quant_exec`, `habilitado`) 
	                        VALUES (NULL, '00AA00000000',           'XX',           '1',               '{$id}',           '{$radiotipogeral}',      '{$data_inicio}', '1979-05-05 00:00:00', '1979-05-05 00:00:00',     '1',          '1',           '1');";

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





$query = "SELECT id, Descricao, REPLACE(username_iphone, ':','') username_iphone, setPubTopic0, tipo_geral FROM `widget` where dispositivo_fisico = 1 and (tipo_geral =1 or tipo_geral=5 or tipo_geral= 9 or tipo_geral=10 or tipo_geral=11 or tipo_geral=14 or tipo_geral=15 or tipo_geral=20 or tipo_geral=21 or tipo_geral=22)";
mysqli_set_charset($con, 'utf8');
$studentData = mysqli_query($con, $query);
//$recStudent = mysql_fetch_array($studentData);
mysqli_close($con);
?>

<html>
<head>
<link href="/css/main.css" rel="stylesheet" type="text/css"/> 
<link href="/css/w3.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="/js/time-picker-mouse-keyboard-interactions/src/theme/jquery.timeselector.css" />
<link href="/js/jquery-ui-1.12.1.custom/jquery-ui.css" rel="stylesheet">
</head>
<body>
<script src="js/jquery.min.js"></script>
 <script src="/js/jquery-1.7.2.min.js"></script>
 <script src="/jsjquery.validate.min.js"></script>
 <script src="/js/jquery-ui-1.12.1.custom/external/jquery/jquery.js"></script>
<script src="/js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script src="/js/time-picker-mouse-keyboard-interactions/src/jquery.timeselector.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn').click(function () {
            window.opener.location.reload(true);
            window.close();
             }); 
            $('#numerobit').keyup(function () {
       	//	alert($('#numerobit').val());
        });
		
		
        $('#btnSubmit').click(function () {
			//		alert($('#codigo').val());
             }); 
			 
			$('#dispositivo_atuador').change(function() {
				var tipogeral;
				var id_dispositivo;
				var array;
				$( "#dispositivo_atuador option:selected" ).each(function() {
				str = $( this ).val();});
				array = str.split(':');
				//alert(array[1]);
				
				$("#tipogeral01").hide();
				$("#tipogeral05").hide();
				$("#tipogeral09").hide();
				$("#tipogeral10").hide();
				$("#tipogeral11").hide();
				$("#tipogeral14").hide();
				$("#tipogeral15").hide();
				$("#tipogeral20").hide();
				$("#tipogeral21").hide();
				$("#tipogeral22").hide();
				$("#tipogeral").val(array[1]);
				if (array[1] == '1' || array[1] == '15')
				{
					$("#tipogeral01").show()
					
				}
				if (array[1] == '5')
				{
					$("#tipogeral05").show()
				}
				if (array[1] == '9')
				{
					$("#tipogeral09").show()
				}
				if (array[1] == '10')
				{
					$("#tipogeral10").show()
				}
				if (array[1] == '11')
				{
					$("#tipogeral11").show()
				}
				if (array[1] == '14')
				{
					$("#tipogeral14").show()
				}
				if (array[1] == '20')
				{
					$("#tipogeral20").show()
				}
				if (array[1] == '21')
				{
					$("#tipogeral21").show()
				}
				if (array[1] == '22')
				{
					$("#tipogeral22").show()
				}
				
			});
    });
    
	
	
  $( function() {
    $( "#slider" ).slider();
	$( "#slider" ).slider( "option", "max", 100 );
	$( "#slider" ).slider( "option", "min", 0 );
	
	  $( "#slider" ).slider({
  change: function( event, ui ) 
	{
	var  sliderpersiana = $( "#slider" ).slider( "option", "value" );
	var sliderpersiana_exibir;
	
		if (sliderpersiana ==  100) {sliderpersiana_exibir = "Abrir Persiana";}
		else if (sliderpersiana ==  0) {sliderpersiana_exibir = "Fechar Persiana";}
		else {sliderpersiana_exibir = "Mover Persiana para Posição: " + sliderpersiana + "%"; }
	$("#sliderpersiana").val( "P" + FormatNumberLength(sliderpersiana, 3) );
	$("#sliderpersiana_exibir").text(sliderpersiana_exibir);
	}});
	
  });
  

	
	


  
	 $( function() {
    $( ".dataacao" ).datepicker();
	});
	
	$(function() {
     $(".timeacao").timeselector({ min: '00:00', max: '24:00' })
	});
	
	function FormatNumberLength(num, length) {
    var r = "" + num;
    while (r.length < length) {
        r = "0" + r;
    }
    return r;
}
			

</script>
<h5>Depois de Modificar click no botão "Atualizar" e depois "Fecha"</h5><b>
<form class="w3-container w3-card-4" method="POST" name="frm" id="frm">


<label class="w3-label w3-text-blue"><b>Dispositivo</b></label>
        <select class="w3-input w3-border dispositivo_atuador" name="dispositivo_atuador" id="dispositivo_atuador">
                    <option value="0:0" selected>Selecione um Dispositivo</option>
					<?php 
                    while($rec = mysqli_fetch_array($studentData)) { 
                         echo "<option value='" . $rec['id']  . ":" . $rec['tipo_geral'] . "'>" . $rec['Descricao'] . "</option>"; 
                     } 
                     ?>
          </select>
		  

<div name="tipogeral01" id="tipogeral01" style="display:none;">
<br>
<label class="w3-label w3-text-blue"><b>Tipo de Ação</b></label>
<br>
	<div id="radioset">
		<input type="radio" class="radiotipogeral" name="radiotipogeral01" id="radiotipogeral01_1" value="1" checked><label for="radio1">Ligar </label>
		<input type="radio" class="radiotipogeral" name="radiotipogeral01" id="radiotipogeral01_2" value="0"> <label for="radio2">Desligar</label>
	</div>

  <br>
<label class="w3-label w3-text-blue"><b>Data da Ação</b></label>

<br>
<input type="text" class="dataacao"  name="dataacao01" id="dataacao01">
<input type="checkbox" class="dataacaotododia" id="dataacaotododia01" name="dataacaotododia01" value="1"> Todos os dias<br>
<br>
<label class="w3-label w3-text-blue"><b>Hora da Ação</b></label>
<br>
<input type="text" class="timeacao"  name="timeacao01" id="timeacao01" />



</div>

<div name="tipogeral05" id="tipogeral05" style="display:none;">

<br>
<label class="w3-label w3-text-blue"><b>Tipo de Ação</b></label>
<br>
	<div id="radioset">
		<input type="radio" class="radiotipogeral" name="radiotipogeral05" id="radiotipogeral05_1" value="p1" checked><label for="radio1">Ligar </label>
		<input type="radio" class="radiotipogeral" name="radiotipogeral05" id="radiotipogeral05_2" value="p0"> <label for="radio2">Desligar</label>
	</div>

  <br>
<label class="w3-label w3-text-blue"><b>Data da Ação</b></label>

<br>
<input type="text" class="dataacao"  name="dataacao05" id="dataacao05">
<input type="checkbox" class="dataacaotododia" id="dataacaotododia05" name="dataacaotododia05" value="1"> Todos os dias<br>
<br>
<label class="w3-label w3-text-blue"><b>Hora da Ação</b></label>
<br>
<input type="text" class="timeacao"  name="timeacao05" id="timeacao05" />


</div>

<div name="tipogeral09" id="tipogeral09" style="display:none;">

<br>
<label class="w3-label w3-text-blue"><b>Posição da Persiana</b></label>
<br>

	<div id="slider"></div>
	<h6 id="sliderpersiana_exibir"></h6>
	<input type="text" class="sliderpersiana"  name="sliderpersiana" id="sliderpersiana" style="visibility:hidden"/>
	
  <br>  
<label class="w3-label w3-text-blue"><b>Data da Ação</b></label>

<br>
<input type="text" class="dataacao"  name="dataacao09" id="dataacao09">
<input type="checkbox" class="dataacaotododia" id="dataacaotododia09" name="dataacaotododia09" value="1"> Todos os dias<br>
<br>
<label class="w3-label w3-text-blue"><b>Hora da Ação</b></label>
<br>
<input type="text" class="timeacao"  name="timeacao09" id="timeacao09" />
</div>




<div name="tipogeral10" id="tipogeral10" style="display:none;">
<br>
<label class="w3-label w3-text-blue"><b>Tipo de Ação</b></label>
<br>
        <select class="w3-input w3-border" name="temperatura10" id="temperatura10">
				 <option value='XX!000!TOFF'>Desligar</option>
                 <option value='XX!000!T16'>Ligar em 16°C</option>
				 <option value='XX!000!T17'>Ligar em 17°C</option>
				 <option value='XX!000!T18'>Ligar em 18°C</option>
				 <option value='XX!000!T19'>Ligar em 19°C</option>
				 <option value='XX!000!T20'>Ligar em 20°C</option>
				 <option value='XX!000!T21'>Ligar em 21°C</option>
				 <option value='XX!000!T22'>Ligar em 22°C</option>
				 <option value='XX!000!T23'>Ligar em 23°C</option>
				 <option value='XX!000!T24'>Ligar em 24°C</option>
				 <option value='XX!000!T25'>Ligar em 25°C</option>
				 <option value='XX!000!T26'>Ligar em 26°C</option>
				 <option value='XX!000!T27'>Ligar em 27°C</option>
				 <option value='XX!000!T28'>Ligar em 28°C</option>
				 <option value='XX!000!T29'>Ligar em 29°C</option>

          </select>


<br>
<label class="w3-label w3-text-blue"><b>Data da Ação</b></label>
<br>
<input type="text" class="dataacao"  name="dataacao10" id="dataacao10">
<input type="checkbox" class="dataacaotododia" id="dataacaotododia10" name="dataacaotododia10" value="1"> Todos os dias<br>
<br>
<label class="w3-label w3-text-blue"><b>Hora da Ação</b></label>
<br>
<input type="text" class="timeacao"  name="timeacao10" id="timeacao10" />
</div>




<div name="tipogeral11" id="tipogeral11" style="display:none;">
<br>
<label class="w3-label w3-text-blue"><b>Tipo de Ação</b></label>
<br>
        <select class="w3-input w3-border" name="tv11" id="tv11">
                    <option value=POW>Liga/Desligar</option>
					<option value=MEN>Menu</option>
					<option value=CPL Canal>Incrementar Canal</option>
					<option value=CMI Canal>Decrementar Canal</option>
					<option value=VPL Volume>Aumentar Volume</option>
					<option value=VMI Volume>Diminuir Volume</option>
					<option value=MUD>Mudo</option>
					<option value=GUI>Guia</option>
					<option value=ENT>Entrada</option>
					<option value=OK>OK</option>          
					</select>


<br>
<label class="w3-label w3-text-blue"><b>Data da Ação</b></label>
<br>
<input type="text" class="dataacao"  name="dataacao11" id="dataacao11">
<input type="checkbox" class="dataacaotododia" id="dataacaotododia11" name="dataacaotododia11" value="1"> Todos os dias<br>
<br>
<label class="w3-label w3-text-blue"><b>Hora da Ação</b></label>
<br>
<input type="text" class="timeacao"  name="timeacao11" id="timeacao11" />
</div>




<div name="tipogeral14" id="tipogeral14" style="display:none;">

<br>
<label class="w3-label w3-text-blue"><b>Tipo de Ação</b></label>
<br>
	<div id="radioset">
		<input type="radio" class="radiotipogeral" name="radiotipogeral14" id="radiotipogeral14_1" value="1" checked><label for="radio1">Ligar </label>
		<input type="radio" class="radiotipogeral" name="radiotipogeral14" id="radiotipogeral14_2" value="0"> <label for="radio2">Desligar</label>
	</div>

  <br>
<label class="w3-label w3-text-blue"><b>Data da Ação</b></label>

<br>
<input type="text" class="dataacao"  name="dataacao14" id="dataacao14">
<input type="checkbox" class="dataacaotododia" id="dataacaotododia14" name="dataacaotododia14" value="1"> Todos os dias<br>
<br>
<label class="w3-label w3-text-blue"><b>Hora da Ação</b></label>
<br>
<input type="text" class="timeacao"  name="timeacao14" id="timeacao14" />


</div>


<div name="tipogeral20" id="tipogeral20" style="display:none;">

<br>
<label class="w3-label w3-text-blue"><b>Tipo de Ação</b></label>
<br>
	<div id="radioset">
		<input type="radio" class="radiotipogeral" name="radiotipogeral20" id="radiotipogeral20_1" value="P100" checked><label for="radio1">Abrir </label>
		<input type="radio" class="radiotipogeral" name="radiotipogeral20" id="radiotipogeral20_2" value="P100" checked><label for="radio1">Fechar </label>
		<input type="radio" class="radiotipogeral" name="radiotipogeral20" id="radiotipogeral20_3" value="P101" checked><label for="radio1">Parar Portão </label>
		<input type="radio" class="radiotipogeral" name="radiotipogeral20" id="radiotipogeral20_4" value="P102" checked><label for="radio1">Inverter Portão </label>

	</div>

  <br>
<label class="w3-label w3-text-blue"><b>Data da Ação</b></label>

<br>
<input type="text" class="dataacao"  name="dataacao20" id="dataacao20">
<input type="checkbox" class="dataacaotododia" id="dataacaotododia20" name="dataacaotododia20" value="1"> Todos os dias<br>
<br>
<label class="w3-label w3-text-blue"><b>Hora da Ação</b></label>
<br>
<input type="text" class="timeacao"  name="timeacao20" id="timeacao20" />



</div>

<div name="tipogeral21" id="tipogeral21" style="display:none;">
<br>
<label class="w3-label w3-text-blue"><b>Tipo de Ação</b></label>
<br>
	<div id="radioset">
		<input type="radio" class="radiotipogeral" name="radiotipogeral21" id="radiotipogeral21_1" value="1" checked><label for="radio1">Ligar </label>
		<input type="radio" class="radiotipogeral" name="radiotipogeral21" id="radiotipogeral21_2" value="0"> <label for="radio2">Desligar</label>
	</div>

  <br>
<label class="w3-label w3-text-blue"><b>Data da Ação</b></label>

<br>
<input type="text" class="dataacao"  name="dataacao21" id="dataacao21">
<input type="checkbox" class="dataacaotododia" id="dataacaotododia21" name="dataacaotododia21" value="1"> Todos os dias<br>
<br>
<label class="w3-label w3-text-blue"><b>Hora da Ação</b></label>
<br>
<input type="text" class="timeacao"  name="timeacao21" id="timeacao21" />
</div>

<div name="tipogeral22" id="tipogeral22" style="display:none;">
<br>
<label class="w3-label w3-text-blue"><b>Tipo de Ação</b></label>
<br>
	<div id="radioset">
		<input type="radio" class="radiotipogeral" name="radiotipogeral22" id="radiotipogeral22_1" value="1" checked><label for="radio1">Ligar </label>
		<input type="radio" class="radiotipogeral" name="radiotipogeral22" id="radiotipogeral22_2" value="0"> <label for="radio2">Desligar</label>
	</div>

  <br>
<label class="w3-label w3-text-blue"><b>Data da Ação</b></label>

<br>
<input type="text" class="dataacao"  name="dataacao22" id="dataacao22">
<input type="checkbox" class="dataacaotododia" id="dataacaotododia22" name="dataacaotododia22" value="1"> Todos os dias<br>
<br>
<label class="w3-label w3-text-blue"><b>Hora da Ação</b></label>
<br>
<input type="text" class="timeacao"  name="timeacao22" id="timeacao22" />


</div>


		  




<br>
<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<input type="text" class="tipogeral" name="tipogeral" id="tipogeral" style="visibility:hidden">
<?php 
echo $msg; 

?>
</form>

</body>
</html>