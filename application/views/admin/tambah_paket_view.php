<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Tambah paket<h2>
		</div>
    </div>
	
	<hr size=1/>
	<form action="paket_barang_view" method="post" target="admin_view" id="form_add_paket_barang">
	<input type="hidden" id="menu_limit" name="menu_limit" value="<?=$menu_limit?>"/>
	<input type="hidden" id="id_paket" name="id_paket" value=""/>
	
    <span class="label">Nama Paket : </span> <input type="text" id="nama_paket" name="nama_paket" class="textbox" value="" default_value=""/>&nbsp;&nbsp;
    <span class="label">Keterangan : </span> <input type="text" id="keterangan" name="keterangan" class="textbox" value="" default_value=""/>&nbsp;&nbsp;
    <input type="button" class="button_mid" value="Count! &#187;" onclick="count_paket(<?=$menu_limit?>)"/>
	<input type="button" id="button_tambah_paket" class="button_right" value="Tambah Paket!" onclick="update_paket_menu()" disabled="disabled"/>
	<span id="harga_paket"></span>
	<br/>
	<br/>
	
    <table id="tabel_menu">
        <tr>
            <td class="table_header">Item</td>
            <td class="table_header">Jml</td>
            <td class="table_header">Tipe</td>
            <td class="table_header">Keterangan</td>
            <td class="table_header">Harga Default</td>
            <td class="table_header">Disc. Rp</td>
            <td class="table_header">Harga Akhir</td>
            <td class="table_header">Harga Total</td>
        </tr>
        <?php
			for ($i=0; $i<$menu_limit; $i++)
			{
				?>
				<input type="hidden" name="menu_sequence-<?=$i?>" id="menu_sequence-<?=$i?>" value="<?=$i?>">
				<tr class="table_row">
					<td class="menu_nama"><input krow="<?=$i?>" type="text" name="menu_nama-<?=$i?>" id="menu_nama-<?=$i?>" default_value=""></td>
					<td class="menu_jml"><input krow="<?=$i?>" type="text" name="menu_jml-<?=$i?>" id="menu_jml-<?=$i?>" value="1"></td>
					<td class="menu_tipe"><input krow="<?=$i?>" type="text" name="menu_tipe-<?=$i?>" id="menu_tipe-<?=$i?>" readonly="readonly"></td>
					<td class="menu_keterangan"><input krow="<?=$i?>" type="text" name="menu_keterangan-<?=$i?>" id="menu_keterangan-<?=$i?>"></td>
					<td class="menu_harga_default input_harga"><input krow="<?=$i?>" type="text" name="menu_harga_default-<?=$i?>" id="menu_harga_default-<?=$i?>" default_value="" readonly="readonly"></td>
					<td class="menu_discount_rp input_harga"><input krow="<?=$i?>" type="text" name="menu_discount_rp-<?=$i?>" id="menu_discount_rp-<?=$i?>" default_value=""></td>
					<td class="menu_harga input_harga"><input krow="<?=$i?>" type="text" name="menu_harga-<?=$i?>" id="menu_harga-<?=$i?>" default_value=""></td>
					<td class="menu_harga_total input_harga"><input krow="<?=$i?>" type="text" name="menu_harga_total-<?=$i?>" id="menu_harga_total-<?=$i?>" readonly="readonly"></td>
				</tr>
				<?php
			}
        ?>
    </table>
	</form>
	
	<br/>
</div>