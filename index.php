<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de Pronóstico</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,900&display=swap" rel="stylesheet"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script>
      $(document).ready(function(){
        $("form").submit(function(event){
          event.preventDefault();
          var user = $("#user").val();
          var pass = $("#password").val();
          var submit = $("#submit").val();
          $(".form-message").load("logica/login.php", {
              user: user,
              pass: pass,
              submit: submit
          });
        });
      });
    </script>
  </head>

  <body>
    <div class="container contenedor container-login">

      <div class="row">

        <div class="col-lg-4 col-sm-8 col-10 div-form" id="div-formLogin">

          <h1>Inicio de sesión</h1>
          <div class="header header-center">
            <p>Llena los campos correspondientes para iniciar sesión</p>
          </div>

          <form action="logica/login.php" method="POST" class="form">
            <div class="form-group">
              <!-- <label>Nombre:</label> -->
              <input id="user" type="text" name="usuario" class="form-control" placeholder="Usuario:">
            </div>
            <div class="form-group">
              <!-- <label>Contraseña:</label> -->
              <input id="password" type="password" name="password" class="form-control" placeholder="Contraseña:">
            </div>
            <p class="form-message"></p>
            <button type="submit" class="btn btnLogin" id="submit">Iniciar Sesión</button>  
            <a href="acerca.php">Acerca de</a>
          </form>
    
        </div>

      </div>

    </div>

  </body>
</html>