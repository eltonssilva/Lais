<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";

		$id = $_GET['id'];
		$descricao= $_GET['descricao'];

if(isset($_POST['btnSubmit'])) 
	{
	$comandos_infrared= $_POST['comandos_infrared'];
    $codigo = $_POST['codigo'];
	$arr = explode(":",$comandos_infrared);
	$comandos_infrared = $arr[0];
	$descricaocomando = $arr[1];
	
	$query = "SELECT * FROM `controle_ir` WHERE comando = '{$comandos_infrared}' AND dispositivo = '{$id}'";
	$dadosdobanco = mysqli_query($con, $query);
	$confirma1 = false;
	while($rec = mysqli_fetch_array($dadosdobanco)) {
	$confirma1 = true;
}

		if (!$confirma1)
		{
			$query =  "INSERT INTO `controle_ir` (`id`, `dispositivo`,  `descricaocomando`, `comando`, `codigo`, `modo`) VALUES (NULL, '{$id}', '{$descricaocomando}',  '{$comandos_infrared}', '{$codigo}', 'TV');";
		}
		else
		{	
			$query =  "UPDATE `controle_ir` SET `codigo` = '{$codigo}', `descricaocomando` = '{$descricaocomando}' WHERE `controle_ir`.`comando` = '{$comandos_infrared}' AND dispositivo = '{$id}';";
		}
		
		if(mysqli_query($con, $query))
				{
				$msg = "Alteração Salva";
				} 
		else 
				{
				$msg = "Erro na Atualização";
				}

}


//echo $query . " " . $confirma1;

$query = "SELECT * FROM `comandos_infrared` WHERE tipoequipamento = '2'";
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn').click(function () {
            window.opener.location.reload(true);
            window.close();
             }); 
            $('#codigo').keyup(function () {
    //   		alert($('#codigo').val());
        });
          $('#btnSubmit').click(function () {
		//			alert($('#codigo').val());
             }); 

    });
    

</script>
<h5>Depois de Modificar click no botão "Atualizar" e depois "Fecha"</h5><b>
<form class="w3-container w3-card-4" method="POST" name="frm" id="frm">
<label class="w3-label w3-text-blue"><b>Descrição</b></label>
<input type="text" class="w3-input w3-border" value= "<?php echo $descricao; ?>";  name="descricao" id="descricao" readonly maxlength=16/>



<label class="w3-label w3-text-blue"><b>Descrição do Controle/Marca</b></label>
        <select class="w3-input w3-border" name="comandos_infrared" id="comandos_infrared">
                    <?php 
                    while($rec = mysqli_fetch_array($studentData)) { 
                         echo "<option value=" . $rec['tag_comando'] .":" . $rec['descricaocomando'] . ">" . $rec['descricaocomando'] .  "</option>"; 
                     } 
                     ?>
          </select>

<label class="w3-label w3-text-blue"><b>Código</b></label>
<input type="text" class="w3-input w3-border" value= "";  name="codigo" id="codigo" maxlength=24/>

<br>
<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php 
echo $msg; 

?>
</form>

</body>
</html>