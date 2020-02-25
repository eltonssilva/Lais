//gBridge/u959/iluminacao/01AA00000015
//gBridge/u959/d0/grequest

module.exports = function (topico, carga) {

var codigo_dispositivo;
var topico_publica;
var mensagem_publica;

traco_1 = topico.indexOf("/" , 1); 
traco_2 = topico.indexOf("/" , traco_1+1); 
traco_3 = topico.indexOf("/" , traco_2+1);

sub_topico =  topico.substring(traco_2+1, traco_3); 
codigo_dispositivo = topico.substring(traco_3 + 1);

if (sub_topico == "iluminacao")
{
 topico_publica = "/house/iluminacao/" + codigo_dispositivo;
     if (carga == 'On')
    {
        carga = '1';
    }
    
        if (carga == 'Off')
    {
        carga = '0';
    }
 mensagem_publica =  carga;
}

else if (sub_topico == "switch")
{
 topico_publica = "/house/switch/" + codigo_dispositivo;
 mensagem_publica =  carga; 
}

if (sub_topico == "rgb")
{
 topico_publica = "/house/rgb/" + codigo_dispositivo;
      if (carga == '1')
    {
        carga = 'p1';
    }
    else if (carga == '0')
    {
        carga = 'p0';
    }
    else if (carga.length <= 3)
    {
        carga = "D" + FormatNumberLength(carga, 3);
    }
        else if (carga.length == 6)  // Nem vai ser utilizdo em lampada dimerizavel
    {
     //   carga = "r" + FormatNumberLength(carga, 6);
    // var valor = ConvertBase("FF").from(16).to(10);
    var r = carga.substring(0, 2); 
    var g = carga.substring(2, 4); 
    var b = carga.substring(4, 6); 
    carga = "r" +  FormatNumberLength(ConvertBase.hex2dec(r), 3) + "," + FormatNumberLength(ConvertBase.hex2dec(g), 3) + "," +  FormatNumberLength(ConvertBase.hex2dec(b), 3);
    }
    else if (carga.substring(0, 6) == "{\"red\"")   // Nem vai ser utilizdo em lampada dimerizavel
    {
        carga =  JSON.parse(carga);
        var r = carga.red; 
        var g = carga.green; 
        var b = carga.blue; 
        carga = "r" +  FormatNumberLength(r, 3) + "," + FormatNumberLength(g, 3) + "," +  FormatNumberLength(b, 3)
    }
    
 mensagem_publica =  carga;
}

if (sub_topico == "iluminacaodim")
{
topico_publica = "/house/iluminacaodim/" + codigo_dispositivo;
      if (carga == '1')
    {
        carga = '1';
    }
    else if (carga == '0')
    {
        carga = '0';
    }
    else if (carga.length <= 3)
    {
        carga = "D" + FormatNumberLength(carga, 3);
    }
        else if (carga.length == 6)
    {
     //   carga = "r" + FormatNumberLength(carga, 6);
    // var valor = ConvertBase("FF").from(16).to(10);
    var r = carga.substring(0, 2); 
    var g = carga.substring(2, 4); 
    var b = carga.substring(4, 6); 
    carga = "r" +  FormatNumberLength(ConvertBase.hex2dec(r), 3) + "," + FormatNumberLength(ConvertBase.hex2dec(g), 3) + "," +  FormatNumberLength(ConvertBase.hex2dec(b), 3);
    }
    else if (carga.substring(0, 6) == "{\"red\"")
    {
        carga =  JSON.parse(carga);
        var r = carga.red; 
        var g = carga.green; 
        var b = carga.blue; 
        carga = "r" +  FormatNumberLength(r, 3) + "," + FormatNumberLength(g, 3) + "," +  FormatNumberLength(b, 3)
    }
    
 mensagem_publica =  carga;
}

else if (sub_topico == "ifredarc")
{
    //gBridge/u959/ifredarc/10AA00000002
  topico_publica = "/house/ifredarc/" + codigo_dispositivo;
    if (carga == 'on')
    {
        carga = 'XX!000!TON';
    }
    
        if (carga == 'off')
    {
        carga = 'XX!000!TOFF';
    }
    
    mensagem_publica =  carga;
}

else if (sub_topico == "persiana")
{
    //gBridge/u959/ifredarc/10AA00000002
    topico_publica = "/house/persiana/" + codigo_dispositivo;

    carga = "P" + FormatNumberLength(carga, 3);
    mensagem_publica =  carga;
}

if (sub_topico == "cena")
{
 topico_publica = "/house/cena/" + codigo_dispositivo;
 mensagem_publica =  carga;   
}
function FormatNumberLength(num, length) {
    var r = "" + num;
    while (r.length < length) {
        r = "0" + r;
    }
    return r;
}

   (function(){

    var ConvertBase = function (num) {
        return {
            from : function (baseFrom) {
                return {
                    to : function (baseTo) {
                        return parseInt(num, baseFrom).toString(baseTo);
                    }
                };
            }
        };
    };
        
    // binary to decimal
    ConvertBase.bin2dec = function (num) {
        return ConvertBase(num).from(2).to(10);
    };
    
    // binary to hexadecimal
    ConvertBase.bin2hex = function (num) {
        return ConvertBase(num).from(2).to(16);
    };
    
    // decimal to binary
    ConvertBase.dec2bin = function (num) {
        return ConvertBase(num).from(10).to(2);
    };
    
    // decimal to hexadecimal
    ConvertBase.dec2hex = function (num) {
        return ConvertBase(num).from(10).to(16);
    };
    
    // hexadecimal to binary
    ConvertBase.hex2bin = function (num) {
        return ConvertBase(num).from(16).to(2);
    };
    
    // hexadecimal to decimal
    ConvertBase.hex2dec = function (num) {
        return ConvertBase(num).from(16).to(10);
    };
    
    this.ConvertBase = ConvertBase;
    
})(this);

function isJson(obj)
{
    	if (obj !== undefined && obj !== null && obj.constructor == Object)
	{
		return true;
	}
	else
	{
		return false;
	}
}

return  {topico: topico_publica, 
         mensagem: mensagem_publica}

}

