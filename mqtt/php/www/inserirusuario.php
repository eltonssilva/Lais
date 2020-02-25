<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";


if(isset($_POST['btnSubmit'])) 
{
	$nome = $_POST['nome'];
	$usuario = $_POST['usuario'];
	$senha = $_POST['senha'];
	$confirmasenha = $_POST['confirmasenha'];
	$acesso = $_POST['acesso'];
	
 if ($senha != $confirmasenha)
 {
	 $msg = "Senhas não Confere";
 }
 else
 {
$query = "SELECT * FROM `usuario_admin` WHERE usuario = '{$usuario}'";

mysqli_set_charset('utf8');
$studentData = mysqli_query($con, $query);
$i=0;
while($rec = mysqli_fetch_array($studentData)) 
		{ 
		$i++;
		}
		if ($i > 0)
		{
		 $msg = "Usuario ja Existe";	
		}
		else
		{
				 $query = "INSERT INTO `autohome`.`usuario_admin` (`id`,    `nome`,    `usuario`,    `senha` ,   `acesso`)     VALUES 
													               (NULL, '{$nome}', '{$usuario}', '".  md5($senha) ."', '{$acesso}');";

				if(mysqli_query($con, $query))
						{
						$msg = "Alteração Salva";
						} 
				else 
						{
						$msg = "Erro na Atualização";
						}

		}
}
}
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
<h5>Depois de Modificar click no botão "Salvar" e depois "Fecha"</h5><b>
<form class="w3-container w3-card-4" method="POST" name="frm" id="frm">
<label class="w3-label w3-text-blue"><b>Nome</b></label>
<input type="text" class="w3-input w3-border" value="" name="nome" id="nome" maxlength=128/>

<label class="w3-label w3-text-blue"><b>Usuario</b></label>
<input type="text" class="w3-input w3-border" value="" name="usuario" id="usuario" maxlength=128/>

<label class="w3-label w3-text-blue"><b>senha</b></label>
<input type="password" class="w3-input w3-border" value="" name="senha" id="senha" maxlength=128/>

<label class="w3-label w3-text-blue"><b>Confirma Senha</b></label>
<input type="password" class="w3-input w3-border" value="" name="confirmasenha" id="confirmasenha" maxlength=128/>


<label class="w3-label w3-text-blue"><b>Acesso</b></label>
 <select name="acesso" id="acesso" class="w3-input w3-border" >
  <option value="S">Supervisorio</option>
  <option value="C">Configuração</option>
  <option value="A">Ambos</option>
</select> 

<br><br><br>
<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php 
echo $msg; 

?>
</form>

</body>
</html>