<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Lihat paket<h2>
		</div>
    </div>
	
	<hr size=1/>
	<form action="paket_barang_view" method="post" target="admin_view" id="form_edit_paket_barang">
	<span class="label">Paket : </span><select id="id_finance_alokasi">
		<?php
			foreach($pakets as $paket)
			{
				?>
				<option value="<?=$paket->id?>"><?=$paket->nama?><?=$paket->keterangan?" (".$paket->keterangan.")":""?></option>
				<?php
			}
		?></select>&nbsp;&nbsp;
		<span class="label">Jumlah : </span> <input type="text" id="jumlah" name="jumlah" class="textbox" value=""/>&nbsp;&nbsp;
		<span class="label">Keterangan : </span> <input type="text" id="keterangan" name="keterangan" class="textbox" value=""/>&nbsp;&nbsp;
	</form>
	
	<form action="paket_barang_view" method="post" target="admin_view" id="form_add_paket_barang">
	<input type="hidden" id="menu_limit" name="menu_limit" value="<?=$menu_limit?>"/>
	
    <input type="button" class="button_right" value="Tambah" onclick="add_paket_barang()"/>
	
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