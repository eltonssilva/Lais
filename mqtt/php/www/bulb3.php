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

<!DOCTYPE html>
<html dir="ltr" lang="pt-BR" style="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>AutoHome</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<link href="/css/main_m.css" rel="stylesheet" type="text/css"/>  

<meta name="description" content="CSS Button Switches with Checkboxes and CSS3 Fanciness" />
<meta name="keywords" content="css3, css-only, buttons, switch, checkbox, toggle, web design, web development" />
<meta name="author" content="Elton de Sousa e Silva" />
<link rel="shortcut icon" href="../favicon.ico"> 
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300' rel='stylesheet' type='text/css' />
		
<script src="/js/jquery-1.10.2.js"></script>
<script src="/js/jscolor.js"></script>
<script src="http://<?php echo $endereco; ?>:4555/socket.io/socket.io.js"></script>
<script src="/js/jquery-1.7.2.min.js"></script>
<script>

var status_lamp = '0';

var width = screen.width;
var height = screen.height;

//alert(width + " " + height);

//$(".bulb").attr("width", width * 0.6);
//$(".bulb").attr("height", height * 0.5);


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
status_lamp = valor;


	   
	 /// alert("Teste");
	   if ((semi_topico == 'iluminacao') && (id ==  <?php echo $id; ?>))
	   {  
	   	var date_ = new Date();
	   	var day_ = date_.getDate();
  			var month_ = date_.getMonth();
  			var year_ = date_.getFullYear();
  			var hora_ = date_.getHours();
  			var minuto_ = date_.getMinutes();
  			var segundo_ = date_.getSeconds();
  			
	   	if (valor == 1)
	   		{
	   		//	alert("on" + valor);
	   		//	$("." + id ).attr('checked', true); h4data
	   			$("#h4data").text("Ligado em " + day_ +"/"+ month_ +"/"+ year_ +" "+ hora_ +":"+ minuto_ +":"+ segundo_);
	   			$("#bulb" + id).attr("src", "/png/switch_on.png");
	   			$("#bulb" + id).attr("width", width * 0.6);
	   			$("#bulb" + id).attr("height", height * 0.5);
	   		}else {
	   		//	alert("off" + valor);
	   		//	$("." + id ).attr('checked', false);
	   			$("#h4data").text("Desligado em " + day_ +"/"+ month_ +"/"+ year_ +" "+ hora_ +":"+ minuto_ +":"+ segundo_ );
	   			$("#bulb" + id).attr("src", "/png/switch_off.png");
	   			$("#bulb" + id).attr("width", width * 0.6);
	   			$("#bulb" + id).attr("height", height * 0.5);
	   		}  
	   }
	   

});

	function pubmqtt(name_, topico, reter)
  {



	 //mostrando o retorno do post
	
  //  alert(name_);
	if(name_ == "0") {
   // alert("Ligado");
  	 $.post('pub.php',{mensagem: '1', topico: topico, reter: reter},function(data){
   }) 
	} else {
 //  alert("Deligado");
  $.post('pub.php',{mensagem: '0', topico: topico, reter: reter},function(data){
   })
 
	}


	
	}
	
</script>

<?php
$con = mysql_connect($DB_SERVER, $DB_USER, $DB_PASS);
mysql_select_db($DB_NAME, $con);
$query = "SELECT * FROM `widget` where id = '$id'";
mysql_set_charset('utf8');
$data = mysql_query($query);
mysql_close($con);

while($rec = mysql_fetch_array($data)) { 

$ambiente = $rec['ambiente'];
$topico = $rec['setSubTopic0'];
$topico_pub = $rec['setPubTopic0'];
$dispositivo = $rec['Descricao'];
$desc_ambiente = '';
$valor = '';
$checked = 'Ligado';
}

$con2 = mysql_connect($DB_SERVER, $DB_USER, $DB_PASS);
mysql_select_db($DB_NAME, $con2);
$query2 = "SELECT * FROM `ambiente` where id = '{$ambiente}'";
mysql_set_charset('utf8');
$data2 = mysql_query($query2);
mysql_close($con2);
while($rec2 = mysql_fetch_array($data2)) 
{ 
$desc_ambiente = $rec2['Descricao'];
}

$con3 = mysql_connect($DB_SERVER, $DB_USER, $DB_PASS);
mysql_select_db($DB_NAME, $con3);
$query3 = "SELECT * FROM `historico_mqtt` where topico ='{$topico}'";
//echo $query3;
mysql_set_charset('utf8');
$data3 = mysql_query($query3);
mysql_close($con3);
while($rec3 = mysql_fetch_array($data3)) 
{ 
$valor = $rec3['valor'];
$dia = $rec3['data'];
}

if($valor == 1)
	{
			$checked = 'Ligado';
			$bulb = '/png/switch_on.png';
	}else 
	{
			$checked = 'Desligado';
			$bulb = '/png/switch_off.png'; 
	}

mysql_close($con);
mysql_close($con2);
mysql_close($con3);
?>


</head>
<body bgcolor="#AFEEEE">
<div id="divcenter" class="divcenter">
<h2><?php echo $dispositivo; ?></h2>
<h3><?php echo $desc_ambiente; ?></h3>
<img id="<?php echo 'bulb' . $_GET['id']; ?>" class="bulb" onclick="return pubmqtt(status_lamp, '<?php echo $topico_pub; ?>', '1')" src="<?php echo $bulb; ?>" alt="Smiley face" height="53%" width="63%" align="middle">
<h4 id="h4data"><?php echo $checked  . ' em ' . $dia; ?></h4>
</div>
</body>
</html>