<?php
session_start();
if($_SESSION['rol']!=1){
    header("Location: ./");
}
include "../conexion.php";
if(!empty($_POST)){
    if($_POST['codproveedor']==1){
        header("Location: lista_provedores.php");
        mysqli_close($conection);
        exit;
    }
    $codproveedor=$_POST['codproveedor'];
    //$query_delete=mysqli_query($conection,"DELETE FROM usuario WHERE idusuario=$idusuario");
    $query_delete=mysqli_query($conection,"UPDATE proveedor  SET estatus=0 WHERE codproveedor=$codproveedor");
    mysqli_close($conection);
    if($query_delete){
        header("Location: lista_provedores.php");
    }else{
        echo "Error al elminar el usuario";
    }

}
if(empty($_REQUEST['id'])){
    header("Location: lista_provedores.php");
    mysqli_close($conection);
}else{
    include "../conexion.php";
    $codproveedor=$_REQUEST['id'];
    $query=mysqli_query($conection,"SELECT * FROM proveedor
                                    WHERE codproveedor=$codproveedor");
    mysqli_close($conection);
    $result=mysqli_num_rows($query);
    if($result>0){
        while($data=mysqli_fetch_array($query)){
            $proveedor=$data['proveedor'];
            $contacto=$data['contacto'];
            $telefono=$data['telefono'];
            $direccion=$data['direccion'];

        }

    }else{
        header("Location: lista_provedores.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php";?>
    <title>Eliminar usuario</title>
</head>

<body>
    <?php include "includes/header.php";?>
    <section id="container">
        <div class="data_delete">
        <h2><i class="fas fa-user-times fa-7x" style="color: red;"></i></h2>
        <br>
        <h2>¿Estas seguro de eliminar el siguiente registro?</h2>
        <p>Proveedor: <span><?php echo $proveedor;?></span></p>
        <p>Contacto: <span><?php echo $contacto;?></span></p>
        <p>Teléfono: <span><?php echo $telefono;?></span></p>
        <p>Dirección: <span><?php echo $direccion;?></span></p>
        <form method="post" action="">
        <input type="hidden" name="codproveedor" value="<?php echo $codproveedor; ?>">
        <a href="lista_provedores.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
        <button type="submit" class="btn_ok">Eliminar <i class="fas fa-trash"></i></button>
        </form>
        </div>
    </section>
    <?php include "includes/footer.php";?>
</body>

</html>