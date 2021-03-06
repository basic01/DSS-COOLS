<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("location:index.php");
        exit();
    }
    else{
      if(isset($_REQUEST['v'])){
        $bd = $_REQUEST['v'];
      }
      else{
        header("location:var.php");
      }

?>

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
    <link rel="stylesheet" type="text/css" href="css/configuracion.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,900&display=swap" rel="stylesheet"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
      $("form").submit(function(event) {
        event.preventDefault();
        var k = $("#k").val();
        var j = $("#j").val();
        var m = $("#m").val();
        var theta = $("#t").val();
        var submit = $("#submit").val();
        var promedioPSE = $("#promedioPSE").val();
        var bd = $("#bd").val();
        $("#form-message").load('logica/validarConfig.php',{
          k: k,
          j: j,
          m: m,
          theta: theta,
          promedioPSE: promedioPSE,
          bd: bd,
          submit:submit
        });
      })
    });
    
    </script>
  </head>

  <body>
      <div class="top">
        <a href="var.php" id="home">Home</a>
            <a href="logica/logout.php" id="logout">Cerrar Sesión</a>
      </div>

    <div class="container contenedor container-login">

      <div class="row">

        <div class="col-lg-4 col-sm-8 col-10 div-form" id="div-formConfig">

          <h1>Configuración</h1>

          <div class="header header-center">
            <p>Llena los campos correspondientes para realizar el análisis de los datos</p>
          </div>

          <form action="logica/validarConfig.php" method="POST" class="form">
            <div class="form-group">
                <input type="text" placeholder="k:" name="k" id="k" class="form-control"> 
                <p id="messageK" class="form-message"></p>
            </div>
            <div class="form-group">
                <input type="text" placeholder="j:" name="j" id="j" class="form-control">
                <p id="messageJ" class="form-message"></p>
            </div>
            <div class="form-group">
                <input type="text" placeholder="m:" name="m" id="m" class="form-control">
                <p id="messageM" class="form-message"></p>
            </div>
            <div class="form-group">
                <input type="text" placeholder="alpha:" name="t" id="t" class="form-control">
                <p id="messageTheta" class="form-message"></p>
            </div>
            <div class="form-group">
              <select name="promedioPSE" id="promedioPSE" class="form-control">
                <option value="PS">PS</option>
                <option value="PMS">PMS</option>
                <option value="PMD">PMD</option>
                <option value="PMDA">PMDA</option>
                <option value="PTMAC">PTMAC</option>
              </select>
            </div>
            <p class="form-message" id="form-message"></p>
            <input id="bd" name="bd" type="hidden" value="<?php echo $bd ?>">
            <button type="submit" id="submit" name="submitConfig"  class="btn boton btnConfig">Siguiente</button>
          </form>
    
        </div>

      </div>

    </div>

  </body>
</html>

<?php
    }
?>
