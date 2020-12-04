<?php
header("Content-Type: text/html; charset=UTF-8",true);
require_once("usuario/dados_bd.php");
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME);
$msg = "";

if(isset($_POST['btnSubmit'])) 
	{
		$tuyacontrole = $_POST['tuyacontrole'];
		$marca = $_POST['marca'];
		$arr = explode("-",$tuyacontrole);
		$remote_id = $arr[1];
    $remote_index = $arr[0];
    $remote_name = $arr[2];


     $query =   "UPDATE `widget` SET `label` = '{$remote_index}', `label2` = '{$remote_id}' WHERE REPLACE(`widget`.`username_iphone`, ':', '') = '{$marca}'";
     
  
		//echo $query ;
		if(mysqli_query($con, $query))
				{
       

        $query =  "INSERT INTO `equipamento_infrared` (`id`, `Descricao`, `Marca`, `Modelo`, `nomeprotocolo`, `numerobit`, `tipoprotocolo`,  `repeticao`, `tipoequipamento`) 
        VALUES (NULL, '{$remote_name}', '{$marca}', 'TUYA', '', '', '',  '', '2');";

            if(mysqli_query($con, $query))
            {
            $msg = "Alteração Salva";
            } 
            else 
            {
            $msg = "Erro na Atualização";
            }

        
				} 
		else 
				{
				$msg = "Erro na Atualização";
        }
        



}





$query = "SELECT * FROM `protocolo_infrared`";
mysqli_set_charset($con, 'utf8');
$studentData = mysqli_query($con, $query);
//$recStudent = mysql_fetch_array($studentData);


$query = "SELECT REPLACE (widget.username_iphone, ':', '') equipamento, Descricao FROM `widget` WHERE tipo_geral = 11 ORDER BY `widget`.`username_iphone` ASC";
mysqli_set_charset($con, 'utf8');
$equipamento = mysqli_query($con, $query);
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

     $('#btnTuya').click(function () {
				


            const URL_TO_FETCH = 'https://autodomo-73076.firebaseio.com/tuya/chave/result/access_token.json'; 
            
            fetch(URL_TO_FETCH, { 
                method: 'get' // opcional
              })
              .then(function(response) { 
              response.text().then(function(result){ 
                  console.log(result); 
                  buscarDevices(result);
                })
              })
              .catch(function(err) { console.error(err); });

            return false;
             
      }); 


function buscarDevices(token){
    const URL_BUSCA_DEVICES = 'https://us-central1-autodomo-73076.cloudfunctions.net/getListRemoteControls'; 

    let token2 = token.replace('"', '').replace('"', '');
    const  device_id = $("#idvirtual").val();

    const body = JSON.stringify({
          "access_token": token2,
          "device_id" : device_id
     });

     const headers = new Headers();

    headers.append('Content-Type', 'application/json');
    headers.append('Accept', 'application/json');
    headers.append('Origin','http://localhost');

     console.log(body);

    fetch(URL_BUSCA_DEVICES, { 
                method: 'POST', // opcional
                body: body,
             //   mode: 'no-cors'
              })
              .then(response => response.json())
              .then(texto => montarSelectTuyaControle(texto))
              .catch(err => console.log(err.message))
  }


    function montarSelectTuyaControle(listaControles){


    let  i =0;
    $('#tuyacontrole')
    .find('option')
    .remove()
    .end()
;

     while(i < listaControles.result.length){
        const  optionValue = listaControles.result[i].remote_id + "-" + listaControles.result[i].remote_index + "-" + listaControles.result[i].remote_name;
        const optionText  = listaControles.result[i].remote_name;

        $('#tuyacontrole').append(new Option(optionText, optionValue));
         console.log(listaControles.result[i].remote_name);
        i++;
     }
   
    }

    });
    

</script>
<h5>Depois de Modificar click no botão "Atualizar" e depois "Fecha"</h5><b>
<form class="w3-container w3-card-4" method="POST" name="frm" id="frm">

<table>

  <tr>
    <td>
    <label class="w3-label w3-text-blue"><b>Codigo Dispositivo Infravermelho (ID Virtual)</b></label>
      <input type="text" class="w3-input w3-border" value="" name="idvirtual" id="idvirtual" maxlength=32/>
    </td>
    <td>
    <input type="image" id="btnTuya" alt="Tuya" src="/png/32/lupa.png">
    </td>
  </tr>

</table>



<label class="w3-label w3-text-blue"><b>Lista de ArCondicionados Pareados </b></label>
        <select class="w3-input w3-border" name="tuyacontrole" id="tuyacontrole">

       </select>

  <label class="w3-label w3-text-blue"><b>Equipamento (Ar Condicionado) </b></label>
        <select class="w3-input w3-border" name="marca" id="marca">
                    <?php 
                    while($rec = mysqli_fetch_array($equipamento)) { 
                         echo "<option value=" . $rec['equipamento'] . ">" . $rec['Descricao'] . "</option>"; 
                     } 
                     ?>
  </select>




<br>
<input type="submit" class="w3-btn w3-blue" name="btnSubmit" value="Salvar"/>
<input type='button' class="w3-btn w3-blue" id='btn' value='Fecha' /><p>
<?php 
echo $msg; 

?>
</form>

</body>
</html>