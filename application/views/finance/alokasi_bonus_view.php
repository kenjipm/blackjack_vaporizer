<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Alokasi Bonus</h2>
		</div>
    </div>
	<hr size=1/>
	<h3>Overview</h3>
	<table>
		<tr>
			<td class="table_header">Jenis Bonus</td>
			<td class="table_header">Jumlah</td>
		</tr>
		<tr>
			<td class="first_row nama_kas">Revenue Perusahaan</td>
			<td class="harga"><?=$text_renderer->to_rupiah($bonus['revenue'])?></td>
		</tr>
		<tr>
			<td class="first_row nama_kas">Incentive</td>
			<td class="harga"><?=$text_renderer->to_rupiah($bonus['incentive_total'])?></td>
		</tr>
		<tr>
			<td class="first_row nama_kas">Poin Customer</td>
			<td class="harga"><?=$text_renderer->to_rupiah($bonus['poin_total'])?></td>
		</tr>
		<!--tr>
			<td class="table_header-2 nama_kas">Unallocated</td>
			<td class="harga"><?=$text_renderer->to_rupiah($bonus['unallocated'])?></td>
		</tr-->
		<tr>
			<td class="table_header-2 nama_kas">TOTAL</td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($bonus['revenue'] + $bonus['incentive_total'] + $bonus['poin_total'])?></td>
		</tr>
	</table>
	
	<hr size=1/>
	<h3>Incentive</h3>
	<table>
		<tr>
			<td class="table_header">Member</td>
			<td class="table_header">Jumlah</td>
		</tr>
		<?php
		foreach ($bonus['incentive'] as $customer_id => $customer)
		{
			?>
			<tr>
				<td class="first_row item"><?=$customer->nama." (".$customer_id.")"?></td>
				<td class="harga"><?=$text_renderer->to_rupiah($customer->jumlah)?></td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td class="table_header-2">TOTAL</td>
			<td class="table_header-2 harga"><?=$text_renderer->to_rupiah($bonus['incentive_total'])?></td>
		</tr>
	</table>
	<br/>
</div>