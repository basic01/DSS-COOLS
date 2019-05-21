<?php
    require 'conexion.php';
    session_start();

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $query = "SELECT COUNT(*) AS resultados FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
    $consulta = mysqli_query($conexion, $query);
    $arrayResultados = mysqli_fetch_array($consulta);

    if($arrayResultados['resultados']>0){
        $_SESSION['user'] = $usuario;
        header("location: ../configuracion.php");
    }
    else{
        header("location: ../index.php");
        echo("Datos incorrectos");
    }
?>