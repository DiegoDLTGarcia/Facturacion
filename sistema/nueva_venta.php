<?php 
	
    session_start();
    include "../conexion.php";
	
    
     ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "includes/scripts.php";?>
    <title>Nueva Cotización</title>
</head>

<body>
    <?php include "includes/header.php";?>
    <section id="container">
        <div class="title_page">
            <h1><i class="fas fa-cube"></i> Nueva Cotización</h1>
        </div>
        <div class="datos_cliente">
            <div class="action_cliente">
                <h4>Datos del cliente</h4>
                <a href="#" class="btn_new btn_new_cliente"><i class="fas fa-plus"></i> Nuevo cliente</a>

            </div>
            <form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos">
                <input type="hidden" name="action" value="addCliente">
                <input type="hidden" id="idcliente" name="idcliente" value="">
                <div class="wd30">
                    <label>Razón social</label>
                    <input type="text" name="razon_social" id="razon_social">
                </div>
                <div class="wd30">
                    <label>RFC</label>
                    <input type="text" name="rfc_cliente" id="rfc_cliente" disabled required>
                </div>

                <div class="wd30">
                    <label>Contacto</label>
                    <input type="text" name="con_cliente" id="con_cliente" disabled required>
                </div>
                <div class="wd50">
                    <label>Teléfono</label>
                    <input type="text" name="tel_cliente" id="tel_cliente" disabled required>
                </div>
                <div class="wd50">
                    <label>Email</label>
                    <input type="text" name="email_cliente" id="email_cliente" disabled required>
                </div>
                <div class="wd50">
                    <label>País</label>
                    <input type="text" name="pais_cliente" id="pais_cliente" disabled required>
                </div>
                

               
                </div>
                <div id="div_registro_cliente" class="wd100">
                    <button type="submit" class="btn_save"><i class="far fa-save fa-lg"></i> Guardar </button>
                </div>

            </form>
        </div>
        <div class="datos_venta">
            <h4>Datos de venta</h4>
            <div class="datos">
                <div class="wd50">
                    <label>Vendedor</label>
                    <p><?php echo $_SESSION['nombre']; ?></p>
                </div>
                <div class="wd50">
                    <label>Tipo de moneda:</label>
                    <select name="combo_cambio" id="combo_cambio">
                        <option value="1">Dolares</option>
                        <option value="2">Moneda Nacional</option>

                    </select>
                    </div>
                <div class="wd50">
                <label for="empresa">Empresa</label>
                <?php 
                    $query_empresa=mysqli_query($conection,"SELECT * FROM configuracion");
                    mysqli_close($conection);
                    $result_empresa=mysqli_num_rows($query_empresa);
                    
                ?>
                <select name="idempresa" id="idempresa">
                    
                <?php
                if($result_empresa>0){
                    while($empresa=mysqli_fetch_array($query_empresa)){
                ?>
                    <option value="<?php echo $empresa["id"]?>"><?php echo $empresa["nombre"]?></option>
                    <?php      
                                
                            }
                        }
                    ?>
                    </select>

                </div>
                <div class="wd50">
                    <label>Acciones</label>
                    <div id="acciones_venta">
                        <a href="#" class="btn_ok textcenter" id="btn_anular_venta"><i class="fas fa-ban"></i>
                            Anular</a>
                        <a href="#" class="btn_cancel textcenter" id="btn_facturar_venta" style="display: none;"><i
                                class="far fa-edit"></i>
                            Procesar</a>
                    </div>
                </div>
            </div>
        </div>
        <table class="tbl_venta">
            <thead>
                <tr>
                    <th>Código</th>
                    <th colspan="1">Descripción</th>
                    <th>Cantidad</th>
                    <th class="textright">Precio unitario</th>
                    <th>Sub total</th>
                    <th class="textright">Precio total</th>
                    <th>Cambio</th>
                    <th>Acción</th>
                </tr>
                <tr>

                    <td><input type="text" name="txt_cod_producto" id="txt_cod_producto"></td>
                    <td id="txt_descripcion">-</td>
                    <td><input type="text" name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled>
                    </td>
                    <td id="txt_precio" class="textright">0.00</td>
                    <td id="txt_precio_total" class="textright">0.00</td>
                    <td id="txt_precio_total2" class="textright">0.00</td>

                    <td><input type="text" id="txt_moneda" name="txt_moneda" value="1.00" disabled></td>
                    <td><a href="#" id="add_product_venta" class="link_add"><i class="fas fa-plus"></i> Agregar</a></td>
                </tr>
                <tr>
                    <th>Código</th>
                    <th colspan="1">Descripción </th>
                    <th>Cantidad</th>
                    <th class="textright">Precio unitario</th>
                    <th>Sub total</th>
                    <th class="textright">Precio total</th>
                    <th>Cambio</th>
                    <th>Acción</th>
                </tr>
            </thead>

            <tbody id="detalle_venta">
                <!--contenido ajx-->
            </tbody>
            </thead>
            <tfoot id="detalle_totales">
                <!-- contenido ajax-->




            </tfoot>



        </table>


    </section>

    <?php include "includes/footer.php";?>
    <script type="text/javascript">
    $(document).ready(function() {
        var usuarioid = '<?php echo $_SESSION['rol']; ?>';
        serchForDetalle(usuarioid);
    });
    </script>
</body>

</html>