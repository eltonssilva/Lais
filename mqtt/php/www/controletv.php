<?php
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
?>

<html dir="ltr" lang="pt-BR" style="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>AutoDomum</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/controleir.css?id=126239" type="text/css">

<script src="/js/jquery-1.10.2.js"></script>

</head>

<script>

	function pubmqtt(codigo_, topico, reter)
  {

 	 $.post('pub.php',{mensagem:codigo_ , topico: topico, reter: reter},function(data){
   })
	
	}
	
</script>
<body id="bodytv">

<?php

$id = $_GET['id'];


$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query = "SELECT * FROM `widget` where id = '$id'";
mysqli_set_charset('utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);

//echo $query;

while($rec = mysqli_fetch_array($data)) { 

$ambiente = $rec['ambiente'];
$topico_sub = $rec['setSubTopic0'];
$topico_pub = $rec['setPubTopic0'];
$dispositivo = $rec['Descricao'];
$codigo_unico = $rec['setName1'];
$topic = $rec['setPubTopic0'];
$desc_ambiente = '';
$valor = '';
$checked = 'Ligado';
}



$con2 =  mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query2 = "SELECT * FROM `ambiente` where id = '{$ambiente}'";
mysqli_set_charset('utf8');
$data2 = mysqli_query($con2, $query2);
mysqli_close($con2);
while($rec2 = mysqli_fetch_array($data2)) 
{ 
$desc_ambiente = $rec2['Descricao'];
}

$con3 =  mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query3 = "SELECT * FROM `controle_ir` where codigo_unico ='{$codigo_unico}'";
mysqli_set_charset('utf8');
$data3 = mysqli_query($con3, $query3);
mysqli_close($con3);
while($rec3 = mysqli_fetch_array($data3)) 
{ 
$tipodeprotocolo = $rec3['tipodeprotocolo'];
$comando = $rec3['comando'];
$codigo = $rec3['codigo'];

?>



<?php
if (($comando == "on") && ($codigo != ""))
{
?>

<img src="png/controle/on.png" onclick="return pubmqtt('<?php echo $tipodeprotocolo; ?>-<?php echo $codigo . '#'; ?>',   '<?php echo $topico_pub; ?>', '0')" id="on" class="button" name="on">

<?php
}
?>


<?php
if (($comando == "onoff") && ($codigo != ""))
{
?>

<img src="png/controle/onoff.png" onclick="return pubmqtt('<?php echo $tipodeprotocolo; ?>-<?php echo $codigo . '#'; ?>',   '<?php echo $topico_pub; ?>', '0')" id="onoff" class="button" name="onoff">

<?php
}
?>


<?php
if (($comando == "off") && ($codigo != ""))
{
?>

<img src="png/controle/off.png" onclick="return pubmqtt('<?php echo $tipodeprotocolo; ?>-<?php echo $codigo . '#'; ?>',   '<?php echo $topico_pub; ?>', '0')" id="off" class="button" name="off">

<?php
}
?>

<?php
if (($comando == "vplus") && ($codigo != ""))
{
?>

<img src="png/controle/plus.png" onclick="return pubmqtt('<?php echo $tipodeprotocolo; ?>-<?php echo $codigo . '#'; ?>',   '<?php echo $topico_pub; ?>', '0')" id="vplus" class="button" name="vplus">

<?php
}
?>


<?php
if (($comando == "vminus") && ($codigo != ""))
{
?>
<img src="png/controle/minus.png" onclick="return pubmqtt('<?php echo $tipodeprotocolo; ?>-<?php echo $codigo . '#'; ?>',   '<?php echo $topico_pub; ?>', '0')" id="vminus" class="button" name="vminus">
<?php
}
?>


<?php
if (($comando == "cplus") && ($codigo != ""))
{
?>
<img src="png/controle/cup.png" onclick="return pubmqtt('<?php echo $tipodeprotocolo; ?>-<?php echo $codigo . '#'; ?>',   '<?php echo $topico_pub; ?>', '0')" id="cplus" class="button" name="cplus">
<?php
}
?>


<?php
if (($comando == "cminus") && ($codigo != ""))
{
?>
<img src="png/controle/cdown.png" onclick="return pubmqtt('<?php echo $tipodeprotocolo; ?>-<?php echo $codigo . '#'; ?>',   '<?php echo $topico_pub; ?>', '0')" id="cminus" class="button" name="cminus">
<?php
}
?>


<?php
if (($comando == "mute") && ($codigo != ""))
{
?>
<img src="png/controle/unnamed.png" onclick="return pubmqtt('<?php echo $tipodeprotocolo; ?>-<?php echo $codigo . '#'; ?>',   '<?php echo $topico_pub; ?>', '0')" id="mute" class="button" name="mute">
<?php
}
?>



<?php
}
?>


</body>

</html>
