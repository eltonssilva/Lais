<?php
require_once("usuario/dados_bd.php");
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página

$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";
$habilitado_t = 'true';

$courseQuery = "SELECT * FROM `veiculos_lpr`";
$courseData = mysqli_query($con, $courseQuery);

if(isset($_POST['btnSubmit'])) 
	{
		$veiculodes = $_POST['veiculodes'];
		$veiculoplaca = $_POST['veiculoplaca'];
		$veiculohabilitado = $_POST['veiculohabilitado'];

		
		
		$query = "update veiculos_lpr set veiculodes = '{$veiculodes}', veiculoplaca = '{$veiculoplaca}', veiculohabilitado='{$veiculohabilitado}' where id = '{$id}'";
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

$query = "select * from veiculos_lpr where id='{$id}'";
$studentData = mysqli_query($con, $query);
mysqli_close($con);
$recStudent = mysqli_fetch_array($studentData);

		if($recStudent['habilitado'] == 1)
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

<div class="form">
<h5>Depois de Modificar click no botão "Atualizar" e depois "Fecha"</h5>

<form class="w3-container w3-card-4" method="POST">
<label class='w3-label w3-text-blue' ><b>Veiculo</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['veiculodes']; ?>" name="veiculodes"/> <br/>
<label class='w3-label w3-text-blue' ><b>Placa</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['veiculoplaca']; ?>" name="veiculoplaca"/> <br/>
Habilitado:<input type="checkbox"   name="veiculohabilitado" value="1" <?php  if ($recStudent['veiculohabilitado']) echo 'checked';  ?> /><br/>
<input type="submit" class= "w3-btn w3-blue" name="btnSubmit" value="Atualizar"/>
<input type="button" class= "w3-btn w3-blue" id='btn' value='Fecha' /><br><p>
<?php echo $msg; ?>
</form>
</div>
</body>
</html>