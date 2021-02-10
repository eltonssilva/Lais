<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";


if(isset($_POST['btnSubmit'])) 
	{
		$id = $_POST['dispositivos'];
		$codigo = $_POST['codigo'];
		$habilitado = $_POST['habilitado'];
		$estado = $_POST['estado'];
$query = "SELECT id, Descricao, proprietario, setName0, setSubTopic0, setPubTopic0  FROM `widget` where id='{$id}'";
mysqli_set_charset($con,  'utf8');
$studentData = mysqli_query($con, $query);
while($rec = mysqli_fetch_array($studentData)) { 
$id_widget = $rec['id']; 
$Descricao = $rec['Descricao'];
$setName0 = $rec['setName0'];
$setSubTopic0 = $rec['setSubTopic0'];
$proprietario = $rec['proprietario'];
if($proprietario) {
$pos = strripos($setSubTopic0, "/");
$codigo_disp = substr($setSubTopic0,$pos + 1);
$setPubTopic0 = $rec['setPubTopic0'];
}else 
{
$setPubTopic0 = $rec['setPubTopic0'];
}

}

		//$query = "update pushover set user_key = '{$user_key}', device = '{$device}', habilitado='{$habilitado}' where id = '{$id}'";
		 $query = "INSERT INTO `autohome`.`rx433mhz_persiana` (`id`, `id_widget`, `codigo`, `topico` , `topico_confirma`, `carga`, `descricao`,  `estado`, `habilitado`) VALUES 
		                                      (NULL, '{$id_widget}', '{$codigo}', '{$setPubTopic0}', '{$setSubTopic0}', '{$estado}', '{$Descricao}',  'X', '{$habilitado}');";
		// $query =  "INSERT INTO `autohome`.`rx433mhz` (`id`, `id_widget`, `codigo`, `data_ms`, `topico`, `topico_confirma`, `carga`, `descricao`, `habilitado`) VALUES (NULL, '0', 'AAAAA', '111111', '/house/CASA', '/house/confirma', '1', 'Teste', '1');";		
		
	//	echo $query;
		if(mysqli_query($con, $query))
				{
				$msg = "Alteração Salva";
				} 
		else 
				{
				$msg = "Erro na Atualização";
				}

	}

$query = "SELECT id, Descricao, setName0, setSubTopic0, setPubTopic0  FROM `widget` where widget.tipo_geral = 9";
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
<label class="w3-label w3-text-blue"><b>Codigo</b></label>
<input type="text" class="w3-input w3-border" value="" name="codigo" id="codigo" maxlength=16/>

<label class="w3-label w3-text-blue"><b>Estado</b></label>
 <select name="estado" id="estado" class="w3-input w3-border" >
  <option value="P100">Abrir</option>
  <option value="P000">Fechar</option>
  <option value="P050">Meia janela</option>
  <option value="P020">20%</option>
  <option value="P101">Parar</option>
  <option value="P102">Abrir-Parar-Fechar</option>
</select> 

<label class="w3-label w3-text-blue"><b>Dispositivo a ser acionado</b></label>
        <select class="w3-input w3-border" name="dispositivos">
                    <?php 
                    while($rec = mysqli_fetch_array($studentData)) { 
                         echo "<option value=" . $rec['id'] . ">" . $rec['Descricao'] . "</option>"; 
                     } 
                     ?>
          </select>


<input type="checkbox" name="habilitado" value="1" checked="true">Habilitado<br>
<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php 
echo $msg; 

?>
</form>

</body>
</html>