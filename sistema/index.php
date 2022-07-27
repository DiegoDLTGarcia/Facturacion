<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php";?>
    <title>Sisteme Ventas</title>
</head>

<body>
    <?php 
    include "includes/header.php";
    include "../conexion.php";

    $query_dash=mysqli_query($conection,"CALL datDashboard();");
    $result_dash=mysqli_num_rows($query_dash);
    if($result_dash > 0){
        $data_dash=mysqli_fetch_assoc($query_dash);
        mysqli_close($conection);

    }
    
    
    ?>
    <section id="container">
        <div class="divContainer">
            <div>
                <h1 class="titlePanelControl">Bienvenido, <?php echo $_SESSION['nombre'];?></h1>
            </div>
            <div class="dashboard">
                <?php
                    if($_SESSION['rol'] !=3  ){

                    
                ?>
                <?php
                    if($_SESSION['rol'] ==1 ){

                    
                ?>
                <a href="lista_usuarios.php">
                    <i class="fas fa-users"></i>
                    <p>
                        <strong>Usuarios</strong><br>
                        <span><?php echo $data_dash['usuarios'];?></span>
                    </p>
                </a>
                <?php
                    }
                ?>

                <a href="lista_clientes.php">
                    <i class="fas fa-user-friends"></i>
                    <p>
                        <strong>Clientes</strong><br>
                        <span><?php echo $data_dash['clientes'];?></span>
                    </p>
                </a>
                <?php
                    if($_SESSION['rol'] ==1 ){

                    
                ?>
                <a href="lista_provedores.php">
                    <i class="fas fa-building"></i>
                    <p>
                        <strong>Proveedor</strong><br>
                        <span><?php echo $data_dash['proveedores'];?></span>
                    </p>
                </a>
                <?php
                    }
                ?>

                <a href="listar_prodcutos.php">
                    <i class="fas fa-cubes"></i>
                    <p>
                        <strong>Productos</strong><br>
                        <span><?php echo $data_dash['productos'];?></span>
                    </p>
                </a>
                <?php
                    if($_SESSION['rol'] ==1 ){

                    
                ?>
                <a href="ventas.php">
                    <i class="fas fa-file-alt"></i>
                    <p>
                        <strong>Cotizaciónes</strong><br>
                        <span><?php echo $data_dash['ventas'];?></span>
                        <?php
                    }
                    }
                ?>
                    </p>
                </a>
            </div>
        </div>

    </section>
    <center>
    <img src="img/cbs-gto.png" width="600" height="500"></center>
    <?php include "includes/footer.php";?>
</body>

</html>