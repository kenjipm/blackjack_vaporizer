<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Omzet - <?=$str_month." ".$str_year?></h2>
		</div>
    </div>
	
	<input type="hidden" id="cur_month" value="<?=$cur_month?>"/>
	<input type="hidden" id="cur_year" value="<?=$cur_year?>"/>
	
	<table id="tabel_omzet">
	<tr>
		<td class="table_header">Hari</td>
		<td class="table_header">Tanggal</td>
		<td class="table_header">Omzet</td>
	</tr>
	<tr>
	<?php
		foreach ($tanggals as $tanggal)
		{
			if ($tanggals)
			{
				?>
					<tr>
						<td class="table_header-2"><?=$haris[$tanggal]?></td>
						<td class="table_header-3"><?=$tanggal?></td>
						<td><?=isset($omzets[$tanggal."-".$cur_month."-".$cur_year])?$text_renderer->to_rupiah($omzets[$tanggal."-".$cur_month."-".$cur_year]->total):""?></td>
					</tr>
				<?php
			}
		}
	?>
	<tr>
		<td colspan="2">TOTAL</td>
		<td><?=$text_renderer->to_rupiah($total_omzet)?></td>
	</tr>
	</table>
    
	<br/>
	
    <input type="button" value="&#8592; Prev Month" onclick="parent.load_omzet_view_month(<?=$prev_month?>, <?=$prev_year?>)"/>
    <input type="button" value="Next Month &#8594;" onclick="parent.load_omzet_view_month(<?=$next_month?>, <?=$next_year?>)"/>
	<br/>
	<br/>
</div>