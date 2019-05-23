<?php
    if(isset($_POST['submit'])){
        $user = $_POST['user'];
        $pass = $_POST['pass'];

    $loginExitoso = false;

    if(empty($user) || empty ($pass)){
        echo "<span>*Uno o más campos vacíos*</span>";
    }
    else{

        require 'conexion.php';
        session_start();

        if(isset($_POST['user'])){
            $usuario = $_POST['user'];
            $password = $_POST['pass'];

            $query = "SELECT COUNT(*) AS resultados FROM usuarios WHERE usuario = '$usuario' AND password = '$password'";
            $consulta = mysqli_query($conexion, $query);
            $arrayResultados = mysqli_fetch_array($consulta);

            if($arrayResultados['resultados']>0){
                $_SESSION['user'] = $usuario;
                $loginExitoso = true;
            }
            else{
                echo "<span>*Usuario o contraseña incorrectos*</span>";
            }
        }
    }
}
?>



<?php
?>

<script>
    loginExitoso = "<?php echo $loginExitoso ?>";
    if(loginExitoso){
        window.location.assign('var.php');
    }
    else{
        $("#user").click(function(){
            $(".form-message").text("");
        }); 
        $("#password").click(function(){
            $(".form-message").text("");
        }); 
    }
</script>