<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("location:index.php");
        exit();
    }
    else{
        include 'logica/graficas.php';
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="css/tablas.css">
    <link rel="stylesheet" type="text/css" href="css/analisis.css">
    <title>Sistema de Pronóstico</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,900&display=swap" rel="stylesheet"> 
</head>
<body>  

      <div class="container-fluid contenedor">
        <div class="row">
            <div class="enlaces">
                <a href="tablas.php" id="back">Regresar</a>
                <a href="#" id="pdf">Generar PDF</a>
                <a href="logica/logout.php" id="logout">Cerrar Sesión</a>
            </div>
            <h1>Análisis Resultados</h1>
            
            <p class="texto">Figura 1.0 - Tabla de pronósticos estimados</p>
            <table class="table">
                <tbody>
            <?php

                print("<tr>");
                    print("<th>Periodo</th>");
                    print("<th>Frecuencias</th>");
                    print("<th>PS</th>");
                    print("<th>PMS K = $k</th>");
                    print("<th>PMD j = $J</th>");
                    print("<th>PMDA m = $m</th>");
                    print("<th>PTMAC</th>");
                    print("<th>PSE $promedioPSE</th>");

                print("</tr>");


                //Periodo, Frecuencia, PS, PMS k = ....
                for ($i=0; $i < $n+1; $i++) {
                    print("<tr>");
                    for ($j=0; $j < $size; $j++) {
                        if($j>1){
                            //PS, PMS k = ....
                            print("<td>".$pronosticos[$i][$j]. "</td>");
                        }
                        else{
                            //PMS Periodo, Frecuencia
                            print("<td class='important'>".$pronosticos[$i][$j]. "</td>");
                        }
                    }
                    print("</tr>");
                }

            ?>
                </tbody>
            </table>
            
            <div class="graficas">
                <div class="grafica">
                    <p class="texto">Figura 2.0 - Gráfica de pronósticos estimados</p>
                    <div id="curve_chart" class="curve_chart"></div>
                </div>
                <div class="grafica">
                    <p class="texto">Figura 3.0 - Gráfica de mejor pronóstico</p>
                    <div id="curve_chart2" class="curve_chart"></div>
                </div>
            </div>

            <div class="cont-velocimetro">
                <p class="texto">Figura 4.0 - Visualización de de pronóstico</p>
                <div id="velocimetro"></div>
            </div>
            
        </div>

      </div>

</body>
</html>


<?php
    }
?>