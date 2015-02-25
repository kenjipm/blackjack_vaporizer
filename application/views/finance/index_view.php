<div id="header_link">
    <a class="button" href="login/logout">Logout</a>
</div>
<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Finance</h2>
		</div>
    </div>
	
	<hr size=1/>
	<table>
		<tr>
			<td class="menu_label">Kas : </td>
			<td>
				<input type="button" value="Kas Overview" onclick="load_kas_overview_view();"/>
				<input type="button" value="Kas Tunai" onclick="load_kas_tunai_view();"/>
				<input type="button" value="Kas Rekening" onclick="load_kas_rekening_view();"/>
				<input type="button" value="Kas Piutang" onclick="load_kas_piutang_view();"/>
				<input type="button" value="Migrasi Kas" onclick="load_kas_migrasi_view();"/>
				<input type="button" value="Penyesuaian Finance" onclick="load_kas_penyesuaian_view();"/>
				<input type="button" value="Tutup Buku" onclick="load_tutup_buku_view();"/>
			</td>
		</tr>
		<tr>
			<td class="menu_label">Alokasi :</td>
			<td>
				<input type="button" value="Alokasi Overview" onclick="load_alokasi_overview_view();"/>
				<input type="button" value="Alokasi Modal" onclick="load_alokasi_modal_view();"/>
				<input type="button" value="Alokasi Bonus" onclick="load_alokasi_bonus_view();"/>
				<input type="button" value="Migrasi Alokasi" onclick="load_alokasi_migrasi_view();"/>
			</td>
		</tr>
		<tr>
			<td class="menu_label">Transaksi :</td>
			<td>
				<input type="button" value="Transaksi Overview" onclick="load_transaksi_overview_view();"/>
				<input type="button" value="Omzet" onclick="load_omzet_view();"/>
			</td>
		</tr>
	</table>
	<hr size=1/>
	
    <iframe id="iframe_finance_view" name="finance_view" src="finance/kas_overview_view"></iframe>
	
	<br/>
</div>