<?php
    $k = $_SESSION['k'];
    $j = $_SESSION['j'];
    $J = $j;
    $m = $_SESSION['m'];
    $theta = $_SESSION['theta'];
    $n = $_SESSION['n'];
    $pronosticos = $_SESSION['pronosticos'];
    $em = $_SESSION['em'];
    $size = count(current($pronosticos));

    $mejor = 0;
    for ($i=1; $i < sizeof($em); $i++) { 
        if($em[$i]<$em[$i-1]){
            $mejor = $i;
        }
    }

    $mejor = $mejor + 2;

    $pronosticoMejor = "";
    switch($mejor){
        case 2:
            $pronosticoMejor = 'PS';
        break;

        case 3:
            $pronosticoMejor = 'PMS k = '.$k;
        break;

        case 4:
            $pronosticoMejor = 'PMD j = '.$j;
        break;

        case 5:
            $pronosticoMejor = 'PMDA m = '.$m;
        break;

        case 6:
            $pronosticoMejor = 'PTMAC';
        break;
    }

    