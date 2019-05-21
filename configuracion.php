<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("location:index.php");
        exit();
    }
    else{
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema de Pronóstico</title>
</head>
<body>
    <a href="logica/logout.php">Cerrar sesión</a>
    <form action="logica/configuracion.php" method="POST">
        <input type="number" placeholder="k:" name="k">
        <input type="number" placeholder="j:" name="j">
        <input type="number" placeholder="m:" name="m">
        <input type="number" placeholder="theta:" name="theta">
        <button type="submit">Siguiente</button>    
    </form>
    <a href="tablas.php">Ver tablas</a>
</body>
</html>


<?php
    }
?>