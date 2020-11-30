<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";

if(isset($_POST['btnSubmit'])) 
	{
		$descricao = $_POST['descricao'];
		$marca = $_POST['marca'];
		$modelo = $_POST['modelo'];
		$numerobit = $_POST['numerobit'];
		$repeticao = $_POST['repeticao'];
		$tipoprotocolo_nomeprotocolo = $_POST['tipoprotocolo_nomeprotocolo'];
		$arr = explode(":",$tipoprotocolo_nomeprotocolo);
		$nomeprotocolo = $arr[1];
		$tipoprotocolo = $arr[0];

		if (strlen($numerobit) == 1)
		{
			$numerobit = "00" . $numerobit;
		}
		else if (strlen($numerobit) == 2)
		{
			$numerobit = "0" . $numerobit;
		}
	
		$query =  "INSERT INTO `equipamento_infrared` (`id`, `Descricao`, `Marca`, `Modelo`, `nomeprotocolo`, `numerobit`, `tipoprotocolo`,  `repeticao`, `tipoequipamento`) 
		                                        VALUES (NULL, '{$descricao}', '{$marca}', '{$modelo}', '{$nomeprotocolo}', '{$numerobit}', '{$tipoprotocolo}',  '{$repeticao}', '1');";

	//	echo $query ;
		if(mysqli_query($con, $query))
				{
				$msg = "Alteração Salva";
				} 
		else 
				{
				$msg = "Erro na Atualização";
				}

}





$query = "SELECT * FROM `protocolo_infrared`";
mysqli_set_charset($con, 'utf8');
$studentData = mysqli_query($con, $query);
//$recStudent = mysql_fetch_array($studentData);


$query = "SELECT REPLACE (widget.username_iphone, ':', '') equipamento, Descricao FROM `widget` WHERE tipo_geral = 10 ORDER BY `widget`.`username_iphone` ASC";
mysqli_set_charset($con, 'utf8');
$equipamento = mysqli_query($con, $query);
//$recStudent = mysql_fetch_array($studentData);
mysqli_close($con);

?>

<html>
<head>
<link href="/css/main.css" rel="stylesheet" type="text/css"/> 
<link href="/css/w3.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<script src="js/jquery.min.js"></script>
 <script src="/js/jquery-1.7.2.min.js"></script>
 <script src="/jsjquery.validate.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn').click(function () {
            window.opener.location.reload(true);
            window.close();
             }); 
            $('#codigo').keyup(function () {
    //   		alert($('#codigo').val());
        });
          $('#btnSubmit').click(function () {
		//			alert($('#codigo').val());
             }); 

    });
    

</script>
<h5>Depois de Modificar click no botão "Atualizar" e depois "Fecha"</h5><b>
<form class="w3-container w3-card-4" method="POST" name="frm" id="frm">

<table>

  <tr>
    <td>
    <label class="w3-label w3-text-blue"><b>Codigo Dispositivo Infravermelho (ID Virtual)</b></label>
      <input type="text" class="w3-input w3-border" value="" name="descricao" id="descricao" maxlength=16/>
    </td>
    <td>
    <a href="javascript: void(0);" onclick="window.open('insertcondicionadordear_tuya.php', 'Adcionar Controle AutoDomo', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=520');"><img src="/png/32/lupa.png"></a>
    </td>
  </tr>

</table>



<label class="w3-label w3-text-blue"><b>Lista de ArCondicionados Pareados </b></label>
        <select class="w3-input w3-border" name="tuyacontrole" id="tuyacontrole">

      </select>

  <label class="w3-label w3-text-blue"><b>Equipamento (Ar Condicionado) </b></label>
        <select class="w3-input w3-border" name="marca" id="marca">
                    <?php 
                    while($rec = mysqli_fetch_array($equipamento)) { 
                         echo "<option value=" . $rec['equipamento'] . ">" . $rec['Descricao'] . "</option>"; 
                     } 
                     ?>
  </select>




<br>
<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php 
echo $msg; 

?>
</form>

</body>
</html>