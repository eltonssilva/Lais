<?php
require_once("../usuario/dados_bd.php");
include_once("../segurancaconfig.php"); // Inclui o arquivo com o sistema de segurança
require_once("../bibliokappelt.php");
protegePagina(); // Chama a função que protege a página


if(isset($_POST['btn'])) 
{
$bearertoken = Get_BearerToken_FromKapellt();
$result = SyncDevicesGoogleHome($BearerToken);
if ($result = 200)
{
	echo "Sistema Sicronizado";
}
else
{
	echo "Erro ao Sicronizado";
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
   //         window.opener.location.reload(true);
    //        window.close();
        });
    });
</script>

<div class="form">
<h5>Tem certeza que deseja Sicronizar seus dispositivo com o GoogleHome</h5>

<form class="w3-container w3-card-4" method="POST">


<input type="submit" class= "w3-btn w3-blue" id='btn' name='btn' value='Sincroniza Google Home' /><br><p>
<?php echo $msg; ?>
</form>
</div>

</body>
</html>

