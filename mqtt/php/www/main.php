<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
//echo "Olá, " . $_SESSION['usuarioLogin'];
error_reporting(0);
$endereco = $_SERVER[HTTP_HOST];

$conip  = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query2 = "SELECT ip FROM `servidor` where 1=1";
mysqli_set_charset($conip, 'utf8');
$data2 = mysqli_query($conip, $query2);
mysqli_close($conip);
while($rec2 = mysqli_fetch_array($data2)) 
{ 
$ip = $rec2['ip'];
}

/*
if ($endereco == $ip)  // 
{
	$endereco = $ip;
}
else 
{
	$posicao = strpos($endereco, ':');
	$endereco = substr($endereco, 0 , $posicao );
}
*/
//echo $endereco;
?>

<!DOCTYPE html>
<html dir="ltr" lang="pt-BR" style=""><head>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>AutoHome</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<link href="/css/main.css" rel="stylesheet" type="text/css"/> 
<link href="/css/w3.css" rel="stylesheet" type="text/css"/> 
<script src="/js/jquery-1.10.2.js"></script>
<script src="/js/jscolor.js"></script>
<script src="http://<?php echo $endereco; ?>:4555/socket.io/socket.io.js"></script>
		<script>
		var socket = io('http://<?php echo $endereco; ?>:4555', {transports: ['websocket', 'polling', 'flashsocket']});
	  socket.on('notificacao', function (data) 
	  {

var traco1 =   data.indexOf('-', 0);
var traco2 =   data.indexOf('-', traco1 + 1);
var barra2 =   data.indexOf('/', traco2 + 3);
var barra3 =   data.indexOf('/', barra2 + 1);
if (barra3 == -1) {barra3 = data.length;}

var id = data.substring(0,traco1);
var valor = data.substring(traco1+1,traco2);
var semi_topico = data.substring(barra2+1,barra3);

    
	   
	   if ( semi_topico == "rx433mhz")
	   {
	   	$("#codigo433mhz1").text("Codigo Controle: " + valor);
	   }
	   
	   if ( semi_topico == "smartinterruptor")
	   {
	   	$("#codigo433mhz1").text("Codigo Controle: " + valor.substr(0, 14));
	   }

		 if ( semi_topico == "newdevice")
	   {
	   	$("#newdevice").text(valor);
	   }

		 if ( semi_topico == "nablenewdevice")
	   {
			
			 if (valor == "1")
			 {
				$("#newdeviceHabilitado").prop('disabled', true);
			 }else{
				$("#newdeviceHabilitado").prop('disabled', false);
			 }

	   	
	   }
	   
	   
	  
	   if (semi_topico == 'iluminacao') 
	   { 
	   	if (valor == 1)
	   		{
	   			$("#myonoffswitch" + id ).attr('checked', true);
	   			$("#bulb" + id).attr("src", "/png/64/bulb_on.png");
	   		}
	   	if (valor == 0) 
	   		{
	   			$("#myonoffswitch" + id ).attr('checked', false);
	   			$("#bulb" + id).attr("src", "/png/64/bulb.png");
	   		} 
				 if (valor == 'X') 
	   		{
					if($("#myonoffswitch" + id).attr('checked')) 
					{
						$("#myonoffswitch" + id ).attr('checked', false);
	   			 	$("#bulb" + id ).attr("src", "/png/64/bulb.png");
					}
					else
					{
						$("#myonoffswitch" + id ).attr('checked', true);
	   				$("#bulb" + id ).attr("src", "/png/64/bulb_on.png");
					}

	   		}   
	   }
	   
	   	   if (semi_topico == 'door') 
	   { 
	   	if (valor == 1)
	   		{
	   			$("." + id ).attr('checked', true);
	   			$("#bulb" + id).attr("src", "/png/64/porta_aberta.png");
	   		}
	   	if (valor == 0) 
	   		{
	   			$("." + id ).attr('checked', false);
	   			$("#bulb" + id).attr("src", "/png/64/porta_fechada.png");
	   		}  
	   }
	   
	   	   if (semi_topico == 'switch') 
	   { 
	   	if (valor == 1)
	   		{
	   			$("." + id ).attr('checked', true);
	   			$("#bulb" + id).attr("src", "/png/64/power button.png");
	   		}
	   	if (valor == 0)
	   		{
	   			$("." + id ).attr('checked', false);
	   			$("#bulb" + id).attr("src", "/png/64/power button.png");
	   		}  
	   }
	   
	   	   	   if (semi_topico == 'alarme') 
	   { 
	   	if (valor == 1)
	   		{
	   			$("." + id ).attr('checked', true);
	   			$("#bulb" + id).attr("src", "/png/64/alarme_on.png");
	   		}
	   	if (valor == 0)
	   		{
	   			$("." + id ).attr('checked', false);
	   			$("#bulb" + id).attr("src", "/png/64/alarme.png");
	   		}  
	   }
	   
	   
	   
	   	   if (semi_topico == 'agrupamento') 
	   { 
	   	if (valor == 1)
	   		{
	   			$("." + id ).attr('checked', true);
	   			$("#bulb" + id).attr("src", "/png/64/group_on.png");
	   		}
	   	if (valor == 0) 
	   		{
	   			$("." + id ).attr('checked', false);
	   			$("#bulb" + id).attr("src", "/png/64/group_off.png");
	   		}  
	   }
	   
	   
	   
	   
	   
	  if (semi_topico == 'rgb') 
	   {
	   	var novacor;
	   document.getElementById('codigo433mhz').innerHTML = valor;
	   	if (valor == "p0")
	   		{
	   			$("." + id ).attr('checked', false);
	   			$(".color" + id ).css('background-color' , "black");
	   		//	$(".color" + id ).val(valor);
	   			//value="cc66ff"
	   		}else {
	   			if (valor == "p1"){valor = "r255,255,255";};
	   			var inicio_cor = valor.substring(0,1);
	   					if (inicio_cor == "r")
	   					{	   			
	   					var r = parseInt(valor.substring(1,4)).toString(16);
	   					var g = parseInt(valor.substring(5,8)).toString(16);
	   					var b = parseInt(valor.substring(9,12)).toString(16);
	   					
	   					novacor = "#" + r + "" + g + "" + b;
	   				//	alert(novacor);

	   					$("." + id ).attr('checked', true);
	   					$(".color" + id ).css('background-color' , novacor );
	   					$(".color" + id ).val(novacor.toUpperCase());
	   					}
	   					if (inicio_cor == "h") //h0.933,1.000,1.000
	   					{
	   					var ponto_h = valor.substring(1,2);
	   					var ponto_s = valor.substring(7,8);
	   					var ponto_b = valor.substring(13,14);
	   					var h = valor.substring(3,6);
	   					var s = valor.substring(9,11);
	   					var b = valor.substring(15,17);
	   					
	   					if (ponto_h == "1") {
	   						h=360;
	   						}else
	   						{ 
	   						h = (parseFloat(h) * 36 /100).toFixed(0); 
	   						}
	   					if (ponto_s == "1") {
	   						s=1;
	   						}else
	   						{ 
	   						s = parseFloat(s)/100;  
	   						}
	   				  if (ponto_b == "1") {
	   						b=1;
	   						}else
	   						{ 
	   						b = parseFloat(b)/100;  
	   						}
	   						
	   						var h_hsl = h;
	   						var l_hsl = (0.5 * parseFloat(b) * (2 - parseFloat(s))).toFixed(2); 
								var s_hsl =	((parseFloat(b) * parseFloat(s))/(1 -	Math.abs((1.99 * parseFloat(l_hsl)) - 1 ))).toFixed(2); 			
								if (s_hsl >= 1){s_hsl=1;}	   						
	   						
	   						var newh = h_hsl;
	   						var news = (s_hsl * 100).toFixed(0); 
	   						var newl = (l_hsl * 100).toFixed(0);  
	   						
	   						
	   					 novacor = "hsl(" + newh + ", " + news + "%, " + newl + "%)";
	   					//novacor = "hsl(232, 100%, 050%)";
	   					//alert(ponto_h + "-" + ponto_s  + "-" + ponto_v  + "-" + h  + "-" + s  + "-" + v);
	   					//alert(novacor);
	   					$(".color" + id ).val(novacor);
	   					$(".color" + id ).css('background-color' , novacor );
	   					}
	   		}  
	   }
	   
	   if (semi_topico == 'temp') { $("." + id ).text(valor + "°C (" + ((valor * 1.8) + 32 ).toFixed(1) + "°F)"); }  //°F = °C × 1,8 + 32
	   if (semi_topico == 'altitude') { $("." + id ).text(valor + "m"); }
	   if (semi_topico == 'pressao') { $("." + id ).text((valor/1009.21).toFixed(3) + "Atm (" + valor/10 + "kPa)"); }
	   if (semi_topico == 'dust') 
	   {
		   var nivel = "";
		   if (valor <= 30) {nivel = "Bom";}
		   else if (valor <= 70) {nivel = "Aceitavel";}
		   else {nivel = "Não aceitavel";}
		   $("." + id ).text((valor/100).toFixed(2) + "mg/m3 (" + nivel + ")"); 
	   }
	   if (semi_topico == 'umidade') { $("." + id ).text(valor + "%"); }
	   if (semi_topico == 'lux') { $("." + id ).text(valor + "%"); }
	   if (semi_topico == 'motion') 
	   { 
	   	if (valor == 1)
	   		{
	   			$("." + id ).text("Acionado");
	   		}
	   		else 
	   		{
	   			$("." + id ).text("Não Acionado");
	   		}  
	   }
	   
	  	   if (semi_topico == 'persiana') 
	   { 
	   	if (valor == "P000")
	   		{
	   			$("." + id ).attr('checked', false);
	   		}else 
	   		{
	   			$("." + id ).attr('checked', true);
	   		}  
	   }
	   
	   	   if (semi_topico == 'power') 
	   { 
	   	if (valor == 1)
	   		{
	   			$("myonoffswitch." + id ).attr('checked', true);
	   			$("#bulb" + id).attr("src", "/png/64/power button.png");
	   		}else {
	   			$("myonoffswitch." + id ).attr('checked', false);
	   			$("#bulb" + id).attr("src", "/png/64/power button.png");
	   		}  
	   }
	   
	   
	   	   	if (semi_topico == 'confirma')  	
	   {
	   	if (valor == "On")
	   		{
	   			$("." + id ).attr('checked', true);
	   		}
	   	if (valor == "Off")
	   		{
	   			$("." + id ).attr('checked', false);
	   		}  
	   }

	   
	   
	   
	   
	  //   document.getElementById('codigo433mhz').innerHTML = valor;
	    
	 });
	  
		function showEdit(editableObj) {
			$(editableObj).css("background","#FFF");
		} 
		
		
		function saveToDatabase(editableObj,column,id) {
			$(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
			$.ajax({
				url: "saveedit.php",
				type: "POST",
				data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
				success: function(data){
					$(editableObj).css("background","#FDFDFD");
				}        
		   });
		}
		

	function pubmqtt(name_, topico, reter)
  {



	 //mostrando o retorno do post
	
    
	if($("#" + name_).attr('checked')) {
 //   alert("Ligado");
  	 $.post('pub.php',{mensagem: '1', topico: topico, reter: reter},function(data){
   }) 
	} else {
 //  alert("Deligado");
  $.post('pub.php',{mensagem: '0', topico: topico, reter: reter},function(data){
   })
 
	}
	}
	
		function pubmqtt_arc(name_, topico, reter)
	{
			if($("#" + name_).attr('checked')) 
			{
		 //   alert("Ligado");
			 $.post('pub.php',{mensagem: 'XX!000!TON', topico: topico, reter: reter},function(data){}) 
			} 
			else 
			{
		 //  alert("Deligado");
		  $.post('pub.php',{mensagem: 'XX!000!TOFF', topico: topico, reter: reter},function(data){})
		 
			}
	}

	
		function pubmqttpersiana(name_, topico, reter, id_)
  {



	 //mostrando o retorno do post
	
    
	if($("#" + name_).attr('checked')) {
//    alert("Ligado");
  	 $.post('pub.php',{mensagem: 'P100', topico: topico, reter: reter},function(data){
   }) 

//   alert("#myRange" + id_);
   $("#myRange" + id_).val(100);
   
	} else {
//   alert("Deligado");
  $.post('pub.php',{mensagem: 'P000', topico: topico, reter: reter},function(data){
   })
 
//	alert("#myRange" + id_);
    $("#myRange" + id_).val(0);
	
	}
	}
	
	
	function pubmqttportao(topico, name_, reter, id_)
{
    
  	 $.post('pub.php',{mensagem: 'P102', topico: topico, reter: reter},function(data){}) 
}
	
	
	function  pubmqttpersianaranger (topico, name_, reter, id_)
  {

//mostrando o retorno do post
	
	
	var slide_posicao = document.getElementById(name_);
	var posicao = slide_posicao.value;
	var chave_persiana = "#myonoffswitch" + id_;
	
//	alert(topico + " " + name_ + " " +  posicao);
  r = posicao;
   
   	if (r=="100") 
	{
		$(chave_persiana).attr('checked', true); 
	}
	else 
	{
		$(chave_persiana).attr('checked', false); 
	}
		
    if (r.length == 1 )  // Corrigindo Tamanho da string no braço
{
	r = "P00" + r;
}

	if (r.length == 2 )  // Corrigindo Tamanho da string no braço
	{
	r = "P0" + r;
	}
	
		if (r.length == 3 )  // Corrigindo Tamanho da string no braço
	{
	r = "P" + r;
	}

  // alert(r);

  	 $.post('pub.php',{mensagem: r, topico: topico, reter: reter},function(data){
   }) 
   
   
}
	
	
	//usuario_habilitado;
	//habilitado;
//'somente_local;

	
	function usuario_habilitado(_name1, _name2, _name3, _selecionado, _id, _imei)
 {

	 //mostrando o retorno do post
	 var  _habilitado = $("#" + _name1).val();
	 var _somente_local = $("#" + _name2).val();
	 var _administrador = $("#" + _name3).val();
	 
if (_selecionado == "1")
{
	if (_habilitado == "1")
	{
		_habilitado = "0";
	}
	else 
	{
		_habilitado = "1";
	}
}

if (_selecionado == "2")
{
	if (_somente_local == "1")
	{
		_somente_local = "0";
	}
	else 
	{
		_somente_local = "1";
	}
}

if (_selecionado == "3")
{
	if (_administrador == "1")
	{
		_administrador = "0";
	}
	else 
	{
		_administrador = "1";
	}
}

//alert(_habilitado + " " + _somente_local);

_mensagem_pub = {  
	_habilitado, 
	_somente_local, 
	_administrador,
	_imei,
		md5: '0000' 
	
	};

		$.post('pub.php',{mensagem: JSON.stringify(_mensagem_pub), topico: "/house/enablemobile/mobile", reter: "0"},function(data){
   })
	 
  	 $.post('usuario_habilitado.php',{habilitado: _habilitado, somente_local: _somente_local, administrador: _administrador, id:_id},function(data){
   }) 

	
	 $("#" + _name1).val(_habilitado);
	 $("#" + _name2).val(_somente_local);
	 $("#" + _name3).val(_administrador);
	 
}

	
		function pubmqttrgb(name_, topico, reter)
  {

	 //mostrando o retorno do post
	
    
	if($("#" + name_).attr('checked')) {
//    alert("Ligado");
  	 $.post('pub.php',{mensagem: 'p1#', topico: topico, reter: reter},function(data){
   }) 
	} else {
//   alert("Deligado");
  $.post('pub.php',{mensagem: 'p0#', topico: topico, reter: reter},function(data){
   })
 
	}

}




function rgbbt(id, jscolor, topico) {
	var hexcode = $("#" + id).css('background-color');
    // 'jscolor' instance can be used as a string
var parente1 =   hexcode.indexOf('(', 0);
var virgula1 =   hexcode.indexOf(',', parente1);
var virgula2 =   hexcode.indexOf(',', virgula1 + 1);
var parente2 =   hexcode.indexOf(')', 0);

var r = hexcode.substring(parente1 + 1,virgula1);
var g = hexcode.substring(virgula1+2,virgula2);
var b = hexcode.substring(virgula2+2,parente2);

if (r.length == 1 )  // Corrigindo Tamanho da string no braço
{
	r = "00" + r;
}

if (r.length == 2 )  // Corrigindo Tamanho da string no braço
{
	r = "0" + r;
}

if (g.length == 1 )  // Corrigindo Tamanho da string no braço
{
	g = "00" + g;
}

if (g.length == 2 )  // Corrigindo Tamanho da string no braço
{
	g = "0" + g;
}

if (b.length == 1 )  // Corrigindo Tamanho da string no braço
{
	b = "00" + b;
}

if (b.length == 2 )  // Corrigindo Tamanho da string no braço
{
	b = "0" + b;
}

var rgb = "r" + r + "," + g + "," + b;

//var rgb = r + " " + red + "," + green + "," + blue;
     	 $.post('pub.php',{mensagem: rgb + "#", topico: topico, reter: '1'},function(data){})
 //  alert(rgb);

}

/**
 * Converts an HSL color value to RGB. Conversion formula
 * adapted from http://en.wikipedia.org/wiki/HSL_color_space.
 * Assumes h, s, and l are contained in the set [0, 1] and
 * returns r, g, and b in the set [0, 255].
 *
 * @param   Number  h       The hue
 * @param   Number  s       The saturation
 * @param   Number  l       The lightness
 * @return  Array           The RGB representation
 */
function hslToRgb(h, s, l) {
  var r, g, b;

  if (s == 0) {
    r = g = b = l; // achromatic
  } else {
    function hue2rgb(p, q, t) {
      if (t < 0) t += 1;
      if (t > 1) t -= 1;
      if (t < 1/6) return p + (q - p) * 6 * t;
      if (t < 1/2) return q;
      if (t < 2/3) return p + (q - p) * (2/3 - t) * 6;
      return p;
    }

    var q = l < 0.5 ? l * (1 + s) : l + s - l * s;
    var p = 2 * l - q;

    r = hue2rgb(p, q, h + 1/3);
    g = hue2rgb(p, q, h);
    b = hue2rgb(p, q, h - 1/3);
  }

  return [ r * 255, g * 255, b * 255 ];
}


/**
 * Converts an HSV color value to RGB. Conversion formula
 * adapted from http://en.wikipedia.org/wiki/HSV_color_space.
 * Assumes h, s, and v are contained in the set [0, 1] and
 * returns r, g, and b in the set [0, 255].
 *
 * @param   Number  h       The hue
 * @param   Number  s       The saturation
 * @param   Number  v       The value
 * @return  Array           The RGB representation
 */
function hsvToRgb(h, s, v) {
  var r, g, b;

  var i = Math.floor(h * 6);
  var f = h * 6 - i;
  var p = v * (1 - s);
  var q = v * (1 - f * s);
  var t = v * (1 - (1 - f) * s);

  switch (i % 6) {
    case 0: r = v, g = t, b = p; break;
    case 1: r = q, g = v, b = p; break;
    case 2: r = p, g = v, b = t; break;
    case 3: r = p, g = q, b = v; break;
    case 4: r = t, g = p, b = v; break;
    case 5: r = v, g = p, b = q; break;
  }

  return [ r * 255, g * 255, b * 255 ];
}

	</script>
</head>
<body>
<ul id="tabs">
    <li><a href="#" name="tab1">Dispositivos</a></li>
    <li><a href="#" name="tab2">433Mhz</a></li>
	<li><a href="#" name="tab8">Infravermelho</a></li>
	<li><a href="#" name="tab9">Zigbee</a></li> 
    <li><a href="#" name="tab3">LPR</a></li>
    <li><a href="#" name="tab5">Historico Alertas</a></li>
    <li><a href="#" name="tab6">Ação</a></li>  
	<li><a href="#" name="tab10">Cena</a></li>	
    <li><a href="#" name="tab7">Configurações</a></li>
	     
</ul>

<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS,$DB_NAME );
$query = "SELECT * FROM `widget` where id_ligado='0' and dispositivo_fisico = '1' ORDER BY ordem asc";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);

?>


<div id="content"> 
<div id="tab1">
<div id="divnewdevice">

<table style="width:100%">
<tr>
<th>
<h6 id="newdevice"></h6>
</th>
<th style="text-align: right;">
</th>
<th style="text-align: right;">
<button onclick="pubmqtt('newdeviceHabilitado', '/houseconf/nablenewdevice/habilitar' ,'0')"  id="newdeviceHabilitado"> Habilitar Novos Dispositivos </button>
</th>
</tr>
</table>





</div>
<div class="w3-panel w3-light-grey w3-round-xlarge">
<p>
<table border="0" cellpadding="0">

<?php while($rec = mysqli_fetch_array($data)) { 

$ambiente = $rec['ambiente'];
$topico = $rec['setSubTopic0'];
$codigo_dispositivo = str_replace(":","",$rec['username_iphone']);
$desc_ambiente = '';
$valor = '';


$con2 = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query2 = "SELECT * FROM `ambiente` where id = '{$ambiente}'";
mysqli_set_charset($con2, 'utf8');
$data2 = mysqli_query($con2, $query2);
mysqli_close($con2);
while($rec2 = mysqli_fetch_array($data2)) 
{ 
$desc_ambiente = $rec2['Descricao'];
}

$con3 = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//$query3 = "SELECT * FROM `historico_mqtt` where topico ='{$topico}'";
$query3 = "SELECT * FROM `historico_mqtt` where topico ='/house/confirma/{$codigo_dispositivo}'"; 
//echo $query3;
mysqli_set_charset($con3, 'utf8');
$data3 = mysqli_query($con3, $query3);
mysqli_close($con3);
while($rec3 = mysqli_fetch_array($data3)) 
{ 
$valor = $rec3['valor'];
}




 if($rec['tipo_geral']=='1')
{ 
if($valor == "On")
	{
			$checked = 'checked';
			$bulb = '/png/64/bulb_on.png';
	}
elseif ($valor == "Off")
	{
			$checked = '';
			$bulb = '/png/64/bulb.png'; 
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img id="bulb<?php echo $rec['id']; ?>" src= <?php echo "'" . $bulb . "'"; ?> alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone']; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
<div class="onoffswitch">
<input type="checkbox" onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
</div>
   


</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>


</th>
</tr>



<?php } ?>



<?php if($rec['tipo_geral']=='2')   // Sensor de Umidade
{ ?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/drop.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
<th  class="<?php echo $rec['id']; ?>" ><?php echo $valor; ?>%</th>
</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>
</th>
</tr>
<?php } ?>


<?php if($rec['tipo_geral']=='3')  // Sensor de Temperatura
{ ?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/temperature.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
<th  class="<?php echo $rec['id']; ?>" > <?php echo $valor; ?> <sup>o</sup>C </th>
</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>
</th>
</tr>
<?php } ?>

<?php if($rec['tipo_geral']=='4')  // Sensor de Luz
{ ?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/lux.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
<th  class="<?php echo $rec['id']; ?>" ><?php echo $valor; ?> lux</th>
</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>
</th>
</tr>
<?php } ?>


<?php if($rec['tipo_geral']=='5')  // Lampada RGB
{ 

if($valor == 'p0')
	{
			$checked = '';	
	}else 
	{
			$checked = 'checked';
	}
	
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/rgb.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th>
 <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqttrgb('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>" class="onoffswitch-checkbox <?php echo $rec['id']; ?>"  id="myonoffswitch<?php echo $rec['id']; ?>"  <?php  echo $checked ?>>
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
</div>


<input  id="rgbuton<?php echo $rec['id']; ?>" class="jscolor color<?php echo $rec['id']; ?>" onchange="rgbbt(this.id, this.jscolor, '<?php echo $rec['setPubTopic0']; ?>')"  value="cc66ff">
 
</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>
</th>
</tr>
<?php } ?>


<?php if($rec['tipo_geral']=='6') // Sensor de Humidade de Solo
{ ?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/houseplant.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
<th  class="<?php echo $rec['id']; ?>"  ><?php echo $valor; ?> %</th>
</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>
</th>
</tr>
<?php } ?>


<?php if($rec['tipo_geral']=='7')  // Sensor de Pressao Atmosferica
{ ?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/atmospheric_pressure.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
<th  class="<?php echo $rec['id']; ?>" ><?php echo $valor; ?>Pa</th>
</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>
</th>
</tr>
<?php } ?>

<?php if($rec['tipo_geral']=='8')  // Sensor de Altitude
{ ?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/altitude.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
<th class="<?php echo $rec['id']; ?>"><?php echo $valor; ?>m</th>
</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>
</th>
</tr>
<?php } ?>



<?php if($rec['tipo_geral']=='9')  // Controle de Persiana
	
{
if($valor == '0')
	{
			$checked = '';	
	}else 
	{
			$checked = 'checked';
	}
		
	 ?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/persiana.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
<th> 

 <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqttpersiana('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1', '<?php echo $rec['id']; ?>')" name="onoffswitch<?php echo $rec['id']; ?>" class="onoffswitch-checkbox <?php echo $rec['id']; ?>"  id="myonoffswitch<?php echo $rec['id']; ?>"  <?php  echo $checked ?>>
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
</div>
<br>
<div id="slidecontainer">
  <input type="range" onclick="return pubmqttpersianaranger( '<?php echo $rec['setPubTopic0']; ?>', '<?php echo "myRange" . $rec['id']; ?>', '1', '<?php echo $rec['id']; ?>')" min="0" max="100" value="<?php echo $valor; ?>" class="slider <?php echo $rec['id']; ?>" id="myRange<?php echo $rec['id']; ?>">
</div>

<!-- https://www.w3schools.com/howto/howto_js_rangeslider.asp -->

</th>

<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>
</th>
</tr>
<?php } ?>

<?php

if($rec['tipo_geral']=='10')  // Controle de Arcodicionado
{ 
if($valor == 1)
	{
			$checked = 'checked';
	}else 
	{
			$checked = '';
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/airconditioningindoor.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqtt_arc('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo "/house/ifredarc/" . $codigo_dispositivo ; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   


</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>

</th>
</tr>



<?php } ?>




<?php

if($rec['tipo_geral']=='11')  // Controle de TV
{ 
if($valor == 1)
	{
			$checked = 'checked';
	}else 
	{
			$checked = '';
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/tv.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   


</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>

</th>
</tr>



<?php } ?>


<?php

if($rec['tipo_geral']=='25')  // Controle de SOM
{ 
if($valor == 1)
	{
			$checked = 'checked';
	}else 
	{
			$checked = '';
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/som.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   


</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>

</th>
</tr>



<?php } ?>




<?php

 if($rec['tipo_geral']=='12')  // Medicao e Controle de Energia
{ 
if($valor == 1)
	{
			$checked = 'checked';
	}
	elseif ($valor == 0)
	{
			$checked = '';
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/power_on.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   


</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>

</th>
</tr>



<?php } ?>







<?php if($rec['tipo_geral']=='13')  // Sensor de Movimento
{ ?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/motion.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
<th class="<?php echo $rec['id']; ?>"><?php if ($valor == '1') {echo 'Acionado';} else {echo 'Não Acionado';} ?></th>
</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>
</th>
</tr>
<?php } ?>



<?php

 if($rec['tipo_geral']=='14')  // Chave liga desliga Switch
{ 
if($valor == "On")
	{
			$checked = 'checked';
			$bulb = '/png/64/bulb_on.png';
	}
elseif ($valor == "Off")
	{
			$checked = '';
			$bulb = '/png/64/bulb.png'; 
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/power button.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   


</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>

</th>
</tr>
<?php } ?>




<?php
 if($rec['tipo_geral']=='15') // Chave Lampada
{ 
if($valor == "On")
	{
			$checked = 'checked';
			$bulb = '/png/64/group_on.png';
	}
elseif ($valor == "Off")
	{
			$checked = '';
			$bulb = '/png/64/group_off.png'; 
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img id="bulb<?php echo $rec['id']; ?>" src= <?php echo "'" . $bulb . "'"; ?> alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   
</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="javascript: void(0);" onclick="window.open('agrupa_dispositivo.php?id=<?php echo $rec['id'] . "&dispositivo_agrupador=" . str_replace(":","",$rec['username_iphone']) ; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=450');"><img src="/png/32/edit.png"></a>
</th>
</tr>
<?php } ?>




<?php
 if($rec['tipo_geral']=='17') // Chave Lampada
{ 
if($valor == "On")
	{
			$checked = 'checked';
			$door = '/png/64/porta_aberta.png';
	}
elseif ($valor == "Off")
	{
			$checked = '';
			$door = '/png/64/porta_fechada.png'; 
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img id="bulb<?php echo $rec['id']; ?>" src= <?php echo "'" . $door . "'"; ?> alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" disabled onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   
</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>

</th>
</tr>
<?php } ?>





<?php if($rec['tipo_geral']=='18')  // Sensor de Qualidade do Ar
{ ?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/air-quality.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
<th  class="<?php echo $rec['id']; ?>" ><?php echo $valor; ?>mg/m3</th>
</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>
</th>
</tr>
<?php } ?>





<?php if($rec['tipo_geral']=='20')  // Controle de Persiana
	
{
if($valor == '0')
	{
			$checked = '';	
	}else 
	{
			$checked = 'checked';
	}
		
	 ?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/garage.png" alt="Smiley face" height="64" width="64" onclick="return pubmqttportao( '<?php echo $rec['setPubTopic0']; ?>', '<?php echo "myRange" . $rec['id']; ?>', '1','<?php echo $rec['id']; ?>')"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
<th> 

 <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqttpersiana('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1', '<?php echo $rec['id']; ?>')" name="onoffswitch<?php echo $rec['id']; ?>" class="onoffswitch-checkbox <?php echo $rec['id']; ?>"  id="myonoffswitch<?php echo $rec['id']; ?>"  <?php  echo $checked ?>>
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
</div>
<br>
<div id="slidecontainer">
  <input type="range" onclick="return pubmqttpersianaranger( '<?php echo $rec['setPubTopic0']; ?>', '<?php echo "myRange" . $rec['id']; ?>', '1', '<?php echo $rec['id']; ?>')" min="0" max="100" value="<?php echo $valor; ?>" class="slider <?php echo $rec['id']; ?>" id="myRange<?php echo $rec['id']; ?>">
</div>

<!-- https://www.w3schools.com/howto/howto_js_rangeslider.asp -->

</th>

<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>
</th>
</tr>
<?php } ?>


<?php if($rec['tipo_geral']=='21')
{ 
if($valor == "On")
	{
			$checked = 'checked';
			$bulb = '/png/64/alarme_on.png';
	}
else
	{
			$checked = '';
			$bulb = '/png/64/alarme.png'; 
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img id="bulb<?php echo $rec['id']; ?>" src= <?php echo "'" . $bulb . "'"; ?> alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone']; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   


</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>

</th>
</tr>



<?php } ?>







<?php

 if($rec['tipo_geral']=='22')  // Tomada Inteligente
{ 
if($valor == 1)
	{
			$checked = 'checked';
	}
	elseif ($valor == 0)
	{
			$checked = '';
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/socket_f.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   


</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>

</th>
</tr>



<?php } ?>








<?php

 if($rec['tipo_geral']=='23')  // Criar Cena
{ 
if($valor == 1)
	{
			$checked = 'checked';
	}
	elseif ($valor == 0)
	{
			$checked = '';
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/cena.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   


</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>

</th>
</tr>

<?php } ?>




<?php

 if($rec['tipo_geral']=='24')
{ 
if($valor == "On")
	{
			$checked = 'checked';
			$bulb = '/png/64/bulb_on.png';
	}
elseif ($valor == "Off")
	{
			$checked = '';
			$bulb = '/png/64/bulb.png'; 
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img id="bulb<?php echo $rec['id']; ?>" src= <?php echo "'" . $bulb . "'"; ?> alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone']; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   


</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>


</th>
</tr>



<?php } ?>


<?php

 if($rec['tipo_geral']=='26')  // Chave liga desliga Switch
{ 
if($valor == "On")
	{
			$checked = 'checked';
			$bulb = '/png/64/lock_close.png';
	}
elseif ($valor == "Off")
	{
			$checked = '';
			$bulb = '/png/64/lock_close.png'; 
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/lock_close.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   


</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>

</th>
</tr>
<?php } ?>




<?php

 if($rec['tipo_geral']=='27')  // Chave liga desliga Switch
{ 
if($valor == "On")
	{
			$checked = 'checked';
			$bulb = '/png/64/garagem.png';
	}
elseif ($valor == "Off")
	{
			$checked = '';
			$bulb = '/png/64/garage.png'; 
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/sprinkler _on.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   


</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>

</th>
</tr>
<?php } ?>







<?php

 if($rec['tipo_geral']=='28')  // Chave liga desliga Switch
{ 
if($valor == "On")
	{
			$checked = 'checked';
			$bulb = '/png/64/sprinkler_on.png';
	}
elseif ($valor == "Off")
	{
			$checked = '';
			$bulb = '/png/64/sprinkler_off.png'; 
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/sprinkler _on.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   


</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>

</th>
</tr>
<?php } ?>



<?php
 if($rec['tipo_geral']=='29') // Chave Lampada
{ 
if(($valor == "On") || ($valor == "1"))
	{
			$checked = 'checked';
			$door = '/png/64/rainsensor_on.png';
	}
elseif ($valor == "Off")
	{
			$checked = '';
			$door = '/png/64/rainsensor_off.png'; 
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img id="bulb<?php echo $rec['id']; ?>" src= <?php echo "'" . $door . "'"; ?> alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo "SN: " . $rec['username_iphone'] ; ?> <a href="javascript: void(0);" onclick="window.open('homekit.php?pin=<?php echo $rec['pin_iphone'] ; ?>', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, TITLEBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO ,STATUS=NO, MENUBAR=NO, TOP=10, LEFT=10, WIDTH=500, HEIGHT=300');"><img src="/png/32/homekitlogo.png"></a></th>
<th>   <a href="javascript: void(0);" onclick="window.open('sincNora.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/googlehome.png"></a></th>
<th><?php echo $desc_ambiente; ?></th>
 <th> 
  
  <div class="onoffswitch">
 <input type="checkbox" disabled onclick="return pubmqtt('myonoffswitch<?php echo $rec['id']; ?>', '<?php echo $rec['setPubTopic0']; ?>', '1')" name="onoffswitch<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="myonoffswitch<?php echo $rec['id']; ?>" value="on" <?php  echo $checked ?> >
<label class="onoffswitch-label" for="myonoffswitch<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
  </div>
   
</th>
<!--
<td align="center">   <a href="javascript: void(0);" onclick="window.open('editdispositivo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
-->
<th> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletedispositivo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </th>
<th>
<a href="#" id="row3Up" class="rowUp">Up</a>
<a href="#" id="row3Down" class="rowDown">Down</a>

</th>
</tr>
<?php } ?>


<?php } 

?>

</table>
</p>
</div> 
<a href="javascript: void(0);" onclick="window.open('insertdispositivo.php', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=600');"><img src="/png/64/device.png">Adicionar Dispositivo</a>
<a href="javascript: void(0);" onclick="window.open('novoagrupamento.php', 'Agrupar Dispositivos', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=600');"><img src="/png/64/device.png">Agrupar Dispositivo</a>
<a href="javascript: void(0);" onclick="window.open('insertnivel.php', 'Adcionar Nivel', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=410');"><img src="/png/64/level.png">Adicionar Nivel</a>
<a href="javascript: void(0);" onclick="window.open('insertambiente.php', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=480');"><img src="/png/64/home.png">Adicionar Ambiente</a>
<a onClick="return confirm('Tem Certeza que deseja deletar todos os dispositivos!')" href="deletedispositivo.php?id=<?php echo 'd1'; ?>"><img src="/png/32/delete.png">Deletar todos dispositivos</a>
<a onClick="return confirm('Tem Certeza que deseja limpar todos os dispositivos do Servidor')" href="deletedispositivo.php?id=<?php echo 'd2'; ?>"><img src="/png/32/delete.png">Limpa Dispositivos</a>  
 
</div>
    
<div id="tab2">
    
    
<!--
TAB 433MHZ
-->


     <h3>Controles 433mhz</h3>
     
     <h6 id="codigo433mhz1"></h6>
     <div id="codigo433mhz"></div>
     	
     
  <ul class="w3-navbar w3-black">
  <li><a href="javascript:void(0)" onclick="openCity('Interruptores')">Interruptores</a></li>
  <li><a href="javascript:void(0)" onclick="openCity('Persiana')">Persiana</a></li>
  <li><a href="javascript:void(0)" onclick="openCity('Garagem')">Garagem</a></li>
  <li><a href="javascript:void(0)" onclick="openCity('Sensores')">Sensores</a></li>
  <li><a href="javascript:void(0)" onclick="openCity('Alarmes')">Alarmes</a></li>
</ul>

<div id="Interruptores" class="w3-container notificacao">
  <h2>Interruptores</h2>


<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
$query = "SELECT id, codigo, descricao, habilitado, estado FROM `rx433mhz`";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Código</th> <th>Descrição do Dispositivo</th> <th>Ações</th> <th>Habilitado</th> <th colspan="2">Editar/Exlcuir</th>
</tr>

<?php while($rec = mysqli_fetch_array($data)) { ?>
<tr>
<td> <?php echo $rec['id']; ?> </td>
<td> <?php echo $rec['codigo']; ?> </td>
<td> <?php echo $rec['descricao']; ?> </td>
<td> 
<?php   
$estado = $rec['estado'];
if($estado == "1") { echo 'Somente ligar';}
if($estado == "0") { echo 'Somente Desligar';}
if($estado == "X") { echo 'Alternar';}
?> 
</td>
<td> <?php echo $rec['habilitado']; ?> </td>
<!--<td> <a href="editpushover.php?id=<?php echo $rec['id']; ?>">Editar</a> </td> -->
  <td>   <a href="javascript: void(0);" onclick="window.open('editinterruptor.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
<td align="center"> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deleteinterruptor.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>

<a href="javascript: void(0);" onclick="window.open('insertinterruptor.php', 'Adcionar Interruptor', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/64/device.png">Adicionar Interruptor</a>
<a onClick="return confirm('Tem Certeza que deseja deletar todos os interruptores!')" href="deleteinterruptor.php?id=<?php echo 'd1'; ?>"><img src="/png/32/delete.png">Deletar todos os Interruptores</a>   



</div>

<div id="Persiana" class="w3-container notificacao" style="display:none">
  <h2>Persiana</h2>



<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
$query = "SELECT * FROM `rx433mhz_persiana`";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Código</th> <th>Descrição do Dispositivo</th> <th>Ações</th> <th>Habilitado</th> <th colspan="2">Editar/Exlcuir</th>
</tr>

<?php while($rec = mysqli_fetch_array($data)) { ?>
<tr>
<td> <?php echo $rec['id']; ?> </td>
<td> <?php echo $rec['codigo']; ?> </td>
<td> <?php echo $rec['descricao']; ?> </td>
<td> 
<?php   
$estado = $rec['carga'];
if($estado == "P100") { echo 'Abrir';}
if($estado == "P000") { echo 'Fechar';}
if($estado == "P050") { echo 'Meia Janela';}
if($estado == "P101") { echo 'Parar';}
if($estado == "P102") { echo 'Abrir-Parar-Fecha';}
if($estado == "P020") { echo '20%';}
?> 
</td>
<td> <?php echo $rec['habilitado']; ?> </td>
<!--<td> <a href="editpushover.php?id=<?php echo $rec['id']; ?>">Editar</a> </td> -->
  <td>   <a href="javascript: void(0);" onclick="window.open('editpersiana.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
<td align="center"> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletepersiana.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>

<a href="javascript: void(0);" onclick="window.open('insertpersiana.php', 'Adcionar Controle Persiana', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/64/device.png">Adcionar Controle Persiana</a>
<a onClick="return confirm('Tem Certeza que deseja deletar todas as Persianas!')" href="deletepersiana.php?id=<?php echo 'd1'; ?>"><img src="/png/32/delete.png">Deletar todas as Persianas</a>     



</div>





<div id="Garagem" class="w3-container notificacao" style="display:none">
  <h2>Garagem</h2>



<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
$query = "SELECT * FROM `rx433mhz_garage`";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Código</th> <th>Descrição do Dispositivo</th> <th>Ações</th> <th>Habilitado</th> <th colspan="2">Editar/Exlcuir</th>
</tr>

<?php while($rec = mysqli_fetch_array($data)) { ?>
<tr>
<td> <?php echo $rec['id']; ?> </td>
<td> <?php echo $rec['codigo']; ?> </td>
<td> <?php echo $rec['descricao']; ?> </td>
<td> 
<?php   
$estado = $rec['carga'];
if($estado == "P100") { echo 'Abrir';}
if($estado == "P000") { echo 'Fechar';}
if($estado == "P101") { echo 'Parar';}
if($estado == "P102") { echo 'Inverter';}

?> 
</td>
<td> <?php echo $rec['habilitado']; ?> </td>
<!--<td> <a href="editpushover.php?id=<?php echo $rec['id']; ?>">Editar</a> </td> -->
  <td>   <a href="javascript: void(0);" onclick="window.open('editgarage.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
<td align="center"> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletegarage.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>

<a href="javascript: void(0);" onclick="window.open('insertgarage.php', 'Adcionar Controle Portão de Garagem', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/64/device.png">Adicionar Controle de Portão de Garagem</a>
<a onClick="return confirm('Tem Certeza que deseja deletar todos os Controles de Garagem!')" href="deletegarage.php?id=<?php echo 'd1'; ?>"><img src="/png/32/delete.png">Deletar todos os Controles de Garagem</a>     



</div>


<div id="Sensores" class="w3-container notificacao" style="display:none">
  <h2>Sensores</h2>

<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
$query = "SELECT * FROM `rx433mhz_portas`";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Código</th> <th>Descrição do Dispositivo</th> <th>Ações</th> <th>Habilitado</th> <th colspan="2">Editar/Exlcuir</th>
</tr>

<?php while($rec = mysqli_fetch_array($data)) { ?>
<tr>
<td> <?php echo $rec['id']; ?> </td>
<td> <?php echo $rec['codigo']; ?> </td>
<td> <?php echo $rec['descricao']; ?> </td>
<td> 
<?php   
$estado = $rec['carga'];
if($estado == "1") { echo 'Aberta';}
if($estado == "0") { echo 'Fechada';}
?> 
</td>
<td> <?php echo $rec['habilitado']; ?> </td>
<!--<td> <a href="editpushover.php?id=<?php echo $rec['id']; ?>">Editar</a> </td> -->
  <td>   <a href="javascript: void(0);" onclick="window.open('editporta.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
<td align="center"> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deleteporta.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>

<a href="javascript: void(0);" onclick="window.open('insertporta.php', 'Adcionar Controle Porta', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/64/device.png">Adcionar Controle Porta</a>
<a onClick="return confirm('Tem Certeza que deseja deletar todos os controles de Portas!')" href="deleteporta.php?id=<?php echo 'd1'; ?>"><img src="/png/32/delete.png">Deletar todos os Controles de Portas</a>  
  
</div>


<div id="Alarmes" class="w3-container notificacao" style="display:none">
  <h2>Alarmes</h2>

<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
$query = "SELECT * FROM `rx433mhz_alarmes`";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Código</th> <th>Descrição do Dispositivo</th> <th>Habilitado</th> <th colspan="2">Editar/Exlcuir</th>
</tr>

<?php while($rec = mysqli_fetch_array($data)) { ?>
<tr>
<td> <?php echo $rec['id']; ?> </td>
<td> <?php echo $rec['codigo']; ?> </td>
<td> <?php echo $rec['descricao']; ?> </td>
<td> <?php echo $rec['habilitado']; ?> </td>
<!--<td> <a href="editpushover.php?id=<?php echo $rec['id']; ?>">Editar</a> </td> -->
  <td>   <a href="javascript: void(0);" onclick="window.open('editalarme.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/32/edit.png"></a></td>
<td align="center"> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletealarme.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>

<a href="javascript: void(0);" onclick="window.open('insertalarme.php', 'Adcionar Controle de Alarmes', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=300');"><img src="/png/64/device.png">Adcionar Controle de Alarmes</a>
<a onClick="return confirm('Tem Certeza que deseja deletar todos os Alarmes!')" href="deletealarme.php?id=<?php echo 'd1'; ?>"><img src="/png/32/delete.png">Deletar todos os Alarmes</a>  

</div>



    
    </div>

    <div id="tab3">
     <h3>Reconhecimento de Placas de Veículos</h3>
     
  <ul class="w3-navbar w3-black">
  <li><a href="javascript:void(0)" onclick="openCity('Cameras')">Cameras</a></li>
  <li><a href="javascript:void(0)" onclick="openCity('Veiculos')">Veiculos</a></li>

</ul>

<div id="Cameras" class="w3-container notificacao">
  <h2>Cadastramento das Cameras Onvif</h2>
<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
$query = "SELECT * FROM `cameralpr`";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Camera</th> <th>IP</th> <th>Usuário Onvif</th> <th>Senha Onvif</th> <th>Secret_Key LPR</th> <th>País (br)</th> <th>Dispositivo Sensor</th> <th>Dispositivo Atuador</th> <th>Dispositivo Trava</th> <th>Delay Atuador</th> <th>Status Trava</th> <th>Habilitado</th><th colspan="2">Ação</th>
</tr>

<?php 
$i=0;
while($rec = mysqli_fetch_array($data)) { 
$i++;
?>

<tr>
<td> <?php echo $i; ?> </td>
<td> <?php echo $rec['descricao_cam']; ?> </td>
<td> <?php echo $rec['ip_camera']; ?> </td>
<td> <?php echo $rec['usercamera']; ?> </td>
<td> <?php echo $rec['senha_camera']; ?> </td>
<td> <?php echo $rec['secret_key']; ?> </td>
<td> <?php echo $rec['country']; ?> </td>
<td> <?php 
$device_sensor_codigo =  $rec['device_sensor_codigo']; 
echo substr($device_sensor_codigo, -12);
?> </td>
<td> <?php 
$device_atuador_codigo =  $rec['device_atuador_codigo']; 
echo substr($device_atuador_codigo, -12);
?> </td>
<td> <?php
$device_trava_codigo =  $rec['device_trava_codigo']; 
echo substr($device_trava_codigo, -12);
?> </td>
<td> <?php echo $rec['delay']; ?> </td>
<td> <?php echo $rec['valor_device_trava_codigo']; ?> </td>
<td> <?php echo $rec['habilitado']; ?> </td>

  <!-- <td>   <a href="javascript: void(0);" onclick="window.open('editpushover.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=490');"><img src="/png/32/edit.png"></a></td> -->
<td align="center"> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletecamera.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>

<a href="javascript: void(0);" onclick="window.open('insertcamera.php', 'Adcionar Câmera', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=800');"><img src="/png/64/device.png">Adicionar Câmeras</a>



</div>

<div id="Veiculos" class="w3-container notificacao" style="display:none">
  <h2>Lista de Veiculos Autorizados</h2>
<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
$query = "SELECT * FROM `veiculos_lpr`";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Veiculo</th> <th>Placa</th> <th>Ultimo Acesso</th> <th>Habilitado</th><th colspan="2">Ação</th>
</tr>

<?php 
$i=0;
while($rec = mysqli_fetch_array($data)) { 
$i++;
?>

<tr>
<td> <?php echo $i; ?> </td>
<td> <?php echo $rec['veiculodes']; ?> </td>
<td> <?php echo $rec['veiculoplaca']; ?> </td>
<td> <?php echo $rec['veiculoultimoacesso']; ?> </td>
<td> <?php echo $rec['veiculohabilitado']; ?> </td>

<!--<td> <a href="editpushover.php?id=<?php echo $rec['id']; ?>">Editar</a> </td> -->
  <td>   <a href="javascript: void(0);" onclick="window.open('editveiculo.php?id=<?php echo $rec['id']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=390');"><img src="/png/32/edit.png"></a></td>
<td> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deleteveiculo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>

<a href="javascript: void(0);" onclick="window.open('insertveiculo.php', 'Adcionar E-mail', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=390');">Adicionar Veiculos</a>



</div>

    </div>
	
<div id="tab8">
    
<!--
TAB Controles Infravermelho
-->
<h3>Controles Infravermelho</h3>
     	 
<ul class="w3-navbar w3-black">
  <li><a href="javascript:void(0)" onclick="openCity('condicionador')">Condicionador de Ar</a></li>
  <li><a href="javascript:void(0)" onclick="openCity('tv')">TV e Mídia</a></li>
  <!-- <li><a href="javascript:void(0)" onclick="openCity('controles')">Associar Controles</a></li> -->
</ul>

<div id="condicionador" class="w3-container notificacao">
<h2>Condicionador de Ar</h2>
<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
//$query = "SELECT * FROM `equipamento_infrared`";
$query = "SELECT * FROM `equipamento_infrared` where `tipoequipamento` = '1' ORDER BY `id` ASC;";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Descrição</th> <th>Código AutoDomo</th> <th>Modelo</th> <th>Nome Protocolo</th> <th>Número de bits</th>  <th colspan="2">Ação</th>
</tr>

<?php while($rec = mysqli_fetch_array($data)) { ?>
<tr>
<td> <?php echo $rec['id']; ?> </td>
<td><a href="javascript: void(0);" onclick="window.open('tabelacodigo.php?id=<?php echo $rec['id']; ?>', '<?php echo $rec['email']; ?> ', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=800, HEIGHT=600');"><img src="/png/32/airconditioningindoor.png"><?php echo $rec['Descricao']; ?> </a></td>
<td> <?php echo $rec['Marca']; ?> </td>
<td> <?php echo $rec['Modelo']; ?> </td>
<td> <?php echo $rec['nomeprotocolo']; ?> </td>
<td> <?php echo $rec['numerobit']; ?> </td>
<!--<td> <a href="editpushover.php?id=<?php echo $rec['id']; ?>">Editar</a> </td> -->
  <td>   <a href="javascript: void(0);" onclick="window.open('editarcondicionado.php?id=<?php echo $rec['id']. "&descricao=" . $rec['Descricao'];  ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=420');"><img src="/png/32/edit.png"></a></td>
<td align="center"> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deleteinfrared.php?id=<?php echo $rec['id']; ?>&marca=<?php echo $rec['Marca']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>

<a href="javascript: void(0);" onclick="window.open('insertcondicionadordear.php', 'Adcionar Controle AutoDomo', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=520');"><img src="/png/32/autodomo.png">Adcionar Controle AutoDomo</a>
    
<a href="javascript: void(0);" onclick="window.open('insertcondicionadordear_tuya.php', 'Adcionar Controle AutoDomo', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=520');"><img src="/png/32/tuya.png">Adcionar Controle Tuya</a>
</div>

<div id="tv" class="w3-container notificacao" style="display:none">
<h2>TV e Mídia</h2>
<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
//$query = "SELECT * FROM `equipamento_infrared`";
$query = "SELECT * FROM `equipamento_infrared` where `tipoequipamento` = '2' ORDER BY `id` ASC";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Descrição</th> <th>Marca</th> <th>Modelo</th> <th>Nome Protocolo</th> <th>Número de bits</th>  <th colspan="2">Ação</th>
</tr>

<?php while($rec = mysqli_fetch_array($data)) { ?>
<tr>
<td> <?php echo $rec['id']; ?> </td>
<td><a href="javascript: void(0);" onclick="window.open('tabelacodigo.php?id=<?php echo $rec['id']; ?>', '<?php echo $rec['email']; ?> ', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=800, HEIGHT=600');"><img src="/png/32/airconditioningindoor.png"><?php echo $rec['Descricao']; ?> </a></td>
<td> <?php echo $rec['Marca']; ?> </td>
<td> <?php echo $rec['Modelo']; ?> </td>
<td> <?php echo $rec['nomeprotocolo']; ?> </td>
<td> <?php echo $rec['numerobit']; ?> </td>
<!--<td> <a href="editpushover.php?id=<?php echo $rec['id']; ?>">Editar</a> </td> -->
  <td>   <a href="javascript: void(0);" onclick="window.open('editartv.php?id=<?php echo $rec['id']. "&descricao=" . $rec['Descricao'];  ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=390');"><img src="/png/32/edit.png"></a></td>
<td align="center"> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deleteinfrared.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>


<a href="javascript: void(0);" onclick="window.open('inserttv.php', 'Adcionar Controle AutoDomo', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=520');"><img src="/png/32/autodomo.png">Adcionar Controle AutoDomo</a>
    
<a href="javascript: void(0);" onclick="window.open('insertcondicionadordetv_tuya.php', 'Adcionar Controle Tuya', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=520');"><img src="/png/32/tuya.png">Adcionar Controle Tuya</a>

</div>

<div id="controles" class="w3-container notificacao" style="display:none">
<h2>Associar Controles</h2>
<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$query = "SELECT widget.id, widget.Descricao, username_iphone, tipo, tipo_geral, ambiente.Descricao ambiente, equipamento_infrared.Descricao Descricaocontrole, equipamento_infrared.Marca, equipamento_infrared.Modelo FROM `widget`, ambiente, equipamento_infrared WHERE widget.ambiente = ambiente.id AND (tipo_geral = 10 OR tipo_geral = 11) AND (equipamento_infrared.id = widget.setPrimaryColor3)";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Descrição Equipamento</th> <th>Codigo Autodomum</th> <th>Ambiente</th> <th>Descrição Controle</th> <th>Marca/Modelo</th>  <th> Ação</th>
</tr>

<?php while($rec = mysqli_fetch_array($data)) { ?>
<tr>
<td> <?php echo $rec['id']; ?> </td>
<td> <?php echo $rec['Descricao']; ?> </td>
<td> <?php echo $rec['username_iphone']; ?> </td>
<td> <?php echo $rec['ambiente']; ?> </td>
<td> <?php echo $rec['Descricaocontrole']; ?> </td>
<td> <?php echo $rec['Marca'] . "/" . $rec['Modelo']  ; ?> </td>
<!--<td> <a href="editpushover.php?id=<?php echo $rec['id']; ?>">Editar</a> </td> -->
  <td>   <a href="javascript: void(0);" onclick="window.open('associarcontrole.php?id=<?php echo $rec['id'] . "&tipo_geral=" . $rec['tipo_geral'] . "&descricao=" . $rec['Descricao']; ?>', 'Pagina', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=390');"><img src="/png/32/edit.png"></a></td>
</tr>
<?php } ?>
</table>


</div>

</div>


<div id="tab9">
    
<!--
TAB Controles Infravermelho
-->
<h3>Zigbee</h3>
     	 
<ul class="w3-navbar w3-black">
  <li><a href="javascript:void(0)" onclick="openCity('zigbee')">ZigBee</a></li>
</ul>

<div id="zigbee" class="w3-container notificacao">
<h2>Zigbee</h2>
<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
//$query = "SELECT * FROM `equipamento_infrared`";
$query = "SELECT zigbeedevice.*, widget.Descricao, widget.username_iphone FROM `zigbeedevice`, widget where zigbeedevice.id_widget = widget.id;";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Descrição</th> <th>Serial</th> <th>Serial Zigbee</th> <th>Tipo Acão</th>  <th colspan="2">Ação</th>
</tr>

<?php while($rec = mysqli_fetch_array($data)) { ?>
<tr>
<td> <?php echo $rec['id']; ?> </td>
<td> <?php echo $rec['Descricao']; ?> </td>
<td> <?php echo $rec['username_iphone']; ?> </td>
<td> <?php echo $rec['serialzigbee']; ?> </td>
<td> <?php echo $rec['carga']; ?> </td>
<!--<td> <a href="editpushover.php?id=<?php echo $rec['id']; ?>">Editar</a> </td> -->
<td align="center"> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletezigbee.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>

<a href="javascript: void(0);" onclick="window.open('insertzigbee.php', 'Adcionar Dispositivo Zigbee Sensor', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=700, HEIGHT=550');">Adcionar Dispositivo Zigbee Sensor</a>
<a href="javascript: void(0);" onclick="window.open('insertzigbeeatuador.php', 'Adcionar Dispositivo Zigbee Atuador', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=700, HEIGHT=550');">Adcionar Dispositivo Zigbee Atuador</a>


 
</div>


</div>


<div id="tab10">
    
<!--
TAB Controles Infravermelho
-->
<h3>Criar Cena</h3>
     	 
<ul class="w3-navbar w3-black">
  <li><a href="javascript:void(0)" onclick="openCity('cena')">Cena</a></li>
</ul>

<div id="cena" class="w3-container notificacao">
<h2>Cena</h2>
<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
//$query = "SELECT * FROM `equipamento_infrared`";
$query = "SELECT zigbeedevice.*, widget.Descricao, widget.username_iphone FROM `zigbeedevice`, widget where zigbeedevice.id_widget = widget.id;";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Descrição</th> <th>Serial</th> <th>Serial Zigbee</th> <th>Tipo Acão</th>  <th colspan="2">Ação</th>
</tr>

<?php while($rec = mysqli_fetch_array($data)) { ?>
<tr>
<td> <?php echo $rec['id']; ?> </td>
<td> <?php echo $rec['Descricao']; ?> </td>
<td> <?php echo $rec['username_iphone']; ?> </td>
<td> <?php echo $rec['serialzigbee']; ?> </td>
<td> <?php echo $rec['carga']; ?> </td>
<!--<td> <a href="editpushover.php?id=<?php echo $rec['id']; ?>">Editar</a> </td> -->
<td align="center"> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deletezigbee.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>

<a href="javascript: void(0);" onclick="window.open('insertzigbee.php', 'Adcionar Dispositivo Zigbee', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=700, HEIGHT=550');">Adcionar Dispositivo Zigbee</a>
<a href="javascript: void(0);" onclick="window.open('insertzigbeeatuador.php', 'Adcionar Dispositivo Zigbee Atuador', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=700, HEIGHT=550');">Adcionar Dispositivo Zigbee Atuador</a>   
</div>


</div>

  
       <div id="tab5">
    
    
     <h3>Historico de Alertas e alarmes</h3>
<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
$query = "SELECT * FROM `historico_alerta`";
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Tipo de Alerta</th> <th>Data e Hora da Alerta</th>
</tr>

<?php
$i=0;
while($rec = mysqli_fetch_array($data)) 
{ 
$i++;
$date = new DateTime($rec['data_alerta']);

?>
<tr>
<td> <?php echo $i; ?> </td>
<td> <?php echo $rec['tipo_alerta']; ?> </td>
<td> <?php echo $date->format('d/m/Y H:i:s'); ?> </td>
</tr>
<?php } ?>
</table>

<a onClick="return confirm('Tem Certeza que deseja limpa Historico!')" href="deletehistoricoalerta.php?id=<?php echo $rec['id']; ?>">Limpa Historico</a> </td>

<?php
//SELECT programacao.id_dispositivo,  widget.Descricao, programacao.data_prog, programacao.habilitado, programacao.funcao FROM programacao join widget ON programacao.id_dispositivo = widget.id;
?>

    
    </div>
   <div id="tab6">
 <h3>Ações e Cenas</h3>
    
  
    
     	 
<ul class="w3-navbar w3-black">
  <li><a href="javascript:void(0)" onclick="openCity('acao_tempo')">Ação Baseada no Tempo</a></li>
  <li><a href="javascript:void(0)" onclick="openCity('acao_acao')">Ação Baseada em um Sensor</a></li>
  <li><a href="javascript:void(0)" onclick="openCity('acao_tempo_acao')">Ação Baseada no tempo e em Sensor</a></li>
</ul>

<div id="acao_tempo" class="w3-container notificacao">
<h4>Ex. Liga a lampada da Sala as 18:00hs</h4>
<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
//$query = "SELECT * FROM `equipamento_infrared`";
$query = "SELECT ifttt.*, widget.setPubTopic0, widget.Descricao, widget.tipo_geral, widget.username_iphone username_iphone_atuador  FROM `ifttt`, widget WHERE  (id_widget_atuador = widget.id) AND tipo_acao = '1'";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Descrição</th> <th>Código</th> <th>Ação</th> <th>Data</th>  <th>Ação </th>
</tr>

<?php while($rec = mysqli_fetch_array($data)) { ?>
<tr>
<td> <?php echo $rec['id']; ?> </td>
<td> <?php echo $rec['Descricao']; ?> </td>
<td> <?php echo $rec['username_iphone_atuador']; ?> </td> 
<td> 
<?php 
$acao = "";
if ($rec['tipo_geral'] == '1' || $rec['tipo_geral'] == '15') // Para Iluminação
{
	if ($rec['valor_atuador'] == '1') { $acao = "Ligar";}
	else if ($rec['valor_atuador'] == '0') { $acao = "Desligar";}
}

if ($rec['tipo_geral'] == '14' || $rec['tipo_geral'] == '21' || $rec['tipo_geral'] == '22') // Para Chave
{
	if ($rec['valor_atuador'] == '1') { $acao = "Ligar";}
	else if ($rec['valor_atuador'] == '0') { $acao = "Desligar";}
}

if ($rec['tipo_geral'] == '5') // Para Lampada RGB
{
	if ($rec['valor_atuador'] == '1') { $acao = "Ligar";}
	else if ($rec['valor_atuador'] == '0') { $acao = "Desligar";}
}

if ($rec['tipo_geral'] == '9') // Para Persiana
{
	if ($rec['valor_atuador'] == 'P100') { $acao = "Abrir";}
	else if ($rec['valor_atuador'] == 'P000') { $acao = "Fechar";}
	else { $acao = 'Posicionar em ' . (substr($rec['valor_atuador'],1)) . '%';}
}

if ($rec['tipo_geral'] == '20') // Para Persiana
{
	if ($rec['valor_atuador'] == 'P100') { $acao = "Abrir";}
	else if ($rec['valor_atuador'] == 'P000') { $acao = "Fechar";}
	else if ($rec['valor_atuador'] == 'P101') { $acao = "Parar";}
	else if ($rec['valor_atuador'] == 'P102') { $acao = "Abrir ou Fechar Portão";}
	else { $acao = 'Posicionar em ' . (substr($rec['valor_atuador'],1)) . '%';}
}

if ($rec['tipo_geral'] == '10') // Para Persiana
{
	if ($rec['valor_atuador'] == 'XX!000!TOFF') { $acao = "Desligar";}
	else if ($rec['valor_atuador'] == 'XX!000!T16') { $acao = "Ligar em 16°C";}
	else if ($rec['valor_atuador'] == 'XX!000!T17') { $acao = "Ligar em 17°C";}
	else if ($rec['valor_atuador'] == 'XX!000!T18') { $acao = "Ligar em 18°C";}
	else if ($rec['valor_atuador'] == 'XX!000!T19') { $acao = "Ligar em 19°C";}
	else if ($rec['valor_atuador'] == 'XX!000!T20') { $acao = "Ligar em 20°C";}
	else if ($rec['valor_atuador'] == 'XX!000!T21') { $acao = "Ligar em 21°C";}
	else if ($rec['valor_atuador'] == 'XX!000!T22') { $acao = "Ligar em 22°C";}
	else if ($rec['valor_atuador'] == 'XX!000!T23') { $acao = "Ligar em 23°C";}
	else if ($rec['valor_atuador'] == 'XX!000!T24') { $acao = "Ligar em 24°C";}
	else if ($rec['valor_atuador'] == 'XX!000!T25') { $acao = "Ligar em 25°C";}
	else if ($rec['valor_atuador'] == 'XX!000!T26') { $acao = "Ligar em 26°C";}
	else if ($rec['valor_atuador'] == 'XX!000!T27') { $acao = "Ligar em 27°C";}
	else if ($rec['valor_atuador'] == 'XX!000!T28') { $acao = "Ligar em 28°C";}
	else if ($rec['valor_atuador'] == 'XX!000!T29') { $acao = "Ligar em 29°C";}
	else { $acao = 'Ação Desconhecida';}
}

if ($rec['tipo_geral'] == '11') // Para Persiana
{
	if ($rec['valor_atuador'] == 'XX!000!POW') { $acao = "Ligar/Desligar";}
	else if ($rec['valor_atuador'] == 'XX!000!MEN') { $acao = "Menu";}
	else if ($rec['valor_atuador'] == 'XX!000!CPL') { $acao = "Incrementar Canal";}
	else if ($rec['valor_atuador'] == 'XX!000!CMI') { $acao = "Decrementar Canal";}
	else if ($rec['valor_atuador'] == 'XX!000!VPL') { $acao = "Aumentar Volume";}
	else if ($rec['valor_atuador'] == 'XX!000!VMI') { $acao = "Diminuir Volume";}
	else if ($rec['valor_atuador'] == 'XX!000!MUD') { $acao = "Mudo";}
	else if ($rec['valor_atuador'] == 'XX!000!GUI') { $acao = "Guia";}
	else if ($rec['valor_atuador'] == 'XX!000!ENT') { $acao = "Entrada";}
	else if ($rec['valor_atuador'] == 'XX!000!OK') { $acao = "OK";}
	else { $acao = 'Ação Desconhecida';}
}


if ($rec['tipo_geral'] == '20') // Para Persiana
{
	if ($rec['valor_atuador'] == 'P100') { $acao = "Abrir";}
	else if ($rec['valor_atuador'] == 'P000') { $acao = "Fechar";}
	else if ($rec['valor_atuador'] == 'P101') { $acao = "Parar";}
	else if ($rec['valor_atuador'] == 'P102') { $acao = "Abrir ou Fechar Portão";}
	else { $acao = 'Posicionar em ' . (substr($rec['valor_atuador'],1)) . '%';}
}

 
echo $acao; 
?> 
</td>
<td> 
<?php 
$date = date_create($rec['data_inicio']);
if (date_format($date, 'Y') == '1979')
{
echo 'Todos os dias ás ' . date_format($date, 'H:i:s'); 
}
else
{
echo date_format($date, 'd/m/Y') . ' ás ' . date_format($date, 'H:i:s'); 
}
?> 
</td>
<!--<td> <a href="editpushover.php?id=<?php echo $rec['id']; ?>">Editar</a> </td> -->

<td align="center"> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deleteacaotempo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>

<a href="javascript: void(0);" onclick="window.open('insertacaotempo.php', 'Ação Baseada no Tempo', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=520');">Adicionar Ação Baseada no Tempo</a>
 <a onClick="return confirm('Tem Certeza que deseja deletar todas as ações!')" href="deleteacaotempo.php?id=<?php echo 'd1'; ?>"><img src="/png/32/delete.png">Deletar Tudo</a>  
</div>

<div id="acao_acao" class="w3-container notificacao" style="display:none">
<h4>Ex. Liga a lampada da Sala quando abrir a porta da sala</h4>

<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
//$query = "SELECT * FROM `equipamento_infrared`";
$query = "SELECT ifttt.*, widget.setPubTopic0, widget.Descricao, widget.tipo_geral, widget.username_iphone username_iphone_atuador  FROM `ifttt`, widget WHERE  (id_widget_atuador = widget.id) AND tipo_acao = '2'";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Sensor</th> <th>Código Sensor</th> <th>Valor Sensor</th> <th>Atuador</th>  <th>Código Atuador</th> <th>Ação</th>  <th>Excluir</th>
</tr>

<?php while($rec = mysqli_fetch_array($data)) { 

if ($rec['compara_sensor'] == '=') { $compara_sensor= "Igual á ";}
else if ($rec['compara_sensor'] == '>') { $compara_sensor= "Maior que ";}
else if ($rec['compara_sensor'] == '<') { $compara_sensor= "Menor que ";}

?>
<tr>
<td> <?php echo $rec['id']; ?> </td>
<td> <?php echo "Nome Sensor"; ?> </td>
<td> <?php echo $rec['username_iphone']; ?> </td> 
<td> <?php echo $compara_sensor . $rec['valor_sensor']; ?> </td>
<td> <?php echo $rec['Descricao']; ?> </td>
<td> <?php echo $rec['username_iphone_atuador']; ?> </td> 

<td> 
<?php 
$acao = "";
if ($rec['tipo_geral'] == '1') // Para Iluminação
{
	if ($rec['valor_atuador'] == '1') { $acao = "Ligar";}
	else if ($rec['valor_atuador'] == '0') { $acao = "Desligar";}
}

if ($rec['tipo_geral'] == '14') // Para Chave
{
	if ($rec['valor_atuador'] == '1') { $acao = "Ligar";}
	else if ($rec['valor_atuador'] == '0') { $acao = "Desligar";}
}

if ($rec['tipo_geral'] == '5') // Para Lampada RGB
{
	if ($rec['valor_atuador'] == '1') { $acao = "Ligar";}
	else if ($rec['valor_atuador'] == '0') { $acao = "Desligar";}
}

if ($rec['tipo_geral'] == '9') // Para Persiana
{
	if ($rec['valor_atuador'] == 'P100') { $acao = "Abrir";}
	else if ($rec['valor_atuador'] == 'P000') { $acao = "Fechar";}
}

if ($rec['tipo_geral'] == '20') // Para Portão
{
	if ($rec['valor_atuador'] == 'P100') { $acao = "Abrir";}
	else if ($rec['valor_atuador'] == 'P000') { $acao = "Fechar";}
}
 
echo $acao; 
?> 
</td>

<!--<td> <a href="editpushover.php?id=<?php echo $rec['id']; ?>">Editar</a> </td> -->

<td align="center"> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deleteacaotempo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>

<a href="javascript: void(0);" onclick="window.open('insertacaosensor.php', 'Adicionar Ação Baseada em um Sensor', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=520');">Adicionar Ação Baseada em um Sensor</a>
<a onClick="return confirm('Tem Certeza que deseja deletar todas as ações!')" href="deleteacaotempo.php?id=<?php echo 'd2'; ?>"><img src="/png/32/delete.png">Deletar Tudo</a>      
	

</div>

<div id="acao_tempo_acao" class="w3-container notificacao" style="display:none">
<h4>Ex. Liga a lampada da Sala quando abrir a porta da sala das 18:00hs</h4>

<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
//$query = "SELECT * FROM `equipamento_infrared`";
$query = "SELECT ifttt.*, widget.setPubTopic0, widget.Descricao, widget.tipo_geral, widget.username_iphone username_iphone_atuador  FROM `ifttt`, widget WHERE  (id_widget_atuador = widget.id) AND tipo_acao = '3'";
mysqli_set_charset($con, 'utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);
?>
     
<table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>Sensor</th> <th>Código Sensor</th> <th>Valor Sensor</th>  <th>Periodo</th>  <th>Atuador</th>  <th>Código Atuador</th> <th>Ação</th><th>Excluir</th>
</tr>

<?php while($rec = mysqli_fetch_array($data)) { 

if ($rec['compara_sensor'] == '=') { $compara_sensor= "Igual á ";}
else if ($rec['compara_sensor'] == '>') { $compara_sensor= "Maior que ";}
else if ($rec['compara_sensor'] == '<') { $compara_sensor= "Menor que ";}

?>
<tr>
<td> <?php echo $rec['id']; ?> </td>
<td> <?php echo "Nome Sensor"; ?> </td>
<td> <?php echo $rec['username_iphone']; ?> </td> 
<td> <?php echo $compara_sensor . $rec['valor_sensor']; ?> </td>

<td> 
<?php 
$date = date_create($rec['data_inicio']);
if (date_format($date, 'Y') == '1979')
{
echo 'Todos os dias entre ' . date_format($date, 'H:i:s'); 
}
else
{
echo date_format($date, 'd/m/Y') . ' ás ' . date_format($date, 'H:i:s'); 
}

$date = date_create($rec['data_fim']);
if (date_format($date, 'Y') == '1979')
{
echo ' e ' . date_format($date, 'H:i:s'); 
}
else
{
echo ' - ' . date_format($date, 'd/m/Y') . ' ás ' . date_format($date, 'H:i:s'); 
}

?> 
</td>


<td> <?php echo $rec['Descricao']; ?> </td>
<td> <?php echo $rec['username_iphone_atuador']; ?> </td> 

<td> 
<?php 
$acao = "";
if ($rec['tipo_geral'] == '1') // Para Iluminação
{
	if ($rec['valor_atuador'] == '1') { $acao = "Ligar";}
	else if ($rec['valor_atuador'] == '0') { $acao = "Desligar";}
}

if ($rec['tipo_geral'] == '14') // Para Chave
{
	if ($rec['valor_atuador'] == '1') { $acao = "Ligar";}
	else if ($rec['valor_atuador'] == '0') { $acao = "Desligar";}
}

if ($rec['tipo_geral'] == '5') // Para Lampada RGB
{
	if ($rec['valor_atuador'] == '1') { $acao = "Ligar";}
	else if ($rec['valor_atuador'] == '0') { $acao = "Desligar";}
}

if ($rec['tipo_geral'] == '9') // Para Persiana
{
	if ($rec['valor_atuador'] == 'P100') { $acao = "Abrir";}
	else if ($rec['valor_atuador'] == 'P000') { $acao = "Fechar";}
}

if ($rec['tipo_geral'] == '20') // Para Portão
{
	if ($rec['valor_atuador'] == 'P100') { $acao = "Abrir";}
	else if ($rec['valor_atuador'] == 'P000') { $acao = "Fechar";}
}
 
echo $acao; 
?> 
</td>




<!--<td> <a href="editpushover.php?id=<?php echo $rec['id']; ?>">Editar</a> </td> -->

<td align="center"> <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deleteacaotempo.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>
<?php } ?>
</table>

<a href="javascript: void(0);" onclick="window.open('insertacaotemposensor.php', 'Adicionar Ação Baseada no Tempo e Sensor', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=520');">Adicionar Ação Baseada no Tempo e Sensor</a>
 <a onClick="return confirm('Tem Certeza que deseja deletar todas as ações!')" href="deleteacaotempo.php?id=<?php echo 'd3'; ?>"><img src="/png/32/delete.png">Deletar Tudo</a>     
	



</div>

  
</div>
   
    <div id="tab7">
    <h3>Configurações</h3>
   <ul class="w3-navbar w3-black">
  	<li><a href="javascript:void(0)" onclick="openCity('senha')">Mudar Senha</a></li>
  	<li><a href="javascript:void(0)" onclick="openCity('sistema')">Informações do Sistema</a></li>
  	<li><a href="javascript:void(0)" onclick="openCity('usuarioacesso')">Usuarios Autodomum</a></li>
		<li><a href="javascript:void(0)" onclick="openCity('qrcode')">Gerar QRCode de Acesso</a></li>
	<li><a href="javascript:void(0)" onclick="openCity('usuariosupervisorio')">Usuarios Supervisorio</a></li>

	</ul>
	
<div id="senha" class="w3-container notificacao">
  <h2>Mudar Senha de Acesso</h2>
  
    <div class="form">
    <form class="w3-container w3-card-4" id="form_login" method="post" action="alterar_senha.php">
    <h4>AutoHome</h4>
    <label class="w3-label w3-text-blue"><b>Usuario</b></label>
      <input class="w3-input w3-border" type="text" name="usuario" placeholder="Usuario"/>
      <p> 
      <label class="w3-label w3-text-blue"><b>Senha</b></label>
      <input class="w3-input w3-border" type="password" name="nova" placeholder="Senha"/>
      <p> 
      <label class="w3-label w3-text-blue"><b>Confirma Senha</b></label>
      <input class="w3-input w3-border" type="password" name="repita" placeholder="Confirma Senha"/>
      <p> 
      <button class="w3-btn w3-blue">Entrar</button>
    </form>
  </div>
  </div>

  <div id="usuariosupervisorio" class="w3-container notificacao">
  <h2>Usuario do Supervisorio</h2>
  
<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
$query = "SELECT * FROM `usuario_admin`";
$data = mysqli_query($con, $query);
mysqli_close($con);
?>

<div class="form">

<table border="1" cellpadding="5">
<tr>
<th>ID</th> <th>Nome</th> <th>Usuario</th> <th>Acesso</th> <th>Excluir</th>
</tr>
<?php
$i=0;
while($rec = mysqli_fetch_array($data)) 
{ 
$i++;
?>

<tr>
<td> <?php echo $i; ?>  </td> <td> <?php echo $rec['nome']; ?>  </td><td> <?php echo $rec['usuario']; ?> </td> <td> <?php echo $rec['acesso']; ?> </td> <td>  <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deleteusuario.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>

<?php
}
?>
</table>

<a href="javascript: void(0);" onclick="window.open('inserirusuario.php', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=600');"><img src="/png/64/usuario.png">Adicionar Usuario</a>
</div>
</div>

<div id="qrcode" class="w3-container notificacao">
  <h2>QRCode de Acesso</h2>
  
<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
$query = "SELECT * FROM `usuario_admin`";
$data = mysqli_query($con, $query);
mysqli_close($con);
?>

<div class="form">

<table border="1" cellpadding="5">
<tr>
<th>ID</th> <th>Nome</th> <th>Usuario</th> <th>Acesso</th> <th>Excluir</th>
</tr>
<?php
$i=0;
while($rec = mysqli_fetch_array($data)) 
{ 
$i++;
?>

<tr>
<td> <?php echo $i; ?>  </td> <td> <?php echo $rec['nome']; ?>  </td><td> <?php echo $rec['usuario']; ?> </td> <td> <?php echo $rec['acesso']; ?> </td> <td>  <a onClick="return confirm('Tem Certeza que deseja deletar!')" href="deleteusuario.php?id=<?php echo $rec['id']; ?>"><img src="/png/32/delete.png"></a> </td>
</tr>

<?php
}
?>
</table>

<a href="javascript: void(0);" onclick="window.open('inserirusuario.php', 'Adcionar Dispositivo', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=600');"><img src="/png/64/usuario.png">Adicionar Usuario</a>
</div>
</div>
  
  

<div id="sistema" class="w3-container notificacao" style="display:none">
  <h2>Informações do Sistema</h2>
<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
$query = "SELECT * FROM `servidor`";
$data = mysqli_query($con, $query);
mysqli_close($con);
$rec = mysqli_fetch_array($data); 
$date = new DateTime($rec['data_alerta']);
?>

<div class="form">   
<table border="1" cellpadding="5">

<tr>
<td>  </td>
<td>  
<a href="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=<?php echo  $rec['nome'] . "-" . $rec['pin'] ."-". $rec['chavedispositivo'] . "-" . $rec['ip']; ?>" target="_blank"><img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo $rec['nome'] . "-" . $rec['pin'] ."-". $rec['chavedispositivo'] . "-" . $rec['ip']; ?>"></a>
</td>
</tr>

<tr>
<td> Nome </td>
<td> <?php echo $rec['nome']; ?> </td>
</tr>

<tr>
<td> Usuário </td>
<td> <?php echo $rec['usuario']; ?> </td>
</tr>

<tr>
<td> E-mail Kappelt </td>
<td> <?php echo $rec['email']; ?> </td>
</tr>

<tr>
<td> Senha Kappelt</td>
<td> <?php echo $rec['senha_user_gh']; ?> </td>
</tr>

<tr>
<td> Usuário MQTT</td>
<td> <?php echo $rec['usu_bb']; ?> </td>
</tr>

<tr>
<td> Senha MQTT</td>
<td> <?php echo $rec['se_bb']; ?> </td>
</tr>



<tr>
<td> Número Serial </td>
<td> <?php echo $rec['pin']; ?> </td>
</tr>
<tr>
<td> Chave dos Dispositivos </td>
<td> <?php echo $rec['chavedispositivo']; ?> </td>
</tr>

<tr>
<td> IP </td>
<td> <?php echo $rec['ip']; ?> </td>
</tr>


<tr>
<td> Chave Local </td>
<td> <?php echo substr($rec['chavelocal'], 0 , 5); ?> </td>
</tr>

<tr>
<td> Versão firmware </td>
<td> <?php echo $rec['firmware']; ?> </td>
</tr>


</table>



</div>


</div>
    

<div id="usuarioacesso" class="w3-container notificacao"  style="display:none">
<h2>Usuarios</h2>

<div class="form">
 <table border="1" cellpadding="5">
<tr>
<th>Id</th> <th>E-mail</th> <th>Imei</th> <th>Token</th> <th>Fone</th> <th>Primeiro Acesso</th>  <th>Último Acesso</th> <th>Habilitado</th> <th>Usuario Pleno</th><th>Administrador</th>
</tr>


<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
//mysql_select_db($DB_NAME, $con);
$query = "SELECT * FROM `usuario`";
$data = mysqli_query($con, $query);
mysqli_close($con);


$i=0;
while($rec = mysqli_fetch_array($data)) 
{ 
$i++;
//$date = new DateTime($rec['data_alerta']);
$habilitado = $rec['habilitado'];
$somente_local = $rec['somente_local'];
$administrador = $rec['administrador'];
$imei_movel = $rec['imei']; 

if($habilitado == '0')
	{
			$checked1 = '';
			$_checked1 = '0';	
	}else 
	{
			$checked1 = 'checked';
			$_checked1 = '1';	
	}
	
	if($somente_local == '0')
	{
			$checked2 = '';
			$_checked2 = '0';		
	}else 
	{
			$checked2 = 'checked';
			$_checked2 = '1';	
	}
	
		if($administrador == '0')
	{
			$checked3 = '';
			$_checked3 = '0';		
	}else 
	{
			$checked3 = 'checked';
			$_checked3 = '1';	
	}
	
	$data_criacao2 = new DateTime($rec['data_criacao']);
	$ultimo_Acesso2 = new DateTime($rec['ultimo_Acesso']);
?>

<tr>

<td> <?php echo $i; ?> </td>
<td> 
<a href="javascript: void(0);" onclick="window.open('usuario_ambiente.php?id=<?php echo $rec['id'] . '&imeimovel=' . $imei_movel; ?>', '<?php echo $rec['email']; ?> ', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=410');"><img src="/png/32/smartphone.png"><?php echo $rec['email']; ?></a>
</td>
<td> <?php echo $rec['imei']; ?> </td>
<td>
<a href="javascript: void(0);" onclick="window.open('sincronizartoken.php?id=<?php echo $rec['id']; ?>', '<?php echo $rec['token']; ?> ', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=NO, TOP=10, LEFT=10, WIDTH=600, HEIGHT=410');"><?php echo substr($rec['token'], 0 , 5); ?></a>
</td>
<td> <?php echo $rec['fone']; ?> </td>
<td> <?php echo $data_criacao2->format('d/m/Y H:i:s'); ?> </td>
<td> <?php echo $ultimo_Acesso2->format('d/m/Y H:i:s'); ?> </td>
<td> <?php //echo $rec['habilitado']; ?> 

<div class="onoffswitch">
 <input type="checkbox" onclick="return usuario_habilitado('habilitado<?php echo $rec['id']; ?>', 'somente_local<?php echo $rec['id']; ?>', 'administrador<?php echo $rec['id']; ?>', '1',  '<?php echo $rec['id']; ?>', '<?php echo $imei_movel; ?>')" name="habilitado<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="habilitado<?php echo $rec['id']; ?>" value="<?php  echo $_checked1 ?>" <?php  echo $checked1 ?> >
<label class="onoffswitch-label" for="habilitado<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
</div>

</td>
<td> <?php // echo $rec['somente_local']; ?> 

<div class="onoffswitch">
 <input type="checkbox" onclick="return usuario_habilitado('habilitado<?php echo $rec['id']; ?>', 'somente_local<?php echo $rec['id']; ?>', 'administrador<?php echo $rec['id']; ?>', '2', '<?php echo $rec['id']; ?>', '<?php echo $imei_movel; ?>')" name="somente_local<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="somente_local<?php echo $rec['id']; ?>" value="<?php  echo $_checked2 ?>" <?php  echo $checked2 ?> >
<label class="onoffswitch-label" for="somente_local<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
</div>



</td>


<td> <?php // echo $rec['somente_local']; ?> 

<div class="onoffswitch">
<input type="checkbox" onclick="return usuario_habilitado('habilitado<?php echo $rec['id']; ?>', 'somente_local<?php echo $rec['id']; ?>', 'administrador<?php echo $rec['id']; ?>', '3', '<?php echo $rec['id']; ?>', '<?php echo $imei_movel; ?>')" name="administrador<?php echo $rec['id']; ?>"  class="onoffswitch-checkbox <?php echo $rec['id']; ?>" id="administrador<?php echo $rec['id']; ?>" value="<?php  echo $_checked3 ?>" <?php  echo $checked3 ?> >
<label class="onoffswitch-label" for="administrador<?php echo $rec['id']; ?>">
<span class="onoffswitch-inner"></span>
<span class="onoffswitch-switch"></span>
</label>
</div>



</td>


</tr>

<?php } ?>

</table>

</div>
</div>
</div>
</div>




<script src="/js/jquery-1.7.2.min.js"></script>
<script>
$(document).ready(function() {
    $("#content").find("[id^='tab']").hide(); // Hide all content
    $("#tabs li:first").attr("id","current"); // Activate the first tab
    $("#content #tab1").fadeIn(); // Show first tab's content
    
    $('#tabs a').click(function(e) {
        e.preventDefault();
        if ($(this).closest("li").attr("id") == "current"){ //detection for current tab
         return;       
        }
        else{             
          $("#content").find("[id^='tab']").hide(); // Hide all content
          $("#tabs li").attr("id",""); //Reset id's
          $(this).parent().attr("id","current"); // Activate this
          $('#' + $(this).attr('name')).fadeIn(); // Show content for the current tab
        }
    });
});


function openCity(cityName) {
    var i;
    var x = document.getElementsByClassName("notificacao");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    document.getElementById(cityName).style.display = "block";  
}

</script>


</body></html>