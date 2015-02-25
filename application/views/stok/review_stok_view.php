<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Review Stok</h2>
		</div>
    </div>
	
	<form id="form_review_stok" action="" target="" method="post">
		<input type="hidden" id="menu_limit" name="menu_limit" value="<?=$menu_limit?>"/>
		<table id="tabel_stok">
			<tr>
				<td class="table_header">Nama</td>
				<td class="table_header">Tipe 1</td>
				<td class="table_header">Tipe 2</td>
				<td class="table_header">Tipe 3</td>
				<td class="table_header">Harga</td>
				<td class="table_header">Harga Default</td>
				<td class="table_header">Harga Min</td>
				<td class="table_header">Harga Base</td>
				<td class="table_header">Stok</td>
				<td class="table_header">Action</td>
			</tr>
				<?php
					$i=0;
					foreach ($items as $item)
					{
						?>
							<input type="hidden" id="menu_id-<?=$i?>" name="menu_id-<?=$i?>" value="<?=$item->id?>"/>
							<tr>
								<td class="first_row menu_nama"><?=$item->nama?></td>
								<td class="menu_textbox"><input item_id=<?=$item->id?> type="text" id="tipe-<?=$item->id?>" name="tipe-<?=$item->id?>" class="textbox" value="<?=$item->tipe?>"/></td>
								<td class="menu_textbox"><input item_id=<?=$item->id?> type="text" id="tipe_2-<?=$item->id?>" name="tipe_2-<?=$item->id?>" class="textbox" value="<?=$item->tipe_2?>"/></td>
								<td class="menu_textbox"><input item_id=<?=$item->id?> type="text" id="tipe_3-<?=$item->id?>" name="tipe_3-<?=$item->id?>" class="textbox" value="<?=$item->tipe_3?>"/></td>
								<td class="menu_harga"><input item_id=<?=$item->id?> type="text" id="harga-<?=$item->id?>" name="harga-<?=$item->id?>" class="textbox" value="<?=$item->harga?>"/></td>
								<td class="menu_harga"><input item_id=<?=$item->id?> type="text" id="harga_default-<?=$item->id?>" name="harga_default-<?=$item->id?>" class="textbox" value="<?=$item->harga_default?>"/></td>
								<td class="menu_harga"><input item_id=<?=$item->id?> type="text" id="harga_min-<?=$item->id?>" name="harga_min-<?=$item->id?>" class="textbox" value="<?=$item->harga_min?>"/></td>
								<td class="menu_harga"><input item_id=<?=$item->id?> type="text" id="harga_base-<?=$item->id?>" name="harga_base-<?=$item->id?>" class="textbox" value="<?=$item->harga_base?>"/></td>
								<td class="menu_stok"><input item_id=<?=$item->id?> type="text" id="stok-<?=$item->id?>" name="stok-<?=$item->id?>" class="textbox" value="<?=$item->stok?>"/></td>
								<td class="menu_action"><input item_id=<?=$item->id?> type="checkbox" id="hidden-<?=$item->id?>" name="hidden-<?=$item->id?>" <?=$item->hidden?"checked=\"checked\"":""?> onchange="update_item_hidden('<?=$item->id?>')"/>Hide <input type="button" id="update_button-<?=$item->id?>" value="Update" class="semi_disabled" onclick="update_item(<?=$item->id?>)"/>&nbsp;<span id="action_status-<?=$item->id?>"></span></td>
							</tr>
						<?php
						$i++;
					}
			?>
		</table>
	</form>
	
</div>