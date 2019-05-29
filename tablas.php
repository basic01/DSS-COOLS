<?php

    session_start();
    if(!isset($_SESSION['user'])){
        header("location:index.php");
        exit();
    }

    else{
        if(isset($_SESSION['k'])){
        require 'logica/conexion.php';
        include 'logica/calculos.php';
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="css/tablas.css">
        <link rel="stylesheet" href="css/estilos.css">
        <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,900&display=swap" rel="stylesheet"> 
        <title>Sistema de Pronóstico</title>
    </head>
    <body>
        <div class="top">
            <a href="var.php" id="home">Home</a>
            <a href="tablas.php" id="link">Tablas</a>
            <a href="graficas.php" id="link">Gráficas</a>
            <a href="analisis.php" id="link">Análisis</a>
            <a href="logica/logout.php" id="logout">Cerrar Sesión</a>
        </div>

        <div class="contenedor">

            <h1>Sistema de Pronóstico</h1>
            <div class="header header-center">
                <p>A continuación se despliegan varias tablas
                    reflejando las distintos métodos para obtener
                    el pronóstico de datos en un periodo específico de tiempo:</p>
            </div>

            <table class="table">
                <tbody>
            <?php

                print("<tr>");
                    for ($j=0; $j < sizeof($titulos); $j++) {
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
                    for ($j=0; $j < sizeof($titulos); $j++) {
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
                print("<th class='header2'>EABS PS </th>");
                print("<th class='header2'>EABS PMS k = $k </th>");
                print("<th class='header2'>EABS PMD j = $J </th>");
                print("<th class='header2'>EABS PMDA m = $m </th>");
                print("<th class='header2'>EABS PTMAC </th>");
                print("<th class='header2'>EABS PSE $promedioPSE </th>");
                
                print("</tr>");


                //EABS....
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
                    
            <?php
            
                print("<tr>");
                //count(current($eabs)) = length de columnas de arreglo eabs
                print("<th class='header3'>EM EABS PS </th>");
                print("<th class='header3'>EM EABS PMS k = $k </th>");
                print("<th class='header3'>EM EABS PMD j = $J </th>");
                print("<th class='header3'>EM EABS PMDA m = $m </th>");
                print("<th class='header3'>EM EABS PTMAC </th>");
                print("<th class='header3'>EM EABS PSE $promedioPSE </th>");
                
                print("</tr>");


                //Erro Medio EABS...
                    for ($j=0; $j < sizeof($em); $j++) {
                        print("<td>".$em[$j]."</td>");
                    }
                    print("</tr>");
                
            ?>
                </tbody>
            </table>

            
            <table class="table">
                <tbody>
                    
            <?php

                //count(current($eabs)) = length de columnas de arreglo eabs
                print("<th class='header4'>ER PS </th>");
                print("<th class='header4'>ER PMS k = $k </th>");
                print("<th class='header4'>ER PMD j = $J </th>");
                print("<th class='header4'>ER PMDA m = $m </th>");
                print("<th class='header4'>ER PTMAC </th>");
                print("<th class='header4'>ER PSE $promedioPSE </th>");
                
                print("</tr>");
                //Error Relativo EABS...
                    for ($j=0; $j < sizeof($er); $j++) {
                        print("<td>".$er[$j]."</td>");
                    }
                    print("</tr>");
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
