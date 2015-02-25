<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Migrasi Kas</h2>
		</div>
    </div>
	
	<form action="kas_migrasi_view" method="post" target="finance_view" id="form_kas_migrasi">
	
	<hr size=1/>
	<h3>Masukkan Data</h3>
	<span class="label">Kas Sumber</span> : <select id="id_tipe_kas_sumber">
	<?php
		foreach($finance_kas_tunais as $finance_kas_tunai)
		{
			?>
			<option value="tunai-<?=$finance_kas_tunai->id?>">Tunai - <?=$finance_kas_tunai->nama?><?=$finance_kas_tunai->keterangan?" (".$finance_kas_tunai->keterangan.")":""?></option>
			<?php
		}
		foreach($finance_kas_rekenings as $finance_kas_rekening)
		{
			?>
			<option value="rekening-<?=$finance_kas_rekening->id?>">Rekening - <?=$finance_kas_rekening->nama?><?=$finance_kas_rekening->no_rek?" (".$finance_kas_rekening->no_rek.")":""?></option>
			<?php
		}
	?></select><br/>
	<span class="label">Jumlah</span> : <input type="text" id="jumlah" name="jumlah" class="textbox" value=""/><br/>
	<span class="label">Kas Tujuan</span> : <select id="id_tipe_kas_tujuan">
	<?php
		foreach($finance_kas_tunais as $finance_kas_tunai)
		{
			?>
			<option value="tunai-<?=$finance_kas_tunai->id?>">Tunai - <?=$finance_kas_tunai->nama?><?=$finance_kas_tunai->keterangan?" (".$finance_kas_tunai->keterangan.")":""?></option>
			<?php
		}
		foreach($finance_kas_rekenings as $finance_kas_rekening)
		{
			?>
			<option value="rekening-<?=$finance_kas_rekening->id?>">Rekening - <?=$finance_kas_rekening->nama?><?=$finance_kas_rekening->no_rek?" (".$finance_kas_rekening->no_rek.")":""?></option>
			<?php
		}
	?></select><br/>
	<span class="label">Keterangan</span> : <input type="text" id="keterangan" name="keterangan" class="textbox" value=""/><br/>
	<input type="button" value="Pindahkan" onclick="do_migrasi_kas()"/>
	</form>
	
	<hr size=1/>
	<h3>Kas Tunai</h3>
	<table>
		<tr>
			<td class="table_header">Nama Kas</td>
			<td class="table_header">Starting Balance</td>
			<td class="table_header">Total Kredit</td>
			<td class="table_header">Total Debit</td>
			<td class="table_header">Ending Balance</td>
		</tr>
		<?php
		foreach ($finance_kas_tunais as $finance_kas_tunai)
		{
			?>
			<tr>
				<td class="first_row nama_kas"><?=$finance_kas_tunai->nama?><?=$finance_kas_tunai->keterangan?" (".$finance_kas_tunai->keterangan.")":""?></td>
				<td class="harga"><?=$text_renderer->to_rupiah($finance_kas_tunai->starting_balance)?></td>
				<td class="harga"><?=$text_renderer->to_rupiah($finance_kas_tunai->total_kredit)?></td>
				<td class="harga"><?=$text_renderer->to_rupiah(-$finance_kas_tunai->total_debit)?></td>
				<td class="harga"><?=$text_renderer->to_rupiah($finance_kas_tunai->ending_balance)?></td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td class="table_header-2 nama_kas">TOTAL</td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_kas_tunai_total->starting_balance)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_kas_tunai_total->total_kredit)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah(-$finance_kas_tunai_total->total_debit)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_kas_tunai_total->ending_balance)?></td>
		</tr>
	</table>
	
	<hr size=1/>
	<h3>Kas Rekening</h3>
	<table>
		<tr>
			<td class="table_header">Nama Kas</td>
			<td class="table_header">Starting Balance</td>
			<td class="table_header">Total Kredit</td>
			<td class="table_header">Total Debit</td>
			<td class="table_header">Ending Balance</td>
		</tr>
		<?php
		foreach ($finance_kas_rekenings as $finance_kas_rekening)
		{
			?>
			<tr>
				<td class="first_row nama_kas"><?=$finance_kas_rekening->nama?><?=$finance_kas_rekening->no_rek?" (".$finance_kas_rekening->no_rek.")":""?></td>
				<td class="harga"><?=$text_renderer->to_rupiah($finance_kas_rekening->starting_balance)?></td>
				<td class="harga"><?=$text_renderer->to_rupiah($finance_kas_rekening->total_kredit)?></td>
				<td class="harga"><?=$text_renderer->to_rupiah(-$finance_kas_rekening->total_debit)?></td>
				<td class="harga"><?=$text_renderer->to_rupiah($finance_kas_rekening->ending_balance)?></td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td class="table_header-2 nama_kas">TOTAL</td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_kas_rekening_total->starting_balance)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_kas_rekening_total->total_kredit)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah(-$finance_kas_rekening_total->total_debit)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_kas_rekening_total->ending_balance)?></td>
		</tr>
	</table>
	
	<hr size=1/>
	<h3>Kas Total</h3>
	<table>
		<tr>
			<td class="table_header">Nama Kas</td>
			<td class="table_header">Starting Balance</td>
			<td class="table_header">Total Kredit</td>
			<td class="table_header">Total Debit</td>
			<td class="table_header">Ending Balance</td>
		</tr>
		<tr>
			<td class="table_header-2 nama_kas">TOTAL</td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_kas_total->starting_balance)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_kas_total->total_kredit)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah(-$finance_kas_total->total_debit)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_kas_total->ending_balance)?></td>
		</tr>
	</table>
</div>