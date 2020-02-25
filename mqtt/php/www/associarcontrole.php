<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";

		$id = $_GET['id'];
		$tipo_geral= $_GET['tipo_geral'];
		$descricao= $_GET['descricao'];

if(isset($_POST['btnSubmit'])) 
	{
	$tipoprotocolo = $_POST['tipoprotocolo'];

	
	$query =  "UPDATE `widget` SET `setPrimaryColor3` = '{$tipoprotocolo}' WHERE `widget`.`id` = {$id};";

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

$tipoequipamento = 1;
if ($tipo_geral == "10")
{
	$tipoequipamento = 1;
}else if ($tipo_geral == "11")
{
	$tipoequipamento = 2;
}



$query = "SELECT * FROM `equipamento_infrared` WHERE tipoequipamento = '{$tipoequipamento}'";
mysqli_set_charset('utf8');
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
<label class="w3-label w3-text-blue"><b>Descrição Equipamento</b></label>
<input type="text" class="w3-input w3-border" value= "<?php echo $descricao; ?>";  name="descricao" id="descricao" readonly maxlength=16/>




<label class="w3-label w3-text-blue"><b>Descrição do Controle/Marca</b></label>
        <select class="w3-input w3-border" name="tipoprotocolo" id="tipoprotocolo">
                    <?php 
                    while($rec = mysqli_fetch_array($studentData)) { 
                         echo "<option value=" . $rec['id'] . ">" . $rec['Descricao'] . "/" . $rec['Marca'] . "</option>"; 
                     } 
                     ?>
          </select>




<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php 
echo $msg; 

?>
</form>

</body>
</html>