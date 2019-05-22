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
    <form action="tablas.php" method="POST">
        <input type="number" placeholder="k:" name="k" id="k">
        <input type="number" placeholder="j:" name="j" id="j">
        <input type="number" placeholder="m:" name="m" id="m">
        <input type="number" placeholder="theta:" name="theta" id="theta">
        <button type="submit" id="btnSubmit">Siguiente</button>    
    </form>
    <a href="tablas.php">Ver tablas</a>
</body>
</html>


<?php
    echo("<script>
    btn = document.getElementById('btnSubmit');
    btn.addEventListener('click', () => {
        window.location.assign('tablas.php');
    })

    </script>");
    }
?>