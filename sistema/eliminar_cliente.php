<?php
session_start();
if($_SESSION['rol']!=1){
    header("Location: ./");
}
include "../conexion.php";
if(!empty($_POST)){
    if($_POST['idcliente']==1){
        header("Location: lista_clientes.php");
        mysqli_close($conection);
        exit;
    }
    $idcliente=$_POST['idcliente'];
    //$query_delete=mysqli_query($conection,"DELETE FROM usuario WHERE idusuario=$idusuario");
    $query_delete=mysqli_query($conection,"UPDATE cliente  SET estatus=0 WHERE idcliente=$idcliente");
    mysqli_close($conection);
    if($query_delete){
        header("Location: lista_clientes.php");
    }else{
        echo "Error al elminar el usuario";
    }

}
if(empty($_REQUEST['id'])){
    header("Location: lista_clientes.php");
    mysqli_close($conection);
}else{
    include "../conexion.php";
    $idcliente=$_REQUEST['id'];
    $query=mysqli_query($conection,"SELECT * FROM cliente
                                    WHERE idcliente=$idcliente");
    mysqli_close($conection);
    $result=mysqli_num_rows($query);
    if($result>0){
        while($data=mysqli_fetch_array($query)){
            $razon_social=$data['razon_social'];
            $rfc=$data['rfc'];
            $contacto=$data['contacto'];
            $telefono=$data['telefono'];
            $email=$data['email'];
            $pais=$data['pais'];


        }

    }else{
        header("Location: lista_clientes.php");
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
        <p>Razón social: <span><?php echo $razon_social;?></span></p>
        <p>RFC: <span><?php echo $rfc;?></span></p>
        <p>Contacto: <span><?php echo $contacto;?></span></p>
        <p>Teléfono: <span><?php echo $telefono;?></span></p>
        <p>Email: <span><?php echo $email;?></span></p>
        <p>País: <span><?php echo $pais;?></span></p>
        <form method="post" action="">
        <input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
        <a href="lista_clientes.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
        <button type="submit" class="btn_ok"><i class="fas fa-trash"></i>Eliminar</button>
        </form>
        </div>
    </section>
    <?php include "includes/footer.php";?>
</body>

</html>