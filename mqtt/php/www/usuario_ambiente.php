<?php
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";
$imeimovel = isset($_GET['imeimovel']) ? $_GET['imeimovel'] : "0";

mysqli_set_charset($con, 'utf8');
$query = "SELECT usuario_widget.id, id_usuario, widget.Descricao, widget.pin_iphone, widget.username_iphone, usuario.imei FROM `usuario_widget`, widget, usuario WHERE widget.id = usuario_widget.id_widget AND id_usuario = $id AND usuario.id = $id";
$query2 = "SELECT id, widget.Descricao FROM `widget` WHERE widget.tipo = 1";
$query3 = "SELECT usu_bb, se_bb FROM `servidor`";

$ambiente_data = mysqli_query($con, $query);
$ambiente_data2 = mysqli_query($con, $query);
$dispositivos = mysqli_query($con, $query2);
$servidor = mysqli_query($con, $query3);

$valendo = false;

$row_cnt = $ambiente_data2->num_rows;
//echo $row_cnt;

while($rec2 = mysqli_fetch_assoc($ambiente_data2)) { 
	$Jsonresul2 .= ('"' . str_replace(':', '', $rec2['username_iphone']) .'":"' . $rec2['id']  . '",');
	$imei = $rec2['imei'];
	$valendo = true;
} 

if($valendo || $row_cnt == 0)
{
	$valendo = false;
$mensagem =  '{' . $Jsonresul2 .  ' "md5" : "0", "_imei" : "' . $imei . '" }';

if ($row_cnt == 0)
{
	$mensagem =  '{ "md5" : "0", "_imei" : "' . $imeimovel . '" }';
}

$rec3 = mysqli_fetch_array($servidor);


$topico = "/house/selectdevicebymobile/mobile";
$reter = "1";
$reterned = '';
$usuario = $rec3['usu_bb'];
$senha = $rec3['se_bb'];

if($reter==1) {$reterned = '-r';};
$output = shell_exec("mosquitto_pub -h mqttautodomo -d -u {$usuario} -P {$senha} -t '{$topico}' -m '{$mensagem}' -q 1 {$reterned}");

	
}else{

}

if(isset($_POST['btnSubmit'])) 
	{
		$ambiente = $_POST['ambiente'];



		//$query = "update pushover set user_key = '{$user_key}', device = '{$device}', habilitado='{$habilitado}' where id = '{$id}'";
		$query = "	INSERT INTO `autohome`.`ambiente` (`id`, `Descricao`, `codigo`) VALUES (NULL, '{$ambiente}', '3');";	
	//	echo $query;
		if(mysqli_query($con, $query))
				{
				$msg = "Alteração Salva";
				header("location:insertambiente.php");
				} 
		else 
				{
				$msg = "Erro na Atualização";
				}
	}
	
	mysqli_close($con);

?>

<html>
<head>
<link href="/css/main.css" rel="stylesheet" type="text/css"/> 
<link href="/css/w3.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn').click(function () {
            window.opener.location.reload(true);
            window.close();
        });
        
        	   $('#btnSubmit').click(function () {
	      //	setTimeout(function(){}, 1000); 
            location.reload(true);
        });
    });
    
    function delete_ambiente()
  {
	 //mostrando o retorno do post
	var id = $( "#dispositivos" ).val();
  // alert(texto);
		var r = confirm("Tem Certeza que deseja deletar o dispositivo!");
		if (r == true) {
	      $.post('delete_dispositivo_usuario.php',{id: id},function(data){})
	     // location.reload(true);
	      window.opener.location.reload(true)
	      location.reload();
		} else {
		//alert("You pressed Cancel!");
		}
	}
	
	
	 function inserir_dispositivo()
  {
	 //mostrando o retorno do post
	var id = $( "#dispositivos_agrupa" ).val();
		$.post('inserir_dispositivo_usuario.php',{id: id},function(data){})
	     // location.reload(true);
	      window.opener.location.reload(true)
	      location.reload();
	}
	

</script>
<h5>Depois de Modificar click no botão "Atualizar" e depois "Fecha"</h5>
<form class="w3-container w3-card-4" method="POST">

	<label class="w3-label w3-text-blue"><b>Dispositivo a ser adcionado</b></label>
        <select class="w3-input w3-border" id="dispositivos_agrupa" name="dispositivos_agrupa" size="10" onClick="return inserir_dispositivo()">
                    <?php 
                    while($rec = mysqli_fetch_array($dispositivos)) { 
                         echo "<option value=" . $rec['id'] . "-" . $id . ">" . $rec['Descricao'] . "</option>"; 
                     } 
                     ?>
          </select>
		  
<label class="w3-label w3-text-blue"><b>Ambientes (Cômodos)</b></label>
        <select class="w3-input w3-border" id="dispositivos"  name="dispositivos" size="10" onClick="return delete_ambiente()">
										<?php 
										
                    while($rec3 = mysqli_fetch_array($ambiente_data )) { 
                         echo "<option value=" . $rec3['id']  .  ">" . $rec3['Descricao'] . "</option>"; 
                     } 
                     ?>
          </select><p>

		  
     
<input type="submit" class="w3-btn w3-blue" id="btnSubmit" name="btnSubmit" value="Salva"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><br><p>
<?php echo $msg; ?>
</form>
</body>
</html>