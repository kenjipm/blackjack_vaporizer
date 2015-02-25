<div id="header_link">
    <a class="button" href="login/logout">Logout</a>
</div>
<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Admin</h2>
		</div>
    </div>
	
	<hr size=1/>
	<table>
		<tr>
			<td class="menu_label">Paket Barang : </td>
			<td>
				<input type="button" value="Tambah Paket" onclick="load_tambah_paket_view();"/>
				<input type="button" value="Lihat Paket" onclick="load_lihat_paket_view();"/>
			</td>
		</tr>
	</table>
	<hr size=1/>
	
    <iframe id="iframe_admin_view" name="admin_view" src="admin/tambah_paket_view"></iframe>
	
	<br/>
</div>