<?php 
	
	session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}

	include "../conexion.php";

	if(!empty($_POST)){
		$alert='';
		if(empty($_POST['rfc']) || empty($_POST['razon_social'])){
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$idcliente  = $_POST['id'];
			$razon_social  = $_POST['razon_social'];
			$rfc  = $_POST['rfc'];
			$contacto = $_POST['contacto'];
            $telefono   = $_POST['telefono'];
            $email  =$_POST['email'];
			$pais  =$_POST['pais'];

            $result=0;
            if(is_numeric($rfc) and $rfc != 0){
                $query = mysqli_query($conection,"SELECT * FROM cliente 
                                                       WHERE (rfc = '$rfc' AND idcliente != $idcliente) ");


                $result = mysqli_fetch_array($query);
                //$result=count($result);
            }

			if($result > 0){
				$alert='<p class="msg_error">El RFC ya existe.</p>';
            }
            else{

					$sql_update = mysqli_query($conection,"UPDATE cliente
															SET razon_social = '$razon_social',
															rfc='$rfc',
															contacto='$contacto',
															telefono='$telefono',
															email='$email',
															pais='$pais'
                                                            WHERE idcliente= $idcliente");
                                                           // echo "UPDATE cliente
															//SET razon_social = '$razon_social',
															//rfc='$rfc',
															//contacto='$contacto',
															//telefono='$telefono',
															//email='$email',
															//pais='$pais'
                                                            //WHERE idcliente= $idcliente ";
                                                            
				

				if($sql_update){
					$alert='<p class="msg_save">Cliente actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el Cliente.</p>';
				}

			}


        }
    }

	

	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_clientes.php');
		mysqli_close($conection);
	}
	$idcliente = $_REQUEST['id'];

	$sql= mysqli_query($conection,"SELECT * FROM cliente
									WHERE idcliente= $idcliente  and estatus=1");
	mysqli_close($conection);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_clientes.php');
	}else{
		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$idcliente  = $data['idcliente'];
			$razon_social  = $data['razon_social'];
			$rfc  = $data['rfc'];
			$contacto = $data['contacto'];
            $telefono   = $data['telefono'];
            $email  =$data['email'];
			$pais  =$data['pais'];
            
			


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
    <title>Actualizar cliente</title>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <section id="container">

        <div class="form_register">
            <h1><i class="fas fa-user-edit"></i> Actualizar cliente</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $idcliente; ?>">
                <label for="razon_social">Razón social</label>
                <input type="text" name="razon_social" id="razon_social" placeholder="Razón social" value="<?php echo $razon_social; ?>">
                <label for="rfc">RFC</label>
                <input type="text" name="rfc" id="rfc" placeholder="RFC"
                    value="<?php echo $rfc; ?>">
                <label for="contacto">Contacto</label>
                <input type="text" name="contacto" id="contacto" placeholder="Contacto"
                    value="<?php echo $contacto; ?>">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" id="telefono" placeholder="Teléfono"
                    value="<?php echo $telefono; ?>">
					<label for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="Email"
                    value="<?php echo $telefono; ?>">
					<label for="pais">País</label>
                <input type="text" name="pais" id="pais" placeholder="País"
                    value="<?php echo $telefono; ?>">
                
                






                <button type="submit" class="btn_save"><i class="far fa-save"></i> Actualizar cliente</button>
            </form>

        </div>


    </section>
    <?php include "includes/footer.php"; ?>
</body>

</html>