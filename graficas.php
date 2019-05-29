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
    <link rel="stylesheet" type="text/css" href="css/graficas.css">
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
                <p>A continuación se muestra una representación gráfica del mejor pronóstico estimado:</p>
                
            </div>


        </div>

      </div>

</body>
</html>


<?php
    }
?>