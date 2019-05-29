<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("location:index.php");
        exit();
    }
    else{
        include 'logica/datosGrafica.php';
    
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,900&display=swap" rel="stylesheet"> 
    <script type="text/javascript">

        const k = "<?php echo $k ?>";
        const j = "<?php echo $j ?>";
        const m = "<?php echo $m ?>";
        const theta = "<?php echo $theta ?>";
        const pronosticoMejor = "<?php echo $pronosticoMejor ?>";

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        //   ['Periodo', 'Frecuencias', 'PS', 'PMS k = ' + k, 'PMD j = ' + j, 'PMDA m = ' + m, 'PTMAC'],
        ['Periodo', 'Frecuencias', 'PS', 'PMS k = ' + k, 'PMD j = ' + j, 'PMDA m = ' + m, 'PTMAC'],
          <?php
            for ($i=0; $i < $n+1; $i++) { 
                $texto = "[";
                for ($j=0; $j < $size; $j++) { 
                    if($j< ($size - 1)){
                        if($pronosticos[$i][$j] == "---"){
                            $texto = $texto.",";
                        }
                        else{
                            $texto = $texto.$pronosticos[$i][$j].",";
                        }
                    }
                    else{
                        if($pronosticos[$i][$j] == "---"){
                            $texto = $texto.",";
                        }
                        else{
                            $texto = $texto.$pronosticos[$i][$j];
                        }
                    }
                }
                if($i<$n){
                 $texto = $texto."],";
                }
                else{
                    $texto = $texto."]";
                }
                print($texto);
            }
            ?>
            
            ]); 
       
        var options = {
          title: 'Resultado Pronósticos',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        //Datos gráfica mejor
        var data2 = google.visualization.arrayToDataTable([
        ['Periodo', 'Frecuencias', pronosticoMejor],
          <?php
            $pos = 0;
            for ($i=0; $i < $n+1; $i++) { 
                $texto = "[";
                for ($j=0; $j < 3; $j++) { 
                    if($j == 2){
                        $pos = $mejor;
                    }
                    else{
                        $pos = $j;
                    }
                    if($pos< ($size - 1)){
                        if($pronosticos[$i][$pos] == "---"){
                            $texto = $texto.",";
                        }
                        else{
                            $texto = $texto.$pronosticos[$i][$pos].",";
                        }
                    }
                    else{
                        if($pronosticos[$i][$pos] == "---"){
                            $texto = $texto.",";
                        }
                        else{
                            $texto = $texto.$pronosticos[$i][$pos];
                        }
                    }
                }
                if($i<$n){
                 $texto = $texto."],";
                }
                else{
                    $texto = $texto."]";
                }
                print($texto);
            }
            ?>
            
            ]); 
       
        var options2 = {
          title: 'Mejor Pronóstico',
          curveType: 'function',
          legend: { position: 'bottom' }
        };


        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        var chart2 = new google.visualization.LineChart(document.getElementById('curve_chart2'));

        chart.draw(data, options);
        chart2.draw(data2, options2);
      }
    </script>
</head>
<body>  
    <div class="top">
        <a href="var.php" id="home">Home</a>
        <a href="tablas.php" id="link">Tablas</a>
        <a href="graficas.php" id="link">Graficas</a>
        <a href="analisis.php" id="link">Análisis</a>
            <a href="logica/logout.php" id="logout">Cerrar Sesión</a>
      </div>

      <div class="container-fluid contenedor">
        <div class="row">
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
            
        </div>

      </div>

</body>
</html>


<?php
    }
?>