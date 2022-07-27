<?php
session_start();
if($_SESSION['rol']!=1){
    header("Location: ./");
}
include "../conexion.php";
if(!empty($_POST)){
    if($_POST['idusuario']==1){
        header("Location: lista_usuarios.php");
        mysqli_close($conection);
        exit;
    }
    $idusuario=$_POST['idusuario'];
    //$query_delete=mysqli_query($conection,"DELETE FROM usuario WHERE idusuario=$idusuario");
    $query_delete=mysqli_query($conection,"UPDATE usuario  SET estatus=0 WHERE idusuario=$idusuario");
    mysqli_close($conection);
    if($query_delete){
        header("Location: lista_usuarios.php");
    }else{
        echo "Error al elminar el usuario";
    }

}
if(empty($_REQUEST['id']) || $_REQUEST['id']==1){
    header("Location: lista_usuarios.php");
    mysqli_close($conection);
}else{
    include "../conexion.php";
    $idusuario=$_REQUEST['id'];
    $query=mysqli_query($conection,"SELECT u.nombre,u.usuario,r.rol
                                    FROM usuario u
                                    INNER JOIN
                                    rol r 
                                    ON u.rol=r.idrol
                                    WHERE u.idusuario=$idusuario");
    mysqli_close($conection);
    $result=mysqli_num_rows($query);
    if($result>0){
        while($data=mysqli_fetch_array($query)){
            $nombre=$data['nombre'];
            $usuario=$data['usuario'];
            $rol=$data['rol'];

        }

    }else{
        header("Location: lista_usuarios.php");
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
        <p>Nombre: <span><?php echo $nombre;?></span></p>
        <p>Usuario: <span><?php echo $usuario;?></span></p>
        <p>Tipo Usuario: <span><?php echo $rol;?></span></p>
        <form method="post" action="">
        <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
        <a href="lista_usuarios.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
        <button type="submit" class="btn_ok">Eliminar <i class="fas fa-trash"></i></button>
        </form>
        </div>
    </section>
    <?php include "includes/footer.php";?>
</body>

</html>