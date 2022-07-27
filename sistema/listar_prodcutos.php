<?php

session_start();

include "../conexion.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php";?>
    <title>Lista de Productos</title>
</head>

<body>
    <?php include "includes/header.php";?>
    <section id="container">
        <div class="limiter">
            <div class="container-table100">
                <div class="wrap-table100">
                    <div class="table100">
                        <h1><i class="fas fa-boxes"></i> Lista de Productos</h1>
                        <br>
                        <?php if($_SESSION['rol']==1 or $_SESSION['rol']==3){
            ?>
                        <a href="regitrar_prodcuto.php" class="btn_new"><i class="fas fa-box-open"></i> Crear
                            producto</a>
                        <?php 
        }
        ?>
                        <form action="buscar_producto.php" method="get" class="form_search">
                            <input type="text" name="busqueda" id="busqueda" placeholder="buscar">
                            <input type="submit" value="Buscar" class="btn_search">
                        </form>

                        <table>
                            <thead>
                                <tr>
                                    <th WIDTH="20">Código</th>
                                    <th>SKU</th>
                                    <th>Descripción</th>
                                    <th WIDTH="300">Contiene</th>
                                    <th>Tipo</th>
                                    <th >Precio</th>
                                    <!-- <th>Existencias</th> -->
                                    <th >Proveedor</th>
                                    <th >Foto</th>
                                    <?php if($_SESSION['rol']==1 or $_SESSION['rol']==3){
            ?>
                                    <th >Acción</th>
                                    <?php 
        }
        ?>
                                </tr>
                            </thead>
                            <?php
            //paginador
            $sql_registe=mysqli_query($conection,"SELECT COUNT(*) AS total_registro FROM  producto WHERE estado=1");
            $result_register=mysqli_fetch_array($sql_registe);
            $total_registro=$result_register['total_registro'];

            $por_pagina=5;
            if(empty($_GET['pagina'])){
                $pagina=1;

            }else{
                $pagina=$_GET['pagina'];
            }
            $desde=($pagina-1)*$por_pagina;
            $total_paginas=ceil($total_registro/$por_pagina);

            $query=mysqli_query($conection,"SELECT p.codproducto,p.SKU,p.descripcion,p.contiene,p.Tipo,p.precio,pr.proveedor,p.foto
            FROM producto p
            INNER JOIN proveedor pr ON p.proveedor = pr.codproveedor
            WHERE estado=1 
            ORDER BY p.codproducto ASC
            LIMIT $desde,$por_pagina");
            mysqli_close($conection);
            $result=mysqli_num_rows($query);
            if($result>0){
                while($data=mysqli_fetch_array($query)){
                    if($data['foto']!= 'img_producto.png'){
                        $foto='img/uploads/'.$data['foto'];
                    }else{
                        $foto= 'img/uploads/'.$data['foto'];
                    }

               
        ?>
                            <tr>
                                <td><?php echo$data["codproducto"]?></td>
                                <td><?php echo$data["SKU"]?></td>
                                <td ><?php echo$data["descripcion"]?></td>
                                <td ><?php echo$data["contiene"]?></td>
                                <td><?php echo$data["Tipo"]?></td>
                                <td><?php echo$data["precio"]?></td>
                                <!-- <td><?php echo$data["existencia"]?></td> -->
                                <td><?php echo$data["proveedor"]?></td>
                                <td class="img_producto"><img src="<?php echo $foto; ?>"
                                        alt="<?php echo $data['descripcion']; ?>">
                                </td>
                                <?php if($_SESSION['rol']==1 or $_SESSION['rol']==3){
            ?>
                                <td>

                                    <a class="link_edit"
                                        href="editar_producto.php?id=<?php echo$data["codproducto"]?>"><i
                                            class="fas fa-edit"></i> Editar</a>
                                            <?php if($_SESSION['rol']==1){
                                             ?>
                                    |
                                    <a class="link_delete"
                                        href="eliminar_producto.php?id=<?php echo$data["codproducto"]?>"><i
                                            class="fas fa-trash-alt"></i> Eliminar</a>

                                </td>
                                <?php 
                                            }
        }
        ?>
                            </tr>
                            <?php
             }

            }
        ?>
                        </table>
                        <div class=" paginador">
                            <ul>
                                <?php
                            if($pagina!=1){

                            
                            ?>
                                <li><a href="?pagina=<?php echo 1;  ?>"><i class="fas fa-angle-left"></i></a>
                                </li>
                                <li><a href="?pagina=<?php echo $pagina-1;  ?>"><i
                                            class="fas fa-angle-double-left"></i></a>
                                </li>
                                <?php
                            }
                for($i=1;$i<=$total_paginas;$i++){
                    if($i==$pagina){
                        echo '<li class="pageSelected">'.$i.'</li>';

                    }else{
                        echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
                    }
                    

                }
                if($pagina!=$total_paginas){

                
                ?>
                                <li><a href="?pagina=<?php echo $pagina+1;  ?>"><i
                                            class="fas fa-angle-double-right"></i></a></li>
                                <li><a href="?pagina=<?php echo $total_paginas;  ?>"><i
                                            class="fas fa-angle-right"></i></a></li>


                                <?php
                }
                        ?>
                            </ul>
                        </div>
    </section>
    <?php include "includes/footer.php";?>
</body>

</html>