<script type='text/javascript' >
</script>

<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Restock</h2>
		</div>
    </div>
	<input type="hidden" id="menu_limit" value="<?=$menu_limit?>"/>
<form id="form_menu_belanja" action="" target="" method="post">

    <input type="hidden" id="menu_limit" name="menu_limit" value="<?=$menu_limit?>"/>
	
	<span class="order_header">
		<span class="label">Supplier : </span><select id="supplier">
			<?php
				foreach($suppliers as $supplier)
				{
					?>
					<option value="<?=$supplier->id?>" <?=($id_supplier_default == $supplier->id)?"selected=\"selected\"":""?>><?=$supplier->nama?><?=$supplier->keterangan?" (".$supplier->keterangan.")":""?></option>
					<?php
				}
			?></select>
		<span class="label">Keterangan : </span> <input type="text" id="keterangan" name="keterangan" class="textbox" value=""/>
		<span class="label">Pembayaran : </span><select id="tipe_pembayaran">
			<?php
				foreach($tunais as $tunai)
				{
					?>
					<option value="tunai-<?=$tunai->id?>">Tunai - <?=$tunai->nama?><?=$tunai->keterangan?" (".$tunai->keterangan.")":""?></option>
					<?php
				}
				foreach($rekenings as $rekening)
				{
					?>
					<option value="transfer-<?=$rekening->id?>" <?=($id_rekening_belanja_default == $rekening->id)?"selected=\"selected\"":""?>>Transfer - <?=$rekening->no_rek?> (<?=$rekening->nama?>)</option>
					<?php
				}
			?></select>
		<span class="label">Dana Tersimpan : </span> <input type="text" id="jumlah_dana_tersimpan" name="jumlah_dana_tersimpan" class="textbox" value="<?=$jumlah_dana_tersimpan?>" readonly="readonly"/><input type="checkbox" id="is_dana_tersimpan" name="is_dana_tersimpan" value="1">Pakai Dana Tersimpan
	</span>
	
    <br/>
    <br/>
    <input type="button" class="button_mid" value="Count! &#187;" onclick="count_belanja(<?=$menu_limit?>)"/>
    <input type="button" class="button_right" value="Buy! &#187;" onclick="buy_belanja()"/>
	<span id="harga_akhir"></span>
    <br/>
    <br/>

    <table id="tabel_menu">
        <tr>
            <td class="table_header">PO</td>
            <td class="table_header">Item</td>
            <td class="table_header">Jml</td>
            <td class="table_header">Tipe</td>
            <td class="table_header">Keterangan</td>
            <td class="table_header">Harga Default</td>
            <td class="table_header">Disc. %</td>
            <td class="table_header">Disc. Rp</td>
            <td class="table_header">Harga</td>
            <td class="table_header">Harga Total</td>
        </tr>
        <?php
			for ($i=0; $i<$menu_limit; $i++)
			{
				?>
				<input type="hidden" name="menu_sequence-<?=$i?>" id="menu_sequence-<?=$i?>" value="<?=$i?>">
				<tr class="table_row">
					<td class="menu_po"><input krow="<?=$i?>" type="checkbox" id="is_po-<?=$i?>" name="is_po-<?=$i?>" value="1"></td>
					<td class="menu_nama"><input krow="<?=$i?>" type="text" name="menu_nama-<?=$i?>" id="menu_nama-<?=$i?>" default_value=""></td>
					<td class="menu_jml"><input krow="<?=$i?>" type="text" name="menu_jml-<?=$i?>" id="menu_jml-<?=$i?>" value="1"></td>
					<td class="menu_tipe"><input krow="<?=$i?>" type="text" name="menu_tipe-<?=$i?>" id="menu_tipe-<?=$i?>" default_value=""></td>
					<td class="menu_keterangan"><input krow="<?=$i?>" type="text" name="menu_keterangan-<?=$i?>" id="menu_keterangan-<?=$i?>"></td>
					<td class="menu_harga_default input_harga"><input krow="<?=$i?>" type="text" name="menu_harga_default-<?=$i?>" id="menu_harga_default-<?=$i?>" default_value=""></td>
					<td class="menu_discount"><input krow="<?=$i?>" type="text" name="menu_discount-<?=$i?>" id="menu_discount-<?=$i?>" default_value=""> %</td>
					<td class="menu_discount_rp input_harga"><input krow="<?=$i?>" type="text" name="menu_discount_rp-<?=$i?>" id="menu_discount_rp-<?=$i?>" default_value=""></td>
					<td class="menu_harga input_harga"><input krow="<?=$i?>" type="text" name="menu_harga-<?=$i?>" id="menu_harga-<?=$i?>" default_value=""></td>
					<td class="menu_harga_total input_harga"><input krow="<?=$i?>" type="text" name="menu_harga_total-<?=$i?>" id="menu_harga_total-<?=$i?>" readonly="readonly"></td>
				</tr>
				<?php
			}
        ?>
    </table>
</form>
</div>