<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";

		$id = $_GET['id'];
		$descricao= $_GET['descricao'];
		$comandos_infrared = "TON";
		$modo = "";
		$temperatura = "";
		$descricaocomando = "";

if(isset($_POST['btnSubmit'])) 
	{
	$modo = $_POST['modo'];
	$fan = $_POST['fan'];
	$temperatura = $_POST['temperatura'];
    $codigo = $_POST['codigo'];

	
	
	
		if ($fan == 1)
	{
		ventilacao_automatica();
	}
	
		if ($fan == 2)
	{
		ventilacao_baixa();
	}
	
		if ($fan == 3)
	{
		ventilacao_media();
	}
	
		if ($fan == 4)
	{
		ventilacao_alta();
	}
	


	
	$query = "SELECT * FROM `controle_ir` WHERE comando = '{$comandos_infrared}' AND dispositivo = '{$id}'";
	$dadosdobanco = mysqli_query($con, $query);
	$confirma1 = false;
	while($rec = mysqli_fetch_array($dadosdobanco)) {
	$confirma1 = true;
	}
//echo $query . " " . $confirma1;
		if (!$confirma1)
		{
		$query =  "INSERT INTO `controle_ir` (`id`, `dispositivo`,  `descricaocomando`, `comando`, `codigo`, `modo`) VALUES (NULL, '{$id}', '{$descricaocomando}',  '{$comandos_infrared}', '{$codigo}', '{$fan}');";
		}
		else
		{	
			$query =  "UPDATE `controle_ir` SET `codigo` = '{$codigo}', `descricaocomando` = '{$descricaocomando}' WHERE `controle_ir`.`comando` = '{$comandos_infrared}' AND dispositivo = '{$id}';";
		}
		
		
		if(mysqli_query($con, $query))
				{
				$msg = "Alteração Salva";
				} 
		else 
				{
				$msg = "Erro na Atualização";
				}

}


	function ventilacao_automatica()
   {
	   global $comandos_infrared, $modo, $temperatura, $descricaocomando;
	   
       if ($modo == 1)  // Modo Refrigerar
       {
           $comandos_infrared  = "T" . $temperatura;
		   $descricaocomando = "Refrigerar (Temp. " . $temperatura . "°C)";
       }

       if ($modo == 2)  // Modo Automatico
       {
           $comandos_infrared  = "A" . $temperatura;
		   $descricaocomando = "Automatico (Temp. " . $temperatura . "°C)";
       }

       if ($modo == 3)  // Modo Aquecer
       {
           $comandos_infrared  = "G" . $temperatura;
		   $descricaocomando = "Aquecer (Temp. " . $temperatura . "°C)"; 
       }

       if ($modo == 4)  // Modo Ventilar
       {
           $comandos_infrared  = "V" . $temperatura;
		   $descricaocomando = "Ventilar (Temp. " . $temperatura . "°C)"; 
       }
   }
   
   	function ventilacao_baixa()
   {
	   global $comandos_infrared, $modo, $temperatura, $descricaocomando;
       if ($modo == 1)  // Modo Refrigerar
       {
           $comandos_infrared  = "X" . $temperatura;
		   $descricaocomando = "Refrigerar (Temp. " . $temperatura . "°C)";
       }

       if ($modo == 2)  // Modo Automatico
       {
           $comandos_infrared  = "Y" . $temperatura;
		   $descricaocomando = "Automatico (Temp. " . $temperatura . "°C)";
       }

       if ($modo == 3)  // Modo Aquecer
       {
           $comandos_infrared  = "Z" . $temperatura;
		   $descricaocomando = "Aquecer (Temp. " . $temperatura . "°C)"; 
       }

       if ($modo == 4)  // Modo Ventilar
       {
           $comandos_infrared  = "W" . $temperatura;
		   $descricaocomando = "Ventilar (Temp. " . $temperatura . "°C)"; 
       }
   }

   function ventilacao_media()
   {
	   global $comandos_infrared, $modo, $temperatura, $descricaocomando;
       if ($modo == 1)  // Modo Refrigerar
       {
           $comandos_infrared  = "R" . $temperatura;
		   $descricaocomando = "Refrigerar (Temp. " . $temperatura . "°C)";
       }

       if ($modo == 2)  // Modo Automatico
       {
           $comandos_infrared  = "S" . $temperatura;
		   $descricaocomando = "Automatico (Temp. " . $temperatura . "°C)";
       }

       if ($modo == 3)  // Modo Aquecer
       {
           $comandos_infrared  = "P" . $temperatura;
		   $descricaocomando = "Aquecer (Temp. " . $temperatura . "°C)"; 
       }

       if ($modo == 4)  // Modo Ventilar
       {
           $comandos_infrared  = "U" . $temperatura;
		   $descricaocomando = "Ventilar (Temp. " . $temperatura . "°C)"; 
       }
   }

   
	function ventilacao_alta()
   {
		global $comandos_infrared, $modo, $temperatura, $descricaocomando;
       if ($modo == 1)  // Modo Refrigerar
       {
           $comandos_infrared  = "E" . $temperatura;
		   $descricaocomando = "Refrigerar (Temp. " . $temperatura . "°C)";
       }

       if ($modo == 2)  // Modo Automatico
       {
           $comandos_infrared  = "F" . $temperatura;
		   $descricaocomando = "Automatico (Temp. " . $temperatura . "°C)";
       }

       if ($modo == 3)  // Modo Aquecer
       {
           $comandos_infrared  = "H" . $temperatura;
		   $descricaocomando = "Aquecer (Temp. " . $temperatura . "°C)"; 
       }

       if ($modo == 4)  // Modo Ventilar
       {
           $comandos_infrared  = "J" . $temperatura;
		   $descricaocomando = "Ventilar (Temp. " . $temperatura . "°C)";
       }
   }
   
$query = "SELECT * FROM `comandos_infrared` WHERE tipoequipamento = '1'";
mysqli_set_charset($con, 'utf8');
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
<label class="w3-label w3-text-blue"><b>Descrição</b></label>
<input type="text" class="w3-input w3-border" value= "<?php echo $descricao; ?>";  name="descricao" id="descricao" readonly maxlength=16/>


<label class="w3-label w3-text-blue"><b>Modo</b></label>
        <select class="w3-input w3-border" name="modo" id="modo">
                 <option value=1>Refrigeração</option>
				 <option value=2>Automatico</option>
				 <option value=3>Aquecer</option>
				 <option value=4>Ventilação</option>

          </select>
		  
		  <label class="w3-label w3-text-blue"><b>Vetilação</b></label>
        <select class="w3-input w3-border" name="fan" id="fan">
                 <option value=1>Automatica</option>
				 <option value=2>Baixa</option>
				 <option value=3>Média</option>
				 <option value=4>Alta</option>

          </select>
		  

<label class="w3-label w3-text-blue"><b>Temperatura</b></label>
        <select class="w3-input w3-border" name="temperatura" id="temperatura">
				 <option value=ON>Ligar</option>
				 <option value=OFF>Desligar</option>
                 <option value=16>16°C</option>
				 <option value=17>17°C</option>
				 <option value=18>18°C</option>
				 <option value=19>19°C</option>
				 <option value=20>20°C</option>
				 <option value=21>21°C</option>
				 <option value=22>22°C</option>
				 <option value=23>23°C</option>
				 <option value=24>24°C</option>
				 <option value=25>25°C</option>
				 <option value=26>26°C</option>
				 <option value=27>27°C</option>
				 <option value=28>28°C</option>
				 <option value=29>29°C</option>

          </select>

<label class="w3-label w3-text-blue"><b>Código</b></label>
<input type="text" class="w3-input w3-border" value= "";  name="codigo" id="codigo" maxlength=64/>

<br>
<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php 
echo $msg; 

?>
</form>

</body>
</html>