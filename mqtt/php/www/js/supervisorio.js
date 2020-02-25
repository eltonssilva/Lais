	//	var socket = io('http://<?php echo $endereco; ?>:4555', {transports: ['websocket', 'polling', 'flashsocket']});
var topico_sendo_utilizado;
var temperatura_atual = 16;
var Modo_atual = 1;// 1-Refrigerar, 2-Automático, 3-Aquecer, 4-Ventilação
var fan = 1; // 1-Automático, 2-Baixa, 3-Média, 4-Alta
var swing = 1; // 1-Girando;   2-Parado
//alert (fan);
	
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
var serial_dispositivo = data.substring(barra3 + 1);
var codigo_dispositivo = serial_dispositivo.substring(0,2);

    
	   
	   if ( semi_topico == "rx433mhz")
	   {
	   	$("#codigo433mhz1").text("Codigo Controle: " + valor);
	   }
	   // <h6 id="codigo433mhz1">Código Radio 433mhz - 4345655665</h6>
	   
	   if ( semi_topico == "smartinterruptor")
	   {
	   	$("#codigo433mhz1").text("Codigo Controle: " + valor);
	   }
	   
/*	  
	   if (semi_topico == 'iluminacao') 
	   { 
	   	if (valor == 1)
	   		{
	   			$("." + id ).attr('checked', true);
	   			$("#bulb" + id).attr("src", "/png/64/bulb_on.png");
	   		}
	   	if (valor == 0) 
	   		{
	   			$("." + id ).attr('checked', false);
	   			$("#bulb" + id).attr("src", "/png/64/bulb.png");
	   		}  
	   }
*/	   
	   	   if (semi_topico == 'door') 
	   { 
	   	if (valor == 1)
	   		{
	   			$("." + id ).attr('checked', true);
	   			$("#bulb" + id).attr("src", "/png/64/door.png");
	   		}
	   	if (valor == 0) 
	   		{
	   			$("." + id ).attr('checked', false);
	   			$("#bulb" + id).attr("src", "/png/64/door.png");
	   		}  
	   }
	  
	/*
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
*/
	   
	   
	   	   if (semi_topico == 'agrupamento') 
	   { 
	   	if (valor == 1)
	   		{
	   			$("." + id ).attr('checked', true);
	   			$("#bulb" + id).attr("src", "/png/64/bulb_on.png");
	   		}
	   	if (valor == 0) 
	   		{
	   			$("." + id ).attr('checked', false);
	   			$("#bulb" + id).attr("src", "/png/64/bulb.png");
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
	   if (semi_topico == 'pressao') { $("." + id ).text((valor/101325).toFixed(3) + "Atm (" + valor + "Pa)"); }
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
	   			$("." + id ).attr('checked', true);
	   			$("#bulb" + id).attr("src", "/png/64/power button.png");
	   		}else {
	   			$("." + id ).attr('checked', false);
	   			$("#bulb" + id).attr("src", "/png/64/power button.png");
	   		}  
	   }
	   
	   
	   	   	if (semi_topico == 'confirma')  	
	   {
		   if (codigo_dispositivo == "01")
		   {
				if (valor == "On")
					{
					//	alert (valor + " " + serial_dispositivo);
						$("." + serial_dispositivo ).attr('checked', true);
						$(".bulb" + serial_dispositivo).attr("src", "/png/64/bulb_on.png");
					}
				if (valor == "Off")
					{
					//	alert (valor + " " + serial_dispositivo);
						$("." + serial_dispositivo ).attr('checked', false);
						$(".bulb" + serial_dispositivo).attr("src", "/png/64/bulb.png");
					}  
		   }
		   
		   if (codigo_dispositivo == "14")
		   {
				if (valor == "On")
					{
					//	alert (valor + " " + serial_dispositivo);
						$("." + serial_dispositivo ).attr('checked', true);
						$(".bulb" + serial_dispositivo).attr("src", "/png/64/power_on.png");
					}
				if (valor == "Off")
					{
					//	alert (valor + " " + serial_dispositivo);
						$("." + serial_dispositivo ).attr('checked', false);
						$(".bulb" + serial_dispositivo).attr("src", "/png/64/power.png");
					}  
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
		
	function pubgeral(topico, mensagem, reter)
	{
  	 $.post('pub.php',{mensagem: mensagem, topico: topico, reter: reter},function(data){
		 
	 }) 
	}
	
	function pubair(topico, mensagem, reter)
	{
		if (mensagem == "on")
		{
			mensagem = "XX!000!TON";
		$.post('pub.php',{mensagem: mensagem, topico: topico, reter: reter},function(data){}) 
		}
		
		if (mensagem == "off")
		{
			mensagem = "XX!000!TOFF";
			$.post('pub.php',{mensagem: mensagem, topico: topico, reter: reter},function(data){}) 
		}
		
		if (mensagem == "oscilar")
		{
			mensagem = "XX!000!TON";
			$.post('pub.php',{mensagem: mensagem, topico: topico, reter: reter},function(data){}) 
		}
		
		if (mensagem == "modo")
		{

			Modo_atual++;
		if (Modo_atual == 5)
            {
                Modo_atual = 1;
            }
    
			montarcomandos(topico,  reter);
		}
		
		 if (mensagem == "plustemp")  // Mais quente
        {
			temperatura_atual++;
            if (temperatura_atual == 30)
            {
                temperatura_atual = 29;
            }
            montarcomandos(topico, reter);
        }
		
      if (mensagem == "minustemp")  // mais frio
        {
			temperatura_atual--;
            if (temperatura_atual == 15)
            {
                temperatura_atual = 16;
            }

            montarcomandos(topico, reter);
        }
		
		    if (mensagem == "minusfan")  // menso ventilação
        {
			fan--;
            if (fan == 0)
            {
                fan = 1;
            }
    

            montarcomandos(topico,  reter);
        }
		
		        if (mensagem == "plusfan")  // mais ventilação
        {
			fan++;
            if (fan== 5)
            {
                fan = 4;
            }
    
            montarcomandos(topico,  reter);
        }
		
		

	}
	
	

   
	function pubmqtt(name_, topico, reter)
 {

	 //mostrando o retorno do post
	
    
	if($("#" + name_).attr('checked')) {
  //  alert("Ligado");
  	 $.post('pub.php',{mensagem: '0', topico: topico, reter: reter},function(data){
   }) 
	} else {
 //  alert("Deligado");
  $.post('pub.php',{mensagem: '1', topico: topico, reter: reter},function(data){
   })
 
	}
}
		function pubmqttpersiana(name_, topico, reter, id_)
  {
	  
    
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

	function topicosendoutilizado(topico)
{
    
  	 topico_sendo_utilizado = topico;
	// alert(topico_sendo_utilizado);
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

	
	function usuario_habilitado(_name1, _name2, _name3, _selecionado, _id)
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
  	 $.post('pub.php',{mensagem: 'p1', topico: topico, reter: reter},function(data){
   }) 
	} else {
//   alert("Deligado");
  $.post('pub.php',{mensagem: 'p0', topico: topico, reter: reter},function(data){
   })
 
	}

}


	   function montarcomandos(topico, reter)
   {
       if (fan == 1)
       {
          ventilacao_automatica(topico, reter);
       }

       if (fan == 2)
       {
           ventilacao_baixa(topico, reter);
       }

       if (fan == 3)
       {
          ventilacao_media(topico, reter);
       }

       if (fan == 4)
       {
           ventilacao_alta(topico, reter);
       }

	   
	   $("#display_lcd").text(temperatura_atual +"°C");
   }
   
    function ventilacao_automatica(topico, reter)
   {
       var comando_infrared;
       if (Modo_atual == 1)  // Modo Refrigerar
       {
           comando_infrared = "XX!000!T" + temperatura_atual;
		   $.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
       }

       if (Modo_atual == 2)  // Modo Automatico
       {
           comando_infrared = "XX!000!A" + temperatura_atual;
		$.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
       }

       if (Modo_atual == 3)  // Modo Aquecer
       {
           comando_infrared = "XX!000!G" + temperatura_atual;
			$.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
       }

       if (Modo_atual == 4)  // Modo Ventilar
       {
           comando_infrared = "XX!000!V" + temperatura_atual;
		 $.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
       }
   }
   
       function ventilacao_baixa(topico, reter)
    {
        var comando_infrared;
        if (Modo_atual == 1)  // Modo Refrigerar
        {
            comando_infrared = "XX!000!X" + temperatura_atual;
            $.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
        }

        if (Modo_atual == 2)  // Modo Automatico
        {
            comando_infrared = "XX!000!Y" + temperatura_atual;
            $.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
        }

        if (Modo_atual == 3)  // Modo Aquecer
        {
            comando_infrared = "XX!000!Z" + temperatura_atual;
            $.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
        }

        if (Modo_atual == 4)  // Modo Ventilar
        {
            comando_infrared = "XX!000!W" + temperatura_atual;
            $.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
        }

    }
   
          function ventilacao_media(topico, reter)
    {
        var comando_infrared;
        if (Modo_atual == 1)  // Modo Refrigerar
        {
            comando_infrared = "XX!000!R" + temperatura_atual;
            $.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
        }

        if (Modo_atual == 2)  // Modo Automatico
        {
            comando_infrared = "XX!000!S" + temperatura_atual;
            $.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
        }

        if (Modo_atual == 3)  // Modo Aquecer
        {
            comando_infrared = "XX!000!P" + temperatura_atual;
            $.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
        }

        if (Modo_atual == 4)  // Modo Ventilar
        {
            comando_infrared = "XX!000!U" + temperatura_atual;
            $.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
        }

    }
	
	          function ventilacao_alta(topico, reter)
    {
        var comando_infrared;
        if (Modo_atual == 1)  // Modo Refrigerar
        {
            comando_infrared = "XX!000!E" + temperatura_atual;
            $.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
        }

        if (Modo_atual == 2)  // Modo Automatico
        {
            comando_infrared = "XX!000!F" + temperatura_atual;
            $.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
        }

        if (Modo_atual == 3)  // Modo Aquecer
        {
            comando_infrared = "XX!000!H" + temperatura_atual;
            $.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
        }

        if (Modo_atual == 4)  // Modo Ventilar
        {
            comando_infrared = "XX!000!J" + temperatura_atual;
            $.post('pub.php',{mensagem: comando_infrared, topico: topico, reter: reter},function(data){}) 
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

 
 $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#example').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );
