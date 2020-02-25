<!DOCTYPE html>
<html dir="ltr" lang="pt-BR" style=""><head>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>AutoHome</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<link href="/css/index.css" rel="stylesheet" type="text/css"/> 
</head>
<body>
<div class="login-page">
  <div class="form">
    <form class="login-form" id="form_login" method="post" action="validasupervisorio.php">
    <h1>AutoHome</h1>
    <h3>Automação Industrial</h3>
      <input type="text" name="usuario" placeholder="Username"/>
      <input type="password" name="senha" placeholder="Password"/>
      <button>Entrar</button>
      <div align="center"> 
        <p>&nbsp;</p>
        <p>2017 &copy; Todos os Direitos Reservados</p>
      </div>
      <p class="message">Not registered? <a href="#">Create an account</a></p>
    </form>
  </div>
</div>
  
 <script>
$('#toggle-login').click(function () {
    $('#login').toggle();
});

$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});

</script>

</body></html>
     