<?php
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";
$habilitado_t = 'true';

$courseQuery = "SELECT * FROM pushover";
$courseData = mysqli_query($con, $courseQuery);

if(isset($_POST['btnSubmit'])) 
	{
		$user_key = $_POST['user_key'];
		$token_key = $_POST['token_key'];
		$device = $_POST['device'];
		$email = $_POST['email'];
		$habilitado = $_POST['habilitado'];
		
		
		$query = "update pushover set user_key = '{$user_key}', token_key = '{$token_key}', device = '{$device}', email = '{$email}', habilitado='{$habilitado}' where id = '{$id}'";
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

$query = "select * from pushover where id='{$id}'";
$studentData = mysqli_query($con, $query);
$recStudent = mysqli_fetch_array($studentData);
mysqli_close($con);

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
<label class='w3-label w3-text-blue' ><b>User Key</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['user_key']; ?>" name="user_key"/> <br/>
<label class='w3-label w3-text-blue' ><b>Token Key</b></label>
<input type='text' class='w3-input w3-border' value="<?php echo $recStudent['token_key']; ?>" name="token_key"/> <br/>
<label class=" w3-label w3-text-blue" ><b>Device</b></label>
<input type="text" class= "w3-input w3-border" value="<?php echo $recStudent['device']; ?>" name="device"/> <br/>
<label class=" w3-label w3-text-blue" ><b>E-mail Pushover</b></label>
<input type="text" class= "w3-input w3-border" value="<?php echo $recStudent['email']; ?>" name="email"/> <br/>
Habilitado:<input type="checkbox" value="1"  name="habilitado" value="1" <?php  echo $habilitado_t ?> /><br/>
<input type="submit" class= "w3-btn w3-blue" name="btnSubmit" value="Atualizar"/>
<input type="button" class= "w3-btn w3-blue" id='btn' value='Fecha' /><br><p>
<?php echo $msg; ?>
</form>
</div>
</body>
</html>