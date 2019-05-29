<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("location:index.php");
        exit();
    }
    else{
        if(!isset($_SESSION['k'])){
            header("location:configuracion.php");
          }
          else{
            include 'logica/graficas.php';
          }
        
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="css/graficas.css">
    <title>Sistema de Pronóstico</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,900&display=swap" rel="stylesheet"> 
    
</head>
<body>  
    <div class="top">
        <a href="var.php" id="home">Home</a>
        <a href="tablas.php" id="link">Tablas</a>
        <a href="graficas.php" id="link">Gráficas</a>
        <a href="analisis.php" id="link">Análisis</a>
            <a href="logica/logout.php" id="logout">Cerrar Sesión</a>
      </div>

      <div class="container-fluid contenedor">
        <div class="row">
            <h1>Gráficas</h1>
            <div class="header header-center">
                <p>Representación de resultados a través de herramientas de visualización</p>
            </div>
            <div class="col-lg-7 grafica-pronosticos">
                <h3>Pronósticos</h3>
                <p>A continuación se muestra una representación gráfica de los pronósticos estimados:</p>
                <div id="curve_chart" class="curve_chart"></div>
            </div>

            <div class="col-lg-7 grafica-pronosticos">
                <h3>Mejor pronóstico</h3>
                <p>A continuación se muestra una representación gráfica del mejor pronóstico estimado:</p>
                <div id="curve_chart2" class="curve_chart"></div>
            </div>

            <div class="col-lg-7 grafica-pronosticos">
                <h3>Velocímetro</h3>
                <p>A continuación se muestra una visualización del pronóstico estimado:</p>
                <div id="velocimetro"></div>
            </div>

                

        </div>

      </div>

</body>
</html>


<?php
    }
?>