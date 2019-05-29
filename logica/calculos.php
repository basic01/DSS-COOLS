<?php
    $k = $_SESSION['k'];
    $J = $_SESSION['j'];
    $m = $_SESSION['m'];
    $theta = $_SESSION['theta'];
    $promedioPSE = $_SESSION['promedioPSE'];
    $datos = [];
    $n = $_SESSION['n'];
    $bd = "salariomin";

    //Validar PSE
    switch ($promedioPSE) {
        case 'PS':
            $posPSE = 2;
            $salto = 1;
        break;

        case 'PMS':
            $posPSE = 3;
            $salto = $k;
        break;

        case 'PMD':
            $posPSE = 4;
            $salto = $k+$j¿J;
        break;
        
        case 'PMDA':
            $posPSE = 7;
            $salto = $k + $J;
        break;

        case 'PTMAC':
            $posPSE = 9;
            $salto = 2;
        break;
    }


    $query = "SELECT * FROM $bd";
    $result = mysqli_query($conexion, $query);
    // $n = mysqli_num_rows($result);

    $titulos = ["Periodo", "Frecuencias", "PS"];

    for ($i=0; $i < $n; $i++) {
        $fila = mysqli_fetch_row($result);
        $datos[$i][0] = $fila[0];
        $datos[$i][1] = $fila[1];
    }
    $datos[$n][0] = $datos[$n-1][0] + 1;
    $datos[$n][1] = "---";

    //Calcular el PS
    $acumulador = 0;
    $datos[0][2] = "---";
    for ($i=1; $i < $n+1; $i++) {
        $acumulador += $datos[$i-1][1];
        $PS = $acumulador/$i;
        $datos[$i][2] = bcdiv($PS, '1', 2);
    }

    //Calcular el PMS
    $acumuladorPMS = 0;
    // $k = 3;
    $kAumentada = $k;
    $contk = 0;

    $titulos[3] = "PMS k=".$k;

    for ($i=0; $i < $k; $i++) {
        $datos[$i][3] = "---";
    }
    for ($i=$k; $i <$n + 1; $i++) {

        while($contk < $kAumentada){
                $acumuladorPMS += $datos[$contk][1];
                $contk++;
            }

        $PMS = $acumuladorPMS / $k;
        $datos[$i][3] = bcdiv($PMS, '1', 2); 

        $kAumentada++;
        $contk = $kAumentada-$k;
        $acumuladorPMS = 0;
    }

    //Calcular el PMD
    $acumuladorPMD = 0;
    // $J = 2;
    $jAumentada = $J;
    $contj = 0;

    $titulos[4] = "PMD j=".$J;

    for ($i=0; $i < $k + $J; $i++) {
        $datos[$i][4] = "---";
    }

    for ($i=$k + $J; $i <$n + 1; $i++) {
        $datos[$i][4] = $i;
        $contj = $i-$J;
        for ($z=0; $z < $J; $z++) {
            $acumuladorPMD += $datos[$contj][3];
            $contj++;
        }
        $PMD = $acumuladorPMD / $J;
        $datos[$i][4] = bcdiv($PMD, '1', 2);  
        $acumuladorPMD = 0;

    }

    //Calcular A,B y PMDA
    $A = 0;
    $B = 0;
    // $m = 1;
    $PMDA = 0;
    $titulos[5] = "A";
    $titulos[6] = "B";
    $titulos[7] = "PMDA m = ".$m;
    for ($i=0; $i < $k + $J; $i++) { 
        $datos[$i][5] = "---";
        $datos[$i][6] = "---";
        $datos[$i][7] = "---";
    }

    for ($i=$k + $J; $i < $n+1; $i++) {
        $A = (2*$datos[$i][3])-$datos[$i][4];
        $B = (2*($datos[$i][3]-$datos[$i][4]))/($n-1);
        $PMDA = ($A + $B) * $m;
        $datos[$i][5] = bcdiv($A, '1', 2);  
        $datos[$i][6] = bcdiv($B, '1', 2);  
        $datos[$i][7] = bcdiv($PMDA, '1', 2);  
    }


    // Calcular EABS
    for ($i=0; $i < 4; $i++) {

        $eabs[0][$i] = "---";
        //EABS PS, PMS, PMD
        if($i < 3){
            $pos = 2;
        }
        //EABS PMDA
        if($i == 3){
            $pos = 4;
        }

        for ($j=1; $j < 1 + $n - 1; $j++) {
            //Datos frecuencias = $datos[$j][1]
            //Datos promediosn = $datos[$j][$i+$pos]
            if($datos[$j][$i+$pos] == "---"){
                $eabs[$j][$i] = "---";
            }
            else{
                $resta = $datos[$j][1] - $datos[$j][$i+$pos];
                $eabs[$j][$i] =  bcdiv(abs($resta), '1', 2);  
            }
        }
        $eabs[$n][$i] = "---";
    }

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
                $valor = $datos[$i-1][1] + ($datos[$i-1][1] * ($tmac[$i-1]/100));
                $ptmac = bcdiv($valor, '1', 2);
                array_push($results,$ptmac);
            }
        }
        return($results);
    }

    function calcularPSE($conexion, $datos, $n, $theta, $salto, $posPSE){
        $results = [];
        for ($j=0; $j <= $salto; $j++) { 
            array_push($results, "---");
        }
        for ($j=$salto+1; $j < $n+1; $j++) { 
            $valor = $datos[$j-1][$posPSE] + ($theta*($datos[$j-1][1]-$datos[$j-1][$posPSE]));
            $pse = bcdiv($valor, '1', 2);
            array_push($results, $pse);
        }
        return($results);
    }

    function calcularEABS($conexion, $bd, $arreglo){
        $results = [];
        $datos = traerDatos($conexion, $bd);
        $datos = mysqli_fetch_all($datos);
        for ($i=0; $i < sizeof($arreglo)-1; $i++) {
            if($arreglo[$i] == "---"){
                $eabs = "---";
            }
            else{
                $valor = $datos[$i][1]-$arreglo[$i];
                $eabs =  bcdiv(abs($valor), '1', 2);
            }
            array_push($results,$eabs);
        }

        array_push($results,"---");
        return($results);
    }


    //Mostar datos TMAC, PTMAC, PSE
    $titulos[8] = "TMAC";
    $titulos[9] = "PTMAC";
    $titulos[10] = 'PSE '.$promedioPSE;
    $tmac = calcularTMAC($conexion, $bd);
    $ptmac = calcularPTMAC($conexion,$bd, $tmac);
    $eabsPTMAC = calcularEABS($conexion,$bd, $ptmac);
    $pse = calcularPSE($conexion, $datos, $n, $theta, $salto, $posPSE);
    $eabsPSE = calcularEABS($conexion,$bd, $pse);
    for ($i=0; $i < $n+1; $i++) {
            $datos[$i][8] = $tmac[$i];
            $datos[$i][9] =  $ptmac[$i];
            $datos[$i][10] =  $pse[$i];
            $eabs[$i][4] = $eabsPTMAC[$i];
            $eabs[$i][5] = $eabsPSE[$i];
    }


    //Calcular em
    $texto = "";
    for ($j=0; $j < count(current($eabs)); $j++) { 
        $cont = 0;
        $sumEABS = 0;

        for ($i=$j; $i < $n; $i++) { 
            if($eabs[$i][$j] != "---" || $eabs[$i][$j] == '0'){
                $sumEABS = $sumEABS + $eabs[$i][$j];
                $cont = $cont + 1;
            }
        }
        $prom = $sumEABS/$cont;
        $em[$j] = bcdiv(abs($prom), '1', 2);
        $texto = $texto."-".$cont;
        $texto = $texto."<br>";
    }

    //Arreglo pronósticos
    for ($i=0; $i < $n+1; $i++) {
        //Periodo
        $pronosticos[$i][0] = $datos[$i][0];
        //Frecuencia
        $pronosticos[$i][1] = $datos[$i][1];
        //PS
        $pronosticos[$i][2] = $datos[$i][2];
        //PMS
        $pronosticos[$i][3] = $datos[$i][3];
        //PMD
        $pronosticos[$i][4] = $datos[$i][4];
        //PMDA
        $pronosticos[$i][5] = $datos[$i][7];
        //PTMAC
        $pronosticos[$i][6] = $datos[$i][9];
        //PSE
        $pronosticos[$i][7] = $datos[$i][10];
        
    }

    for ($i=0; $i < sizeof($em); $i++) { 
        $igual = false;
        for ($j=$i+1; $j < sizeof($em); $j++) { 
            if($em[$i] == $em[$j]){
                $igual = true;
            }
        }
        if($igual){
            $error = ($em[$i] * 100) / $pronosticos[$n][$i+2];
            $er[$i] = bcdiv(abs($error), '1', 2);
            $errores[$i] = $er[$i];
        }
        else{
            $er[$i] = "---";
            $errores[$i] = $em[$i];
        }
    }

    $_SESSION['pronosticos'] = $pronosticos;
    $_SESSION['errores'] = $errores;

?>