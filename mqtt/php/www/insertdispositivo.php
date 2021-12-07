<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
include_once("seguranca.php"); // Inclui o arquivo com o sistema de segurança
require_once("noderedEdit.php");
require_once("noderedEditCameras.php");
error_reporting(0);
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
	$device_id_kappelt='0';
	$type_kappelt= $_POST['type_kappelt'];
	$traits_type_kappelt= $_POST['traits_type_kappelt'];
	$requiresActionTopic_kappelt= $_POST['requiresActionTopic_kappelt'];





	$pin_iphone = rand (100, 999) . "-" . rand (10, 99) . "-" . rand (100, 999);

	if(($id_ == '1') || ($id_ == '14')  || ($id_ == '15') || ($id_ == '22') ){ 

	$type_kappelt =  $_POST['typekappeltModificado'];

	}

	if($id_ == '13'){ 

		$type_kappelt =  $_POST['tipocameraSelect'];
		$traits_type_kappelt= $_POST['ipcamera'];
		$label= $_POST['usuariocamera'];
		$label2= $_POST['senhacamera'];
	
		}

	
	if($id_ == '01') //Para Lampadas
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '1'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/iluminacao/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/iluminacao/' . $username_topico;  //Topico para Publicar
	$setPubTopic0_confirma = '/house/confirma/' . $username_topico;  //Topico para Publicar
	$publishValue='1'; // Ligado no caso de Chave
	$publishValue2='0'; // Desligado no caso de Chave
	$additionalValue='';  // Nada no Caso de Chave
	$additionalValue2=''; // Nada no caso de chave
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='1'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Para chave mode é 2
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo

	
	 $url = 'http://localhost/write_lampada_js.php';
	$data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setPubTopic0_confirma, 
	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);
	}
	
	if($id_ == '02') // Para Sensor de umidade
	{		
	$tipo = '6';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '2'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/umidade/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/umidade/' . $username_topico;  //Topico para Publicar
	$publishValue='0'; // Ligado no caso de Chave
	$publishValue2='100'; // Desligado no caso de Chave
	$additionalValue='10';  // Nada no Caso de Chave
	$additionalValue2='90'; // Nada no caso de chave
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='0'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Para chave mode é 2
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	$url = 'http://localhost/write_sensorhumidade_js.php';
	$data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setSubTopic0, 
	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);

	
	}
	
	if($id_ == '03') // Para Sensor de temperatura
	{		
	$tipo = '6';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '3'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao . "(°C)"; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/temp/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/temp/' . $username_topico;  //Topico para Publicar
	$publishValue='0'; // Ligado no caso de Chave
	$publishValue2='100'; // Desligado no caso de Chave
	$additionalValue='0';  // Nada no Caso de Chave
	$additionalValue2='90'; // Nada no caso de chave
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='0'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='1'; //Em caso de medir temos: (Simples mode=0, valor=1, percentagem=2)
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
		$url = 'http://localhost/write_sensortemperatura_js.php';
	 $data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setSubTopic0, 
	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);

	}
	
		if($id_ == '04') // Para Sensor de nivel de luz
	{		
	$tipo = '6';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '4'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao . "(lx)"; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/lux/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/lux/' . $username_topico;  //Topico para Publicar
	$publishValue='0'; // Ligado no caso de Chave
	$publishValue2='900'; // Desligado no caso de Chave
	$additionalValue='0';  // Nada no Caso de Chave
	$additionalValue2='900'; // Nada no caso de chave
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='0'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='1'; //Para chave mode é 2
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
			$url = 'http://localhost/write_sensornivelluz_js.php';
	 $data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setSubTopic0, 
	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);

	}
	
	if($id_ == '05') // Para Lampada RGB
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '5'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/rgb/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/rgb/' . $username_topico;  //Topico para Publicar
	$setPubTopic0_confirma = '/house/confirma/' . $username_topico;  //Topico para Publicar
	$publishValue='p1'; // Ligado no caso de Chave RGB
	$publishValue2='p0'; // Desligado no caso de Chave RGB
	$additionalValue='';  // Nada no Caso de Chave
	$additionalValue2=''; // Nada no caso de chave
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='1'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Para chave mode é 2
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
			$url = 'http://localhost/write_rgb_js.php';
	 $data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setSubTopic0, 
	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);


	}
	
		if($id_ == '06') // Para Nivel de Umidade de Solo
	{		
	$tipo = '6';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '6'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5 , Umidade Terra=6
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/umidade/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/umidade/' . $username_topico;  //Topico para Publicar
	$publishValue='0'; // Ligado no caso de Chave
	$publishValue2='100'; // Desligado no caso de Chave
	$additionalValue='10';  // Nada no Caso de Chave
	$additionalValue2='90'; // Nada no caso de chave
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='0'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Para chave mode é 2
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	}
	
		if($id_ == '07') // Para Sensor de Pressão
	{		
	$tipo = '6';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '7'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5, Pressão=7, Altitude=8
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao . "(Pa)"; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/pressao/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/pressao/' . $username_topico;  //Topico para Publicar
	$publishValue='0'; // Ligado no caso de Chave
	$publishValue2='500000'; // Desligado no caso de Chave
	$additionalValue='0';  // Nada no Caso de Chave
	$additionalValue2='500000'; // Nada no caso de chave
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='0'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='1'; //Em caso de medir temos: (Simples mode=0, valor=1, percentagem=2)
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	//	$url = 'http://localhost/write_sensortemperatura_js.php';
//	 $data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setSubTopic0, 
	//        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);

	}
	
	if($id_ == '08') // Para Sensor de Altitude
	{		
	$tipo = '6';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '8'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5, Pressão=7, Altitude=8
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao . "(m)"; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/altitude/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/altitude/' . $username_topico;  //Topico para Publicar
	$publishValue='0'; // Ligado no caso de Chave
	$publishValue2='3000'; // Desligado no caso de Chave
	$additionalValue='0';  // Nada no Caso de Chave
	$additionalValue2='3000'; // Nada no caso de chave
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='0'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='1'; //Em caso de medir temos: (Simples mode=0, valor=1, percentagem=2)
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	//	$url = 'http://localhost/write_sensortemperatura_js.php';
//	 $data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setSubTopic0, 
	//        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);

	}
	
		if($id_ == '09') // Para Controle de Persiana
	{		
	$tipo = '4';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '9'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5, Pressão=7, Altitude=8  , Persiana=9
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/confirma/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/persiana/' . $username_topico;  //Topico para Publicar
	$publishValue='P000'; // Aberto no Caso da Persiana
	$publishValue2='P100'; // Fechado no Caso de Persiana
	$additionalValue='0';  // Minimo no Caso de Persiana
	$additionalValue2='100'; // Maximo no Caso de Persiana
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='1'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Em caso de medir temos: (Simples mode=0, valor=1, percentagem=2)
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	 $url = 'http://localhost/write_persiana_js.php';
	$data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setPubTopic0' => $setPubTopic0, 
	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);

	}
	
			if($id_ == '10') // Para Controle de Arcondicionado
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '10'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5, Pressão=7, Altitude=8  , Persiana=9, , Ar condicionado=10
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/confirma/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/ifredarc/' . $username_topico;  //Topico para Publicar
	$publishValue='P000'; // Comando Ligar
	$publishValue2='P100'; // Comando Desligar
	$additionalValue='0';  // Não Util no caso de Arcondicionado
	$additionalValue2='100'; // Não Util no caso de Arcondicionado
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='1'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Em caso de medir temos: (Simples mode=0, valor=1, percentagem=2)
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	//	$url = 'http://localhost/write_sensortemperatura_js.php';
//	 $data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setSubTopic0, 
	//        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);

	}
	
	if($id_ == '11') // Para Controle de TV e midia
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '11'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5, Pressão=7, Altitude=8  , Persiana=9, , Ar condicionado=10
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/confirma/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/ifredtvc/' . $username_topico;  //Topico para Publicar
	$publishValue='P000'; // Comando Ligar
	$publishValue2='P100'; // Comando Desligar
	$additionalValue='0';  // Não Util no caso de Arcondicionado
	$additionalValue2='100'; // Não Util no caso de Arcondicionado
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='1'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Em caso de medir temos: (Simples mode=0, valor=1, percentagem=2)
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	//	$url = 'http://localhost/write_sensortemperatura_js.php';
//	 $data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setSubTopic0, 
	//        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);

	}
	
		if($id_ == '12') // Para Controle e medicao de Cargas
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '12'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5, Pressão=7, Altitude=8  , Persiana=9, Ar condicionado=10, TV=11, Power=12
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/power/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/power/' . $username_topico;  //Topico para Publicar
	$setPubTopic0_confirma = '/house/confirma/' . $username_topico;  //Topico para Publicar
	$publishValue='1'; // Ligado no caso de Chave
	$publishValue2='0'; // Desligado no caso de Chave
	$additionalValue='';  // Nada no Caso de Chave
	$additionalValue2=''; // Nada no caso de chave
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='1'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Para chave mode é 2
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	 $url = 'http://localhost/write_switch_js.php';
	$data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setPubTopic0_confirma, 
	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);
	
	}
	
			if($id_ == '13') // Para Sensor de Movimento
	{		
	$tipo = '0';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '13'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5, Pressão=7, Altitude=8  , Persiana=9, Ar condicionado=10, TV=11, Power=12
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/motion/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/motion/' . $username_topico;  //Topico para Publicar
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
	
	 $url = 'http://localhost/write_motion_js.php';
	$data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setPubTopic0_confirma, 
	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);
	
	}
	
			if($id_ == '14') // Para chaves
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '14'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5, Pressão=7, Altitude=8  , Persiana=9, Ar condicionado=10, TV=11, Power=12
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/switch/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/switch/' . $username_topico;  //Topico para Publicar
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
	
	 $url = 'http://localhost/write_switch_js.php';
	$data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setPubTopic0_confirma, 
	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);
	
	}
	
		if($id_ == '15') //Para Lampadas
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
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
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='1'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Para chave mode é 2
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	 $url = 'http://localhost/write_lampada_js.php';
	$data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setPubTopic0_confirma, 
	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);
	}
	
	
	if($id_ == '17') //Sensor de Portas e Janelas
	{		
	$tipo = '6';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '17'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5  // sensor porta=17
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/door/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/door/' . $username_topico;  //Topico para Publicar
	$setPubTopic0_confirma = '/house/confirma/' . $username_topico;  //Topico para Publicar
	$publishValue='1'; // Ligado no caso de Chave
	$publishValue2='0'; // Desligado no caso de Chave
	$additionalValue='';  // Nada no Caso de Chave
	$additionalValue2=''; // Nada no caso de chave
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='1'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Para chave mode é 2
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	 $url = 'http://localhost/write_sensorporta_js.php';
	$data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setPubTopic0_confirma, 
	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);
	}
	
	
	 if($id_ == '18') // Para Sensor de Qualidade do ar
	{		
	$tipo = '6';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '18'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5, Pressão=7, Altitude=8 , Qualidade do ar=18
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao . "(Pa)"; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/dust/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/dust/' . $username_topico;  //Topico para Publicar
	$publishValue='0'; // Ligado no caso de Chave
	$publishValue2='500000'; // Desligado no caso de Chave
	$additionalValue='0';  // Nada no Caso de Chave
	$additionalValue2='500000'; // Nada no caso de chave
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='0'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='1'; //Em caso de medir temos: (Simples mode=0, valor=1, percentagem=2)
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	//$url = 'http://localhost/write_sensornivelluz_js.php';
	// $data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setSubTopic0, 
	//        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);

	}
	
		if($id_ == '20') //Para Portas de Garagem
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '20'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/garage/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/garage/' . $username_topico;  //Topico para Publicar
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
	
//	 $url = 'http://localhost/write_lampada_js.php';
//	$data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setPubTopic0_confirma, 
//	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);
	
	}
	
		if($id_ == '21') //Para Lampadas
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '21'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/alarme/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/alarme/' . $username_topico;  //Topico para Publicar
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
	
		if($id_ == '22') //Para Tomadas Inteligentes
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '22'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/tomada/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/tomada/' . $username_topico;  //Topico para Publicar
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
	
	 $url = 'http://localhost/write_outlet_js.php';
	$data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setPubTopic0_confirma, 
	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);
	
	}
	
	
	if($id_ == '23') //Para Adcionar Cena
	{
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '23'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/cena/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/cena/' . $username_topico;  //Topico para Publicar
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
	
	 $url = 'http://localhost/write_outlet_js.php';
	$data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setPubTopic0_confirma, 
	        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);
	
	}
	
		if($id_ == '24') //Para Lampadas Dimerizadas
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '24'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/iluminacaodim/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/iluminacaodim/' . $username_topico;  //Topico para Publicar
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


	if($id_ == '25') // Para Controle de TV e midia
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '25'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5, Pressão=7, Altitude=8  , Persiana=9, , Ar condicionado=10
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/confirma/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/ifredsomc/' . $username_topico;  //Topico para Publicar
	$publishValue='P000'; // Comando Ligar
	$publishValue2='P100'; // Comando Desligar
	$additionalValue='0';  // Não Util no caso de Arcondicionado
	$additionalValue2='100'; // Não Util no caso de Arcondicionado
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='1'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Em caso de medir temos: (Simples mode=0, valor=1, percentagem=2)
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	//	$url = 'http://localhost/write_sensortemperatura_js.php';
//	 $data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setSubTopic0, 
	//        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);

	}

	if($id_ == '26') // Para de Fechadura
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '26'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5, Pressão=7, Altitude=8  , Persiana=9, , Ar condicionado=10
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/confirma/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/lock/' . $username_topico;  //Topico para Publicar
	$publishValue='1'; // Comando Ligar
	$publishValue2='0'; // Comando Desligar
	$additionalValue='0';  // Não Util no caso de Arcondicionado
	$additionalValue2='100'; // Não Util no caso de Arcondicionado
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='1'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Em caso de medir temos: (Simples mode=0, valor=1, percentagem=2)
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	//	$url = 'http://localhost/write_sensortemperatura_js.php';
//	 $data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setSubTopic0, 
	//        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);

	}
	
	if($id_ == '27') // Para de Fechadura
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '27'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5, Pressão=7, Altitude=8  , Persiana=9, , Ar condicionado=10
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/confirma/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/garagedoor/' . $username_topico;  //Topico para Publicar
	$publishValue='1'; // Comando Ligar
	$publishValue2='0'; // Comando Desligar
	$additionalValue='0';  // Não Util no caso de Arcondicionado
	$additionalValue2='100'; // Não Util no caso de Arcondicionado
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='1'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Em caso de medir temos: (Simples mode=0, valor=1, percentagem=2)
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	//	$url = 'http://localhost/write_sensortemperatura_js.php';
//	 $data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setSubTopic0, 
	//        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);

	}
	
	if($id_ == '28') // Para Controle de Irrigação
	{		
	$tipo = '1';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '28'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5, Pressão=7, Altitude=8  , Persiana=9, , Ar condicionado=10
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/confirma/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/irrigation/' . $username_topico;  //Topico para Publicar
	$publishValue='1'; // Comando Ligar
	$publishValue2='0'; // Comando Desligar
	$additionalValue='0';  // Não Util no caso de Arcondicionado
	$additionalValue2='100'; // Não Util no caso de Arcondicionado
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='1'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='2'; //Em caso de medir temos: (Simples mode=0, valor=1, percentagem=2)
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	//	$url = 'http://localhost/write_sensortemperatura_js.php';
//	 $data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setSubTopic0, 
	//        'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);

	}
	
	if($id_ == '29') // Para Sensor de temperatura
	{		
	$tipo = '6';       //(Android) Ler Valor=0, Chave=1, Botão=2, Led=3, Slider=4, Cabeçalho=5, Medir=6, Grafico=7, Buttons set=8, Combo box=9 
	$tipo_geral = '29'; //Geral(não Mostrar no site)=0 Chave Lampada=1, Sensor de Humidade=2, Sensor de Temperatura=3; Nivel de Luz=4, RGB Lampada=5
	$dispositivo_fisico = '1'; //é dispositivo fisico? Sim=1, Não=0
	$proprietario = '1'; // Dispositivo é Propriedade da Autohome? Sim=1, Não=0
	$setname0 = $descricao . "(°C)"; //setname0 é o nome que aparece no celular 
	$setSubTopic0= '/house/rain/' . $username_topico;  //Topico para Subscrever
	$setPubTopic0= '/house/rain/' . $username_topico;  //Topico para Publicar
	$publishValue='0'; // Ligado no caso de Chave
	$publishValue2='1'; // Desligado no caso de Chave
	$additionalValue='0';  // Nada no Caso de Chave
	$additionalValue2='90'; // Nada no caso de chave
	$setPrimaryColor0='0'; // Nada no cado de chave
	$retained='0'; // Reter=1 pareter valor e retained='0' para não reter
	$mode='1'; //Em caso de medir temos: (Simples mode=0, valor=1, percentagem=2)
	$habilitado='1'; //1 para dispositivo habilitado 0 para desabilitado
	$convidado='0';  //0 para usuario principal 1 para convidadeo
	
	// 	$url = 'http://localhost/write_sensorrain_js.php';
	//  $data = array('username_iphone' => $username_iphone, 'pin_iphone' => $pin_iphone, 'setSubTopic0_confirma' => $setSubTopic0, 
	//         'setSubTopic0' => $setSubTopic0, 'Descricao' => $descricao, 'publishValue' => $publishValue, 'publishValue2' => $publishValue2);

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
	if ($result === FALSE) { echo "_Erro_"; }


	
	$query = "INSERT INTO `autohome`.`widget` (`id`, `id_ligado`, `Descricao`,     `username_iphone`,    `pin_iphone`,    `ordem`,   `tipo`,     `tipo_geral`,    `ambiente`,    `dispositivo_fisico`,    `proprietario`,    `setName0`, `setName1`, `setName2`, `setName3`, `setSubTopic0`, `setSubTopic1`, `setSubTopic2`, `setSubTopic3`, `setPubTopic0`,    `publishValue`,   `publishValue2`,   `label`, `label2`,   `additionalValue`,   `additionalValue2`, `additionalValue3`,     `setPrimaryColor0`, `setPrimaryColor1`, `setPrimaryColor2`, `setPrimaryColor3`, `retained`,    `decimalMode`,    `mode`,   `onShowExecute`, `onReceiveExecute`, `formatMode`,    `habilitado`,   `convidado`,   `device_id_kappelt`,   `type_kappelt`,   `traits_type_kappelt`,   `requiresActionTopic_kappelt`,   `requiresStatusTopic_kappelt`)  
	                                    VALUES (NULL,   '0',      '{$descricao}', '{$username_iphone}', '{$pin_iphone}', '{$ordem}', '{$tipo}', '{$tipo_geral}', '{$ambiente}', '{$dispositivo_fisico}', '{$proprietario}', '{$setname0}',   '',         '',         '',    '{$setSubTopic0}',      '',             '',             '',    '{$setPubTopic0}', '{$publishValue}', '{$publishValue2}',    '{$label}',      '{$label2}',   '{$additionalValue}', '{$additionalValue2}',         '',         '{$setPrimaryColor0}',         '0',               '0',               '0',        '{$retained}',       '0',        '{$mode}',        '',                 '',              '',     '{$habilitado}', '{$convidado}',  '$device_id_kappelt',  '{$type_kappelt}', '{$traits_type_kappelt}', '{$requiresActionTopic_kappelt}', '{$requiresStatusTopic_kappelt}');";
//echo $query;

mysqli_set_charset($con, 'utf8');
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
	
	
	
	$query = "INSERT INTO `autohome`.`widget` (`id`, `id_ligado`, `Descricao`,     `username_iphone`,    `pin_iphone`,    `ordem`,   `tipo`,     `tipo_geral`,    `ambiente`,    `dispositivo_fisico`,    `proprietario`,    `setName0`, `setName1`, `setName2`, `setName3`, `setSubTopic0`, `setSubTopic1`, `setSubTopic2`, `setSubTopic3`, `setPubTopic0`,    `publishValue`,   `publishValue2`,   `label`, `label2`,   `additionalValue`,   `additionalValue2`, `additionalValue3`,     `setPrimaryColor0`, `setPrimaryColor1`, `setPrimaryColor2`, `setPrimaryColor3`, `retained`,    `decimalMode`,    `mode`,   `onShowExecute`, `onReceiveExecute`, `formatMode`,    `habilitado`,   `convidado`,   `device_id_kappelt`,   `type_kappelt`,   `traits_type_kappelt`,   `requiresActionTopic_kappelt`,   `requiresStatusTopic_kappelt`) 
	                                    VALUES (NULL,   '{$id_ligado}',      'Status-{$descricao}', '',       '',       '{$ordem}', '{$tipo}', '{$tipo_geral}', '{$ambiente}', '{$dispositivo_fisico}', '{$proprietario}', 'Status-{$setname0}',   '',         '',         '',    '{$setSubTopic0}',      '',             '',             '',    '', '{$publishValue}', '{$publishValue2}',    '{$label}',      '{$label2}',    '{$additionalValue}', '{$additionalValue2}',         '',         '{$setPrimaryColor0}',         '0',               '0',               '0',        '{$retained}',       '0',        '{$mode}',        '',                 '',              '',     '{$habilitado}',       '{$convidado}',  '{$device_id_kappelt}',  '{$type_kappelt}', '{$traits_type_kappelt}', '{$requiresActionTopic_kappelt}', '{$requiresStatusTopic_kappelt}');";
	mysqli_set_charset('utf8');
	$studentData =  mysqli_query($con, $query);

	}

	updateFluxo();  //Atualiza o Fluxo NodeRed
	updateFluxoCameras();  //Atualiza o Fluxo NodeRed das Cameras Hikvision
		

	$query = "SELECT pin, chavedispositivo, usu_bb, se_bb FROM `servidor` where 1=1";
	$dadosdobanco = mysqli_query($con, $query);
	$usuario;
	$senha;
	while($rec = mysqli_fetch_array($dadosdobanco)) {
	$confirma1 = true;
	$chavedispositivo_ = $rec['chavedispositivo'];
	$numeroserial_ = $rec['pin'];
	$usuario_ = $rec['usu_bb'];
	$senha_ = $rec['se_bb'];
	}
	$reterned_ = '-r';
	$comando_ = "1";
	
	$output = shell_exec("mosquitto_pub -h mqttautodomo -d -u {$usuario_} -P {$senha_} -t '{$setSubTopic0}' -m '{$comando_}' -q 1 {$reterned}");

	
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
mysqli_set_charset($con, 'utf8');
$studentData = mysqli_query($con, $query);
while($rec = mysqli_fetch_array($studentData)) { 
$id_ = $rec['id']; 
$Descricao_ = $rec['Descricao'];
$codigo_ = $rec['codigo'];
$src_imagem = $rec['src_imagem'];
$type_kappelt = $rec['type_kappelt'];
$traits_type_kappelt = $rec['traits_type_kappelt'];
$requiresActionTopic_kappelt = $rec['requiresActionTopic_kappelt'];
$requiresStatusTopic_kappelt = $rec['requiresStatusTopic_kappelt'];

}
}
$query = "SELECT * FROM `ambiente`";
mysqli_set_charset($con, 'utf8');
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

				$('#tipocameraSelect').click(function () {
					 const tipoCamera = $("#tipocameraSelect").val();
					 if (tipoCamera == "hikvision"){
						$("#ipcameraLabel").show();
						$("#ipcamera").show();

						$("#senhacameraLabel").show();
						$("#senhacamera").show();

						$("#usuariocameraLabel").show();
						$("#usuariocamera").show();
					 }else{
						$("#ipcameraLabel").hide();
						$("#ipcamera").hide();

						$("#senhacameraLabel").hide();
						$("#senhacamera").hide();

						$("#usuariocameraLabel").hide();
						$("#usuariocamera").hide();
					 }
        });

				
    });
    

</script>


<?php if($codigo_ ==''){ ?>
<h5>Depois de inseri o codigo click em "Enviar Código"</h5><b>
<form class="w3-container w3-card-4" method="POST" name="frm">
<label class="w3-label w3-text-blue"><b>Codigo</b></label>
<input type="text" class="w3-input w3-border" value="" name="codigo" maxlength=17/> <br/>
<?php } ?>
<?php if($codigo_ !=''){ ?>
<h5>Para confirmar click em "Salva Dispositivo" ou para reiniciar click em "Limpar"</h5><b>
<form class="w3-container w3-card-4" method="POST" name="frm">
<label class="w3-label w3-text-blue"><b>Codigo</b></label>
<input type="text" class="w3-input w3-border" value="<?php echo $id_; ?>" name="id_" maxlength=17 /> <br/>
<input type="text" class="w3-input w3-border" value="<?php echo $codigo; ?>" name="codigo2" maxlength=17 /> <br/>
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


<?php if(($codigo_ == '1') || ($codigo_ == '14')  || ($codigo_ == '15') || ($codigo_ == '22') ){ ?>
<label class="w3-label w3-text-blue"><b>Tipo Dispositivo</b></label>
<select name="typekappeltModificado" id="typekappeltModificado" class="w3-input w3-border" >
  <option value="Light">Luz (Lâmpada)</option>
  <option value="Outlet">Chave</option>
</select> 

<?php } ?>


<?php if(($codigo_ == '13')){ ?>
<label class="w3-label w3-text-blue"><b>Tipo Dispositivo</b></label>
<select name="tipocameraSelect" id="tipocameraSelect" class="w3-input w3-border" >
  <option value="">Padrão Zigbee</option>
  <option value="hikvision">Camera Hikvision</option>
</select> 

<?php } ?>


<label class="w3-label w3-text-blue"><b>Descrição</b></label>
<input type="text" class="w3-input w3-border" value="" name="descricao" maxlength=31/> 

<label class="w3-label w3-text-blue" name="ipcameraLabel" id="ipcameraLabel" style="display:none;"><b>IP Câmera</b></label>
<input type="text" class="w3-input w3-border" value="" name="ipcamera" id="ipcamera" maxlength=17 style="display:none;"/>

<label class="w3-label w3-text-blue" name="usuariocameraLabel" id="usuariocameraLabel" style="display:none;"><b>Usuario Câmera</b></label>
<input type="text" class="w3-input w3-border" value="" name="usuariocamera" id="usuariocamera" maxlength=65 style="display:none;"/>

<label class="w3-label w3-text-blue" name="senhacameraLabel" id="senhacameraLabel" style="display:none;"><b>Senha Câmera</b></label>
<input type="text" class="w3-input w3-border" value=""  name="senhacamera" id="senhacamera" maxlength=65 style="display:none;"/>

<input type="text" class="w3-input w3-border" value="<?php echo $type_kappelt; ?>" name="type_kappelt" maxlength=30 style="display:none;"/>
<input type="text" class="w3-input w3-border" value="<?php echo $traits_type_kappelt; ?>" name="traits_type_kappelt" maxlength=30 style="display:none;"/>
<input type="text" class="w3-input w3-border" value="<?php echo $requiresActionTopic_kappelt; ?>" name="requiresActionTopic_kappelt" maxlength=30 style="display:none;"/>
<input type="text" class="w3-input w3-border" value="<?php echo $requiresStatusTopic_kappelt; ?>" name="requiresStatusTopic_kappelt" maxlength=30 style="display:none;"/>
<br/>
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