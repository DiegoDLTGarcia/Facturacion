<?php
session_start();
if($_SESSION['rol']==3){
    header("Location: ./");
}

include "../conexion.php";
    if(!empty($_POST)){
        $alert='';
        if(empty($_POST['rfc']) || empty($_POST['razon_social'])){
            $alert='<p class="msg_error">Todos los campos son obligatorios.</p>';

        }else{
            $razon_social        =$_POST['razon_social'];
            $rfc     =$_POST['rfc'];
            $contacto   =$_POST['contacto'];
            $telefono  =$_POST['telefono'];
            $email  =$_POST['email'];
            $pais  =$_POST['pais'];
            $usuario_id =$_SESSION['idUser'];
            
            
            $result=0;
            if(is_numeric($rfc)){
                $query=mysqli_query($conection,"SELECT * FROM cliente WHERE rfc='$rfc' ");
                $result=mysqli_fetch_array($query);
            }
            
            
            if($result>0){
                $alert='<p class="msg_error">El numero RFC ya existe.</p>'; 

            }else{
                $query_insert=mysqli_query($conection,"INSERT INTO cliente(razon_social,rfc,contacto,telefono,email,pais,usuario_id) 
                VALUES ('$razon_social','$rfc','$contacto','$telefono','$email','$pais','$usuario_id')");
                                                
                if($query_insert){
                    $alert='<p class="msg_save">El cliente fue guardado con exito.</p>';
                }else{
                    $alert='<p class="msg_error">Error al guardar el cliente.</p>';
                    
                }
            }
        }
       
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Registro cliente</title>
</head>

<body>
    <?php include "includes/header.php";?>
    <section id="container">
        <div class="form_register">
            <h1><i class="fas fa-user-friends"></i> Registro cliente</h1>
            <hr>
            <div class="alert"><?php echo  isset($alert) ? $alert : '' ?></div>
            <form action="" method="post">
               
                <label for="razon_social">Razón social</label>
                <input type="text" name="razon_social" id="razon_social" placeholder="Razón social">
                <label for="rfc">RFC</label>
                <input type="text" name="rfc" id="rfc" placeholder="RFC">
                <label for="contacto">Contacto</label>
                <input type="text" name="contacto" id="contacto" placeholder="Contacto">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" id="telefono" placeholder="Teléfono">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="Email">
                <label for="pais">País</label>
                <input type="text" name="pais" id="pais" placeholder="País">
               

                </select>

                
                
                <button type="submit" class="btn_save"><i class="far fa-save"></i> Crear cliente</button>
            </form>
        </div>

    </section>

    <?php include "includes/footer.php";?>
</body>

</html>