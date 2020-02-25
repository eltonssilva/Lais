<?php
include("segurancasupervisorio.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
//echo "Pronto ";
//echo $_SESSION['usuarioNomeSupervisorio'];

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




$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS,$DB_NAME );
$CODICAO = " (widget.tipo_geral = '1'  OR  widget.tipo_geral = '2'  OR  widget.tipo_geral = '3' OR  widget.tipo_geral = '14' OR  widget.tipo_geral = '10' ) ";
$query = "SELECT widget.id, widget.Descricao, widget.setSubTopic0, widget.setName0,  widget.tipo_geral, widget.setPubTopic0, widget.username_iphone, nivel.nivel, ambiente.Descricao ambiente from widget, ambiente, nivel WHERE {$CODICAO} AND widget.dispositivo_fisico = 1 AND widget.ambiente = ambiente.id AND nivel.id = ambiente.codigo";
mysqli_set_charset('utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);




?>

<html>
<head>

		
		
    <meta charset="UTF-8" />
    <title>Filtros agrupados</title>


<link href="/css/jquery.dataTables.min.css?v=3" rel="stylesheet" type="text/css"/> 
<script src="/js/jquery-3.3.1.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<link href="/css/main.css" rel="stylesheet" type="text/css"/> 
<link href="../css/custon.css?v=3" rel="stylesheet" type="text/css"/> 
<script src="http://<?php echo $endereco; ?>:4555/socket.io/socket.io.js"></script>
 <script type="text/javascript">
 var socket = io('http://<?php echo $endereco; ?>:4555', {transports: ['websocket', 'polling', 'flashsocket']});
</script>
<script src="/js/supervisorio.js"></script>

	
</head>
<body>
<a href="https://www.extranet.ceuma.br/novoportal/" imageanchor="1" style="clear: left; float: left; margin-bottom: 1em; margin-right: 1em;"><img alt="Uniceuma" border="0" height="72" src="png/ceuma.png" title="Uniceuma" width="72" /></a><br />
<a href="http://www.autodomo.com.br/" imageanchor="1" style="clear: right; float: right; margin-bottom: 1em; margin-left: 1em;"><img alt="AutoDomum" border="0" height="72" src="png/logo_autodomum.jpg" title="AutoDomum" width="72" /></a></div>

<h1 class="central">Gerenciamento</h1>


<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Dispositivo</th>
                <th>Prédio</th>
				<th>Sala</th>
                <th>Descrição</th>
                <th>Status</th>
             
            </tr>
        </thead>
        <tbody>
		
	
<?php while($rec = mysqli_fetch_array($data)) { 
$Descricao = $rec['Descricao'];
$setSubTopic0 = $rec['setSubTopic0'];
$setPubTopic0 = $rec['setPubTopic0'];
$setName0 = $rec['setName0'];
$nivel = $rec['nivel'];
$ambiente = $rec['ambiente'];
$tipo_geral = $rec['tipo_geral'];
$username_iphone = str_replace(":","",$rec['username_iphone']);
$complemento= '<a href="#">';
$topico_para_publicar = $setPubTopic0;
$botao = true;

$con3 = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query3 = "SELECT * FROM `historico_mqtt` where topico ='/house/confirma/{$username_iphone}'"; 
//echo $query3;
mysqli_set_charset('utf8');
$data3 = mysqli_query($con3, $query3);
//mysqli_close($con3);
while($rec3 = mysqli_fetch_array($data3)) 
{ 
$valor = $rec3['valor'];
}

$query3 = "SELECT * FROM `historico_mqtt` where topico ='{$setPubTopic0}'"; 
//echo $query3;
mysqli_set_charset('utf8');
$data3 = mysqli_query($con3, $query3);
mysqli_close($con3);
while($rec3 = mysqli_fetch_array($data3)) 
{ 
$valor2 = $rec3['valor'];
}




//echo $valor . " " . $tipo_geral . "<br>";
 if($tipo_geral =='1')
{ 
$botao = true;
if($valor == "On")
	{
			$checked = 'checked';
			$bulb = '/png/64/bulb_on.png';
	}
elseif ($valor == "Off")
	{
			$checked = '';
			$bulb = '/png/64/bulb.png'; 
	}
	
}

 if($tipo_geral =='2')
{
	$botao = false;


			$bulb = '/png/64/drop.png';
			$status =  $valor2 . "%";
}

 if($tipo_geral =='3')
{ 
	$botao = false;

			$bulb = '/png/64/temperature.png';
			$status = $valor2 . "°C";
}


 if($tipo_geral =='14')
{ 
	$botao = true;

if($valor == "On")
	{
			$checked = 'checked';
			$bulb = '/png/64/power_on.png';
	}
elseif ($valor == "Off")
	{
			$checked = '';
			$bulb = '/png/64/power.png'; 
	}
	
}

 if($tipo_geral =='10')
{ 
$botao = false;
$bulb = '/png/64/airconditioningindoor.png';
$complemento = '<a href="#modal">';
$topico_para_publicar = '/house/ifredarc/' . $username_iphone;
if($valor == "On")
	{
			$checked = 'checked';
	}
elseif ($valor == "Off")
	{
			$checked = '';
	}
	
}

?>
	
			
			<tr>
			
                <td>
				<?php echo $nivel; ?> 
				</td>
				
                <td>
				<?php echo $ambiente; ?> 
				</td>
				
				 <td>
				<?php echo $Descricao; ?> 
				</td>
				
                <td>
				
				<?php echo $complemento; ?> <img id="bulb<?php echo $rec['id']; ?>" src= <?php echo "'" . $bulb . "'"; ?>  onclick="return topicosendoutilizado('<?php echo $topico_para_publicar; ?>')"  class=" bulb<?php echo $username_iphone; ?>" alt="Dispositivo" height="32" width="32"/></a>
				</td>
				



				 
                <td class="<?php echo $rec['id']; ?>" >
				<?php   if(!$botao) echo "<!--";   ?> 
				 <div class="onoffswitch">
					 <input type="checkbox" onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>',  '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?> <?php echo $username_iphone; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
					<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
					<span class="onoffswitch-inner"></span>
					<span class="onoffswitch-switch"></span>
					</label>
					
				</div>
				<?php   if(!$botao) echo "-->" . $status;   ?> 

				
				</td>
				
            </tr>
			
<?php
}
?>
		   
        <tfoot>
            <tr>
                <th>Prédio</th>
                <th>Descrição</th>
                <th>Laboratorio</th>
                <th>Dispositivo</th>
                <th>Status</th>
            </tr>
        </tfoot>
    </table>
	
	        <div class="modal" id="modal"><div class="modal__content"><a href="#" class="modal__close">&times;</a> 
			    <div class="display_lcd">
				<h1 class="h1_display_lcd" id="display_lcd">16°C</h1>
				</div>
				
				<div class="teclas_lcd_Linha1">
	
				<button class="button_on" id="button_on"   onclick="return pubair(topico_sendo_utilizado, 'on' ,  '1')" >Ligar</button>
				<button class="button_off" id="button_off" onclick="return pubair(topico_sendo_utilizado, 'off' ,  '1')" >Desligar</button>
				
				</div>
				
				<div class="teclas_lcd_Linha1">
				<button class="button_on" id="button_plusch" onclick="return pubair(topico_sendo_utilizado, 'plustemp' ,  '1')" >+</button>
				</div>
				
				<div class="teclas_lcd_Linha1">
				<button class="button_on" id="button_minusfan" onclick="return pubair(topico_sendo_utilizado, 'minusfan' ,  '1')" >-</button>
				<button class="button_off" id="button_plusfan" onclick="return pubair(topico_sendo_utilizado, 'plusfan' ,  '1')" >+</button>
				</div>
				
						<div class="teclas_lcd_Linha1">
				<button class="button_on" id="button_minusch" onclick="return pubair(topico_sendo_utilizado, 'minustemp' ,  '1')" >-</button>
				</div>
				
				<div class="teclas_lcd_Linha1">
				<button class="button_on" id="button_modo" onclick="return pubair(topico_sendo_utilizado, 'modo' ,  '1')" >Modo</button>
				<button class="button_off" id="button_oscilar" onclick="return pubair(topico_sendo_utilizado, 'oscilar' ,  '1')" >Oscilar</button>
				</div>

			
	      </div> </div> 

</body>
</html>