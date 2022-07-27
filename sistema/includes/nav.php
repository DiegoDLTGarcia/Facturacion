<nav>
    <ul>
        <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
        <?php
					if($_SESSION['rol']==1){
					?>
        <li class="principal">

            <a href="#"><i class="fas fa-users"></i> Usuarios</a>
            <ul>
                <li><a href="registro_usuario.php"><i class="fas fa-plus"></i> Nuevo Usuario</a></li>
                <li><a href="lista_usuarios.php"><i class="fas fa-bars"></i> Lista de Usuarios</a></li>
            </ul>
        </li>
        <?php
				}
				?>
        <?php
					if($_SESSION['rol']==1 or $_SESSION['rol']==2){
					?>
        <li class="principal">
            <a href="#"><i class="fas fa-user-friends"></i> Clientes</a>
            <ul>
                <li><a href="registro_cliente.php"><i class="fas fa-plus"></i> Nuevo Cliente</a></li>
                <li><a href="lista_clientes.php"><i class="fas fa-bars"></i> Lista de Clientes</a></li>
            </ul>
        </li>
        <?php
				}
				?>
        <?php
					if($_SESSION['rol']==1){
					?>
        <li class="principal">
            <a href="#"><i class="fas fa-user-tie"></i> Proveedores</a>
            <ul>
                <li><a href="registro_provedores.php"><i class="fas fa-plus"></i> Nuevo Proveedor</a></li>
                <li><a href="lista_provedores.php"><i class="fas fa-bars"></i> Lista de Proveedores</a></li>
            </ul>
        </li>
        <?php
				}
				?>
        <?php
					if($_SESSION['rol']==1 or $_SESSION['rol']==2 or $_SESSION['rol']==3){
					?>
        <li class="principal">
            <a href="#"><i class="fas fa-boxes"></i> Productos</a>
            <ul>
                <?php if($_SESSION['rol']==1 or $_SESSION['rol']==3){
							?>
                <li><a href="regitrar_prodcuto.php"><i class="fas fa-plus"></i> Nuevo Producto</a></li>
                <?php
				}
				?>
                <li><a href="listar_prodcutos.php"><i class="fas fa-bars"></i> Lista de Productos</a></li>
            </ul>
        </li>
        <?php
				}
				?>
        <?php
					if($_SESSION['rol']==1 or $_SESSION['rol']==2 or $_SESSION['rol']==3){
					?>
        <li class="principal">
            <a href="#"><i class="fas fa-file-invoice"></i></i> Cotización</a>
            <ul>
                <?php
					if($_SESSION['rol']==1 or $_SESSION['rol']==2){

					
					?>
                <li><a href="nueva_venta.php"><i class="fas fa-plus"></i> Nuevo Cotización</a></li>
                <?php
					}
                    ?>
                <?php if($_SESSION['rol']==3){
                        ?>

                <li><a href="lista_ventas_administacion.php"><i class="fas fa-file-invoice-dollar"></i> Cotizaciónes</a></li>
                <?php
                    }else{
                ?>
                <?php
					if($_SESSION['rol']==1){
                        ?>
                <li><a href="ventas.php"><i class="fas fa-file-invoice-dollar"></i> Cotización Totales</a></li>
                <li><a href="lista_ventas_vendedores.php"><i class="fas fa-file-invoice-dollar"></i> Cotización de <?php $usuario_activo=$_SESSION['nombre']; echo $usuario_activo;?></a></li>
                    <?php }else{
                    ?>
                    <li><a href="lista_ventas_vendedores.php"><i class="fas fa-file-invoice-dollar"></i> Ventas</a></li>
                <?php
                    }
                }
                ?>
            </ul>
        </li>
        <?php
                
                    
				}
				?>
        <?php
					if($_SESSION['rol']==1 or $_SESSION['rol']==2){
					?>

        <li class="principal">
            <a href="#"><i class="far fa-chart-bar"></i> Dashboard</a>
            <ul>
                <li><a href="panel_facturas.php"><i class="fas fa-chart-line"></i> Dashboard Facturas</a></li>
                
            </ul>
        </li>
        <?php
				}
				?>

        <li class="principal">
            <a href="#"><i class="fas fa-address-card"></i> Perfil</a>
            <ul>
                <li><a href="perfil.php"><i class="fas fa-id-card"></i> Mis datos</a></li>
                <!--<li><a href="seguimiento.php"><i class="fas fa-file-invoice-dollar"></i> Seguimiento de facturas</a>
                </li>-->
            </ul>
        </li>
    </ul>



</nav>