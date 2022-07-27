<?php
session_start();

include "../conexion.php";
    if(!empty($_POST)){
        $alert='';
        if(empty($_POST['descripcion']) || empty($_POST['precio'])
        || empty($_POST['foto_actual']) || empty($_POST['foto_remove'])){
            
            $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';

        }else{
            $sku                 =$_POST['sku'];
            $contiene             =$_POST['contiene'];
            $tipo                =$_POST['tipo'];
            $codproducto        =$_POST['id'];
            $proveedor           =$_POST['proveedor'];
            $descripcion         =$_POST['descripcion'];
            $precio              =$_POST['precio'];
            $imgProdcuto         =$_POST['foto_actual'];
            $imgRemove           =$_POST['foto_remove'];
            //$exitencia           =$_POST['exitencia'];
            //$usuario_id          =$_SESSION['rol'];

            $foto=$_FILES['foto'];
            $nombre_foto=$foto['name'];
            $type=$foto['type'];
            $url_temp=$foto['tmp_name'];

            $upd='';

            if($nombre_foto != ''){
                $destino='img/uploads/';
                $img_nombre='img_'.md5(date('d-m-Y H:m:s'));
                $imgProdcuto=$img_nombre.'.jpg';
                $src=$destino.$imgProdcuto; 
                
            }else{
                if($_POST['foto_actual'] != $_POST['foto_remove']){
                    $imgProdcuto='img_producto.png';

                }
            }
                $query_update=mysqli_query($conection,"UPDATE 	producto
                                                      SET descripcion='$descripcion' ,SKU='$sku',proveedor=$proveedor,contiene='$contiene',Tipo='$tipo',precio=$precio, foto='$imgProdcuto'
                                                      WHERE  codproducto=$codproducto ");
                                                     
                                                    //echo("UPDATE producto
                                                    //SET descripcion='$descripcion',proveedor=$proveedor,precio=$precio,foto='$imgProdcuto'
                                                    //WHERE  codproducto=$codproducto");
                                                
                if($query_update){
                    if(($nombre_foto != '' && ($_POST['foto_actual'] != 'img_producto.png')) || ($_POST['foto_actual'] != $_POST['foto_remove'])){
                        unlink('img/uploads'.$_POST['foto_actual']);

                    }
                    if($nombre_foto != ''){
                        move_uploaded_file($url_temp,$src);
                    }
                    $alert='<p class="msg_save">El producto fue actualizado con exito.</p>';
                }else{
                    $alert='<p class="msg_error">Error al actualizado el producto.</p>';
                    
                }
           
        }
       
    }

    //mostrar datos
    if(empty($_REQUEST['id'])){
        //header('Location: listar_prodcutos.php');
        mysqli_close($conection);
    }else{
    $id_producto  = $_REQUEST['id'];
    if(is_numeric($id_producto)){
        //header('Location: listar_prodcutos.php');
    }
    $query_producto=mysqli_query($conection,"SELECT 
                                p.codproducto,p.SKU,p.descripcion,p.contiene,p.precio,p.Tipo,p.foto,pr.codproveedor,pr.proveedor 
                                FROM producto p
                                INNER JOIN proveedor pr
                                ON p.proveedor=pr.codproveedor 
                                WHERE p.codproducto = $id_producto and p.estado=1");
    $result_producto=mysqli_num_rows($query_producto);
    $foto='';
    $classRemove='notBlock';
    

    if($result_producto>0){
        $data_producto=mysqli_fetch_assoc($query_producto);
        if($data_producto['foto'] != 'img_producto.png'){
            $classRemove='';
            $foto='<img id="img" src="img/uploads/'.$data_producto['foto'].'" alt="Producto"';

        }
       //print_r($data_producto);

    }else{
            header('Location: listar_prodcutos.php');
        }
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
<style type="text/css">
    .notItemOne option:first-child {
        display: none;

    }
    </style>

    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Actualizar producto</title>
</head>

<body>
    <?php include "includes/header.php";?>
    <section id="container">
        <div class="form_register">
            <h1><i class="fas fa-cubes"></i> Actualizar producto</h1>
            <hr>
            <div class="alert"><?php echo  isset($alert) ? $alert : '' ?></div>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $data_producto['codproducto']; ?>">
                <input type="hidden" id="foto_actual" name="foto_actual" value="<?php echo $data_producto['foto']; ?>">
                <input type="hidden" id="foto_remove" name="foto_remove" value="<?php echo $data_producto['foto']; ?>">
                <label for="proveedor">Proveedor</label>
                
                <?php 
                    $query_proveedor=mysqli_query($conection,"SELECT codproveedor,proveedor FROM proveedor 
                    WHERE estatus=1 ORDER BY proveedor ASC");
                    $result_proveedor=mysqli_num_rows($query_proveedor);
                    mysqli_close($conection);
                ?>
                <select name="proveedor" id="proveedor" class="notItemOne">
                <option value="<?php echo $data_producto['codproveedor']; ?>" selected><?php echo $data_producto['proveedor'];?></option>
                    <?php 
                        if($result_proveedor>0){
                            while($proveedor=mysqli_fetch_array($query_proveedor)){
                    ?>
                        <option value="<?php echo $proveedor['codproveedor'];?>"><?php echo $proveedor['proveedor'];?></option>
                    <?php

                            }
                        }
                    ?>
                    
                </select>
                <label for="sku">SKU</label>
                <input type="text" name="sku" id="sku" placeholder="SKU del producto" value="<?php echo $data_producto['SKU'];?>">
                <label for="descripcion">Descripcion</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="Nombre producto" value="<?php echo $data_producto['descripcion'];?>">
                <label for="contiene">Contiene</label>
                <input type="text" name="contiene" id="contiene" placeholder="Que contiene el producto" value="<?php echo $data_producto['contiene'];?>">
                <label for="tipo">Tipo de lecenciamiento</label>
                <select name="tipo" id="tipo" class="notItemOne">
                    <option ><?php echo $data_producto['Tipo'];?></option>
                    <option value="Mensual">Mensual</option>
                    <option value="Anual">Anual</option>
                    <option value="Servico">Servico</option>
                </select>
                <label for="precio">Precio</label>
                <input type="number" step="any" name="precio" id="precio" placeholder="Precio del producto" value="<?php echo $data_producto['precio'];?>">        
                
                <!--<label for="exitencia">Exitencia</label>
                <input type="number" name="exitencia" id="exitencia" placeholder="Cantidad del producto">-->
                <div class="photo">
                    <label for="foto">Foto</label>
                    <div class="prevPhoto">
                        <span class="delPhoto <?php echo $classRemove; ?>">X</span>
                        <label for="foto"></label>
                        <?php echo $foto;?>
                    </div>
                    <div class="upimg">
                        <input type="file" name="foto" id="foto">
                    </div>
                    <div id="form_alert"></div>
                </div>


                <button type="submit" class="btn_save"><i class="far fa-save"></i> Actualizar producto</button>
            </form>
        </div>

    </section>

    <?php include "includes/footer.php";?>
</body>

</html>