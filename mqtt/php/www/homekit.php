<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança

	
	$PIN = $_GET['pin'];


?>


<html>
<head>
<link href="/css/main.css?id=123436" rel="stylesheet" type="text/css"/> 
<link href="/css/w3.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<div class="divTable minimalistBlack">
<div class="divTableBody">
<div class="divTableRow">
<div class="divTableCell1"><img class="displayed" src="/png/64/homekit2.png" alt="homekit" align="right" /></div>
<div class="divTableCell2"><?php echo  " " . $PIN ." "; ?></div>
</div>
</div>
</div>

</body>
</html>