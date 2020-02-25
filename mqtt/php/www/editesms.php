<?php
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";
$habilitado_t = 'true';

$courseQuery = "SELECT * FROM `sms`";
$courseData = mysqli_query($con, $courseQuery);

if(isset($_POST['btnSubmit'])) 
	{
		$numerosms = $_POST['numerosms'];
		$proprietario = $_POST['proprietario'];
		$client_secret_ = $_POST['client_secret_'];
		$habilitado = $_POST['habilitado'];

		
		
		$query = "update sms set numerosms = '{$numerosms}', client_secret_ = '{$client_secret_}',  proprietario = '{$proprietario}', habilitado='{$habilitado}' where id = '{$id}'";
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

$query = "select * from sms where id='{$id}'";
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
<label class='w3-label w3-text-blue' ><b>Numero SMS</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['numerosms']; ?>" name="numerosms"/> <br/>
<label class='w3-label w3-text-blue' ><b>Código de Envio</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['client_secret_']; ?>" name="client_secret_"/> <br/>
<label class='w3-label w3-text-blue' ><b>Proprietario</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['proprietario']; ?>" name="proprietario"/> <br/>
Habilitado:<input type="checkbox" value="1"  name="habilitado" value="1" <?php  echo $habilitado_t ?> /><br/>
<input type="submit" class= "w3-btn w3-blue" name="btnSubmit" value="Atualizar"/>
<input type="button" class= "w3-btn w3-blue" id='btn' value='Fecha' /><br><p>
<?php echo $msg; ?>
</form>
</div>
</body>
</html>