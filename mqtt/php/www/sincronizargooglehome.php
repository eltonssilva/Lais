<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
require_once("bibliokappelt.php");
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

//echo $query  . "<br>" ;
//echo $chavelocal . "<br>" ;
//echo $pin . "<br>" ;

$query = "SELECT widget.id, widget.Descricao, widget.username_iphone, widget.tipo_geral,  widget.setSubTopic0, widget.type_kappelt, widget.traits_type_kappelt, widget.requiresActionTopic_kappelt, widget.requiresStatusTopic_kappelt, widget.device_id_kappelt, ambiente.Descricao ambiente FROM widget, ambiente WHERE widget.id = {$id}  and ambiente.id = widget.ambiente;";

$studentData = mysqli_query($con, $query);
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

$traits_actionTopic = substr($topico, 7);
$lastIndex = strripos($traits_actionTopic, "/");
	if (requiresActionTopic_kappelt == "0")
	{
	$traits_statusTopic = $traits_actionTopic;
	}
	else
	{
	$traits_statusTopic =   "confirma/" . substr($traits_actionTopic, $lastIndex+1);  //substr($texto, 0, 16);
	}

}

//echo $query  . "<br>" ;
//echo $Descricao . "<br>" ;
//echo $username_iphone . "<br>" ;
//echo $ambiente . "<br>" ;
//echo $type_kappelt . "<br>" ;
//echo $traits_type_kappelt . "<br>" ;
//echo $topico . "<br>" ;
//echo $traits_actionTopic . "<br>" ;
//echo $traits_statusTopic . "<br>" ;

mysqli_close($con);

if(isset($_POST['btnSubmit'])) 
{
	if (strlen($_POST['Descricao']) > 3)
	{
		$Descricao = $_POST['Descricao'];
	}
	if ($device_id_kappelt == 0)
	{
		$bearertoken = Get_BearerToken_FromKapellt();
		$result = newDeviceKapellt($bearertoken, $Descricao, $type_kappelt, $traits_type_kappelt, $requiresActionTopic_kappelt, $requiresStatusTopic_kappelt,  $traits_actionTopic,  $traits_statusTopic );
		$result = SaveDates($result, 2, $id);  // Salva Bearer Tokem
	}
	else
	{
		$bearertoken = Get_BearerToken_FromKapellt();
		$result = UpdateDevice($bearertoken, $device_id_kappelt, $Descricao, $type_kappelt, $traits_type_kappelt, $requiresActionTopic_kappelt, $requiresStatusTopic_kappelt,  $traits_actionTopic,  $traits_statusTopic );
		$result = SaveDates($result, 2, $id);  // Salva Bearer Tokem
	}

	if ($result > 0)
	{
		echo "Dispositivo Atualizado";
	}
	else
	{
		echo "Erro na Atualização";
	}
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
<h5>Depois de Modificar click no botão "Atualizar" e depois "Fecha"</h5><b>
<form class="w3-container w3-card-4" method="POST" name="frm">

<label class="w3-label w3-text-blue"><b>Descricao</b></label>
<input type="text" class="w3-input w3-border" value="<?php echo $Descricao; ?>" name="Descricao" id="Descricao" maxlength=20/>

<label class="w3-label w3-text-blue"><b>Ambiente</b></label>
<input type="text" class="w3-input w3-border" value="<?php echo $ambiente; ?>" name="ambiente" maxlength=16/>
<input type="hidden" class="w3-input w3-border" value="<?php echo $username_iphone; ?>" name="username_iphone" maxlength=16/>
 <input type="hidden" class="w3-input w3-border" value="<?php echo $pin; ?>" name="servidor" maxlength=16/>   
 <input type="hidden" class="w3-input w3-border" value="<?php echo $tipogeral; ?>" name="tipogeral" maxlength=16/>   
 <input type="hidden" class="w3-input w3-border" value="<?php echo $topico; ?>" name="topico" maxlength=16/> 
 <input type="hidden" class="w3-input w3-border" value="<?php echo $md5_gerado; ?>" name="hash" maxlength=16/>  

 
<input type="submit" class="w3-btn w3-blue" id="btnSubmit" name="btnSubmit" value="Sincronizar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php echo $msg; ?>
</form>
</body>
</html>