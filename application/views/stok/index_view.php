<div id="header_link">
    <a class="button" href="login/logout">Logout</a>
</div>
<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Stok</h2>
		</div>
    </div>
	
	<hr size=1/>
	<table>
		<tr>
			<td class="menu_label">Restock : </td>
			<td>
				<input type="button" value="Restock" onclick="load_restock_view();"/>
				<input type="button" value="Histori Restock" onclick="load_histori_restock_view();"/>
			</td>
		</tr>
		<tr>
			<td class="menu_label">Rekap :</td>
			<td>
				<input type="button" value="Stok Belanja" onclick="load_belanja_view();"/>
				<input type="button" value="Stok Penjualan" onclick="load_penjualan_view();"/>
			</td>
		</tr>
		<tr>
			<td class="menu_label">Pengaturan :</td>
			<td>
				<input type="button" value="Review Stok" onclick="load_review_stok_view();"/>
				<input type="button" value="Penyesuaian Stok" onclick="load_penyesuaian_stok_view();"/>
			</td>
		</tr>
	</table>
	<hr size=1/>
	
    <iframe id="iframe_stok_view" name="stok_view" src=""></iframe>
	
	<br/>
</div>