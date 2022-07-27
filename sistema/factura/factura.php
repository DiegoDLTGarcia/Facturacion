<?php
	$subtotal 	= 0;
	$iva 	 	= 0;
	$impuesto 	= 0;
	$tl_sniva   = 0;
	$total 		= 0;
 //print_r($configuracion); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Factura</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php echo $anulada; ?>
<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
				<img src="img/logo-cbs-mexico.png" width="200" height="100">
				</div>
			</td>
			<td class="info_empresa">
				<?php
					if($result_config > 0){
						$iva = $configuracion['iva'];
				 ?>
				<div>
					<span class="h2"><?php echo strtoupper($configuracion['empresa_configuracion']); ?></span>
					<p><?php echo $configuracion['razon_social']; ?></p>
					<p><?php echo $configuracion['direccion']; ?></p>
					<p>RFC: <?php echo $configuracion['rfc']; ?></p>
					<p>Teléfono: <?php echo $configuracion['telefono']; ?></p>
					
				</div>
				<?php
					}
					if ($cambio["Cambio"]==1){
                        $tipo = '<span class="pendiente">USD</span>';
					}
					if ($cambio["Cambio"]>=2){
                        $tipo = '<span class="pendiente">MXN</span>';
                    }
				 ?>
			</td>
			<td class="info_factura">
				<div class="round">
					<span class="h3">Cotización</span>
					<p>No. Cotización: <strong><?php echo $factura['nofactura']; ?></strong></p>
					<p>Fecha: <?php echo $factura['fecha']; ?></p>
					<p>Hora: <?php echo $factura['hora']; ?></p>
					<p>Vendedor: <?php echo $factura['vendedor']; ?></p>
					<p>Tipo de moneda: <?php echo $tipo;  ?></p>
					
				</div>
			</td>
		</tr>
	</table>
	<table id="factura_cliente">
		<tr>
			<td class="info_cliente">
				<div class="round">
					<span class="h3">Cliente</span>
					<table class="datos_cliente">
						<tr>
							<td><label>Razon social:</label><p><?php echo $factura['razon_social']; ?></p></td>
							<td><label>RFC:</label> <p><?php echo $factura['rfc']; ?></p></td>
							
						</tr>
						<tr>
							<td><label>Telefono:</label> <p><?php echo $factura['telefono']; ?></p></td>
							<td><label>Email:</label> <p><?php echo $factura['email']; ?></p></td>
							
						</tr>
						<tr>
						<td>
							<label>Contacto:</label> <p><?php echo $factura['contacto']; ?></p></td>
							<td><label>Pais:</label> <p><?php echo $factura['pais']; ?></p></td>
						</tr>
					</table>
				</div>
			</td>

		</tr>
	</table>

	<table id="factura_detalle">
			<thead>
				<tr>
					<th width="50px">Cant.</th>
					<th class="textleft">Descripción</th>
					<th class="textright" width="150px">Precio Unitario.</th>
					<th class="textright" width="150px"> Precio Total</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">

			<?php
				
				if($result_detalle > 0){

					while ($row = mysqli_fetch_assoc($query_productos)){
						
			 ?>
				<tr>
					<td class="textcenter"><?php echo $row['cantidad']; ?></td>
					<td><?php echo $row['descripcion']; ?></td>
					<td class="textright"><?php echo $row['precio_venta']*$row['Cambio']; ?></td>
					<td class="textright"><?php echo $row['precio_total']; ?></td>
				</tr>
			<?php
						$precio_total = $row['precio_total'];
						$subtotal = round($subtotal + $precio_total, 2);
					}
				}

				$impuesto 	= round($subtotal * ($iva / 100), 2);
				$tl_sniva 	= round($subtotal ,2 );
				$total 		= round($tl_sniva + $impuesto,2);

				
			?>
			</tbody>
			<tfoot id="detalle_totales">
				<tr>
					<td colspan="3" class="textright"><span>SUBTOTAL $</span></td>
					<td class="textright"><span><?php echo $tl_sniva; ?></span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>IVA (<?php echo $iva; ?> %)</span></td>
					<td class="textright"><span><?php echo $impuesto; ?></span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>TOTAL $</span></td>
					<td class="textright"><span><?php echo $total; ?></span></td>
				</tr>
		</tfoot>
	</table>
	<div>
	<p class="nota"><strong>Cotización en Pesos Mexicanos<br>Precios sujetos a cambio sin previo aviso
	<br>Precios Antes de IVA <br>Tiempo de entrega:  48 horas</strong><br>* No incluye gastos de envio <br>* No incluye Gastos de Instalacion en Servidores<br><strong style="color: red;">Forma de Pago: 100% contado </strong>
<br>No se acepta cancelacion una vez autorizada la Orden De Compra por parte del cliente.<br>Cualquier cambio en la cantidad de productos presentados puede variar el precio por unidad<br>
Esperamos que la presente cotización esté de acuerdo a las necesidades de su empresa, para cualquier aclaración al respecto nos ponemos a sus órdenes.</p>
		<h4 class="label_gracias">Atentamente,<br><br>
		<?php if($factura['vendedor']=="Sandra Beristain"){
		?>
		<img src="img/pie-factura-sandy.jpg" width="600" height="400"></h4>
		<?php
		}
		?>
		<?php if($factura['vendedor']=="Sara Mena"){
		?>
		<img src="img/pe-factura-sara.jpg" width="600" height="300"></h4>
		<?php
		}
		?>
	</div>

</div>

</body>
</html>