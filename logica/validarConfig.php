<?php
    if(isset($_POST['submit'])){
        $k = $_POST['k'];
        $j = $_POST['j'];
        $m = $_POST['m'];
        $theta = $_POST['theta'];

        $errorK = false;
        $errorJ = false;
        $errorM = false;
        $errorTheta = false;
        $exito = false;
        $errorEmpty = false;

        if(empty($k) || empty($j) || empty($m) || empty($theta)){
            $errorEmpty = true;
            echo "<span>*Uno o más campos vacíos o valores en cero*</span>";
        }
        else{
            if(is_numeric($k) && is_numeric($j) && is_numeric($m) && is_numeric($theta)){

                require 'conexion.php';

                $query = "SELECT * FROM salariomin";
                $result = mysqli_query($conexion, $query);
                $n = mysqli_num_rows($result);
                
                $texto = "";
                if($k<=0 || $k >=($n-1)){
                    $errorK = true;
                    $exito = false;
                }
                if($j<=0 || $j>=$k){
                    $errorJ = true;
                    $exito = false;
                }
                if($m<=0){
                    $errorM = true;
                    $exito = false;
                }
                if($theta <= 0 || $theta >= 1){
                    $errorTheta = true;
                    $exito = false;
                }

                if(!$errorJ && !$errorK && !$errorM && !$errorTheta){
                    $exito = true;
                }

                if($exito){
                    session_start();
                    $_SESSION['k'] = $k;
                    $_SESSION['j'] = $j;
                    $_SESSION['m'] = $m;
                    $_SESSION['theta'] = $theta;
                }
            }
            else{
                $errorEmpty = true;
                echo "<span>*Uno o más datos son inválidos*</span>";
            }

        }
    }
?>

<script>

    function agregarError(idMensaje, variable){
        // $("#div-formConfig").css('marginTop', '3em');    
        $(idMensaje).text("*Cantidad inválida para "+variable+"*");    
    }

    function quitarError(idMensaje){
        // $("#div-formConfig").css('marginTop', '-5em');
        $(idMensaje).text("");
        $("#form-message").text("");
    }
    errorK = "<?php echo $errorK ?>";
    errorJ = "<?php echo $errorJ ?>";
    errorM = "<?php echo $errorM ?>";
    errorTheta = "<?php echo $errorTheta ?>";
    exito = "<?php echo $exito ?>";
    errorEmpty = "<?php echo $errorEmpty ?>";

    if(exito){
        window.location.assign('tablas.php');
    }
    else{
        if(!errorEmpty){
            if(errorK){
                agregarError("#messageK", 'k');
            }
            if(errorJ){
                agregarError("#messageJ", 'j');
            }
            if(errorM){
                agregarError("#messageM", 'm');
            }
            if(errorTheta){
                agregarError("#messageTheta", 'theta');
            }
        }


        $("#k").click(function(){
            quitarError("#messageK");
        }); 
        $("#j").click(function(){
            quitarError("#messageJ");
        }); 
        $("#m").click(function(){
            quitarError("#messageM");
        }); 
        $("#t").click(function(){
            quitarError("#messageTheta");
        }); 
    }
</script>