<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";


if(isset($_POST['btnSubmit'])) 
	{
		$descricao_cam = $_POST['descricao_cam'];
		$ip_camera = $_POST['ip_camera'];
		$senha_camera = $_POST['senha_camera'];
		$usercamera = $_POST['usercamera'];
		$secret_key = $_POST['secret_key'];
		$country = $_POST['country'];
		$device_atuador_codigo = $_POST['device_atuador_codigo'];
		$device_sensor_codigo = $_POST['device_sensor_codigo'];
		$device_sensor_codigo = substr($device_sensor_codigo, -12);
		$device_trava_codigo = $_POST['device_trava_codigo'];
		$valor_device_trava_codigo = $_POST['valor_device_trava_codigo'];
		$delay = $_POST['delay'];
		$habilitado = $_POST['habilitado'];


		$query = "INSERT INTO cameralpr (id, descricao_cam, ip_camera, senha_camera, usercamera, secret_key, country, device_atuador_codigo, device_sensor_codigo, device_trava_codigo, valor_device_trava_codigo, delay, habilitado) VALUES (NULL, '${descricao_cam}', '{$ip_camera}', '{$senha_camera}', '{$usercamera}', '{$secret_key}', '{$country}', '{$device_atuador_codigo}', '{$device_sensor_codigo}', '{$device_trava_codigo}', '{$valor_device_trava_codigo}', '{$delay}', '{$habilitado}');";										  
	//	echo $query;
		if(mysqli_query($con, $query))
				{
				$msg = "Alteração Salva";
				} 
		else 
				{
				$msg = "Erro na Atualização";
				}

	}

$query = "SELECT id, Descricao, setName0, setSubTopic0, setPubTopic0  FROM `widget` where (widget.tipo_geral = 1)  OR (widget.tipo_geral = 5) OR (widget.tipo_geral = 13) OR (widget.tipo_geral = 14) OR (widget.tipo_geral = 15) OR (widget.tipo_geral = 17)  OR (widget.tipo_geral > 20)  ";  // COLOQUE 1=1 PARA SECIONAT TUDO DEPOIS VEJO
mysqli_set_charset($con, 'utf8');
$device_sensor_codigo = mysqli_query($con, $query);
$device_atuador_codigo = mysqli_query($con, $query);
$device_trava_codigo = mysqli_query($con, $query);
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

<label class="w3-label w3-text-blue"><b>Câmera</b></label>
<input type="text" class="w3-input w3-border" value="" name="descricao_cam" id="descricao_cam" maxlength=16/>

<label class="w3-label w3-text-blue"><b>IP</b></label>
<input type="text" class="w3-input w3-border" value="" name="ip_camera" id="ip_camera" maxlength=16/>

<label class="w3-label w3-text-blue"><b>Usuário Onvif</b></label>
<input type="text" class="w3-input w3-border" value="" name="usercamera" id="usercamera" maxlength=16/>

<label class="w3-label w3-text-blue"><b>Senha Onvif</b></label>
<input type="text" class="w3-input w3-border" value="" name="senha_camera" id="senha_camera" maxlength=16/>

<label class="w3-label w3-text-blue"><b>secret_key LPR</b></label>
<input type="text" class="w3-input w3-border" value="" name="secret_key" id="secret_key" maxlength=16/>

<label class="w3-label w3-text-blue"><b>Pais (Exe. br)</b></label>
<input type="text" class="w3-input w3-border" value="" name="country" id="country" maxlength=16/>

<label class="w3-label w3-text-blue"><b>Dispositivo Sensor</b></label>
        <select class="w3-input w3-border" name="device_sensor_codigo">
                    <?php 
                    while($rec = mysqli_fetch_array($device_sensor_codigo)) { 
                         echo "<option value=" . $rec['setPubTopic0'] . ">" . $rec['Descricao'] . "</option>"; 
                     } 
                     ?>
          </select>

<label class="w3-label w3-text-blue"><b>Dispositivo a ser acionado</b></label>
        <select class="w3-input w3-border" name="device_atuador_codigo">
                    <?php 
                    while($rec = mysqli_fetch_array($device_atuador_codigo)) { 
                         echo "<option value=" . $rec['setPubTopic0'] . ">" . $rec['Descricao'] . "</option>"; 
                     } 
                     ?>
          </select>

<label class="w3-label w3-text-blue"><b>Dispositivo Trava</b></label>
        <select class="w3-input w3-border" name="device_trava_codigo">
                    <?php 
                    while($rec = mysqli_fetch_array($device_trava_codigo)) { 
                         echo "<option value=" . $rec['setPubTopic0'] . ">" . $rec['Descricao'] . "</option>"; 
                     } 
                     ?>
          </select>

					<label class="w3-label w3-text-blue"><b>Delay em Segundo desacionamento de Atuador</b></label>
<input type="text" class="w3-input w3-border" value="" name="delay" id="delay" maxlength=16/>


<input type="checkbox" name="habilitado" value="1" checked="true">Habilitado<br>
<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php 
echo $msg; 

?>
</form>

</body>
</html>