<html dir="ltr" lang="pt-BR" style="">
<head>
</head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>AutoHome</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<link href="/css/main.css" rel="stylesheet" type="text/css"/> 
<link href="/css/w3.css" rel="stylesheet" type="text/css"/> 

<?php

require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";

		$id_dispositivo = $_GET['id'];
		$descricao= $_GET['descricao'];
		
		

$query = "SELECT * FROM `controle_ir` where dispositivo = '{$id_dispositivo}' ORDER BY `id` ASC";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Comando</th> <th>Código</th> <th>Observação</th>  <th colspan="1">Ação</th>
</tr>

<?php while($rec = mysqli_fetch_array($data)) { 
$observacao = "";
if ($rec['modo'] == 1)
{
	$observacao = "Ventilacao Automatica";
}

if ($rec['modo'] == 2)
{
	$observacao = "Ventilacao Baixa";
}

if ($rec['modo'] == 3)
{
	$observacao = "Ventilacao Média";
}

if ($rec['modo'] == 4)
{
	$observacao = "Ventilacao Alta";
}



?>
<tr>
<td> <?php echo $rec['descricaocomando']; ?> </td>
<td> <?php echo $rec['codigo']; ?> </td>
<td> <?php echo $observacao; ?> </td>
<td align="center"> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletecodigoinfrared.php?id=<?php echo $rec['id'] . "&" . "id_dispositivo=". $id_dispositivo; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>

</body></html>