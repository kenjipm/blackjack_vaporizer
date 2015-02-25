<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Kas Tunai (Periode <?=$str_periode_awal?> - <?=$str_periode_akhir?>)</h2>
			<input type="button" value="&#8592; Prev Session" onclick="prev_session()" <?=$is_prev_session?"":"disabled=\"disabled\""?>/>
			<input type="button" value="Next Session &#8594;" onclick="next_session()" <?=$is_next_session?"":"disabled=\"disabled\""?>/>
		</div>
    </div>
	
	<form action="kas_rekening_view" method="post" target="finance_view" id="form_add_finance_transaksi_kas_rekening">
	<input type="hidden" id="session_tutup_buku_no" name="session_tutup_buku_no" value="<?=$session_tutup_buku_no?>"/>
	<input type="hidden" id="str_array_kas_rekening_selected" name="str_array_kas_rekening_selected" value=""/>
	<input type="hidden" id="kas_rekening_limit" name="kas_rekening_limit" value="<?=$kas_rekening_limit?>"/>
	
	<?php
	if (!$is_session_locked)
	{
		?>
		<hr size=1/>
		<h3>Masukkan data</h3>
		<span class="label">Kas : </span><select id="id_tipe_kas">
		<?php
			foreach($finance_kas_rekenings as $finance_kas_rekening)
			{
				?>
				<option value="<?=$finance_kas_rekening->id?>"><?=$finance_kas_rekening->nama?><?=$finance_kas_rekening->no_rek?" (".$finance_kas_rekening->no_rek.")":""?></option>
				<?php
			}
		?></select>&nbsp;&nbsp;
		<span class="label">Alokasi : </span><select id="id_finance_alokasi">
		<?php
			foreach($finance_alokasis as $finance_alokasi)
			{
				?>
				<option value="<?=$finance_alokasi->id?>"><?=$finance_alokasi->nama?><?=$finance_alokasi->keterangan?" (".$finance_alokasi->keterangan.")":""?></option>
				<?php
			}
		?></select>&nbsp;&nbsp;
		<span class="label">Jumlah : </span> <input type="text" id="jumlah" name="jumlah" class="textbox" value=""/>&nbsp;&nbsp;
		<span class="label">Keterangan : </span> <input type="text" id="keterangan" name="keterangan" class="textbox" value=""/>&nbsp;&nbsp;
		<input type="button" value="Masukkan" onclick="add_finance_transaksi_kas_rekening()"/>
		<?php
	}
	?>
	</form>
	
	<hr size=1/>
	<h3>Kas yang Ditampilkan</h3>
	<?php
	$i=0;
	foreach ($finance_kas_rekenings as $finance_kas_rekening)
	{
		?>
		<input type="checkbox" id="finance_kas_rekening-<?=$i?>" name="finance_kas_rekening" value="<?=$finance_kas_rekening->id?>" <?=$finance_kas_rekening->selected?"checked=\"checked\"":""?> onchange="reload_kas_rekening()"><?=$finance_kas_rekening->nama?><?=$finance_kas_rekening->no_rek?" (".$finance_kas_rekening->no_rek.")":""?>
		<?php
		$i++;
	}
	?>
	
	<hr size=1/>
	<h3>Overview</h3>
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
			if ($finance_kas_rekening->selected)
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
		}
		?>
		<tr>
			<td class="table_header-2 nama_kas">TOTAL</td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_kas_total->starting_balance)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_kas_total->total_kredit)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah(-$finance_kas_total->total_debit)?></td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($finance_kas_total->ending_balance)?></td>
		</tr>
	</table>
	
	<hr size=1/>
	<h3>Detail Transaksi</h3>
	<table>
		<tr>
			<td class="table_header" rowspan=2>Keterangan</td>
			<td class="table_header" rowspan=2>Transaksi Terkait</td>
			<td class="table_header" rowspan=2>Tanggal</td>
			<?php
			foreach ($finance_kas_rekenings as $finance_kas_rekening)
			{
				if ($finance_kas_rekening->selected)
				{
					?>
					<td class="table_header" colspan=3><?=$finance_kas_rekening->nama?><?=$finance_kas_rekening->no_rek?" (".$finance_kas_rekening->no_rek.")":""?></td>
					<?php
				}
			}
			?>
			<td class="table_header" rowspan=2>Total Balance</td>
		</tr>
		<tr>
			<?php
			$total_balance = 0;
			foreach ($finance_kas_rekenings as $finance_kas_rekening)
			{
				if ($finance_kas_rekening->selected)
				{
					$balance[$finance_kas_rekening->id] = $finance_kas_rekening->starting_balance;
					?>
					<td class="table_header-2">Income</td>
					<td class="table_header-2">Expense</td>
					<td class="table_header-2">Balance</td>
					<?php
					$total_balance += $finance_kas_rekening->starting_balance;
				}
			}
			?>
		</tr>
		<?php
		foreach ($finance_transaksi_kass as $finance_transaksi_kas)
		{
			?>
			<tr>
				<td class="first_row keterangan"><?=$finance_transaksi_kas->keterangan?></td>
				<td class="first_row keterangan"><?=$finance_transaksi_kas->transaksi_terkait?><?=$finance_transaksi_kas->id_transaksi_terkait?" #".$finance_transaksi_kas->id_transaksi_terkait:""?></td>
				<td class="first_row tanggal"><?=date_format(date_create($finance_transaksi_kas->waktu), "d M Y")?></td>
				<?php
				foreach ($finance_kas_rekenings as $finance_kas_rekening)
				{
					if ($finance_kas_rekening->selected)
					{
						if ($finance_transaksi_kas->id_tipe_kas == $finance_kas_rekening->id)
						{
							?>
							<td class="harga"><?=($finance_transaksi_kas->jumlah >= 0)?$text_renderer->to_rupiah($finance_transaksi_kas->jumlah):""?></td>
							<td class="harga"><?=($finance_transaksi_kas->jumlah < 0)?$text_renderer->to_rupiah(-$finance_transaksi_kas->jumlah):""?></td>
							<?php
								$balance[$finance_kas_rekening->id] += $finance_transaksi_kas->jumlah;
								$total_balance += $finance_transaksi_kas->jumlah;
							?>
							<td class="table_highlight harga"><?=$text_renderer->to_rupiah($balance[$finance_kas_rekening->id])?></td>
							<?php
						}
						else
						{
							?>
							<td class="harga"></td>
							<td class="harga"></td>
							<td class="table_highlight harga"><?=$text_renderer->to_rupiah($balance[$finance_kas_rekening->id])?></td>
							<?php
						}
					}
				}
				?>
				<td class="first_row harga"><?=$text_renderer->to_rupiah($total_balance)?></td>
			</tr>
			<?php
		}
		?>
	</table>
	
	<br/>
</div>