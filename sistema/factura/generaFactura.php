<?php

	//print_r($_REQUEST);
	//exit;
	//echo base64_encode('2');
	//exit;
	session_start();
	//if(empty($_SESSION['active']))
	//{
	//	header('location: ../');
	//}

	include "../../conexion.php";
	require_once '../pdf/vendor/autoload.php';
	use Dompdf\Dompdf;

	if(empty($_REQUEST['cl']) || empty($_REQUEST['f']))
	{
		echo "No es posible generar la factura.";
	}else{
		$codCliente = $_REQUEST['cl'];
		$noFactura = $_REQUEST['f'];
		$anulada = '';

		$query_config   = mysqli_query($conection,"SELECT f.nofactura,f.codcliente,cl.razon_social as cliente_empresa,cl.idcliente as id_cliente,c.id as id_configuracion,c.nombre as empresa_configuracion,
		c.rfc as rfc, c.razon_social as razon_social , c.telefono as telefono,c.direccion as direccion,c.iva as iva  
		FROM factura f
		INNER JOIN cliente cl
		ON f.codcliente=cl.idcliente 
		INNER JOIN configuracion c
		ON f.idempresa = c.id
		WHERE nofactura=$noFactura");
		$result_config  = mysqli_num_rows($query_config);
		if($result_config > 0){
			$configuracion = mysqli_fetch_assoc($query_config);
		}
		$query_cambio  = mysqli_query($conection,"SELECT DISTINCT dt.Cambio,f.nofactura as factura FROM detallefactura dt
		INNER JOIN factura f 
		on dt.nofactura=f.nofactura
		WHERE f.nofactura=$noFactura");
		$result_cambio  = mysqli_num_rows($query_cambio);
		if($result_cambio> 0){
			$cambio = mysqli_fetch_assoc($query_cambio);
		}


		$query = mysqli_query($conection,"SELECT f.nofactura, DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(f.fecha,'%H:%i:%s') as  hora, f.codcliente, f.estatus,
		v.nombre as vendedor,
		cl.razon_social, cl.rfc, cl.contacto,cl.telefono,cl.email,cl.pais
   		FROM factura f
   		INNER JOIN usuario v
   		ON f.usuario = v.idusuario
   		INNER JOIN cliente cl
   		ON f.codcliente = cl.idcliente
											WHERE f.nofactura = $noFactura AND f.codcliente = $codCliente  AND f.estatus != 10 ");

		$result = mysqli_num_rows($query);
		if($result > 0){

			$factura = mysqli_fetch_assoc($query);
			$no_factura = $factura['nofactura'];

			if($factura['estatus'] == 2){
				$anulada = '<img class="anulada" src="img/anulado.png" alt="Anulada">';
			}

			$query_productos = mysqli_query($conection,"SELECT p.descripcion,dt.cantidad,dt.precio_venta,dt.Cambio,(dt.cantidad * (dt.precio_venta*dt.Cambio)) as precio_total
														FROM factura f
														INNER JOIN detallefactura dt
														ON f.nofactura = dt.nofactura
														INNER JOIN producto p
														ON dt.codproducto = p.codproducto
														WHERE f.nofactura = $no_factura ");
			$result_detalle = mysqli_num_rows($query_productos);

			ob_start();
		    include(dirname('__FILE__').'/factura.php');
		    $html = ob_get_clean();

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();

			$dompdf->loadHtml($html);
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('letter', 'portrait');
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('factura_'.$noFactura.'.pdf',array('Attachment'=>0));
			exit;
		}
	}

?>