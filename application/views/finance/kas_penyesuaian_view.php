<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Penyesuaian Finance</h2>
		</div>
    </div>
	
	<form action="kas_penyesuaian_view" method="post" target="finance_view" id="form_sesuaikan_finance_transaksi_kas_tunai">
	<hr size=1/>
	<h3>Kas Tunai</h3>
	<table>
		<tr>
			<td class="table_header">Nama Kas</td>
			<td class="table_header">Starting Balance</td>
			<td class="table_header">Total Kredit</td>
			<td class="table_header">Total Debit</td>
			<td class="table_header">Ending Balance</td>
			<td class="table_header">Penyesuaian Jumlah</td>
			<td class="table_header">Alokasi</td>
			<td class="table_header">Keterangan</td>
			<td class="table_header">Action</td>
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
				<td><input type="text" id="tunai-jumlah-<?=$finance_kas_tunai->id?>" name="tunai-jumlah-<?=$finance_kas_tunai->id?>" class="textbox" value=""/></td>
				<td>
					<select id="tunai-alokasi-<?=$finance_kas_tunai->id?>" name="tunai-alokasi-<?=$finance_kas_tunai->id?>">
					<?php
						foreach($finance_alokasis as $finance_alokasi)
						{
							?>
							<option value="<?=$finance_alokasi->id?>"><?=$finance_alokasi->nama?><?=$finance_alokasi->keterangan?" (".$finance_alokasi->keterangan.")":""?></option>
							<?php
						}
					?></select>
				</td>
				<td><input type="text" id="tunai-keterangan-<?=$finance_kas_tunai->id?>" name="tunai-keterangan-<?=$finance_kas_tunai->id?>" class="textbox" value=""/></td>
				<td><input type="button" value="Sesuaikan" onclick="sesuaikan_finance_transaksi_kas('tunai', '<?=$finance_kas_tunai->id?>')"/></td>
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
			<td class="table_header-2" colspan="4"></td>
		</tr>
	</table>
	</form>
	
	<form action="kas_penyesuaian_view" method="post" target="finance_view" id="form_sesuaikan_finance_transaksi_kas_rekening">
	<hr size=1/>
	<h3>Kas Rekening</h3>
	<table>
		<tr>
			<td class="table_header">Nama Kas</td>
			<td class="table_header">Starting Balance</td>
			<td class="table_header">Total Kredit</td>
			<td class="table_header">Total Debit</td>
			<td class="table_header">Ending Balance</td>
			<td class="table_header">Penyesuaian Jumlah</td>
			<td class="table_header">Alokasi</td>
			<td class="table_header">Keterangan</td>
			<td class="table_header">Action</td>
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
				<td><input type="text" id="rekening-jumlah-<?=$finance_kas_rekening->id?>" name="rekening-jumlah-<?=$finance_kas_rekening->id?>" class="textbox" value=""/></td>
				<td>
					<select id="rekening-alokasi-<?=$finance_kas_rekening->id?>" name="rekening-alokasi-<?=$finance_kas_rekening->id?>">
					<?php
						foreach($finance_alokasis as $finance_alokasi)
						{
							?>
							<option value="<?=$finance_alokasi->id?>"><?=$finance_alokasi->nama?><?=$finance_alokasi->keterangan?" (".$finance_alokasi->keterangan.")":""?></option>
							<?php
						}
					?></select>
				</td>
				<td><input type="text" id="rekening-keterangan-<?=$finance_kas_rekening->id?>" name="rekening-keterangan-<?=$finance_kas_rekening->id?>" class="textbox" value=""/></td>
				<td><input type="button" value="Sesuaikan" onclick="sesuaikan_finance_transaksi_kas('rekening', '<?=$finance_kas_rekening->id?>')"/></td>
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
			<td class="table_header-2" colspan="4"></td>
		</tr>
	</table>
	</form>
	
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