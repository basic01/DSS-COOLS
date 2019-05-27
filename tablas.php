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
        $datos = [];
        echo ("k: $k, j: $J, m: $m, theta: $theta ");

        $query = "SELECT * FROM salariominimo";
        $result = mysqli_query($conexion, $query);
        $n = mysqli_num_rows($result);

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
            $datos[$i][2] = round($PS,2);
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
            $datos[$i][3] = round($PMS, 2);

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
            $datos[$i][4] = round($PMD, 2);
            $acumuladorPMD = 0;

        }

        //Calcular A,B y PMDA
        $A = 0;
        $B = 0;
        // $m = 1;
        $PMDA = 0;
        $titulos[5] = "A";
        $titulos[6] = "B";
        $titulos[7] = "PMDA";
        for ($i=0; $i < $k + $J; $i++) {
            $datos[$i][5] = "---";
            $datos[$i][6] = "---";
            $datos[$i][7] = "---";
        }

        for ($i=$k + $J; $i < $n+1; $i++) {
            $A = (2*$datos[$i][3])-$datos[$i][4];
            $B = (2*($datos[$i][3]-$datos[$i][4]))/($n-1);
            $PMDA = ($A + $B) * $m;
            $datos[$i][5] = round($A, 2);
            $datos[$i][6] = round($B, 2);
            $datos[$i][7] = round($PMDA, 2);
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
                    $eabs[$j][$i] =  round(abs($resta),2);
                }
            }
            $eabs[$n][$i] = "---";
        }
      function traerDatos($conexion){
        $query = "SELECT * FROM salariominimo";
        $result = mysqli_query($conexion, $query);
        $n = mysqli_num_rows($result);
        return $result;
      }
      function calcularTMAC($conexion){
        $results = [];
        $datos = traerDatos($conexion);
        $datos = mysqli_fetch_all($datos);

        for ($i=0; $i < sizeof($datos)-1 ; $i++) {
          $valor =((($datos[$i+1][1]/$datos[$i][1])-1) * 100);
          $tmac = bcdiv($valor, '1', 2);
          array_push($results,$tmac);
        }
        array_push($results,"---");
        return($results);
      }
      function calcularPTMAC($conexion,$tmac){
        $results = ["---"];
        $datos = traerDatos($conexion);
        $datos = mysqli_fetch_all($datos);;
        $tam = sizeof($tmac)-1;
        for ($i=0; $i < $tam; $i++) {
          $valor =((($tmac[$i]/100)*($datos[$i+1][1]))+$datos[$i+1][1]);
          $ptmac = bcdiv($valor, '1', 2);
          array_push($results,$ptmac);
        }
        return($results);
      }

      function calcularEABS($conexion,$ptmac){
        $results = ["---"];
        $datos = traerDatos($conexion);
        $datos = mysqli_fetch_all($datos);
        for ($i=1; $i < sizeof($ptmac)-2; $i++) {
          $j = $i+1;
          $valor = (($datos[$j][1])-($ptmac[$i]));
          $eabs =  bcdiv($valor, '1', 2);
          array_push($results,$eabs);
        }
        $u = sizeof($datos)-1;
        $o = sizeof($ptmac)-2;
        $valor = (($datos[$u][1])-($ptmac[$o]));
        $eabs = bcdiv($valor, '1', 2);
        array_push($results,$eabs);
        array_push($results,"---");
        return($results);
      }



    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="css/tablas.css">
        <link rel="stylesheet" href="css/estilos.css">
        <title></title>
    </head>
    <body>

        <div class="top">
        <a href="var.php" id="home">Home</a>
            <a href="logica/logout.php" id="logout">Cerrar Sesión</a>
        </div>

        <div class="contenedor">
            <h1>Sistema de Pronóstico</h1>
            <div class="header header-center">
                <p>A continuación se despliegan varias tablas
                    reflejando las distintos métodos para obtener
                    el pronóstico de un dato en un periodo específico de tiempo:</p>
            </div>

            <table class="table">
                <tbody>
            <?php

                print("<tr>");
                    for ($j=0; $j < 8; $j++) {
                        if($j>1){
                            print("<th>".$titulos[$j]. "</th>");
                        }
                        else{
                            if($j == 0){
                                print("<th>".$titulos[$j]. "</th>");
                            }
                            else if($j==1){
                                print("<th>".$titulos[$j]. "</th>");
                            }
                        }
                    }
                print("</tr>");


                //Periodo, Frecuencia, PS, PMS k = ....
                for ($i=0; $i < $n+1; $i++) {
                    print("<tr>");
                    for ($j=0; $j < 8; $j++) {
                        if($j>1){
                            //PS, PMS k = ....
                            print("<td>".$datos[$i][$j]. "</td>");
                        }
                        else{
                            //PMS Periodo, Frecuencia
                            print("<td class='important'>".$datos[$i][$j]. "</td>");
                        }
                    }
                    print("</tr>");
                }

            ?>
                </tbody>
            </table>

            <table class="table">
                <tbody>
            <?php
                print("<tr>");
                //count(current($eabs)) = length de columnas de arreglo eabs
                    for ($j=0; $j < count(current($eabs)); $j++) {
                        if($j==0){
                            print("<th class='header2'>EABS PS </th>");
                        }
                        if($j == 1){
                            print("<th class='header2'>EABS PMS k=$k </th>");
                        }
                        if($j == 2){
                            print("<th class='header2'>EABS PMD j=$J </th>");
                        }
                        if($j == 3){
                            print("<th class='header2'>EABS PMDA m=$m </th>");
                        }
                    }
                print("</tr>");


                //EABS PS y PMS k = ....
                for ($i=0; $i < $n+1; $i++) {
                    print("<tr>");
                    for ($j=0; $j < count(current($eabs)); $j++) {
                        print("<td>".$eabs[$i][$j]."</td>");
                    }
                    print("</tr>");
                }
            ?>
                </tbody>
            </table>


            <table class="table">
            <tbody>
              <tr>
                <th class='header2'>TMAC</th>
                <th class='header2' >PTMAC</th>
                <th class='header2' >EABS</th>
              </tr>
              <tr>
                <td>---</td>
                <td>---</td>
                <td>---</td>
              </tr>
        <?php

          $tmac = calcularTMAC($conexion);
          $ptmac = calcularPTMAC($conexion,$tmac);
          $eabs = calcularEABS($conexion,$ptmac);
          for ($i=0; $i < sizeof($ptmac) ; $i++) {
            $t = $tmac[$i];
            $pt = $ptmac[$i];
            $e = $eabs[$i];
            print("<tr>
              <td>".$t."</td>
              <td>".$pt."</td>
              <td>".$e."</td>
            </tr>");
          }
        ?>
            </tbody>
        </table>






            </div>


    </body>
    </html>

<?php
        }
        else{
            header("location:configuracion.php");
        exit();
        }
    }

?>
