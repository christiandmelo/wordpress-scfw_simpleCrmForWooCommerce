<?php
	require_once plugin_dir_path(__FILE__) . '../../includes/querys/product.php';
	require_once plugin_dir_path(__FILE__) . '../../includes/querys/order.php';
?>

<form method="post" class="form-horizontal">
	<fieldset>
	<!-- Form Name -->
	<legend>Filtro</legend>
	<!-- Select Basic -->
	<div class="form-group">
		<label class="col-md-4 control-label" for="selectbasic">Status do pedido</label>
		<div class="col-md-4">
			<select name="statsFilter" class="form-control">
				<option value="0" selected >Selecione...</option>
				<option value="wc-processing">Processando</option>
				<option value="wc-ps-pagamento">Pagando</option>
				<option value="wc-completed">Finalizado</option>
				<option value="wc-cancelled">Canceldo</option>
				<option value="wc-trash">Lixo</option>
				<option value="wc-on-hold">Em espera</option>
			</select>
		</div>

		<label class="col-md-4 control-label" for="selectbasic">Produto</label>
		<div class="col-md-4">
			<select name="productFilter" class="form-control">
				<option value="0" selected >Selecione...</option>
				<?php 
					$products = listAllProducts();
					foreach ($products as $product) {
						?> <option value="<?=$product->ID;?>" ><?=$product->post_title;?></option> <?php
					}
				?>
			</select>
		</div>

		<input type="checkbox" name="exportCSV" value="1">Exportar via csv</input>

	</div>
	<!-- Button -->
	<div class="form-group">
		<div class="col-md-4">
			<button name="btnOrdersFilter" class="btn btn-primary">Filtrar</button>
		</div>
	</div>
	</fieldset>
</form>


<!-- functions -->
<?php
//export orders by itens for CSV
if(isset($_POST['exportCSV'])){
	
	download_send_headers("data_export_" . date("Y-m-d") . ".csv");
	ob_get_clean();
	$out = fopen('php://output', 'w');
	fputcsv($out, array('Nome Produto','Status Ordem','Nome Cliente','Email', 'Qtd.', utf8_decode('Preço Unitário')));
	$orders = listOrdersByProduct($_POST['statsFilter'], $_POST['productFilter']);
				foreach ($orders as $order) {
					fputcsv(
						$out, 
						array(	$order->order_id,
								utf8_decode($order->name_product),
								utf8_decode($order->status),
								utf8_decode($order->display_name),
								utf8_decode($order->user_email),
								$order->product_qty,
								$order->revenue_price
							)
						);
				}
	fclose($out);

	die();
}


//list orders by itens
	if(isset($_POST['btnOrdersFilter'])){
		?>
		<table>
			<thead>
				<tr>
					<th>Id Ordem</th>
					<th>Nome Produto</th>
					<th>Status Ordem</th>
					<th>Nome Cliente</th>
					<th>Email</th>
					<th>Qtd.</th>
					<th>Preço Unitário</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$orders = listOrdersByProduct($_POST['statsFilter'], $_POST['productFilter']);
				foreach ($orders as $order) {
					?>
					<tr>
						<td><?=$order->order_id;?></td>
						<td><?=$order->name_product;?></td>
						<td><?=$order->status;?></td>
						<td><?=$order->display_name;?></td>
						<td><?=$order->user_email;?></td>
						<td><?=$order->product_qty;?></td>
						<td><?=$order->revenue_price;?></td>
					</tr>
					<?php
				}
			?>
			</tbody>
		</table>
	<?php
	}
?>