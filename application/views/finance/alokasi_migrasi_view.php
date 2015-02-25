<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Migrasi Alokasi</h2>
		</div>
    </div>
	
	<form action="alokasi_migrasi_view" method="post" target="finance_view" id="form_alokasi_migrasi">
	
	<hr size=1/>
	<h3>Masukkan Data</h3>
	<span class="label">Alokasi Sumber</span> : <select id="id_alokasi_sumber">
	<?php
		foreach($finance_alokasis as $finance_alokasi)
		{
			?>
			<option value="<?=$finance_alokasi->id?>"><?=$finance_alokasi->nama?><?=$finance_alokasi->keterangan?" (".$finance_alokasi->keterangan.")":""?></option>
			<?php
		}
	?></select><br/>
	<span class="label">Tipe Sumber</span> : <input type="text" id="tipe_alokasi_sumber" name="tipe_alokasi_sumber" class="textbox" value=""/><br/>
	<span class="label">Jumlah</span> : <input type="text" id="jumlah" name="jumlah" class="textbox" value=""/><br/>
	<span class="label">Alokasi Tujuan</span> : <select id="id_alokasi_tujuan">
	<?php
		foreach($finance_alokasis as $finance_alokasi)
		{
			?>
			<option value="<?=$finance_alokasi->id?>"><?=$finance_alokasi->nama?><?=$finance_alokasi->keterangan?" (".$finance_alokasi->keterangan.")":""?></option>
			<?php
		}
	?></select><br/>
	<span class="label">Tipe Tujuan</span> : <input type="text" id="tipe_alokasi_tujuan" name="tipe_alokasi_tujuan" class="textbox" value=""/><br/>
	<span class="label">Keterangan</span> : <input type="text" id="keterangan" name="keterangan" class="textbox" value=""/><br/>
	<input type="button" value="Pindahkan" onclick="do_migrasi_alokasi()"/>
	</form>
	
	<hr size=1/>
	<h3>Alokasi</h3>
	<table>
		<tr>
			<td class="table_header">Nama Alokasi</td>
			<td class="table_header">Tipe Alokasi</td>
			<td class="table_header">Starting Balance</td>
			<td class="table_header">Total Kredit</td>
			<td class="table_header">Total Debit</td>
			<td class="table_header">Ending Balance</td>
		</tr>
		<?php
		foreach ($finance_alokasi_tipe as $id_key => $finance_alokasi_tipe_id)
		{
			?>
			<tr>
			<td class="first_row nama_kas" rowspan="<?=count($finance_alokasi_tipe_id)+1?>"><?=$finance_alokasi_tipe_total[$id_key]->nama?><?=$finance_alokasi_tipe_total[$id_key]->keterangan?" (".$finance_alokasi_tipe_total[$id_key]->keterangan.")":""?></td>
			<?php
			$start = true;
			foreach ($finance_alokasi_tipe_id as $finance_alokasi_tipe_nama => $finance_alokasi_tipe_cur)
			{
				if (!$start)
				{
					?> 
					<tr>
					<?php
				}
				else
				{
					$start = false;
				}
				?>
				<td class="first_row nama_kas"><?=$finance_alokasi_tipe_nama?></td>
				<td class="harga"><?=$text_renderer->to_rupiah($finance_alokasi_tipe_cur->starting_balance)?></td>
				<td class="harga"><?=$text_renderer->to_rupiah($finance_alokasi_tipe_cur->total_kredit)?></td>
				<td class="harga"><?=$text_renderer->to_rupiah(-$finance_alokasi_tipe_cur->total_debit)?></td>
				<td class="harga"><?=$text_renderer->to_rupiah($finance_alokasi_tipe_cur->ending_balance)?></td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td class="first_row nama_kas">TOTAL</td>
				<td class="first_row harga"><?=$text_renderer->to_rupiah($finance_alokasi_tipe_total[$id_key]->starting_balance)?></td>
				<td class="first_row harga"><?=$text_renderer->to_rupiah($finance_alokasi_tipe_total[$id_key]->total_kredit)?></td>
				<td class="first_row harga"><?=$text_renderer->to_rupiah(-$finance_alokasi_tipe_total[$id_key]->total_debit)?></td>
				<td class="first_row harga"><?=$text_renderer->to_rupiah($finance_alokasi_tipe_total[$id_key]->ending_balance)?></td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td class="table_header-2 nama_kas" colspan="2">TOTAL</td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_alokasi_total->starting_balance)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_alokasi_total->total_kredit)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah(-$finance_alokasi_total->total_debit)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_alokasi_total->ending_balance)?></td>
		</tr>
	</table>
</div>