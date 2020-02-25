<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";
$habilitado_t = 'true';

$courseQuery = "SELECT * FROM `rx433mhz_violacao` ORDER BY `rx433mhz_violacao`.`id` ASC";
mysqli_set_charset('utf8');
$courseData = mysqli_query($con, $courseQuery);

if(isset($_POST['btnSubmit'])) 
	{
		$codigo = $_POST['codigo'];
		$mensagem = $_POST['mensagem'];
		$descricao = $_POST['descricao'];
		$habilitado = $_POST['habilitado'];
		
		
		$query = "update rx433mhz_violacao set codigo = '{$codigo}', mensagem = '{$mensagem}', descricao = '{$descricao}', habilitado='{$habilitado}' where id = '{$id}'";
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

$query = "select * from `rx433mhz_violacao` where id='{$id}'";
mysqli_set_charset('utf8');
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

<label class="w3-label w3-text-blue"><b>Código</b></label>
<input type="text" class="w3-input w3-border" value="<?php echo $recStudent['codigo']; ?>" name="codigo"/> <br/>
<label class="w3-label w3-text-blue"><b>Mensagem</b></label>
<input type="text" class="w3-input w3-border" value="<?php echo $recStudent['mensagem']; ?>" name="mensagem"/> <br/>
<label class="w3-label w3-text-blue"><b>Descrição</b></label>
<input type="text" class="w3-input w3-border" value="<?php echo $recStudent['descricao']; ?>" name="descricao"/> <br/>
<input type="checkbox" name="habilitado" value="1" <?php  echo $habilitado_t ?> />Habilitado<br> 
<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><br><p>
<?php echo $msg; ?>
</form>
</div>
</body>
</html>