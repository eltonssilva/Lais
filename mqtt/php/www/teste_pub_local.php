<?php
header("Content-Type: text/html; charset=UTF-8",true);
//require_once("pub.php");


$mensagem= "0";
$topico = "/house/iluminacao/01AA00000010";
$reter = "1";
$numeroserial = "c4ca4238a0b92387";
$imei_cliente = "354015086182854";
$chavedispositivo = "ABCDEF254552";
$email = "eltonss.eng@gmail.com";
$timestamp = (microtime(true) * 10000);
//pub_para_servidor ($mensagem, $topico, $reter, $numeroserial, $imei_cliente);

$md5 = $numeroserial . $timestamp . $chavedispositivo . $imei_cliente . $email  . "salgadinhodelocal";
echo $md5 . "<br>";
echo $md5_gerado = md5($md5);
?>


<html>
<head>
<link href="/css/main.css" rel="stylesheet" type="text/css"/> 
<link href="/css/w3.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<script>

alert(md5("Teste"));

</script>
 
  <br>
 <form action="pub_local.php" method="POST">
 <label for="servidor">Numero Serial</label>
 <br>
<input type="text" name="servidor" value="<?php echo $numeroserial; ?>" size="50"/>
<br><br>

 <label for="imei_cliente">Imei Cliente</label>
 <br>
<input type="text" name="imei_cliente" value="<?php echo $imei_cliente; ?>" size="50"/>
<br><br>

 <label for="email">email</label>
 <br>
<input type="text" name="email" value="<?php echo $email; ?>" size="100"/>
<br><br>


 <label for="topico">topico</label>
 <br>
 <input type="text" name="topico" value="<?php echo $topico; ?>" size="50"/>
 <br><br>
 
  <label for="comando">comando</label>
  <br>
 <input type="text" name="comando" value="<?php echo $mensagem; ?>" size="50"/>
 <br><br>
 
   <label for="timestamp">timestamp</label>
  <br>
 <input type="text" name="timestamp" value="<?php echo  $timestamp; ?>" size="50"/>
 <br><br>
 
    <label for="hash">Hash</label>
  <br>
 <input type="text" name="hash" value="<?php echo $md5_gerado; ?>" size="50"/>
 <br><br>
 
   <label for="reter">reter</label>
   <br>
 <input type="text" name="reter" value="1" size="50"/>
 <br><br>
 
 <input type="submit" name="comando_teste" value="Enviar Comando Teste" />
 </form>
 
<?php
echo	"Mensagem Enviada: " . $mensagem;
?>
 
 
</body>
</html>