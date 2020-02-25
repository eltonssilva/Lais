<?php
require_once("usuario/dados_bd.php");
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página

$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";

$courseQuery = "SELECT * FROM `email`";
$courseData = mysqli_query($con, $courseQuery);

if(isset($_POST['btnSubmit'])) 
	{
		$email = $_POST['email'];
		$proprietario = $_POST['proprietario'];
		$habilitado = $_POST['habilitado'];


		//$query = "update pushover set user_key = '{$user_key}', device = '{$device}', habilitado='{$habilitado}' where id = '{$id}'";
		 $query = "INSERT INTO `autohome`.`email` (`id`, `email`,  `proprietario`, `habilitado`) VALUES (NULL, '{$email}', '{$proprietario}', '{$habilitado}');";
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

$query = "select * from email where id='{$id}'";
$studentData = mysqli_query($con, $query);
mysqli_close($con);
$recStudent = mysqli_fetch_array($studentData);
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
<h5>Depois de Modificar click no botão "Atualizar" e depois "Fecha"</h5>
<form class="w3-container w3-card-4" method="POST">

<label class="w3-label w3-text-blue"><b>E-mail</b></label>
<input type="text" class="w3-input w3-border" value="" name="email"/> <br/>
<label class="w3-label w3-text-blue"><b>Proprietario</b></label>
<input type="text" class="w3-input w3-border" value="" name="proprietario"/> <br/>
<input type="checkbox" name="habilitado" value="1" checked="true">Habilitado<br>
<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><br><p>
<?php echo $msg; ?>
</form>
</body>
</html>