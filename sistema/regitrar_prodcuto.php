<?php
session_start();
if($_SESSION['rol']==2){
    header("Location: ./");
}

include "../conexion.php";
    if(!empty($_POST)){
        $alert='';
        if(empty($_POST['descripcion'] || empty($_POST['precio']) || $_POST['precio'] <= 0)){
            
            $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';

        }else{
            $sku                 =$_POST['sku'];
            $contiene             =$_POST['contiene'];
            $tipo                =$_POST['tipo'];
            $proveedor           =$_POST['proveedor'];
            $descripcion         =$_POST['descripcion'];
            $precio              =$_POST['precio'];
            //$exitencia           =$_POST['exitencia'];
            $usuario_id          =$_SESSION['idUser'];

            $foto=$_FILES['foto'];
            $nombre_foto=$foto['name'];
            $type=$foto['type'];
            $url_temp=$foto['tmp_name'];

            $imgProdcuto='img_producto.png';

            if($nombre_foto != ''){
                $destino='img/uploads/';
                $img_nombre='img_'.md5(date('d-m-Y H:m:s'));
                $imgProdcuto=$img_nombre.'.jpg';
                $src=$destino.$imgProdcuto; 
                
            }
                $query_insert=mysqli_query($conection,"INSERT INTO 	producto(proveedor,sku,descripcion,contiene,tipo,precio,usuario_id,foto) 
                                                      VALUES ('$proveedor','$sku','$descripcion','$contiene','$tipo',$precio,'$usuario_id','$imgProdcuto')");
                                                        //echo "INSERT INTO 	producto(proveedor,sku,descripcion,contiene,tipo,precio,usuario_id,foto) 
                                                        //VALUES ('$proveedor',''$sku','$descripcion','$contiene','$tipo','$precio','$usuario_id','$imgProdcuto')";
                                                
                if($query_insert){
                    if($nombre_foto != ''){
                        move_uploaded_file($url_temp,$src);
                    }
                    $alert='<p class="msg_save">El producto fue guardado con exito.</p>';
                }else{
                    $alert='<p class="msg_error">Error al guardar el producto.</p>';
                    
                }
           
        }
       
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Registro producto</title>
</head>

<body>
    <?php include "includes/header.php";?>
    <section id="container">
        <div class="form_register">
            <h1><i class="fas fa-cubes"></i> Registro producto</h1>
            <hr>
            <div class="alert"><?php echo  isset($alert) ? $alert : '' ?></div>
            <form action="" method="post" enctype="multipart/form-data">

                <label for="proveedor">Proveedor</label>
                <?php 
                    $query_proveedor=mysqli_query($conection,"SELECT codproveedor,proveedor FROM proveedor 
                    WHERE estatus=1 ORDER BY proveedor ASC");
                    $result_proveedor=mysqli_num_rows($query_proveedor);
                    mysqli_close($conection);
                ?>
                <select name="proveedor" id="proveedor">
                    <?php 
                        if($result_proveedor>0){
                            while($proveedor=mysqli_fetch_array($query_proveedor)){
                    ?>
                    <option value="<?php echo $proveedor['codproveedor'];?>"><?php echo $proveedor['proveedor'];?>
                    </option>
                    <?php

                            }
                        }
                    ?>

                </select>

                <label for="sku">SKU</label>
                <input type="text" name="sku" id="sku" placeholder="SKU del producto">
                <label for="descripcion">Descripcion</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="Nombre producto">
                <label for="contiene">Contiene</label>
                <input type="text" name="contiene" id="contiene" placeholder="Que contiene el producto">
                <label for="tipo">Tipo de lecenciamiento</label>
                <select name="tipo" id="tipo">
                    <option value="Mensual">Mensual</option>
                    <option value="Anual">Anual</option>
                    <option value="Servico">Servicio</option>
                </select>
                <label for="precio">Precio</label>
                <input type="number" step="any" name="precio" id="precio" placeholder="Precio del producto">
                <!--<label for="exitencia">Exitencia</label>
                <input type="number" name="exitencia" id="exitencia" placeholder="Cantidad del producto">-->
                <div class="photo">
                    <label for="foto">Foto</label>
                    <div class="prevPhoto">
                        <span class="delPhoto notBlock">X</span>
                        <label for="foto"></label>
                    </div>
                    <div class="upimg">
                        <input type="file" name="foto" id="foto">
                    </div>
                    <div id="form_alert"></div>
                </div>


                <button type="submit" class="btn_save"><i class="far fa-save"></i> Crear producto</button>
            </form>
        </div>

    </section>

    <?php include "includes/footer.php";?>
</body>

</html>