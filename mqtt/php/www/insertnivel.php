<?php
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";

//echo $DB_SERVER . "<br>";
//echo $DB_USER . "<br>";
//echo $DB_PASS . "<br>";
//echo $DB_NAME . "<br>";
$query = "SELECT * FROM `nivel` where 1=1";
mysqli_set_charset($con, 'utf8');
$nivel_data = mysqli_query($con, $query);


if(isset($_POST['btnSubmit'])) 
	{
		$nivel = $_POST['nivel'];


		$query = "	INSERT INTO `autohome`.`nivel` (`id`, `nivel` ) VALUES (NULL, '{$nivel}');";	
	//	echo $query;
		if(mysqli_query($con, $query))
				{
				$msg = "Alteração Salva";
				header("location:insertnivel.php");
				} 
		else 
				{
				$msg = "Erro na Atualização";
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
  if  (id == '1')
  {
	  alert("Não é Possivel deleter o Nivel Geral");
	  return;
  }
		var r = confirm("Tem Certeza que deseja deletar!");
		if (r == true) {
	      $.post('deletenivel.php',{id: id},function(data){})
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

<label class="w3-label w3-text-blue"><b>Nivel (Prédios)</b></label>
        <select class="w3-input w3-border" id="dispositivos"  name="dispositivos" size="10" onClick="return delete_ambiente()">
                    <?php 
                    while($rec3 = mysqli_fetch_array($nivel_data )) { 
                         echo "<option value=" . $rec3['id']  .  ">" . $rec3['nivel'] . "</option>"; 
                     } 
                     ?>
          </select><p>
<label class="w3-label w3-text-blue"><b>Novo Nivel (Prédio)</b></label>
<input type="text" class="w3-input w3-border" value="" name="nivel" maxlength=31/> <br/>       
<input type="submit" class="w3-btn w3-blue" id="btnSubmit" name="btnSubmit" value="Novo"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><br><p>
<?php echo $msg; ?>
</form>
</body>
</html>