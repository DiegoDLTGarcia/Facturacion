<?php
session_start();
if($_SESSION['rol']!=1){
    header("Location: ./");
}
include "../conexion.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php";?>
    <title>Lista de proveedores</title>
</head>

<body>
    <?php include "includes/header.php";?>
    <section id="container">
        <?php
        $busqueda=strtolower($_REQUEST['busqueda']);
        if(empty($busqueda)){
            header("Location: lista_provedores.php");
            mysqli_close($conection);

        }
        ?>
        <div class="limiter">
            <div class="container-table100">
                <div class="wrap-table100">
                    <div class="table100">
                        <h1><i class="fas fa-user-tie"></i> Lista de proveedores</h1>
                        <br>
                        <a href="registro_provedores.php" class="btn_new"><i class="fas fa-user-plus"></i> Crear
                            proveedor</a>
                        <form action="buscar_proveedores.php" method="get" class="form_search">
                            <input type="text" name="busqueda" id="busqueda" placeholder="buscar"
                                value="<?php echo $busqueda;?>">
                            <input type="submit" value="Buscar" class="btn_search">
                        </form>

                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Proveedor</th>
                                    <th>Contacto</th>
                                    <th>Telefono</th>
                                    <th>Direccion</th>
                                    <th>Acción</th>
                                </tr>
                                <thead>
                                    <?php
            //paginador
            $sql_registe=mysqli_query($conection,"SELECT COUNT(*) 
            AS total_registro FROM  proveedor  WHERE (
            codproveedor LIKE '%$busqueda%' OR
            proveedor LIKE '%$busqueda%' OR
            contacto LIKE '%$busqueda%' OR
            telefono LIKE '%$busqueda%' OR
            direccion LIKE '%$busqueda%' 
            AND estatus=1)");
            $result_register=mysqli_fetch_array($sql_registe);
            $total_registro=$result_register['total_registro'];

            $por_pagina=10;
            if(empty($_GET['pagina'])){
                $pagina=1;

            }else{
                $pagina=$_GET['pagina'];
            }
            $desde=($pagina-1)*$por_pagina;
            $total_paginas=ceil($total_registro/$por_pagina);

            $query=mysqli_query($conection,"SELECT * FROM proveedor
             WHERE (
            codproveedor LIKE '%$busqueda%' OR
            proveedor LIKE '%$busqueda%' OR
            contacto LIKE '%$busqueda%' OR
            telefono LIKE '%$busqueda%' OR 
            direccion LIKE '%$busqueda%') 
            AND estatus=1 ORDER BY codproveedor ASC
            LIMIT $desde,$por_pagina");
            mysqli_close($conection);
            $result=mysqli_num_rows($query);
            if($result>0){
                while($data=mysqli_fetch_array($query)){

               
        ?>
                                    <tr>
                                        <td><?php echo$data["codproveedor"]?></td>
                                        <td><?php echo$data["proveedor"]?></td>
                                        <td><?php echo$data["contacto"]?></td>
                                        <td><?php echo$data["telefono"]?></td>
                                        <td><?php echo$data["direccion"]?></td>
                                        <td>
                                            <a class="link_edit"
                                                href="editar_proveedor.php?id=<?php echo$data["codproveedor"]?>"><i
                                                    class="fas fa-edit"></i> Editar</a>
                                            <?php
                        
                    ?>
                                            |
                                            <a class="link_delete"
                                                href="eliminar_proveedor.php?id=<?php echo$data["codproveedor"]?>"><i
                                                    class="fas fa-trash-alt"></i> Eliminar</a>
                                            <?php
                
                ?>
                                        </td>
                                    </tr>
                                    <?php
             }

            }
        ?>
                        </table>
                        <?php
        if($total_registro!=0){

        
        ?>
                        <div class=" paginador">
                            <ul>
                                <?php
                            if($pagina!=1){

                            
                            ?>
                                <li><a href="?pagina=<?php echo 1;  ?>&busqueda=<?php echo $busqueda; ?>"><i
                                            class="fas fa-angle-left"></i></i></a>
                                </li>
                                <li><a href="?pagina=<?php echo $pagina-1;  ?>&busqueda=<?php echo $busqueda; ?>"><i
                                            class="fas fa-angle-double-left"></i></a>
                                </li>
                                <?php
                            }
                for($i=1;$i<=$total_paginas;$i++){
                    if($i==$pagina){
                        echo '<li class="pageSelected">'.$i.'</li>';

                    }else{
                        echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
                    }
                    

                }
                if($pagina!=$total_paginas){

                
                ?>
                                <li><a href="?pagina=<?php echo $pagina+1;  ?>&busqueda=<?php echo $busqueda; ?>"><i
                                            class="fas fa-angle-double-right"></i></a></li>
                                <li><a href="?pagina=<?php echo $total_paginas;  ?>&busqueda=<?php echo $busqueda; ?>"><i
                                            class="fas fa-angle-right"></i></a></li>


                                <?php
                }
                        ?>
                            </ul>
                        </div>
                        <?php }?>
    </section>
    <?php include "includes/footer.php";?>
</body>

</html>