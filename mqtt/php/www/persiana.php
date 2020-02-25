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

$id = $_GET['id'];
//echo "id" . $id;
?>



<html dir="ltr" lang="pt-BR" style="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>AutoDomum</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/ranger.css?id=4" type="text/css">

<body id="body">
<script src="js/jquery-3.2.1.js"></script>
<script src="js/materialize.min.js"> </script> 
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
var valor_semP = valor.substring(1);


	   if (semi_topico == 'persiana') 
	   { 
		//	alert(valor_semP + " " + id);
	   			$("#myRange" + id ).val(valor_semP);
	   			$("#porcentagem").text(valor_semP + "%");
	
	   }
	   
	   
	   

});


		function  pubmqttpersianaranger (topico, name_, reter, id_)
  {

//mostrando o retorno do post
	
	
	var slide_posicao = document.getElementById(name_);
	var posicao = slide_posicao.value;
	
	
  r = posicao;
   
		
    if (r.length == 1 )  // Corrigindo Tamanho da string no braço
{
	r = "P00" + r;
}

	if (r.length == 2 )  // Corrigindo Tamanho da string no braço
	{
	r = "P0" + r;
	}
	
		if (r.length == 3 )  // Corrigindo Tamanho da string no braço
	{
	r = "P" + r;
	}

  // alert(r);
//alert(topico + " " + name_ + " " +  r);

	 $("#porcentagem").text(posicao + "%");
  	 $.post('pub.php',{mensagem: r, topico: topico, reter: reter},function(data){
   }) 
   
   
}
	
</script>


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
$query3 = "SELECT * FROM `historico_mqtt` where topico ='{$topico_pub}'";
//echo $query3;
mysqli_set_charset('utf8');
$data3 = mysqli_query($con3, $query3);
mysqli_close($con3);
while($rec3 = mysqli_fetch_array($data3)) 
{ 
$valor = substr($rec3['valor'],1);  // Pega o Valor da posicao da persiana porem somente aparti do segundo caracter Exemplo P090 somente 090
$dia = $rec3['data'];
}

if($valor == 1)
	{
			$checked = 'checked';
	}else 
	{
			$checked = '';
	}

mysqli_close($con);
mysqli_close($con2);
mysqli_close($con3);
?>

	<div align="center">
			<h2><?php echo $dispositivo; ?></h2>
			<h3><?php echo $desc_ambiente; ?></h3>
			<h4 id="porcentagem"><?php echo $valor . "%"; ?></h4>
	</div>


	<form action="#">
    	<p class="range-field" >
    	<input type="range" onchange="return pubmqttpersianaranger( '<?php echo $topico_pub; ?>', 'myRange<?php echo $id; ?>', '1', '<?php echo $id; ?>')" min="0" max="100" value="<?php echo $valor; ?>" class="slider <?php echo $id; ?> range vertical-heighest-first round" id="myRange<?php echo $id; ?>">
   	</p>
  	</form>

</body>

</html>