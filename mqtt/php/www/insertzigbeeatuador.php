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
		$acao = $_POST['acao'];
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

      //     $('#btnSubmit').click(function () {
			// //		alert("1223");
		  //  $("#codigo433mhz1").text("Codigo Controle: ");
            
			// }); 
 
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
<input type="text" class="w3-input w3-border" value= "";  name="serialzigbee" id="serialzigbee"  maxlength=16/>
<br>
<label class="w3-label w3-text-blue"><b>Tipo de Ação</b></label>

<input type="text" class="w3-input w3-border" value= "";  name="acao" id="acao"  maxlength=16/>
<br>

<label class="w3-label w3-text-blue"><b>Modelo Dispositivo</b></label>
<select class="w3-input w3-border" name="modelo" id="modelo">
  <option value="ZNLDP12LM" selected>ZNLDP12LM</option> 
</select>


<br>


<input type="submit" class="w3-btn w3-blue" id='btnSubmit' name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php 
echo $msg; 

?>
</form>

</body>
</html>