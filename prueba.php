<?php

    session_start();
    if(!isset($_SESSION['user'])){
        header("location:index.php");
        exit();
    }

    else{
        if(isset($_SESSION['k'])){
        
        require 'logica/conexion.php';

        $k = $_SESSION['k'];
        $J = $_SESSION['j'];
        $m = $_SESSION['m'];
        $theta = $_SESSION['theta'];
        $promedioPSE = $_SESSION['promedioPSE'];
        $datos = [];
        $n = $_SESSION['n'];
        $bd = "salariomin";

        $query = "SELECT * FROM $bd";
        $result = mysqli_query($conexion, $query);
        // $n = mysqli_num_rows($result);

        $titulos = ["Periodo", "Frecuencias", "PTMAC"];

        for ($i=0; $i < $n; $i++) {
            $fila = mysqli_fetch_row($result);
            $datos[$i][0] = $fila[0];
            $datos[$i][1] = $fila[1];
        }
        $datos[$n][0] = $datos[$n-1][0] + 1;
        $datos[$n][1] = "---";

        
        // // Calcular EABS
        // for ($i=0; $i < 4; $i++) {

        //     $eabs[0][$i] = "---";
        //     //EABS PS, PMS, PMD
        //     if($i < 3){
        //         $pos = 2;
        //     }
        //     //EABS PMDA
        //     if($i == 3){
        //         $pos = 4;
        //     }

        //     for ($j=1; $j < 1 + $n - 1; $j++) {
        //         //Datos frecuencias = $datos[$j][1]
        //         //Datos promediosn = $datos[$j][$i+$pos]
        //         if($datos[$j][$i+$pos] == "---"){
        //             $eabs[$j][$i] = "---";
        //         }
        //         else{
        //             $resta = $datos[$j][1] - $datos[$j][$i+$pos];
        //             $eabs[$j][$i] =  round(abs($resta),2);
        //         }
        //     }
        //     $eabs[$n][$i] = "---";
        // }

      function traerDatos($conexion, $bd){
        $query = "SELECT * FROM $bd";
        $result = mysqli_query($conexion, $query);
        $n = mysqli_num_rows($result);
        return $result;
      }

      function calcularTMAC($conexion, $bd){
        $results = [];
        $datos = traerDatos($conexion, $bd);
        $datos = mysqli_fetch_all($datos);

        for ($i=0; $i < sizeof($datos); $i++) {
            if($i==0){
                array_push($results, "---");
            }
            else{
                $valor =  (($datos[$i][1]/$datos[$i-1][1]) - 1) * 100;
                $tmac = bcdiv($valor, '1', 2);    
                array_push($results,$tmac);
            }
            
        }
        array_push($results,"---");
        return($results);
      }

      function calcularPTMAC($conexion, $bd, $tmac){
        $results = [];
        $datos = traerDatos($conexion, $bd);
        $datos = mysqli_fetch_all($datos);;
        for ($i=0; $i < sizeof($tmac); $i++) {
            if($i<2){
                array_push($results, "---");
            }
            else{
                $texto = $datos[$i-1][1]." + (".$datos[$i-1][1]." * (".$tmac[$i-1]."/100))";
                $valor = $datos[$i-1][1] + ($datos[$i-1][1] * ($tmac[$i-1]/100));
                // $valor =((($tmac[$i]/100)*($datos[$i][1]))+$datos[$i][1]);
                $ptmac = bcdiv($valor, '1', 2);
                array_push($results,$ptmac);
            }
        }
        return($results);
      }

      function calcularEABS($conexion, $bd, $ptmac){
        $results = [];
        $datos = traerDatos($conexion, $bd);
        $datos = mysqli_fetch_all($datos);
        for ($i=0; $i < sizeof($ptmac)-1; $i++) {
            if($ptmac[$i] == "---"){
                $eabs = "---";
            }
            else{
                $valor = $datos[$i][1]-$ptmac[$i];
                $eabs =  bcdiv(abs($valor), '1', 2);
            }

          array_push($results,$eabs);
        }

        array_push($results,"---");
        return($results);
      }
    
        }
        else{
            header("location:configuracion.php");
        exit();
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table class="table"> 
            <tbody> 
              <tr> 
                <th class='header2'>TMAC</th> 
                <th class='header2' >PTMAC</th> 
              </tr> 
        <?php 
          $tmac = calcularTMAC($conexion, $bd); 
          $ptmac = calcularPTMAC($conexion, $bd, $tmac); 
          $eabs = calcularEABS($conexion, $bd, $ptmac); 
          for ($i=0; $i < sizeof($tmac); $i++) { 

            $t = $tmac[$i]; 
            $pt = $ptmac[$i]; 
            $e = $eabs[$i];
            print("<tr> 
              <td>".$t."</td> 
              <td>".$pt."</td>
              <td>".$e."</td>
              <td>".$i."</td>
            </tr>"); 
          } 
        ?> 
            </tbody> 
        </table> 
</body>
</html>