<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Factura</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<img class="anulada" src="img/anulado.png" alt="Anulada">
<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img src="img/logo-cbs-mexico.png" width="200" height="100">
				</div>
			</td>
			<td class="info_empresa">
				<div>
					<span class="h2">SISTEMA VENTAS</span>
					<p>Direccion</p>
					<p>Teléfono: </p>
					<p>Email:</p>
				</div>
			</td>
			<td class="info_factura">
				<div class="round">
					<span class="h3">Factura</span>
					<p>No. Factura: <strong>000001</strong></p>
					<p>Fecha: 20/01/2019</p>
					<p>Hora: 10:30am</p>
					<p>Vendedor:</p>
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
							<td><label>rfc:</label><p>54895468</p></td>
							<td><label>Teléfono:</label> <p>7854526</p></td>
						</tr>
						<tr>
							<td><label>Nombre:</label> <p>Diego</p></td>
							<td><label>Dirección:</label> <p>Mexico/p></td>
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
				<tr>
					<td class="textcenter">1</td>
					<td>Plancha</td>
					<td class="textright">516.67</td>
					<td class="textright">516.67</td>
				</tr>
				<tr>
					<td class="textcenter">1</td>
					<td>Plancha</td>
					<td class="textright">516.67</td>
					<td class="textright">516.67</td>
				</tr>
				<tr>
					<td class="textcenter">1</td>
					<td>Plancha</td>
					<td class="textright">516.67</td>
					<td class="textright">516.67</td>
				</tr>
				<tr>
					<td class="textcenter">1</td>
					<td>Plancha</td>
					<td class="textright">516.67</td>
					<td class="textright">516.67</td>
				</tr>
				<tr>
					<td class="textcenter">1</td>
					<td>Plancha</td>
					<td class="textright">516.67</td>
					<td class="textright">516.67</td>
				</tr>
				<tr>
					<td class="textcenter">1</td>
					<td>Plancha</td>
					<td class="textright">516.67</td>
					<td class="textright">516.67</td>
				</tr>
			</tbody>
			<tfoot id="detalle_totales">
				<tr>
					<td colspan="3" class="textright"><span>SUBTOTAL Q.</span></td>
					<td class="textright"><span>516.67</span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>IVA (12%)</span></td>
					<td class="textright"><span>516.67</span></td>
				</tr>
				<tr>
					<td colspan="3" class="textright"><span>TOTAL Q.</span></td>
					<td class="textright"><span>516.67</span></td>
				</tr>
		</tfoot>
	</table>
	<div>
		<p class="nota"><strong>Cotización en Pesos Mexicanos<br>Precios sujetos a cambio sin previo aviso
	<br>Precios Antes de IVA <br>Tiempo de entrega:  48 horas</strong><br>* No incluye gastos de envio <br>* No incluye Gastos de Instalacion en Servidores<br><strong style="color: red;">Forma de Pago: 100% contado </strong>
<br>No se acepta cancelacion una vez autorizada la Orden De Compra por parte del cliente.<br>Cualquier cambio en la cantidad de productos presentados puede variar el precio por unidad<br>
Esperamos que la presente cotización esté de acuerdo a las necesidades de su empresa, para cualquier aclaración al respecto nos ponemos a sus órdenes.</p>
		<h4 class="label_gracias">Atentamente,<br><br><img src="img/pie-factura.jpg" width="500" height="250"></h4>
	</div>

</div>

</body>
</html>