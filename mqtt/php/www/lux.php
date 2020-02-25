<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
require_once("usuario/antisql.php");
include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
//echo "Olá, " . $_SESSION['usuarioLogin'];
$endereco = $_SERVER[HTTP_HOST];

if ($endereco == 'localhost')
{
	$endereco = 'localhost';
}
else 
{
	$posicao = strpos($endereco, ':');
	$endereco = substr($endereco, 0 , $posicao );
}
//echo $endereco;

$topic = $_GET['topic'];
$id = $_GET['id'];
?>

<?php
$con = mysql_connect($DB_SERVER, $DB_USER, $DB_PASS);
mysql_select_db($DB_NAME, $con);
$query = "SELECT * FROM `widget` where id = '$id'";
mysql_set_charset('utf8');
$data = mysql_query($query);
mysql_close($con);

while($rec = mysql_fetch_array($data)) { 

$ambiente = $rec['ambiente'];
$topico = $rec['setSubTopic0'];
$topico_pub = $rec['setPubTopic0'];
$dispositivo = $rec['Descricao'];
$desc_ambiente = '';
$valor = '';
$checked = 'Ligado';
}

$con2 = mysql_connect($DB_SERVER, $DB_USER, $DB_PASS);
mysql_select_db($DB_NAME, $con2);
$query2 = "SELECT * FROM `ambiente` where id = '{$ambiente}'";
mysql_set_charset('utf8');
$data2 = mysql_query($query2);
mysql_close($con2);
while($rec2 = mysql_fetch_array($data2)) 
{ 
$desc_ambiente = $rec2['Descricao'];
}

$con3 = mysql_connect($DB_SERVER, $DB_USER, $DB_PASS);
mysql_select_db($DB_NAME, $con3);
$query3 = "SELECT * FROM `historico_mqtt` where topico ='{$topico}'";
//echo $query3;
mysql_set_charset('utf8');
$data3 = mysql_query($query3);
mysql_close($con3);
while($rec3 = mysql_fetch_array($data3)) 
{ 
$valor = $rec3['valor'];
$dia = $rec3['data'];
}

if($valor == 1)
	{
			$checked = 'Ligado';
			$bulb = '/png/switch_on.png';
	}else 
	{
			$checked = 'Desligado';
			$bulb = '/png/switch_off.png'; 
	}

mysql_close($con);
mysql_close($con2);
mysql_close($con3);
?>


<!DOCTYPE html>
<html dir="ltr" lang="pt-BR" style="">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>AutoHome</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<link href="/css/main_m.css" rel="stylesheet" type="text/css"/>  
<script src="/js/jquery-1.10.2.js"></script>
<script src="/js/jscolor.js"></script>
<script src="http://<?php echo $endereco; ?>:4555/socket.io/socket.io.js"></script>
<script src="/js/jquery-1.7.2.min.js"></script>
<script src="/js/iro.js-master/dist/iro.js" charset="utf-8"></script>
<script>

      var demo = new iro.ColorWheel("#demoWheel", {
      	width: 290,
  			height: 290,
  			markerRadius: 8,
  			// Padding space around the markers:
  			padding: 6,
  			// Space between the hue/saturation ring and the value slider:
  			sliderMargin: 20
  			// Initial color value -- any hex, rgb or hsl color string works:
    
      });
      
      demo.watch(watchFunction);


$(document).ready(function() {
    $('#rbgon').click(function(e) {  
    //  alert(1);
       var topico = $("#topico").text();
 	   var id = $("#id").text();
 		 var rgbString = demo.color.rgbString;
 // alert(topico + " " + id);
		rgbbt(id, rgbString, topico);
    });
});


     
      
  function watchFunction(color) {
  // For this example, we'll just log the color's HEX value to the developer console
 // console.log(color.hexString);
// $("#h4data").text(color.rgbString);
// $("#h4data").text(color.hslString);
 

};


		var socket = io('http://<?php echo $endereco; ?>:4555', {transports: ['websocket', 'polling', 'flashsocket']});
	  socket.on('notificacao', function (data) {

var traco1 =   data.indexOf('-', 0);
var traco2 =   data.indexOf('-', traco1 + 1);
var barra2 =   data.indexOf('/', traco2 + 3);
var barra3 =   data.indexOf('/', barra2 + 1);
if (barra3 == -1) {barra3 = data.length;}

var id = data.substring(0,traco1);
var valor = data.substring(traco1+1,traco2);
var semi_topico = data.substring(barra2+1,barra3);
status_lamp = valor;

/*
	  if (semi_topico == 'rgb') 
	   {
	   	var novacor;
	  // 	alert(valor);
	   	if (valor == "p0")
	   		{
					demo.color.rgbString = "rgb(0, 0, 0)";
	   		}else {
	   			if (valor == "p1"){demo.color.rgbString = "rgb(255, 255, 255)";};
	   			var inicio_cor = valor.substring(0,1);
	   					if (inicio_cor == "r")
	   					{	   			
	   					var r = parseInt(valor.substring(1,4)).toString(16);
	   					var g = parseInt(valor.substring(5,8)).toString(16);
	   					var b = parseInt(valor.substring(9,12)).toString(16);
	   					
	   					novacor = "#" + r + "" + g + "" + b;
	   			//		alert(novacor);
	   					demo.color.hexString = novacor;

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
	   						h=359;
	   					//	h=1;
	   						}else
	   						{ 
	   						h = (parseFloat(h) * 36 /100).toFixed(0);
	   					//	h = (parseFloat(h)/1000); 
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
	   						
	   					//	newh = 350;
	   					//	news = 100; 
	   					//	newl = 100;  
	   						
	   				//	var conv_rgb = hslToRgb(h_hsl, s_hsl, l_hsl);
	   					var conv_rgb = calc(newh , news,  newl ) 
	   					
	   				//	 novacor = "hsl(" + newh + ", " + news + "%, " + newl + "%)";
	   				//	 novacor = "#" + h_hsl + "-" +s_hsl + "-" + l_hsl;
	   					// alert(novacor);
	   				//	 demo.color.hsv = novacor;

							var hexrgb = conv_rgb[0];	   					
	   					var r = conv_rgb[1];
	   					var g = conv_rgb[2];
	   					var b = conv_rgb[3];
	   				//	var r = parseInt(r).toString(16);
	   				//	var g = parseInt(g).toString(16);
	   				//	var b = parseInt(b).toString(16);
	   					//$("#geral").text(demo.color.hslString);	
	   					
	   				//	$("#geral").text(newh + "-" + news + "-" +  newl + "-" + hexrgb + "-" + r + "-" + g + "-" + b);
	   					novacor = hexrgb;
	   				//	$("#geral").text(novacor);
	   			//		alert(novacor);
	   					demo.color.hexString = novacor;
	   					
	   					}
	   		}  
	   }
	   
	  */

});



function rgbbt(id, jscolor, topico) {
	var hexcode = jscolor;

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
     	 $.post('pub.php',{mensagem: rgb, topico: topico, reter: '1'},function(data){})
 //  alert(rgb);


}




		function calc(h_, s_, l_) 
		{
			h = h_;
			s = s_;
			l = l_;
			if( h=="" ) h=0;
			if( s=="" ) s=0;
			if( l=="" ) l=0;
			h = parseFloat(h);
			s = parseFloat(s);
			l = parseFloat(l);
			if( h<0 ) h=0;
			if( s<0 ) s=0;
			if( l<0 ) l=0;
			if( h>=360 ) h=359;
			if( s>100 ) s=100;
			if( l>100 ) l=100;
			s/=100;
			l/=100;
			C = (1-Math.abs(2*l-1))*s;
			hh = h/60;
			X = C*(1-Math.abs(hh%2-1));
			r = g = b = 0;
			if( hh>=0 && hh<1 )
			{
				r = C;
				g = X;
			}
			else if( hh>=1 && hh<2 )
			{
				r = X;
				g = C;
			}
			else if( hh>=2 && hh<3 )
			{
				g = C;
				b = X;
			}
			else if( hh>=3 && hh<4 )
			{
				g = X;
				b = C;
			}
			else if( hh>=4 && hh<5 )
			{
				r = X;
				b = C;
			}
			else
			{
				r = C;
				b = X;
			}
			m = l-C/2;
			r += m;
			g += m;
			b += m;
			r *= 255.0;
			g *= 255.0;
			b *= 255.0;
			r = Math.round(r);
			g = Math.round(g);
			b = Math.round(b);
			hex = r*65536+g*256+b;
			hex = hex.toString(16,6);
			len = hex.length;
			if( len<6 )
				for(i=0; i<6-len; i++)
					hex = '0'+hex;
		 //	document.calcform.hex.value = '#'hex.toUpperCase();
		 //	document.calcform.r.value = r;
		 //	document.calcform.g.value = g;
		 //	document.calcform.b.value = b;
		 //	document.calcform.color.style.backgroundColor='#'+hex;
		 	 return [ '#'+hex.toUpperCase(), r, g , b ];
		}

</script>




</head>
<body bgcolor="#E6E6FA">
<div id="divcenter" class="divcenter">
<h4><?php echo $dispositivo . "(" . $desc_ambiente . ")"; ?></h4>


          <div class="wheel">
            <div id="demoWheel" width="290" height="290"></div>
          </div>

      
<img id="rbgon" src="/png/64/rgb.png" alt="Smiley face" height="64" width="64">
<h5 id="h4data"><?php echo $checked  . ' em ' . $dia; ?></h5>
<h4 style="visibility: hidden" id="topico"><?php echo $topico_pub; ?></h4>
<h4 style="visibility: hidden" id="id"><?php echo $id; ?></h4>
</div>
</body>
</html>