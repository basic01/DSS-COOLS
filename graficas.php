<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("location:index.php");
        exit();
    }
    else{
        $k = $_SESSION['k'];
        $j = $_SESSION['j'];
        $m = $_SESSION['m'];
        $theta = $_SESSION['theta'];
        $n = $_SESSION['n'];
        $pronosticos = $_SESSION['pronosticos'];
        $size = count(current($pronosticos));
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

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
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

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
</head>
<body>  
    <div class="top">
        <a href="var.php" id="home">Home</a>
        <a href="tablas.php" id="link">Tablas</a>
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
                <div id="curve_chart"></div>
            </div>
        </div>

      </div>

</body>
</html>


<?php
    }
?>