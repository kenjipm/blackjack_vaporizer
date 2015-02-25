<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Alokasi Modal</h2>
		</div>
    </div>
	<hr size=1/>
	<h3>Overview</h3>
	<table>
		<tr>
			<td class="table_header">Jenis Modal</td>
			<td class="table_header">Jumlah</td>
		</tr>
		<!--tr>
			<td class="table_header-2 nama_kas">Modal (Tunai)</td>
			<td class="harga"><?=$text_renderer->to_rupiah($modal['tunai'])?></td>
		</tr>
		<tr>
			<td class="table_header-2 nama_kas">Modal (Rekening)</td>
			<td class="harga"><?=$text_renderer->to_rupiah($modal['rekening'])?></td>
		</tr-->
		<tr>
			<td class="table_header-2 nama_kas">Modal Cair</td>
			<td class="harga"><?=$text_renderer->to_rupiah($modal['total'])?></td>
		</tr>
		<tr>
			<td class="table_header-2 nama_kas">Modal Barang</td>
			<td class="harga"><?=$text_renderer->to_rupiah($harga_total_semua_barang)?></td>
		</tr>
		<tr>
			<td class="table_header-2 nama_kas">TOTAL</td>
			<td class="harga"><?=$text_renderer->to_rupiah($modal['total'] + $harga_total_semua_barang)?></td>
		</tr>
	</table>
	
	<hr size=1/>
	<h3>Modal Barang</h3>
	<table>
		<tr>
			<td class="table_header">Item</td>
			<td class="table_header">Stok</td>
			<td class="table_header">Harga Modal</td>
			<td class="table_header">Harga Total</td>
		</tr>
		<?php
		foreach ($barangs as $barang)
		{
			?>
			<tr>
				<td class="first_row item"><?=$barang->nama?></td>
				<td class="stok"><?=$barang->stok?></td>
				<td class="harga"><?=$text_renderer->to_rupiah($barang->harga_base)?></td>
				<td class="first_row harga"><?=$text_renderer->to_rupiah($barang->harga_total)?></td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td class="table_header-2" colspan=3>TOTAL</td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($harga_total_semua_barang)?></td>
		</tr>
	</table>
	<br/>
</div>