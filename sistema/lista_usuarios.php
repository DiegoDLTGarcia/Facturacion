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
    <title>Lista de usuarios</title>
</head>

<body>
    <?php include "includes/header.php";?>
    <section id="container">
        <div class="limiter">
            <div class="container-table100">
                <div class="wrap-table100">
                    <div class="table100">
                        <h1><i class="fas fa-users"></i> Lista de usuarios</h1>
                        <br>
                        <a href="registro_usuario.php" class="btn_new"><i class="fas fa-user-plus"></i> Crear
                            usuario</a>
                        <form action="buscar_usuario.php" method="get" class="form_search">
                            <input type="text" name="busqueda" id="busqueda" placeholder="buscar">
                            <input type="submit" value="Buscar" class="btn_search">
                        </form>

                        <table>
                            <thead>
                                <tr>
                                    <th >ID</th>
                                    <th >Nombre</th>
                                    <th >Correo electrónico</th>
                                    <th>Usuario</th>
                                    <th>rol</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <?php
            //paginador
            $sql_registe=mysqli_query($conection,"SELECT COUNT(*) AS total_registro FROM  usuario WHERE estatus=1");
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

            $query=mysqli_query($conection,"SELECT u.idusuario,u.nombre,u.correo,u.usuario,r.rol FROM usuario u INNER JOIN rol r 
            ON u.rol=r.idrol WHERE estatus=1 
            ORDER BY idusuario ASC
            LIMIT $desde,$por_pagina");
            mysqli_close($conection);
            $result=mysqli_num_rows($query);
            if($result>0){
                while($data=mysqli_fetch_array($query)){

               
        ?>
                            <tr>
                                <td><?php echo$data["idusuario"]?></td>
                                <td><?php echo$data["nombre"]?></td>
                                <td><?php echo$data["correo"]?></td>
                                <td><?php echo$data["usuario"]?></td>
                                <td><?php echo$data["rol"]?></td>
                                <td>
                                    <a class="link_edit" href="editar_usuario.php?id=<?php echo$data["idusuario"]?>"><i
                                            class="fas fa-edit"></i> Editar</a>
                                    <?php
                        if($data["idusuario"]!=1){
                    ?>
                                    |
                                    <a class="link_delete"
                                        href="eliminar_usuario.php?id=<?php echo$data["idusuario"]?>"><i
                                            class="fas fa-trash-alt"></i> Eliminar</a>
                                    <?php
                }
                ?>
                                </td>
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