<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Penjualan - <?=$str_month." ".$str_year?></h2>
		</div>
    </div>
	
	<input type="hidden" id="cur_month" value="<?=$cur_month?>"/>
	<input type="hidden" id="cur_year" value="<?=$cur_year?>"/>
	
	<table id="tabel_stok">
	<tr><td rowspan=2 class="table_header">Stok</td>
	<td rowspan=2 class="table_header">Barang</td>
	<?php
		foreach ($haris as $hari)
		{
			?>
				<td class="table_header-2"><?=$hari?></td>
			<?php
		}
		?><td rowspan=2 class="table_header">Total</td></tr><tr><?php
		foreach ($tanggals as $tanggal)
		{
			?>
				<td class="table_header-3"><?=$tanggal?></td>
			<?php
		}
		?></tr><?php
		foreach ($items as $item)
		{
			?>
				<tr>
				<td class="first_row"><?=$item->stok?></td>
				<td class="first_row"><?=$item->nama?></td>
				<?php
					foreach ($tanggals as $tanggal)
					{
						$array_identifier = $tanggal."-".$cur_month."-".$cur_year."-".$item->id;
						?>
							<td><?=isset($stoks[$array_identifier])?$stoks[$array_identifier]->jumlah:" "?></td>
						<?php
					}
				?>
				<td class="first_row"><?=isset($stoks[$item->id])?$stoks[$item->id]->jumlah:"0"?></td>
				</tr>
			<?php
		}
	?>
	</table>
    
	<br/>
	
    <input type="button" value="&#8592; Prev Month" onclick="parent.load_penjualan_view_month(<?=$prev_month?>, <?=$prev_year?>)"/>
    <input type="button" value="Next Month &#8594;" onclick="parent.load_penjualan_view_month(<?=$next_month?>, <?=$next_year?>)"/>
	<br/>
	<br/>
</div>