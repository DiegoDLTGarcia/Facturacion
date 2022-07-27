<?php
session_start();
if($_SESSION['rol']!=1){
    header("Location: ./");
}
include "../conexion.php";
if(!empty($_POST)){
    if($_POST['codproducto']==1){
        header("Location: listar_prodcutos.php");
        mysqli_close($conection);
        exit;
    }
    $codproducto=$_POST['codproducto'];
    //$query_delete=mysqli_query($conection,"DELETE FROM usuario WHERE idusuario=$idusuario");
    $query_delete=mysqli_query($conection,"UPDATE producto  SET estado=0 WHERE codproducto=$codproducto");
    mysqli_close($conection);
    if($query_delete){
        header("Location: listar_prodcutos.php");
    }else{
        echo "Error al elminar el usuario";
    }

}
if(empty($_REQUEST['id'])){
    header("Location: listar_prodcutos.php");
    mysqli_close($conection);
}else{
    include "../conexion.php";
    $codproducto=$_REQUEST['id'];
    $query=mysqli_query($conection,"SELECT p.codproducto,p.SKU,p.descripcion,p.contiene,p.Tipo,p.precio,pr.proveedor,p.foto
                                    FROM producto p
                                    INNER JOIN proveedor pr ON 
                                    p.proveedor = pr.codproveedor
                                    WHERE codproducto=$codproducto and estado=1 ");
    
    mysqli_close($conection);
    $result=mysqli_num_rows($query);
    if($result>0){
        while($data=mysqli_fetch_array($query)){
            $SKU                 =$data['SKU'];
            $contiene             =$data['contiene'];
            $Tipo                =$data['Tipo'];
            $descripcion=$data['descripcion'];
            $precio=$data['precio'];
            $proveedor=$data['proveedor'];
            if($data['foto']!= 'img_producto.png'){
                $foto='img/uploads/'.$data['foto'];
            }else{
                $foto= 'img/uploads/'.$data['foto'];
            }

        }

    }else{
        header("Location: listar_prodcutos.php");
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
        <h2><i class="fas fa-box-open fa-7x" style="color: red;"></i></h2>
        <br>
        <h2>¿Estas seguro de eliminar el siguiente registro?</h2>
        <p>SKU: <span><?php echo $SKU;?></span></p>
        <p>Descripcion: <span><?php echo $descripcion;?></span></p>
        <p>Contiene: <span><?php echo $contiene;?></span></p>
        <p>Tipo: <span><?php echo $Tipo;?></span></p>
        <p>Precio: <span><?php echo $precio;?></span></p>
        <p>Proveedor: <span><?php echo $proveedor;?></span></p>
        
        <p>Foto:</p>
        <br>
        <span class="img_producto"><img src="<?php echo $foto; ?>" alt="<?php echo $data['descripcion']; ?>"></span>
        <form method="post" action="">
        <input type="hidden" name="codproducto" value="<?php echo $codproducto; ?>">
        <a href="listar_prodcutos.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
        <button type="submit" class="btn_ok">Eliminar <i class="fas fa-trash"></i></button>
        </form>
        </div>
    </section>
    <?php include "includes/footer.php";?>
</body>

</html>