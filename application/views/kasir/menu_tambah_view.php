<div id="header">
    <div id="header_content">
        <h2>New Order</h2>
        <!--input type="button" id="header_button_right" value="Clear" onclick="parent.reload_tambah_menu()"/-->
        <a class="button_image button_reset" onclick="parent.reload_tambah_menu()"></a>
    </div>
</div>
<div id="body">

<form id="form_menu_tambah" action="" target="" method="post">
    <input type="hidden" id="id_order" name="id_order" value="<?=$id_order?>"/>
    <input type="hidden" id="tipe" name="tipe" value="<?=$tipe?>"/>
    <input type="hidden" id="session_no" name="session_no" value="<?=$session_no?>"/>
    <input type="hidden" id="no_pembeli" name="no_pembeli" value="<?=$no_pembeli?>"/>
    <input type="hidden" id="menu_limit" name="menu_limit" value="<?=$menu_limit?>"/>

	<span class="order_header">
		<?="#".$no_pembeli?>
		<br/>

		<span class="label">Customer ID : </span> <input type="text" id="customer_id" name="customer_id" class="textbox" value="<?=isset($customer_id)?$customer_id:""?>" <?=($tipe =="count")?"readonly='readonly'":""?> autocomplete="off"/>
		<br/>
		<span class="label">Keterangan : </span> <input type="text" id="keterangan" name="keterangan" class="textbox" value="<?=isset($keterangan)?$keterangan:""?>" <?=($tipe =="count")?"readonly='readonly'":""?> autocomplete="off"/>
		<br/>
		<center><span id="detail_customer" class="success"></span></center>
	</span>
	
    <br/>
    <br/>
    <?php /*<input type="button" class="button_left" value="&#171; Order!" onclick="order_to_list();" <?=$id_order?"disabled='disabled'":""?>/>*/ ?>
    <input type="button" class="button_mid" value="<?=($tipe =="edit")?"Edit & Count!":"Order & Count!"?>" onclick="<?=($tipe =="default")?"order_to_list();":"order_to_list_edit()"?>" <?=($tipe =="count")?"disabled='disabled'":""?>/>
    <input type="button" class="button_right" value="Count! &#187;" onclick="order_to_payment()"/>
    <br/>
    <br/>

    <table id="tabel_menu">
        <tr class="table_header">
            <td>Menu</td>
            <td>Jml</td>
            <td>Keterangan</td>
        </tr>
        <?php
			if ($tipe == "default") //kalo load biasa, kosongin semua
            {
                for ($i=0; $i<$menu_limit; $i++)
                {
                    ?>
                    <input type="hidden" name="menu_sequence-<?=$i?>" id="menu_sequence-<?=$i?>" value="<?=$i?>">
                    <tr class="table_row">
                        <td class="menu_nama"><input type="text" name="menu_nama-<?=$i?>" id="menu_nama-<?=$i?>"></td>
                        <td class="menu_jml"><input type="text" name="menu_jml-<?=$i?>" id="menu_jml-<?=$i?>" value="1"></td>
                        <td class="menu_keterangan"><input type="text" name="menu_keterangan-<?=$i?>" id="menu_keterangan-<?=$i?>"></td>
                    </tr>
                    <?php
                }
            }
			else if ($tipe == "edit") //kalo edit order
            {
                $i=0;
                foreach ($menus as $menu)
                {
                    ?>
                    <input type="hidden" name="menu_sequence-<?=$i?>" id="menu_sequence-<?=$i?>" value="<?=$menu['menu_sequence']?>">
                    <tr class="table_row">
                        <td class="menu_nama"><input type="text" name="menu_nama-<?=$i?>" id="menu_nama-<?=$i?>" value="<?=$menu['nama']?>"></td>
                        <td class="menu_jml"><input type="text" name="menu_jml-<?=$i?>" id="menu_jml-<?=$i?>"  value="<?=$menu['jml']?>"></td>
                        <td class="menu_keterangan"><input type="text" name="menu_keterangan-<?=$i?>" id="menu_keterangan-<?=$i?>" value="<?=$menu['keterangan']?>"></td>
                    </tr>
                    <?php
                    $i++;
                }
				$total_menu = $i;
                for ($i=$total_menu; $i<$menu_limit; $i++)
                {
                    ?>
                    <input type="hidden" name="menu_sequence-<?=$i?>" id="menu_sequence-<?=$i?>" value="<?=$i?>">
                    <tr class="table_row">
                        <td class="menu_nama"><input type="text" name="menu_nama-<?=$i?>" id="menu_nama-<?=$i?>"></td>
                        <td class="menu_jml"><input type="text" name="menu_jml-<?=$i?>" id="menu_jml-<?=$i?>" value="1"></td>
                        <td class="menu_keterangan"><input type="text" name="menu_keterangan-<?=$i?>" id="menu_keterangan-<?=$i?>"></td>
                    </tr>
                    <?php
                }
            }
            else if ($tipe == "count") //kalo dari order list, isi2in + ada order_menu id nya
            {
                $i=0;
                foreach ($menus as $menu)
                {
                    ?>
                    <input type="hidden" name="order_menu_id-<?=$i?>" id="order_menu_id-<?=$i?>" value="<?=$menu['id']?>">
                    <input type="hidden" name="menu_sequence-<?=$i?>" id="menu_sequence-<?=$i?>" value="<?=$menu['menu_sequence']?>">
                    <tr class="table_row">
                        <td class="menu_nama"><input type="text" name="menu_nama-<?=$i?>" id="menu_nama-<?=$i?>" value="<?=$menu['nama']?>" readonly="readonly"></td>
                        <td class="menu_jml"><input type="text" name="menu_jml-<?=$i?>" id="menu_jml-<?=$i?>"  value="<?=$menu['jml']?>" readonly="readonly"></td>
                        <td class="menu_keterangan"><input type="text" name="menu_keterangan-<?=$i?>" id="menu_keterangan-<?=$i?>" value="<?=$menu['keterangan']?>" readonly="readonly"></td>
                    </tr>
                    <?php
                    $i++;
                }
            }
        ?>
    </table>
</form>
</div>