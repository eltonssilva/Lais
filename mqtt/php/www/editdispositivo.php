<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
$con = mysql_connect($DB_SERVER, $DB_USER, $DB_PASS);
mysql_select_db($DB_NAME, $con);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";


if(isset($_POST['btnSubmit'])) 
	{
		$ambiente = $_POST['ambiente'];
		$Descricao = $_POST['Descricao'];
		$habilitado = $_POST['habilitado'];

	
	//	$query = "UPDATE `autohome`.`widget` SET `Descricao` = '{$Descricao}', `setName0` = '{$Descricao}', `ambiente` = '{$ambiente}', `habilitado` = '{$habilitado}' WHERE `widget`.`id` = '{$id}'";

		echo $query;
		if(mysql_query($query))
				{
				$msg = "Alteração Salva";
				} 
		else 
				{
				$msg = "Erro na Atualização";
				}

	}


$query = "SELECT * FROM `ambiente`";
mysql_set_charset('utf8');
$studentData = mysql_query($query);

$query = "SELECT * FROM `widget` where id ={$id}";
mysql_set_charset('utf8');
$interruptor = mysql_query($query);
while($recinterruptor = mysql_fetch_array($interruptor)) { 
 $ambiente = $recinterruptor['ambiente'];
 $Descricao = $recinterruptor['Descricao'];
 $habilitado = $recinterruptor['habilitado'];
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
        
             $('#btnSubmit').click(function () {
            window.opener.location.reload(true);
        });
    });
    

</script>
<h5>Depois de Modificar click no botão "Atualizar" e depois "Fecha"</h5><b>
<form class="w3-container w3-card-4" method="POST" name="frm">
<label class="w3-label w3-text-blue"><b>Descrição</b></label>
<input type="text" class="w3-input w3-border" value="<?php echo $Descricao; ?>" name="Descricao" maxlength=31/> <br/>

<label class="w3-label w3-text-blue"><b>Ambiente do Dispositivo</b></label>
        <select class="w3-input w3-border" name="ambiente">
                    <?php 
                    while($rec = mysql_fetch_array($studentData)) { 
                         echo "<option value=" . $rec['id'];  if ($ambiente==$rec['id']){echo " selected='selected'";} echo ">" . $rec['Descricao'] . "</option>"; 
                     } 
                     ?>
          </select>


<input type="checkbox" name="habilitado" value="1" <?php  echo $habilitado_t ?> />Habilitado<br>
<input type="submit" class="w3-btn w3-blue" id="btnSubmit" name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php echo $msg; ?>
</form>
</body>
</html>