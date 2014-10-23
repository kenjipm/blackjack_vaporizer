<div id="header_link">
    <a class="button" href="login/logout">Logout</a>
</div>
<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Stok</h2>
		</div>
    </div>
	
	<input type="button" value="Restock" onclick="load_restock_view();"/>
	<input type="button" value="Histori Restock" onclick="load_histori_restock_view();"/>
	<input type="button" value="Penyesuaian Stok" onclick="load_penyesuaian_stok_view();"/>
	<input type="button" value="Stok Belanja" onclick="load_belanja_view();"/>
	<input type="button" value="Stok Penjualan" onclick="load_penjualan_view();"/>
	
	<br/>
	
	
    <iframe id="iframe_stok_view" name="stok_view" src="stok/restock_view"></iframe>
	
	<br/>
</div>