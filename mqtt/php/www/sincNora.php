<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
require_once("noderedEdit.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";


$query = "SELECT * FROM `servidor` WHERE id=1";
mysqli_set_charset('utf8');
$studentData = mysqli_query($con, $query);

while($rec = mysqli_fetch_array($studentData)) { 
$chavelocal = $rec['chavelocal'];
$pin = $rec['pin'];
}


function selectDadosWidget($id){
	global $DB_SERVER;
	global $DB_USER;
	global $DB_PASS;
	global $DB_NAME;
	$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);

	$query = "SELECT widget.id, widget.Descricao, widget.username_iphone, widget.tipo_geral,  widget.setSubTopic0, widget.type_kappelt, widget.traits_type_kappelt, widget.requiresActionTopic_kappelt, widget.requiresStatusTopic_kappelt, widget.device_id_kappelt, ambiente.Descricao ambiente, ambiente.id ambienteId FROM widget, ambiente WHERE widget.id = {$id}  and ambiente.id = widget.ambiente;";
	mysqli_set_charset($cnx, 'utf8');
	$data = mysqli_query($cnx, $query);
	mysqli_close($cnx);
	return $data;

}

$studentData = selectDadosWidget($id);
while($rec = mysqli_fetch_array($studentData)) { 
$Descricao = $rec['Descricao'];
$username_iphone = $rec['username_iphone'];
$ambiente = $rec['ambiente'];
$tipogeral = $rec['tipo_geral'];
$topico = $rec['setSubTopic0'];
$type_kappelt = trim($rec['type_kappelt']);
$device_id_kappelt = trim($rec['device_id_kappelt']);
$traits_type_kappelt = trim($rec['traits_type_kappelt']);
$requiresActionTopic_kappelt = trim($rec['requiresActionTopic_kappelt']);
$requiresStatusTopic_kappelt = trim($rec['requiresStatusTopic_kappelt']);
$ambienteId = trim($rec['ambiente.id']);


}

$query = "SELECT * FROM `ambiente`";
mysqli_set_charset($con, 'utf8');
$ambieteData =  mysqli_query($con, $query);

mysqli_close($con);

function updateWidget($_Descricao, $_Ambiente, $_tipoDevice, $typekappeltModificado, $_Id)
{
		global $DB_SERVER;
		global $DB_USER;
		global $DB_PASS;
		global $DB_NAME;
		$cnx = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);

		$query = "update `widget` set Descricao = '{$_Descricao}', ambiente = '{$_Ambiente}' where id = '{$_Id}'";

		if(($_tipoDevice == '1') || ($_tipoDevice== '14')  || ($_tipoDevice == '15') || ($_tipoDevice == '22') ){
			$query = "update `widget` set Descricao = '{$_Descricao}', ambiente = '{$_Ambiente}', type_kappelt = '{$typekappeltModificado}' where id = '{$_Id}'";
		}
		
		mysqli_set_charset($cnx, 'utf8');
		$data = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		return $data;
}


if(isset($_POST['btnSubmit'])) 
{
	if (strlen($_POST['Descricao']) > 3)
	{
		$_Descricao = $_POST['Descricao'];
		$_Ambiente = $_POST['ambiente'];
		$_tipoDevice = $_POST['tipogeral'];
		$typekappeltModificado = $_POST['typekappeltModificado'];
		$_Id = $_POST['id'];
		updateWidget($_Descricao, $_Ambiente, $_tipoDevice , $typekappeltModificado, $_Id);
	}
	updateFluxo();  //Atualiza o Fluxo NodeRed
}

?>

<html dir="ltr" lang="pt-BR" style="">
<head>
<link href="/css/main.css" rel="stylesheet" type="text/css"/> 
<link href="/css/w3.css" rel="stylesheet" type="text/css"/>
</head>
<meta charset="UTF-8">
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

<label class="w3-label w3-text-blue"><b>Descricao</b></label>
<input type="text" class="w3-input w3-border" value="<?php echo $Descricao; ?>" name="Descricao" id="Descricao" maxlength=20/>
<br>
<!-- <label class="w3-label w3-text-blue"><b>Ambiente</b></label>
<input type="text" class="w3-input w3-border" value="<?php echo $ambiente; ?>" name="ambiente" maxlength=16/> -->

<label class="w3-label w3-text-blue"><b>Ambiente</b></label>
        <select class="w3-input w3-border" name="ambiente">
                    <?php 
                    while($rec = mysqli_fetch_array($ambieteData)) { 
                         echo "<option value=" . $rec['id'];  if ($ambiente == $rec['Descricao']){echo " selected='selected'";} echo ">" . $rec['Descricao'] . "</option>";  
                     } 
                     ?>
          </select>


<br>
<?php if(($tipogeral == '1') || ($tipogeral == '14')  || ($tipogeral == '15') || ($tipogeral == '22') ){ ?>
<label class="w3-label w3-text-blue"><b>Tipo Dispositivo</b></label>
<select name="typekappeltModificado" id="typekappeltModificado" class="w3-input w3-border" >
  <option value="Light">Luz (Lâmpada)</option>
  <option value="Outlet">Chave</option>
</select> 

<?php } ?>

<br><br>
 <input type="hidden" class="w3-input w3-border" value="<?php echo $username_iphone; ?>" name="username_iphone" maxlength=16/>
 <input type="hidden" class="w3-input w3-border" value="<?php echo $pin; ?>" name="servidor" maxlength=16/>   
 <input type="hidden" class="w3-input w3-border" value="<?php echo $tipogeral; ?>" name="tipogeral" maxlength=16/>   
 <input type="hidden" class="w3-input w3-border" value="<?php echo $topico; ?>" name="topico" maxlength=16/> 
 <input type="hidden" class="w3-input w3-border" value="<?php echo $id; ?>" name="id" maxlength=16/>  

 
<input type="submit" class="w3-btn w3-blue" id="btnSubmit" name="btnSubmit" value="Sincronizar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php echo $msg; ?>
</form>
</body>
</html>