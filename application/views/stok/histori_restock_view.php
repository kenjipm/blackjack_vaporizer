<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Histori Restock</h2>
		</div>
    </div>
    <?php
	if (count($belanjas) > 0)
	{
		sort($belanjas);
		$total_belanja_session = 0;
		foreach($belanjas as $belanja)
		{
			?>
			<span class="order_header">
				<span class="label"><b>Tanggal : </b></span><?=$belanja->str_waktu?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="label"><b>Supplier : </b></span><?=$belanja->supplier?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="label"><b>Keterangan : </b></span><?=$belanja->keterangan?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="label"><b>Pembayaran : </b></span><?=($belanja->tipe_pembayaran == "tunai")?"Tunai":"Transfer - ".$belanja->rekening->nama." (".$belanja->rekening->no_rek.")"?>
			</span>
			
			<table id="tabel_menu">
				<tr>
					<td class="table_header">Item</td>
					<td class="table_header">Tipe</td>
					<td class="table_header">Jml</td>
					<td class="table_header">Keterangan</td>
					<td class="table_header">Harga Default</td>
					<td class="table_header">Disc. %</td>
					<td class="table_header">Disc. Rp</td>
					<td class="table_header">Harga</td>
					<td class="table_header">Harga Total</td>
				</tr>
				<?php
				$subtotal = 0;
				foreach($belanja->menu as $belanja_menu)
				{
					$discount_per_item = round((1 - ($belanja_menu->harga_beli_supplier / $belanja_menu->harga_awal)) * 10000) / 100;
					$discount_rp_per_item = $belanja_menu->harga_awal - $belanja_menu->harga_beli_supplier;
					$harga_total_per_item = $belanja_menu->jumlah * $belanja_menu->harga_beli_supplier;
					?>
					<tr class="table_row">
						<td class="menu_nama first_row"><?=$belanja_menu->nama?></td>
						<td class="menu_tipe"><?=$belanja_menu->tipe?></td>
						<td class="menu_jml"><?=$belanja_menu->jumlah?></td>
						<td class="menu_keterangan"><?=$belanja_menu->keterangan?></td>
						<td class="menu_harga_default input_harga"><?=$text_renderer->to_rupiah($belanja_menu->harga_awal)?></td>
						<td class="menu_discount"><?=$discount_per_item?> %</td>
						<td class="menu_discount_rp input_harga"><?=$text_renderer->to_rupiah($discount_rp_per_item)?></td>
						<td class="menu_harga input_harga"><?=$text_renderer->to_rupiah($belanja_menu->harga_beli_supplier)?></td>
						<td class="menu_harga_total input_harga"><?=$text_renderer->to_rupiah($harga_total_per_item)?></td>
					</tr>
					<?php
					$subtotal += $harga_total_per_item;
				}
				?>
				<tr>
					<td class="table_footer" colspan=8>Subtotal</td>
					<td class="table_footer"><?=$text_renderer->to_rupiah($subtotal)?></td>
				</tr>
			</table>
			<br/>
			<?php
			$total_belanja_session += $subtotal;
		}
		?>
		<h3>Total Belanja Session Ini : <?=$text_renderer->to_rupiah($total_belanja_session)?></h3>
		<?php
	}
	?>
	
	<br/>
	
    <input type="button" value="&#8592; Prev Session" onclick="prev_session()"/>
    <input type="button" value="Next Session &#8594;" onclick="next_session()"/>
	<br/>
	<br/>
</div>