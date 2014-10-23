<div id="header">
    <div id="header_content">
        <h2>Order List</h2>
        <!--input type="button" id="header_button_right" class="button_refresh" value="Refresh" onclick="parent.reload_order_list()"/-->
        <a class="button_image button_refresh" onclick="parent.reload_order_list()"></a>
    </div>
</div>
<div id="body">
<input type="hidden" id="new_order_id" name="new_order_id" value="<?=$new_order_id?>"/>
<?php
    $anchor = true;
    foreach($orders as $order)
    {
        ?>
        <span <?=(!$order->done_all && $anchor)?"id='anchor'":""?>></span>
        <div id="order_id-"<?=$order->id?>>
        <form id="form_order_list-<?=$order->id?>" action="" target="" method="post">
            <input type="hidden" id="jml_menu" name="jml_menu" value="<?=count($order->menu)?>"/>
            <input type="hidden" id="id_order" name="id_order" value="<?=$order->id?>"/>
            <input type="hidden" id="no_pembeli" name="no_pembeli" value="<?=$order->no_pembeli?>"/>
            <input type="hidden" id="session_no" name="session_no" value="<?=$order->session_no?>"/>
            <input type="hidden" id="customer_id" name="customer_id" value="<?=$order->customer_id?>"/>
            <input type="hidden" id="keterangan" name="keterangan" value="<?=$order->keterangan?>"/>
            
			<span class="order_header">
				<span class="no_pembeli">#<?=$order->no_pembeli?></span>
				<span class="customer_nama"><?=$order->customer_nama?></span>
				<span class="customer_id">(<?=$order->customer_id?>)</span>
			</span>
			
			<span class="keterangan">
				<span class="waktu_order"><?="<".date("H:i:s", strtotime($order->waktu)).">"?></span>
			</span>
            
            <span class="paid_status">
                <span class="<?=$order->paid?"success":"failure"?>">
                    <?=$order->paid?"&#10004; Paid":"&#10008; Not Paid"?>
                </span>
            </span>
            
            <span class="keterangan"><?=$order->keterangan?"<br/>NB : ".$order->keterangan:""?></span>
            
            <div class="order_menu">
            <?php
                $i=0;
                foreach ($order->menu as $menu)
                {
                    ?>
                    <span class="done" ><input id="order_menu-<?=$menu->id_order_menu?>" type="checkbox" <?=$menu->done?"checked=\"checked\"":""?> onchange="set_menu_done('<?=$menu->id_order_menu?>')"/></span>
                    <input type="hidden" name="id_menu-<?=$i?>" id="id_menu-<?=$i?>" value="<?=$menu->id?>">
                    <input type="hidden" name="keterangan_order_menu-<?=$i?>" id="keterangan_order_menu-<?=$i?>" value="<?=$menu->keterangan?>">
                    <input type="hidden" name="menu_sequence-<?=$i?>" id="menu_sequence-<?=$i?>" value="<?=$menu->menu_sequence?>">
                    <span class="nama_menu"><?=$menu->nama?></span>
                    <span class="keterangan"><?=$menu->keterangan?"(".$menu->keterangan.")":""?></span>
					
                    <span class="success keterangan" id="time_elapsed-<?=$menu->id_order_menu?>"><?=$menu->time_elapsed?("<".$menu->time_elapsed." sec>"):""?></span>
                    <br/>
                    <?php
                    $i++;
                }
            ?>
            </div>
            <input type="button" class="button_left <?=$order->paid?"semi_disabled":""?>" value="Cancel" onclick="delete_order(<?=$order->id?>, '<?=$order->customer_id?>', <?=$order->paid?>)"/>
            <input type="button" class="button_mid <?=$order->paid?"semi_disabled":""?>" value="Edit &#187;" onclick="edit_order(<?=$order->id?>)"/>
            <input type="button" class="button_right <?=$order->paid?"semi_disabled":""?>" value="Count! &#187;" onclick="copy_to_new_order(<?=$order->id?>)"/>
        </form>
        <br/>
        <hr size="1"/>
        </div>
        <?php
    }
	if ($anchor)
	{
		?>
        <span id='anchor'></span>
		<?php
	}
?>
</div>