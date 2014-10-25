<div id="body">
    <div id="header">
		<div id="header_content">
			<h2>Penyesuaian Stok</h2>
		</div>
    </div>
	
	<form id="form_penyesuaian_stok" action="" target="" method="post">
		<input type="hidden" id="menu_limit" name="menu_limit" value="<?=$menu_limit?>"/>
		
		<input type="button" value="&#8592; Prev Session" onclick="prev_session()"/>
		<input type="button" value="Next Session &#8594;" onclick="next_session()"/>
		<br/>
		
		<span class="label">Keterangan : </span> <input type="text" id="keterangan" name="keterangan" class="textbox" value="<?=$keterangan?>" <?=$is_session_locked?"disabled=\"disabled\"":""?>/>
		<?php
			if (!$is_session_locked)
			{
				?>
				<input type="button" class="button_right" value="Update! &#187;" onclick="do_penyesuaian_stok()"/>
				<?php
			}
		?>
		<table id="tabel_stok">
			<tr>
				<td class="table_header">Barang</td>
				<td class="table_header">Stok Data</td>
				<td class="table_header">Stok Real</td>
				<td class="table_header">Keterangan</td>
			</tr>
				<?php
					$i=0;
					foreach ($items as $item)
					{
						?>
							<input type="hidden" id="menu_id-<?=$i?>" name="menu_id-<?=$i?>" value="<?=$item->id?>"/>
							<tr>
								<td class="first_row menu_nama"><?=$item->nama?></td>
								<td class="stok"><input krow=<?=$i?> type="text" id="stok_data-<?=$i?>" name="stok_data-<?=$i?>" class="textbox" value="<?=$is_session_locked?$item->stok_data:$item->stok?>" readonly="readonly"/></td>
								<td class="stok"><input krow=<?=$i?> type="text" id="stok_real-<?=$i?>" name="stok_real-<?=$i?>" class="textbox" value="<?=$is_session_locked?$item->stok_real:""?>" <?=$is_session_locked?"disabled=\"disabled\"":""?>/></td>
								<td class="keterangan"><input krow=<?=$i?> type="text" id="keterangan-<?=$i?>" name="keterangan-<?=$i?>" class="textbox" value="<?=$is_session_locked?$item->keterangan:""?>" <?=$is_session_locked?"disabled=\"disabled\"":""?>/></td>
							</tr>
						<?php
						$i++;
					}
			?>
		</table>
	</form>
	
</div>