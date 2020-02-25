<?php
require_once("../usuario/dados_bd.php");
include("../segurancaconfig.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width-device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/materialize.css?id=9">
	<link rel="stylesheet" href="../css/personalizar.css?id=8">
	<script language="JavaScript" src="../js/materialize.js"></script>
	<script language="JavaScript" src="../js/utils.js"></script>
	<script src="../js/jquery.min.js"></script>
	<script src="../js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript">
	
    $(document).ready(function () {
        $('.btn1').click(function () {
         var codigo_dispositivo = $(".last_name").val();
		 var sub_codigo_dispositivo;
		 codigo_dispositivo = codigo_dispositivo.replace(":","");
		 codigo_dispositivo = codigo_dispositivo.replace(":","");
		 codigo_dispositivo = codigo_dispositivo.replace(":","");
		 codigo_dispositivo = codigo_dispositivo.replace(":","");
		 codigo_dispositivo = codigo_dispositivo.replace(":","");
		 sub_codigo_dispositivo = codigo_dispositivo.substring(0, 2);
		 if (sub_codigo_dispositivo == "01")
		 {
			  window.open('configlux.php?sn=' + codigo_dispositivo,"_self" );
		 }else if (sub_codigo_dispositivo == "20")
		 {
			 window.open('configportao.php?sn=' + codigo_dispositivo,"_self" );
		 }else if (sub_codigo_dispositivo == "09")
		 {
			 window.open('confpersiana.php?sn=' + codigo_dispositivo,"_self" );
		 }
		
		// alert(codigo_dispositivo);
             }); 
		$('.btn2').click(function () {
			$(".last_name").val('');
             }); 
    });
    

</script>
</head>
<body>


<div class="prime">
		 <div class="input-field col s3">
          <input class="last_name" id="last_name" type="text" class="validate">
          <label for="last_name">Código do Dispositivo</label>
        </div>
      </div>
 
  
	  
	  <a class="waves-effect waves-light btn-small blue accent-3 btn1 ">Enviar</a> <a class="waves-effect waves-light btn-small blue accent-3 btn2 ">Limpar</a>
	  
	  
</body>

</html>