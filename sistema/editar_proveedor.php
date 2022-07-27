<?php 
	
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}

	include "../conexion.php";

	if(!empty($_POST)){
		$alert='';
		if(empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono'])  || empty($_POST['direccion'])){
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$codproveedor  = $_POST['id'];
            $proveedor = $_POST['proveedor'];
            $contacto = $_POST['contacto'];
			$telefono  = $_POST['telefono'];
			$direccion   = $_POST['direccion'];

            $result=0;
            //if(is_numeric($rfc) and $rfc != 0){
                $query = mysqli_query($conection,"SELECT * FROM proveedor 
                                                       WHERE (proveedor = '$proveedor' AND codproveedor  != $codproveedor) ");


                $result = mysqli_fetch_array($query);
                //$result=count($result);
            //}

			if($result > 0){
				$alert='<p class="msg_error">El RFC ya existe.</p>';
            }
            else{

					$sql_update = mysqli_query($conection,"UPDATE proveedor
															SET proveedor = '$proveedor', contacto='$contacto',telefono='$telefono',direccion='$direccion'
                                                            WHERE codproveedor = $codproveedor ");
                                                            //echo "UPDATE cliente
															//SET rfc = '$rfc', nombre='$nombre',telefono='$telefono',direccion='$direccion'
                                                            //WHERE idcliente= $idcliente ";
                                                            
				

				if($sql_update){
					$alert='<p class="msg_save">Proveedor actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el proveedor.</p>';
				}

			}


        }
    }

	

	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_provedores.php');
		mysqli_close($conection);
	}
	$codproveedor  = $_REQUEST['id'];

	$sql= mysqli_query($conection,"SELECT * FROM proveedor
									WHERE codproveedor = $codproveedor  and estatus=1");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_provedores.php');
	}else{
		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$codproveedor   = $data['codproveedor'];
			$proveedor      = $data['proveedor'];
			$contacto       = $data['contacto'];
			$telefono       = $data['telefono'];
			$direccion      = $data['direccion'];

			


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
    <title>Actualizar proveedor</title>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <section id="container">

        <div class="form_register">
            <h1><i class="fas fa-user-edit"></i> Actualizar proveedor</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $codproveedor ; ?>">
                <label for="proveedor">Proveedor</label>
                <input type="text" name="proveedor" id="proveedor" placeholder="Proveedor" value="<?php echo $proveedor; ?>">
                <label for="contacto">Contacto</label>
                <input type="text" name="contacto" id="contacto" placeholder="Contacto"
                    value="<?php echo $contacto; ?>">
                <label for="telefono">Teléfono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Telefono"
                    value="<?php echo $telefono; ?>">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion" placeholder="Direccion"
                    value="<?php echo $direccion; ?>">


                    <button type="submit" class="btn_save"><i class="far fa-save"></i> Actualizar proveedor</button>
            </form>

        </div>


    </section>
    <?php include "includes/footer.php"; ?>
</body>

</html>