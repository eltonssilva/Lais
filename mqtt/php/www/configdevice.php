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
	  socket.on('notificacao', function (data) {

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
	   // <h6 id="codigo433mhz1">Código Radio 433mhz - 4345655665</h6>
	   
	  
	   if (semi_topico == 'iluminacao') 
	   { 
	   	if (valor == 1)
	   		{
	   			$("." + id ).attr('checked', true);
	   			$("#bulb" + id).attr("src", "/png/64/bulb_on.png");
	   		}else {
	   			$("." + id ).attr('checked', false);
	   			$("#bulb" + id).attr("src", "/png/64/bulb.png");
	   		}  
	   }
	   
	  if (semi_topico == 'rgb') 
	   {
	   	var novacor;
	  // 	alert(valor);
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
	   			//		alert(novacor);

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
	   				//	alert(novacor);
	   					$(".color" + id ).val(novacor);
	   					$(".color" + id ).css('background-color' , novacor );
	   					}
	   		}  
	   }
	   
	   if (semi_topico == "temp") { $("." + id ).text(valor + "°C (" + ((valor * 1.8) + 32 ).toFixed(1) + "°F)"); }  //°F = °C × 1,8 + 32
	   if (semi_topico == "altitude") { $("." + id ).text(valor + "m"); }
	   if (semi_topico == "pressao") { $("." + id ).text((valor/101325).toFixed(3) + "Atm (" + valor + "Pa)"); }
	   if (semi_topico == "umidade") { $("." + id ).text(valor + "%"); }
	   if (semi_topico == "lux") { $("." + id ).text(valor + " lux"); }
	   if (semi_topico == 'motion') 
	   { 
	   	if (valor == 1)
	   		{
	   			$("." + id ).text("Acionado");
	   		}else {
	   			$("." + id ).text("Não Acionado");
	   		}  
	   }
	  
	   if (semi_topico == 'persiana') 
	   { 
	   	if (valor == "P000")
	   		{
	   			$("." + id ).attr('checked', false);
	   		}else {
	   			$("." + id ).attr('checked', true);
	   		}  
	   }
	   
	   	   if (semi_topico == 'power') 
	   { 
	   	if (valor == 1)
	   		{
	   			$("." + id ).attr('checked', true);
	   			$("#bulb" + id).attr("src", "/png/64/power_on.png");
	   		}else {
	   			$("." + id ).attr('checked', false);
	   			$("#bulb" + id).attr("src", "/png/64/power.png");
	   		}  
	   }
	   
	   
	   	   if (semi_topico == 'switch') 
	   { 
	   	if (valor == 1)
	   		{
	   			$("." + id ).attr('checked', true);
	   			$("#bulb" + id).attr("src", "/png/64/power button.png");
	   		}else {
	   			$("." + id ).attr('checked', false);
	   			$("#bulb" + id).attr("src", "/png/64/power button.png");
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
	
			function pubmqttpersiana(name_, topico, reter)
  {



	 //mostrando o retorno do post
	
    
	if($("#" + name_).attr('checked')) {
//    alert("Ligado");
  	 $.post('pub.php',{mensagem: 'P100', topico: topico, reter: reter},function(data){
   }) 
	} else {
//   alert("Deligado");
  $.post('pub.php',{mensagem: 'P000', topico: topico, reter: reter},function(data){
   })
 
	}
	}
	
		function pubmqttrgb(name_, topico, reter)
  {

	 //mostrando o retorno do post
	
    
	if($("#" + name_).attr('checked')) {
//    alert("Ligado");
  	 $.post('pub.php',{mensagem: 'p1', topico: topico, reter: reter},function(data){
   }) 
	} else {
//   alert("Deligado");
  $.post('pub.php',{mensagem: 'p0', topico: topico, reter: reter},function(data){
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
     	 $.post('pub.php',{mensagem: rgb, topico: topico, reter: '1'},function(data){})
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


<?php
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME );
//mysqli_select_db($DB_NAME, $con);
$query = "SELECT * FROM `widget` where id_ligado='0' and dispositivo_fisico = '1' ORDER BY ordem asc";
mysqli_set_charset('utf8');
$data = mysqli_query($con, $query);
mysqli_close($con);

?>

<p>
<table border="0" cellpadding="0">

<?php while($rec = mysqli_fetch_array($data)) { 

$ambiente = $rec['ambiente'];
$topico = $rec['setSubTopic0'];
$desc_ambiente = '';
$valor = '';


$con2 = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS,$DB_NAME );
//mysql_select_db($DB_NAME, $con2);
$query2 = "SELECT * FROM `ambiente` where id = '{$ambiente}'";
mysqli_set_charset('utf8');
$data2 = mysqli_query($con2, $query2);
mysqli_close($con2);
while($rec2 = mysqli_fetch_array($data2)) 
{ 
$desc_ambiente = $rec2['Descricao'];
}

$con3 = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS,$DB_NAME );
//mysql_select_db($DB_NAME, $con3);
$query3 = "SELECT * FROM `historico_mqtt` where topico ='{$topico}'";
//echo $query3;
mysqli_set_charset('utf8');
$data3 = mysqli_query($con3, $query3);
mysqli_close($con3);
while($rec3 = mysqli_fetch_array($data3)) 
{ 
$valor = $rec3['valor'];
}




 if($rec['tipo_geral']=='1')
{
	$bulb = '/png/64/bulb.png'; 
//echo $valor;
if($valor == 1)
	{
			
			$checked = 'checked';
			$bulb = '/png/64/bulb_on.png';
	}else 
	{

			$checked = '';
			$bulb = '/png/64/bulb.png'; 
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">

<th><a href="/bulb.php?<?php echo 'id=' . $rec['id'] . '&topic=' . $rec['setPubTopic0'];?>"><img id="bulb<?php echo $rec['id']; ?>" src= <?php echo "'" . $bulb . "'"; ?> alt="Smiley face" height="64" width="64"><a></th> 
<th><?php echo $rec['Descricao']; ?></th>
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
</tr>
<?php } ?>



















<tr id="row<?php echo $rec['ordem']; ?>">

<th><a href="/controlear.php?<?php echo 'id=' . $rec['id'] . '&topic=' . $rec['setPubTopic0'];?>"><img id="bulb<?php echo $rec['id']; ?>" src= <?php echo "'" . $bulb . "'"; ?> alt="Ar Condicionado" height="64" width="64"><a></th> 
<th><?php echo $rec['Descricao']; ?></th>
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
</tr>
<?php 
} 
?>




<?php

 if($rec['tipo_geral']=='11')
{
	$bulb = '/png/64/tv.png'; 
//echo $valor;
if($valor == 1)
	{
			
			$checked = 'checked';
	}else 
	{

			$checked = '';
	}
	
?>
<tr id="row<?php echo $rec['ordem']; ?>">

<th><a href="/controletv.php?<?php echo 'id=' . $rec['id'] . '&topic=' . $rec['setPubTopic0'];?>"><img id="bulb<?php echo $rec['id']; ?>" src= <?php echo "'" . $bulb . "'"; ?> alt="Controle TV" height="64" width="64"><a></th> 
<th><?php echo $rec['Descricao']; ?></th>
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
</tr>
<?php } ?>


<?php

if($rec['tipo_geral']=='12')
{
	$bulb = '/png/64/power.png'; 
	
	if($valor == 1)
	{
			
			$checked = 'checked';
			$bulb = '/png/64/power_on.png';
	}else 
	{

			$checked = '';
			$bulb = '/png/64/power.png'; 
	}

?>
<tr id="row<?php echo $rec['ordem']; ?>">

<th><a href="/power.php?<?php echo 'id=' . $rec['id'] . '&topic=' . $rec['setPubTopic0'];?>"><img id="bulb<?php echo $rec['id']; ?>" src= <?php echo "'" . $bulb . "'"; ?> alt="Smiley face" height="64" width="64"><a></th> 
<th><?php echo $rec['Descricao']; ?></th>
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
</tr>
<?php } ?>


<?php if($rec['tipo_geral']=='13')
{ ?>
<tr id="row<?php echo $rec['ordem']; ?>">
<th><img src="/png/64/motion.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
<th><?php echo $desc_ambiente; ?></th>
<th class="<?php echo $rec['id']; ?>"><?php if ($valor == '1') {echo 'Acionado';} else {echo 'Não Acionado';} ?></th>
</th>
</tr>
<?php } ?>




<?php

 if($rec['tipo_geral']=='14')
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
<th><img src="/png/64/power button.png" alt="Smiley face" height="64" width="64"></th> 
<th><?php echo $rec['Descricao']; ?></th>
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
</tr>



<?php } ?>


<?php

 if($rec['tipo_geral']=='15')
{
	$bulb = '/png/64/bulb.png'; 
//echo $valor;
if($valor == 1)
	{
			
			$checked = 'checked';
			$bulb = '/png/64/bulb_on.png';
	}else 
	{

			$checked = '';
			$bulb = '/png/64/bulb.png'; 
	}
?>
<tr id="row<?php echo $rec['ordem']; ?>">

<th><a href="/bulb.php?<?php echo 'id=' . $rec['id'] . '&topic=' . $rec['setPubTopic0'];?>"><img id="bulb<?php echo $rec['id']; ?>" src= <?php echo "'" . $bulb . "'"; ?> alt="Smiley face" height="64" width="64"><a></th> 
<th><?php echo $rec['Descricao']; ?></th>
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
</tr>
<?php } ?>




<?php 
} 
mysqli_close($con);
?>

</table>
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