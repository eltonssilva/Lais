<?php
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";
$dispositivo_agrupador = isset($_GET['dispositivo_agrupador']) ? $_GET['dispositivo_agrupador'] : "0";



$query = "SELECT associar_widget.*, widget.Descricao FROM `associar_widget`, widget where associar_widget.id_widget2 = widget.id AND associar_widget.pin_dispositivo = '{$dispositivo_agrupador}'";
mysqli_set_charset('utf8');
$ambiente_data = mysqli_query($con, $query);


if(isset($_POST['btnSubmit'])) 
	{
		$dispositivo_agrupado = $_POST['dispositivo_agrupado'];
		
	 $query = "SELECT * FROM `associar_widget` WHERE associar_widget.pin_dispositivo = '{$dispositivo_agrupador}' and associar_widget.id_widget2 = '{$dispositivo_agrupado}'";

		$query_dispositivo_agrupado = mysqli_query($con, $query);
		$cont = mysqli_num_rows($query_dispositivo_agrupado);
 
        // se resultado for igual a zero, uma mensagem é exibida
        if ($cont != 0)
		{
		$msg = "Dispositivo já Associado a esse agrupamento!";
		}
		else
		{

	$query = "INSERT INTO `associar_widget` (`id`, `pin_dispositivo`, `id_agrupador` , `id_widget2`) VALUES (NULL, '{$dispositivo_agrupador}', '{$id}', '{$dispositivo_agrupado}');";	
	//	echo $query;
		if(mysqli_query($con, $query))
				{
				$msg = "Alteração Salva";
				header("location:agrupa_dispositivo.php?id={$id}&dispositivo_agrupador={$dispositivo_agrupador}");
				} 
		else 
				{
				$msg = "Erro na Atualização";
				}
		}
	}

$query = "SELECT id, Descricao, REPLACE(username_iphone, ':','') username_iphone, setPubTopic0, tipo_geral FROM `widget` where dispositivo_fisico = 1 and (tipo_geral =1 or tipo_geral=5 or tipo_geral=14 or tipo_geral=22)";
mysqli_set_charset('utf8');
$studentData = mysqli_query($con, $query);
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn').click(function () {
            window.opener.location.reload(true);
            window.close();
        });
        
        	   $('#btnSubmit').click(function () {
	      //	setTimeout(function(){}, 1000); 
            location.reload(true);
        });
    });
    
    function delete_ambiente()
  {
	 //mostrando o retorno do post
	var id = $( "#dispositivos" ).val();
  // alert(texto);
		var r = confirm("Tem Certeza que deseja deletar!");
		if (r == true) {
	      $.post('deletedispositivoagrupado.php',{id: id},function(data){})
	     // location.reload(true);
	      window.opener.location.reload(true)
	      location.reload();
		} else {
		//alert("You pressed Cancel!");
		}
	}
	

</script>
<h5>Depois de Modificar click no botão "Atualizar" e depois "Fecha"</h5>
<form class="w3-container w3-card-4" method="POST">

<label class="w3-label w3-text-blue"><b>Agrupamento do Dispositivo  <?php echo $dispositivo_agrupador; ?></b></label>
        <select class="w3-input w3-border" id="dispositivos"  name="dispositivos" size="10" onClick="return delete_ambiente()">
                    <?php 
                    while($rec3 = mysqli_fetch_array($ambiente_data )) { 
                         echo "<option value=" . $rec3['id']  .  ">" . $rec3['Descricao'] . "</option>"; 
                     } 
                     ?>
          </select><p>
		  

<label class="w3-label w3-text-blue"><b>Dispositivo</b></label>
        <select class="w3-input w3-border dispositivo_agrupado" name="dispositivo_agrupado" id="dispositivo_agrupado">
                    <option value="0:0" selected>Selecione um Dispositivo</option>
					<?php 
                    while($rec = mysqli_fetch_array($studentData)) { 
						  echo "<option value='" . $rec['id'] . "'>" . $rec['Descricao'] . "</option>"; 
                     } 
                     ?>
          </select>
		  
<input type="submit" class="w3-btn w3-blue" id="btnSubmit" name="btnSubmit" value="Adicionar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><br><p>
<?php echo $msg; ?>
</form>
</body>
</html>