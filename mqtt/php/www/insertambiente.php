<?php
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";

//echo $DB_SERVER . "<br>";
//echo $DB_USER . "<br>";
//echo $DB_PASS . "<br>";
//echo $DB_NAME . "<br>";
$query = "SELECT * FROM `ambiente` where 1=1";
mysqli_set_charset($con, 'utf8');
$ambiente_data = mysqli_query($con, $query);


if(isset($_POST['btnSubmit'])) 
	{
		$ambiente = $_POST['ambiente'];



		//$query = "update pushover set user_key = '{$user_key}', device = '{$device}', habilitado='{$habilitado}' where id = '{$id}'";
		$query = "	INSERT INTO `autohome`.`ambiente` (`id`, `Descricao`, `codigo` ) VALUES (NULL, '{$ambiente}', '3');";	
	//	echo $query;
		if(mysqli_query($con, $query))
				{
				$msg = "Alteração Salva";
				header("location:insertambiente.php");
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
	  alert("Não é Possivel deleter a Casa");
	  return;
  }
  
		var r = confirm("Tem Certeza que deseja deletar!");
		if (r == true) {
	      $.post('deleteambiente.php',{id: id},function(data){})
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

<label class="w3-label w3-text-blue"><b>Ambientes (Cômodos)</b></label>
        <select class="w3-input w3-border" id="dispositivos"  name="dispositivos" size="10" onClick="return delete_ambiente()">
                    <?php 
                    while($rec3 = mysqli_fetch_array($ambiente_data )) { 
                         echo "<option value=" . $rec3['id']  .  ">" . $rec3['Descricao'] . "</option>"; 
                     } 
                     ?>
          </select><p>
<label class="w3-label w3-text-blue"><b>Nivel</b></label>
    <select class="w3-input w3-border" name="nivel">
          <?php 
            while($rec4 = mysqli_fetch_array($nivelData)) { 
                  echo "<option value=" . $rec['id'];  if ('1'==$rec['id']){echo " selected='selected'";} echo ">" . $rec['nivel'] . "</option>";  
                  } 
             ?>
    </select>
<label class="w3-label w3-text-blue"><b>Descrição</b></label>
<label class="w3-label w3-text-blue"><b>Novo Ambientes (Cômodos)</b></label>
<input type="text" class="w3-input w3-border" value="" name="ambiente" maxlength=31/> <br/>       
<input type="submit" class="w3-btn w3-blue" id="btnSubmit" name="btnSubmit" value="Novo"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><br><p>
<?php echo $msg; ?>
</form>
</body>
</html>