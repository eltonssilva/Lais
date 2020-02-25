<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
//echo "Olá, " . $_SESSION['usuarioLogin'];
$endereco = $_SERVER[HTTP_HOST];

if ($endereco == 'localhost')
{
	$endereco = 'localhost';
}
else 
{
	$posicao = strpos($endereco, ':');
	$endereco = substr($endereco, 0 , $posicao );
}
//echo $endereco;

$topic = $_GET['topic'];
$id = $_GET['id'];
?>

<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query = "SELECT * FROM `widget` where id = '$id'";
mysqli_set_charset('utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);

while($rec = mysqli_fetch_array($data)) { 

$ambiente = $rec['ambiente'];
$topico = $rec['setSubTopic0'];
$topico_pub = $rec['setPubTopic0'];
$dispositivo = $rec['Descricao'];
$desc_ambiente = '';
$valor = '';
$checked = 'Ligado';
$tipo_geral = $rec['tipo_geral'];

}

$con2 = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query2 = "SELECT * FROM `ambiente` where id = '{$ambiente}'";
mysqli_set_charset('utf8');
$data2 = mysqli_query($con2, $query2);
mysqli_close($con2);
while($rec2 = mysqli_fetch_array($data2)) 
{ 
$desc_ambiente = $rec2['Descricao'];
}

$con3 = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query3 = "SELECT * FROM `historico_mqtt` where topico ='{$topico}'";
//echo $query3;
mysqli_set_charset('utf8');
$data3 = mysqli_query($con3, $query3);
mysqli_close($con3);
while($rec3 = mysqli_fetch_array($data3)) 
{ 
$valor = $rec3['valor'];
$dia = $rec3['data'];
}


mysqli_close($con);
mysqli_close($con2);
mysqli_close($con3);
?>


<!DOCTYPE html>
<html dir="ltr" lang="pt-BR" style="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>AutoHome</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<link href="/css/main_m.css" rel="stylesheet" type="text/css"/>  
<script src="/js/jquery-1.10.2.js"></script>
<script src="/js/jscolor.js"></script>
<script src="http://<?php echo $endereco; ?>:4555/socket.io/socket.io.js"></script>
<script src="/js/jquery-1.7.2.min.js"></script>
<script src="/js/iro.js-master/dist/iro.js" charset="utf-8"></script>
<script>


   


		var socket = io('http://<?php echo $endereco; ?>:4555', {transports: ['websocket', 'polling', 'flashsocket']});
	  socket.on('notificacao', function (data) {

var traco1 =   data.indexOf('-', 0);
var traco2 =   data.indexOf('-', traco1 + 1);
var barra2 =   data.indexOf('/', traco2 + 3);
var barra3 =   data.indexOf('/', barra2 + 1);
if (barra3 == -1) {barra3 = data.length;}

var id = data.substring(0,traco1);
var valor = data.substring(traco1+1,traco2);
var semi_topico = data.substring(barra2+1,barra3);
//$("#h4data").text(id);

	   	var date_ = new Date();
	   	var day_ = date_.getDate();
  			var month_ = date_.getMonth();
  			var year_ = date_.getFullYear();
  			var hora_ = date_.getHours();
  			var minuto_ = date_.getMinutes();
  			var segundo_ = date_.getSeconds();
  			


<?php if( $tipo_geral =='2'){
echo 'if ((semi_topico == "umidade") && (id=="'. $id .'")) { $("#valor").text(valor + "%"); $("#h4data").text("Atualizado em " + day_ +"/"+ month_ +"/"+ year_ +" "+ hora_ +":"+ minuto_ +":"+ segundo_);}';

}?>
<?php if( $tipo_geral =='3'){echo 'if ((semi_topico == "temp") && (id=="'. $id .'")) { $("#valor").text(valor + "°C (" + ((valor * 1.8) + 32 ).toFixed(1) + "°F)"); $("#h4data").text("Atualizado em " + day_ +"/"+ month_ +"/"+ year_ +" "+ hora_ +":"+ minuto_ +":"+ segundo_);}';}?>
<?php if( $tipo_geral =='4'){echo 'if ((semi_topico == "lux") && (id=="'. $id .'")) { $("#valor").text(valor + " lux"); $("#h4data").text("Atualizado em " + day_ +"/"+ month_ +"/"+ year_ +" "+ hora_ +":"+ minuto_ +":"+ segundo_);}';}?>
<?php if( $tipo_geral =='6'){echo 'if ((semi_topico == "umidadesolo") && (id=="'. $id .'")) { $("#valor").text(valor + "%"); $("#h4data").text("Atualizado em " + day_ +"/"+ month_ +"/"+ year_ +" "+ hora_ +":"+ minuto_ +":"+ segundo_);}';}?>
<?php if( $tipo_geral =='7'){echo 'if ((semi_topico == "pressao") && (id=="'. $id .'")) { $("#valor").text((valor/101325).toFixed(3) + "Atm (" + valor + "Pa)"); $("#h4data").text("Atualizado em " + day_ +"/"+ month_ +"/"+ year_ +" "+ hora_ +":"+ minuto_ +":"+ segundo_);}';}?>
<?php if( $tipo_geral =='8'){echo 'if ((semi_topico == "altitude") && (id=="'. $id .'")) { $("#valor").text(valor + "m"); $("#h4data").text("Atualizado em " + day_ +"/"+ month_ +"/"+ year_ +" "+ hora_ +":"+ minuto_ +":"+ segundo_);}';}?>



});









</script>




</head>
<body bgcolor="#AFEEEE">
<div id="divcenter" class="divcenter">
<h3><?php echo $dispositivo; ?></h3>
<h4><?php echo $desc_ambiente; ?></h4>
<?php if( $tipo_geral =='2')
{ ?>
<img src="/png/64/drop.png" alt="Smiley face" height="64" width="64">
<h5 id="valor"><?php echo $valor; ?>%</h5>
<?php } ?>

<?php if( $tipo_geral =='3')
{ ?>
<img src="/png/64/temperature.png" alt="Smiley face" height="64" width="64">
<h5 id="valor"><?php echo $valor; ?> <sup>o</sup>C</h5>
<?php } ?>

<?php if( $tipo_geral =='4')
{ ?>
<img src="/png/64/lux.png" alt="Smiley face" height="64" width="64">
<h5 id="valor"><?php echo $valor; ?> lux</h5>
<?php } ?>

<?php if( $tipo_geral =='6')
{ ?>
<img src="/png/64/houseplant.png" alt="Smiley face" height="64" width="64">
<h5 id="valor"><?php echo $valor; ?> %</h5>
<?php } ?>

<?php if( $tipo_geral =='7')
{ ?>
<img src="/png/64/atmospheric_pressure.png" alt="Smiley face" height="64" width="64">
<h5 id="valor"><?php echo $valor; ?> Pa</h5>
<?php } ?>

<?php if( $tipo_geral =='8')
{ ?>
<img src="/png/64/altitude.png" alt="Smiley face" height="64" width="64">
<h5 id="valor"><?php echo $valor; ?>m</h5>
<?php } ?>



<h5 id="h4data"><?php echo $dia; ?></h5>

</div>
</body>
</html>