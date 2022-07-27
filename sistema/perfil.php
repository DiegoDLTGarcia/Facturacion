<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php";?>
    <title>Sisteme Ventas</title>
</head>

<body>
    <?php 
    include "includes/header.php";
    include "../conexion.php";

    $emprsa="";
    $rfc='';
    $nombreEmpresa='';
    $razonSocial='';
    $telEmpresa='';
    $emailEmpresa='';
    $dirEmpresa='';
    $conEmpresa='';
    $iva='';
    

   /* $query_empresa=mysqli_query($conection,"SELECT * FROM configuracion where id=2");
    $row_empresa=mysqli_num_rows($query_empresa);
    if($row_empresa>0){
        while($arrInfoEmpresa=mysqli_fetch_assoc($query_empresa)){
            $rfc=$arrInfoEmpresa['rfc'];
            $nombreEmpresa=$arrInfoEmpresa['nombre'];
            $razonSocial=$arrInfoEmpresa['razon_social'];
            $telEmpresa=$arrInfoEmpresa['telefono'];
            $emailEmpresa=$arrInfoEmpresa['email'];
            $dirEmpresa=$arrInfoEmpresa['direccion'];
            $conEmpresa=$arrInfoEmpresa['contacto'];
            $iva=$arrInfoEmpresa['iva'];

        }
            
        }*/
    



    /*$query_dash=mysqli_query($conection,"CALL datDashboard();");
    $result_dash=mysqli_num_rows($query_dash);
    if($result_dash > 0){
        $data_dash=mysqli_fetch_assoc($query_dash);
        //mysqli_close($conection);

    }*/
    
    
    ?>
    <section id="container">
        <div class="divInfoSistema">
            <div>
                <h1 class="titlePanelControl">Configuración</h1>
            </div>
            <div class="containerPerfil">
                <div class="containerDataUser">
                    <div class="logUser">
                        <img src="img/logoUser.png">
                    </div>
                    <div class="dataUser">
                        <h4>Informacion Personal</h4>

                        <div>
                            <label>Nombre: </label><span><?php echo $_SESSION['nombre'];?></span>
                        </div>
                        <div>
                            <label>Correo: </label><span><?php echo $_SESSION['email'];?></span>
                        </div>
                        <h4>Datos usuario</h4>

                        <div>
                            <label>Rol: </label><span><?php echo $_SESSION['rol_name'];?></span>
                        </div>
                        <div>
                            <label>Usuario: </label><span><?php echo $_SESSION['user'];?></span>
                        </div>
                        <h4>Cambiar contraseña</h4>
                        <form action="" method="post" name="frmChangePass" id="frmChangePass">
                            <div>
                                <input type="password" name="txtPassUser" id="txtPassUser"
                                    placeholder="Contraseña actual" required>
                            </div>
                            <div>
                                <input class="newPass" type="password" name="txtNewPassUser" id="txtNewPassUser"
                                    placeholder="Nueva contraseña" required>
                            </div>
                            <div>
                                <input class="newPass" type="password" name="txtPassConfirm" id="txtPassConfirm"
                                    placeholder="Confirmar contraseña" required>
                            </div>
                            <div class="alertChangesPass" style="display: none;">


                            </div>
                            <div>
                                <button type="submit" class="btn_save btnChangePass"><i class="fas fa-key"></i> Cambiar
                                    contraseña</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if($_SESSION['rol']==1){?>
                <div class="containerDataEmpresa">
                    <div class="logCompany">
                        <img src="img/logoEmpresa.png">

                    </div>

                    
                    <form name="form_empresa" id="form_empresa">

                        <div class="wd100">
                            <label>Empresa</label>
                            <input type="text" name="nom_empresa" id="nom_empresa">
                        </div>
                    </form>




                    <br>
                    <h4>Datos de la empresa</h4>


                    <form action="" method="post" name="frmEmpresa" id="frmEmpresa">
                        <input type="hidden" name="action" value="updateDataEmpresa">
                        <input  type="hidden"  id="idEmpresa" name="idEmpresa" value="">
                        <div>

                            <label>RFC:</label><input type="text" name="txtRfc" id="txtRfc"
                                placeholder="RFC de la empresa"  required>
                        </div>
                        <div>
                            <label>Nombre: </label><input type="text" name="txtNombre" id="txtNombre"
                                placeholder="Nombre de la empresa"  required>
                        </div>
                        <div>
                            <label>Razon social: </label><input type="text" name="txtRsocial" id="txtRsocial"
                                placeholder="Razon social" required>
                        </div>
                        <div>
                            <label>Telefono: </label><input type="text" name="txtTelefono" id="txTelefono"
                                placeholder="Numero de telefono"  required>
                        </div>
                        <div>
                            <label>Correo electronico: </label><input type="email" name="txtEmail" id="txtEmail"
                                placeholder="Correo electronico"  required>
                        </div>
                        <div>
                            <label>Direccion: </label><input type="text" name="txtDireccion" id="txtDireccion"
                                placeholder="Direccion de la empresa"  required>
                        </div>
                        <div>
                            <label>Contacto: </label><input type="text" name="txtContacto" id="txtContacto"
                                placeholder="Contacto de la empresa"  required>
                        </div>
                        <div>
                            <label>IVA (%): </label><input type="number" name="txtIva" id="txtIva"
                                placeholder="Impuesto al valor agregado (IVA)"  required>
                        </div>
                        <div class="alertFormEmpresa" style="display: none;"></div>

                        <div>
                            <button type="submit" class="btn_save BtnChangePass"><i class="far fa-save fa-lg"></i>
                                Guardar datos</button>
                        </div>

                    </form>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php include "includes/footer.php";?>
</body>

</html>