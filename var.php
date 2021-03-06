<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("location:index.php");
        exit();
    }
    else{
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sistema de Pronóstico</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="css/var.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,900&display=swap" rel="stylesheet"> 
  </head>

  <body>

    <div class="top">
            <a href="logica/logout.php" id="logout">Cerrar Sesión</a>
    </div>

    <div class="container-fluid contenedor">
        <div class="row">
            <div class="col-lg-7 mt-5 col-sm-8 col-10 div-form">
                <h1>Elección de variables</h1>
                <div class="header header-center">
                    <p>Para continuar, seleccione el tema sobre el que quiera conocer su pronóstico:</p>
                </div>
                <ul>
                    <li>
                        <a href="configuracion.php?v=var1" class="option">
                            <div class="number" id="number1"><p>1</p></div>
                            <div class="data">
                                <h4>Variable 1</h4>
                                <p>Serie histórica del Producto Interno Bruto de México durante el periodo de 1919 al 2018.</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="configuracion.php?v=var2" class="option">
                            <div class="number" id="number2"><p>2</p></div>
                            <div class="data">
                                <h4>Variable 2</h4>
                                <p>Serie histórica de la tasa de homicidios por 100 mil habitantes en el país durante el periodo de 1931 a 2017.</p>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
  </body>
</html>

<?php
    }
?>