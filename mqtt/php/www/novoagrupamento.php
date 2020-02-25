<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
$msg = "";
$id = isset($_GET['id']) ? $_GET['id'] : "0";
$Descricao_ = "";
$codigo_ = "";
$url = "";
$data = "";
	
if(isset($_POST['btnSalvar'])) 
{
		$query = "SELECT max(ordem) ordem FROM `widget` ";
		$studentData = mysqli_query($con, $query);
		while($rec = mysqli_fetch_array($studentData)) 
	{ 
		$ordem = $rec['ordem']; 
	}
	
	$id_ = $_POST['id_'];
	$username_iphone = $_POST['codigo2'];
	$username_topico = str_replace(":","",$username_iphone);
	$ordem = $ordem + 10;
	$descricao = $_POST['descricao'];
	$descricao2 = $_POST['descricao2'];
	$ambiente = $_POST['ambiente'];
	$pin_iphone = rand (100, 999) . "-" . rand (10, 99) . "-" . rand (100, 999);
	
		if($id_ == '15') //Para Lampadas
	{		
	$tipo = '15';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '15'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5  // Sensor porta=17
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/agrupamento/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/agrupamento/' . $username_topico;  //Topico para Publicar
	$setPubTopic0_confirma = '/house/confirma/' . $username_topico;  //Topico para Publicar
	$publishValue='1'; // Ligado no caso de Chave
	$publishValue2='0'; // Desligado no caso de Chave
	$additionalValue='';  // Nada no Caso de Chave
	$additionalValue2=''; // Nada no caso de chave
	$setPrimaryColor0=''; // Nada no cado de chave
	$retained='1'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Para chave mode é 2
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	 $url = 'http://localhost/write_lampada_js.php';
	$data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setPubTopic0_confirma, 
	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);
	}
	

	
	
	
// use key 'http' even if you send the request to https://...
	$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    	)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	if ($result === FALSE) { echo "Erro"; }


	
	
	
	$query = "INSERT INTO `autohome`.`widget` (`id`, `id_ligado`, `Descricao`,     `username_iphone`,    `pin_iphone`,    `ordem`,   `tipo`,     `tipo_geral`,    `ambiente`,    `dispositivo_fisico`,    `proprietario`,    `setName0`, `setName1`, `setName2`, `setName3`, `setSubTopic0`, `setSubTopic1`, `setSubTopic2`, `setSubTopic3`, `setPubTopic0`,    `publishValue`,   `publishValue2`,   `label`, `label2`,   `additionalValue`,   `additionalValue2`, `additionalValue3`,     `setPrimaryColor0`, `setPrimaryColor1`, `setPrimaryColor2`, `setPrimaryColor3`, `retained`,    `decimalMode`,    `mode`,   `onShowExecute`, `onReceiveExecute`, `formatMode`,    `habilitado`,   `convidado`) 
	                                    VALUES (NULL,   '0',      '{$descricao}', '{$username_iphone}', '{$pin_iphone}', '{$ordem}', '{$tipo}', '{$tipo_geral}', '{$ambiente}', '{$dispositivo_fisico}', '{$proprietario}', '{$setname0}',   '',         '',         '',    '{$setSubTopic0}',      '',             '',             '',    '{$setPubTopic0}', '{$publishValue}', '{$publishValue2}',    '',      '',    '{$additionalValue}', '{$additionalValue2}',         '',         '{$setPrimaryColor0}',         '0',               '0',               '0',        '{$retained}',       '0',        '{$mode}',        '',                 '',              '',     '{$habilitado}', '{$convidado}');";
mysqli_set_charset($con,'utf8');
$studentData = mysqli_query($con, $query);

	if($id_ == '01') // Inserir o Status Caso Lampada/Interruptor
	{
		$id_ligado="";
		$query = "SELECT id FROM `widget` where `username_iphone` = '{$username_iphone}';";
		$studentData =  mysqli_query($con, $query);
		while($rec = mysqli_fetch_array($studentData)) 
	{ 
		$id_ligado = $rec['id']; 
	}
	
	$ordem = $ordem +1;
	$tipo = 3;
	$tipo_geral = 0;
	$dispositivo_fisico = 0;
	$setSubTopic0 = '/house/confirma/' . $username_topico;  //Topico para Subscrever
	$publishValue='On'; // Ligado no caso de Chave
	$publishValue2='Off'; // Desligado no caso de Chave
	$additionalValue='20';  // Nada no Caso de Chave
	$additionalValue2='50'; // Nada no caso de chave
	$setPrimaryColor0='-16711936'; // Nada no cado de chave
	$retained='0'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='0'; //Para chave mode é 2
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	$query = "INSERT INTO `autohome`.`widget` (`id`, `id_ligado`, `Descricao`,     `username_iphone`,    `pin_iphone`,    `ordem`,   `tipo`,     `tipo_geral`,    `ambiente`,    `dispositivo_fisico`,    `proprietario`,    `setName0`, `setName1`, `setName2`, `setName3`, `setSubTopic0`, `setSubTopic1`, `setSubTopic2`, `setSubTopic3`, `setPubTopic0`,    `publishValue`,   `publishValue2`,   `label`, `label2`,   `additionalValue`,   `additionalValue2`, `additionalValue3`,     `setPrimaryColor0`, `setPrimaryColor1`, `setPrimaryColor2`, `setPrimaryColor3`, `retained`,    `decimalMode`,    `mode`,   `onShowExecute`, `onReceiveExecute`, `formatMode`,    `habilitado`,   `convidado`) 
	                                    VALUES (NULL,   '{$id_ligado}',      'Status-{$descricao}', '',       '',       '{$ordem}', '{$tipo}', '{$tipo_geral}', '{$ambiente}', '{$dispositivo_fisico}', '{$proprietario}', 'Status-{$setname0}',   '',         '',         '',    '{$setSubTopic0}',      '',             '',             '',    '', '{$publishValue}', '{$publishValue2}',    '',      '',    '{$additionalValue}', '{$additionalValue2}',         '',         '{$setPrimaryColor0}',         '0',               '0',               '0',        '{$retained}',       '0',        '{$mode}',        '',                 '',              '',     '{$habilitado}', '{$convidado}');";
	mysqli_set_charset('utf8');
	$studentData =  mysqli_query($con, $query);
	}
//		echo $query;
		$Descricao_ = "";
		$codigo_ = "";
}


if(isset($_POST['btnlimpar'])) 
{
$Descricao_ = "";
$codigo_ = "";
}

if(isset($_POST['btnSubmit'])) 
{

$codigo = trim($_POST['codigo']);

$comprimento_codigo = strlen($codigo);

if ($comprimento_codigo == 12)
{
	$codigo = substr($codigo, 0, 2) . ":" . substr($codigo, 2, 2) . ":" . substr($codigo, 4, 2) . ":" . substr($codigo, 6, 2) . ":" . substr($codigo, 8, 2) . ":" . substr($codigo, 10, 2);
}
 
if (($comprimento_codigo != 12) && ($comprimento_codigo != 17))
{
	$codigo = "";
} 

$subcodigo = substr($codigo, 0, 2);
$query = "SELECT * FROM `dispositivo_type` WHERE codigo ='{$subcodigo}'";
//echo $query;
mysqli_set_charset('utf8');
$studentData = mysqli_query($con, $query);
while($rec = mysqli_fetch_array($studentData)) { 
$id_ = $rec['id']; 
$Descricao_ = $rec['Descricao'];
$codigo_ = $rec['codigo'];
$src_imagem = $rec['src_imagem'];

}
}
$query = "SELECT * FROM `ambiente`";
mysqli_set_charset($con,'utf8');
$studentData =  mysqli_query($con, $query);
//$recStudent = mysqli_fetch_array($studentData);
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
    });
    

</script>


<?php if($codigo_ ==''){ ?>
<h5>Depois de inseri o codigo click em "Enviar Código"</h5><b>
<form class="w3-container w3-card-4" method="POST" name="frm">
<label class="w3-label w3-text-blue"><b>Codigo</b></label>
<input type="text" class="w3-input w3-border" value="<?php  echo "15:AA" .":". gerarSenha(2, 0) .":". gerarSenha(2, 0) .":". gerarSenha(2, 0) .":". gerarSenha(2, 0)  ?>" name="codigo" readonly maxlength=17/>  <br/>
<?php } ?>
<?php if($codigo_ !=''){ ?>
<h5>Para confirmar click em "Salva Dispositivo" ou para reiniciar click em "Limpar"</h5><b>
<form class="w3-container w3-card-4" method="POST" name="frm">
<label class="w3-label w3-text-blue"><b>Codigo</b></label>
<input type="text" class="w3-input w3-border" value="<?php echo $id_; ?>" name="id_" readonly maxlength=17 /> <br/>
<input type="text" class="w3-input w3-border" value="<?php echo $codigo; ?>" name="codigo2" readonly maxlength=17 /> <br/>
<label class="w3-label w3-text-blue"><b>Tipo Dispositivo</b></label>
<table border="0" cellpadding="0">
<tr>
<th><img src="<?php echo $src_imagem; ?>" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $Descricao_; ?></th>
</tr>
</table>
<label class="w3-label w3-text-blue"><b>Ambiente</b></label>
        <select class="w3-input w3-border" name="ambiente">
                    <?php 
                    while($rec = mysqli_fetch_array($studentData)) { 
                         echo "<option value=" . $rec['id'];  if ('1'==$rec['id']){echo " selected='selected'";} echo ">" . $rec['Descricao'] . "</option>";  
                     } 
                     ?>
          </select>
<label class="w3-label w3-text-blue"><b>Descrição</b></label>
<input type="text" class="w3-input w3-border" value="" name="descricao" maxlength=17/> <br/>

<input type="submit" class="w3-btn w3-blue" name="btnSalvar" value="Salvar Dispositivo"/>
<input type='submit' class="w3-btn w3-blue" id='btnlimpar' name="btnlimpar" value='Limpar' />
<?php } ?>










<?php if($codigo_ ==''){ ?>
<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Enviar Código"/>
<input type='submit' class="w3-btn w3-blue" id='btn' value='Fechar' />
<?php } ?>
<?php 
echo $msg; 
mysqli_close($con);
?>
<p>
</form>

</body>
</html>

<?php
function gerarSenha($tamanho=2, $forca=0) {
    $vogais = '0123456789AE';
    $consoantes = 'BCDF';
    if ($forca >= 1) {
        $consoantes .= 'BDGHJLMNPQRSTVWXZ';
    }
    if ($forca >= 2) {
        $vogais .= "AEIOUY";
    }
    if ($forca >= 4) {
        $consoantes .= '0123456789';
    }
    if ($forca >= 8 ) {
        $vogais .= 'LMY0';
    }
 
    $senha = '';
    $alt = time() % 2;
    for ($i = 0; $i < $tamanho; $i++) {
        if ($alt == 1) {
            $senha .= $consoantes[(rand() % strlen($consoantes))];
            $alt = 0;
        } else {
            $senha .= $vogais[(rand() % strlen($vogais))];
            $alt = 1;
        }
    }
    return $senha;
}
?>