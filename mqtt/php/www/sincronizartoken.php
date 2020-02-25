<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";


$query = "SELECT * FROM `servidor` WHERE id=1";
mysqli_set_charset('utf8');
$studentData = mysqli_query($con, $query);

while($rec = mysqli_fetch_array($studentData)) { 
$chavedispositivo = $rec['chavedispositivo'];
$pin = $rec['pin'];
}

//echo $query  . "<br>" ;
//echo $chavedispositivo . "<br>" ;
//echo $pin . "<br>" ;

$query = "SELECT * FROM `usuario` WHERE id = '$id';";

$studentData = mysqli_query($con, $query);
while($rec = mysqli_fetch_array($studentData)) { 
$email = $rec['email'];
$casa = $rec['casa'];
$imei = $rec['imei'];
$token = $rec['token'];
$habilitado = $rec['habilitado'];
$somente_local = $rec['somente_local'];
$fone = $rec['fone'];
}

//echo $query  . "<br>" ;
//echo $email . "<br>" ;
//echo $casa . "<br>" ;
//echo $token . "<br>" ;

mysqli_close($con);

$md5 = $pin  . $chavedispositivo . $token .  $imei . "salgadinho";
//echo $md5 . "<br>";
$md5_gerado = md5($md5);

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
<form action="https://www.autodomo.com.br/post_get/inserir_dados_notificacao.php" class="w3-container w3-card-4" method="POST" name="frm">

<label class="w3-label w3-text-blue"><b>E-mail</b></label>
<input type="text" class="w3-input w3-border" value="<?php echo $email; ?>" name="email" maxlength=16/>  

<label class="w3-label w3-text-blue"><b>Imei</b></label>
<input type="text" class="w3-input w3-border" value="<?php echo $imei; ?>" name="imei" maxlength=16/> 
<input type="hidden" class="w3-input w3-border" value="<?php echo $casa; ?>" name="casa" maxlength=16/> 
 <input type="hidden" class="w3-input w3-border" value="<?php echo $pin; ?>" name="servidor" maxlength=16/>   
 <input type="hidden" class="w3-input w3-border" value="<?php echo $token; ?>" name="token" maxlength=16/>  
 <input type="hidden" class="w3-input w3-border" value="<?php echo $md5_gerado; ?>" name="hash" maxlength=16/>  
  <input type="hidden" class="w3-input w3-border" value="<?php echo $habilitado; ?>" name="habilitado" maxlength=16/> 
   <input type="hidden" class="w3-input w3-border" value="<?php echo $somente_local; ?>" name="somente_local" maxlength=16/> 
   <input type="hidden" class="w3-input w3-border" value="<?php echo $fone; ?>" name="fone" maxlength=16/> 

 
<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Sincronizar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php echo $msg; ?>
</form>
</body>
</html>