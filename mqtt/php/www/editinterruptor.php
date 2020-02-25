<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";



if(isset($_POST['btnSubmit'])) 
	{
		$id_widget = $_POST['dispositivos'];
		$codigo = $_POST['codigo'];
		$habilitado = $_POST['habilitado'];
		$estado = $_POST['estado'];
$query = "SELECT id, Descricao, proprietario, setName0, setSubTopic0, setPubTopic0  FROM `widget` where id='{$id_widget}'";
//echo $query;
mysqli_set_charset($con, 'utf8');
$studentData = mysqli_query($con, $query);
while($rec = mysqli_fetch_array($studentData)) { 
$id_widget = $rec['id']; 
$Descricao = $rec['Descricao'];
$setName0 = $rec['setName0'];
$setSubTopic0 = $rec['setSubTopic0'];;
$proprietario = $rec['proprietario'];
if($proprietario) {
$pos = strripos($setSubTopic0, "/");
$codigo_disp = substr("$setSubTopic0",$pos + 1);
$setPubTopic0 = "/house/confirma/" .  $codigo_disp;
}else 
{
$setPubTopic0 = $rec['setPubTopic0'];
}
}
		$query = "update `autohome`.`rx433mhz` set `codigo`= '{$codigo}', `id_widget`= '{$id_widget}', `topico` = '{$setSubTopic0}', `topico_confirma` = '{$setPubTopic0}', `descricao` =  '{$Descricao}',  `estado` =  '{$estado}', `habilitado` =  '{$habilitado}'  where id = '{$id}'";
	//	 $query = "INSERT INTO `autohome`.`rx433mhz` (`id`, `id_widget`, `codigo`, `topico` , `topico_confirma`, `carga`, `descricao`, `habilitado`) VALUES 
	//	                                      (NULL, '{$id}', '{$codigo}', '{$setSubTopic0}', '{$setPubTopic0}', '0', '{$Descricao}', '{$habilitado}');";
		// $query =  "INSERT INTO `autohome`.`rx433mhz` (`id`, `id_widget`, `codigo`, `data_ms`, `topico`, `topico_confirma`, `carga`, `descricao`, `habilitado`) VALUES (NULL, '0', 'AAAAA', '111111', '/house/CASA', '/house/confirma', '1', 'Teste', '1');";		
		
//		echo $query;
		if(mysqli_query($con, $query))
				{
				$msg = "Alteração Salva";
				} 
		else 
				{
				$msg = "Erro na Atualização";
				}

	}
https://www.google.com.br/imgres?imgurl=https%3A%2F%2Fcdn.thingiverse.com%2Frenders%2F49%2Fb5%2F4b%2F04%2F42%2Fe023d34b7527edf41a67d4ed8d8c2bf8_preview_card.JPG&imgrefurl=https%3A%2F%2Fwww.thingiverse.com%2Ftag%3ALDR&docid=lUih5DXbU7RTwM&tbnid=RTemp4y2E8d94M%3A&vet=10ahUKEwj1zcSpw7rbAhUKgJAKHdUwBYsQMwg6KAMwAw..i&w=292&h=219&bih=641&biw=1366&q=ldr%20THINGIVERSE%20esp8266&ved=0ahUKEwj1zcSpw7rbAhUKgJAKHdUwBYsQMwg6KAMwAw&iact=mrc&uact=8

$query = "SELECT id, Descricao, setName0, setSubTopic0, setPubTopic0  FROM `widget` where tipo =1 and `dispositivo_fisico` = '1'";
mysqli_set_charset($con, 'utf8');
$studentData = mysqli_query($con, $query);

$query = "SELECT * FROM `rx433mhz` where id ={$id}";
mysqli_set_charset($con, 'utf8');
$interruptor = mysqli_query($con, $query);
mysqli_close($con);
while($recinterruptor = mysqli_fetch_array($interruptor)) { 
 $codigo_interruptor = $recinterruptor['codigo'];
 $id_widget = $recinterruptor['id_widget'];
 $habilitado = $recinterruptor['habilitado'];
 $estado_default = $recinterruptor['estado'];
 
}


		if($habilitado == 1)
		{
			$habilitado_t = 'checked';
		}else 
		{
			$habilitado_t = '';
		} 
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
    });
    

</script>
<h5>Depois de Modificar click no botão "Atualizar" e depois "Fecha"</h5><b>
<form class="w3-container w3-card-4" method="POST" name="frm">
<label class="w3-label w3-text-blue"><b>Codigo</b></label>
<input type="text" class="w3-input w3-border" value="<?php echo $codigo_interruptor; ?>" name="codigo" maxlength=16/>

<label class="w3-label w3-text-blue"><b>Dispositivo a ser acionado</b></label>
        <select class="w3-input w3-border" name="dispositivos">
                    <?php 
                    while($rec = mysqli_fetch_array($studentData)) { 
                         echo "<option value=" . $rec['id'];  if ($id_widget==$rec['id']){echo " selected='selected'";} echo ">" . $rec['Descricao'] . "</option>"; 
                     //	 if ($id_widget==$rec['id']){$estado_default = $rec['estado'] ;}
                     //	 echo $estado_default;
                     } 
                     ?>
       </select>
          
          

<label class="w3-label w3-text-blue"><b>Estado</b></label>
 <select name="estado" id="estado" class="w3-input w3-border" >
  <option value="X" <?php    if ($estado_default == "X"){echo " selected='selected'";}  ?> >Alternar</option>
  <option value="1" <?php    if ($estado_default == "1"){echo " selected='selected'";}  ?> >Somente Ligar</option>
  <option value="0" <?php    if ($estado_default == "0"){echo " selected='selected'";}  ?> >Somente Desligar</option>
</select> 

<input type="checkbox" name="habilitado" value="1" <?php  echo $habilitado_t ?> />Habilitado<br>
<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php echo $msg; ?>
</form>
</body>
</html>