<?php

session_start();

include "../conexion.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php";?>
    <title>Lista de ventas</title>
</head>

<body>
    <?php include "includes/header.php";?>
    <section id="container">
        <div class="limiter">
            <div class="container-table100">
                <div class="wrap-table100">
                    <div class="table100">
                        <h1><i class="fas fa-file-invoice-dollar"></i> Lista de Cotizaciónes</h1>

                        <br>
                        <?php if($_SESSION['rol']!=3){
                            ?>



                        <a href="nueva_venta.php" class="btn_new"><i class="fas fa-file-invoice-dollar"></i> Nueva
                            cotizacion</a>
                        <?php
                        }
                        ?>
                        <form action="buscar_venta.php" method="get" class="form_search">
                            <input type="text" name="busqueda" id="busqueda" placeholder="No. Factura">
                            <input type="submit" value="Buscar" class="btn_search">
                        </form>
                        <div>

                            <h5>Buscar por fecha</h5>
                            <form action="buscar_venta.php" method="get" class="form_search_date">
                                <label>De: </label>
                                <input type="date" name="fecha_de" required>
                                <label> A </label>
                                <input type="date" name="fecha_a" id="fecha_a" required>
                                <button type="submit" class="btn_view"><i class="fas fa-search"></i></button>
                            </form>
                        </div>


                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Fecha / Hora</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Estado</th>
                                    <th>Empresa</th>
                                    <th class="textright">Total antes de IVA</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <?php
            //paginador
           
            $sql_registe=mysqli_query($conection,"SELECT COUNT(*) AS total_registro FROM  factura WHERE estatus!=11");
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

            

            $query=mysqli_query($conection,"SELECT f.nofactura,f.fecha,f.totaltactura,f.codcliente,f.estatus,u.nombre as vendedor,
            cl.razon_social as cliente,c.nombre as empresa
        FROM factura f
        INNER JOIN usuario u
        ON f.usuario=u.idusuario
        INNER JOIN cliente cl
        ON f.codcliente=cl.idcliente
        INNER JOIN configuracion c
        ON f.idempresa=c.id
        WHERE f.estatus != 11
            ORDER BY f.fecha DESC
            LIMIT $desde,$por_pagina");
            mysqli_close($conection);
            $result=mysqli_num_rows($query);
            if($result>0){
                while($data=mysqli_fetch_array($query)){
                    if ($data["estatus"]==1){
                        $estado = '<span class="relizada">Realizada.</span>';
                    }
                    elseif ($data["estatus"]==2){
                        $estado = '<span class="anulada">Cancelada.</span';
                    }
                    elseif ($data["estatus"]==3){
                        $estado = '<span class="pendiente">Pipeline 15%.</span>';
                    }
                    
                    elseif ($data["estatus"]==4){
                        $estado = '<span class="pendiente">Weak Upside 30%.</span>';
                    }
                    elseif ($data["estatus"]==5){
                        $estado = '<span class="pendiente">Strong Upside 65%.</span>';
                    }
                    elseif ($data["estatus"]==6){
                        $estado = '<span class="pendiente">Presupuesto – tomadores de desición 85%.</span>';
                    }
                    elseif ($data["estatus"]==7){
                        $estado = '<span class="pendiente">Negociación 95%.</span>';
                    }
                    elseif ($data["estatus"]==8){
                        $estado = '<span class="pendiente">Commit 100%.</span>';
                    }
                    elseif ($data["estatus"]==9){
                        $estado = '<span class="pagada">Pagada.</span>';
                    }
                    elseif ($data["estatus"]==10){
                        $estado = '<span class="porfacturar">Por facturar.</span>';
                    }
                   
                    
                    
                    

               
        ?>
                            <tr id="row_<?php echo $data["nofactura"]; ?>">
                                <td><?php echo $data["nofactura"]?></td>
                                <td width="200"><?php echo $data["fecha"]?></td>
                                <td width="200"><?php echo $data["cliente"]?></td>
                                <td><?php echo $data["vendedor"]?></td>
                                <td width="200"><?php echo $estado?></td>
                                <td><?php echo $data["empresa"]?></td>
                                <td class="textright totalfactura">
                                    <sapn>$</sapn><?php echo$data["totaltactura"]?>
                                </td>
                                <td width="200">
                                    <div class="div_acciones">
                                        <div>
                                            <button class="btn_view view_factura" type="button"
                                                cl="<?php echo $data["codcliente"]; ?>"
                                                f="<?php echo $data['nofactura'];?>"><i class="fas fa-eye"></i></button>

                                        </div>


                                        <div>
                                            <?php 
                        if($_SESSION['rol']!=1){
                            
                                
                           
                        ?>
                                            <div class="div_factura">
                                                <button class="btn_view estado_factura" type="button"
                                                    f="<?php echo $data["nofactura"]; ?>"><i
                                                        class="fas fa-edit"></i></button>
                                                        
                                                <button class="btn_anular anular_factura"
                                                    fac="<?php echo $data["nofactura"]; ?>"><i
                                                        class="fas fa-ban"></i></button>
                                                       
                                            </div>
                                            <?php }else{
                                                
                                                

                            ?>
                                            <div class="div_factura">
                                                <button class="btn_view inactive" type="button"
                                                    f="<?php echo $data["nofactura"]; ?>"><i
                                                        class="fas fa-edit"></i></button>
                                                        <?php if($_SESSION['rol']!=3){
                                                            ?>
                                                <button type="button" class="btn_anular inactive"><i
                                                        class="fas fa-ban"></i></button>
                                            </div>
                                            <?php } 
                            
                        }
                            ?>


                                        </div>

                                    </div>

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