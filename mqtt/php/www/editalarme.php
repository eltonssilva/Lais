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
$query = "SELECT id, Descricao, proprietario, username_iphone, setName0, setSubTopic0, setPubTopic0  FROM `widget` where id='{$id_widget}'";
//echo $query;
mysqli_set_charset('utf8');
$studentData = mysqli_query($con, $query);
while($rec = mysqli_fetch_array($studentData)) { 
$id_widget = $rec['id']; 
$Descricao = $rec['Descricao'];
$setName0 = $rec['setName0'];
$setSubTopic0 =  $rec['setSubTopic0'];
$setPubTopic0 = $rec['setSubTopic0'];
$proprietario = $rec['proprietario'];

}
		$query = "update `autohome`.`rx433mhz_alarmes` set `codigo`= '{$codigo}', `id_widget`= '{$id_widget}', `topico` = '{$setPubTopic0}', `topico_confirma` = '{$setSubTopic0}', `descricao` =  '{$Descricao}',  `carga` =  '1', `habilitado` =  '{$habilitado}'  where id = '{$id}'";

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

$query = "SELECT id, Descricao, setName0, setSubTopic0, setPubTopic0  FROM `widget` where widget.tipo_geral = 21";
mysqli_set_charset('utf8');
$studentData = mysqli_query($con, $query);

$query = "SELECT * FROM `rx433mhz_alarmes` where id ={$id}";
mysqli_set_charset('utf8');
$interruptor = mysqli_query($con, $query);
mysqli_close($con);
while($recinterruptor = mysqli_fetch_array($interruptor)) { 
 $codigo_interruptor = $recinterruptor['codigo'];
 $id_widget = $recinterruptor['id_widget'];
 $habilitado = $recinterruptor['habilitado'];
 $estado_default = $recinterruptor['carga'];
 
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
          
          


<input type="checkbox" name="habilitado" value="1" <?php  echo $habilitado_t ?> />Habilitado<br>
<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php echo $msg; ?>
</form>
</body>
</html>