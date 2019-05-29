<?php
    include 'logica/datosGrafica.php';
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

        const k = "<?php echo $k ?>";
        const j = "<?php echo $j ?>";
        const m = "<?php echo $m ?>";
        const theta = "<?php echo $theta ?>";
        const promedioPSE  = "<?php echo $promedioPSE ?>";
        const pronosticoMejor = "<?php echo $pronosticoMejor ?>";

      google.charts.load('current', {'packages':['corechart', 'gauge']});
      google.charts.setOnLoadCallback(drawChart);
      

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        //   ['Periodo', 'Frecuencias', 'PS', 'PMS k = ' + k, 'PMD j = ' + j, 'PMDA m = ' + m, 'PTMAC'],
        ['Periodo', 'Frecuencias', 'PS', 'PMS k = ' + k, 'PMD j = ' + j, 'PMDA m = ' + m, 'PTMAC', 'PSE ' + promedioPSE ,],
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


        //Datos gráfica mejor
        var data3 = google.visualization.arrayToDataTable([
        ['Periodo', 'Frecuencia'],
           <?php
             print("['".$pronosticos[$n][0]."',".$pronosticos[$n][$mejor]."]");
         ?>
         ]);
 
         var options3 = {
           width: '100%',
           greenFrom:0, greenTo: 33, 
           yellowFrom:33, yellowTo: 66,
           redFrom: 66, redTo: 110,
           minorTicks: 5
         };


        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        var chart2 = new google.visualization.LineChart(document.getElementById('curve_chart2'));
        var chart3 = new google.visualization.Gauge(document.getElementById('velocimetro'));

        chart.draw(data, options);
        chart2.draw(data2, options2);
        chart3.draw(data3, options3);
      }
    </script>