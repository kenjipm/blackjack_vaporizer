<div id="header">
    <div id="header_content">
        <h2>Payment</h2>
        <!--input type="button" id="header_button_right" value="Clear" onclick="parent.reload_payment()"/-->
        <a class="button_image button_reset" onclick="parent.reload_payment()"></a>
    </div>
</div>
<div id="body">

<form id="form_order_payment" action="" target="" method="post">
    <input type="hidden" id="id_order" name="id_order" value="<?=$id_order?>"/>
    <input type="hidden" id="session_no" name="session_no" value="<?=$session_no?>"/>
    <input type="hidden" id="no_pembeli" name="no_pembeli" value="<?=$no_pembeli?>"/>
    <input type="hidden" id="jml_menu" name="jml_menu" value="<?=$jml_menu?>"/>

    #<span id="no_pembeli_display"><?=$no_pembeli?></span>
    <br/>

    <span class="label">Customer ID : </span> <input type="text" id="customer_id" name="customer_id" class="textbox" value="<?=$customer_id?>" readonly="readonly"/>
    <br/>
    <span class="label">Keterangan : </span> <input type="text" id="keterangan" name="keterangan" class="textbox" value="<?=$keterangan?>" readonly="readonly"/>
    <br/>
    <span class="label">Discount : </span> <input type="text" id="discount" name="discount" class="textbox" autocomplete="off"/> %

    <br/>
    <br/>
    <?php
        if ($id_order)
        {
            ?>
            <input type="button" value="Pay!" onclick="do_payment();"/>    
            <?php
        }
        else
        {
            ?>
            <input type="button" value="Order first, please :)" disabled="disabled"/>    
            <?php
        }
    ?>

    <br/>
    <br/>


    <table id="tabel_menu">
        <tr class="table_header">
            <td>Nama</td>
            <td>Jml</td>
            <td>Keterangan</td>
            <td>Initial Price</td>
            <td>Discount</td>
            <td>Price</td>
        </tr>
        <?php
            for ($i=0; $i<$jml_menu; $i++)
            {
                ?>
                <input type="hidden" name="menu_sequence-<?=$i?>" id="menu_sequence-<?=$i?>" value="<?=$menu['menu_sequence'][$i]?>">
                <tr class="table_row">
                    <td class="payment_nama"><input type="text" id="payment_nama-<?=$i?>" name="payment_nama-<?=$i?>" value="<?=$menu['nama'][$i]?>" readonly="readonly"></td>
                    <td class="payment_jml"><input type="text" id="payment_jml-<?=$i?>" name="payment_jml-<?=$i?>" value="<?=$menu['jml'][$i]?>" readonly="readonly"></td>
                    <td class="payment_keterangan"><input type="text" id="payment_keterangan-<?=$i?>" name="payment_keterangan-<?=$i?>" value="<?=$menu['keterangan'][$i]?>" readonly="readonly"></td>
                    <td class="payment_initial_price"><input type="text" id="payment_initial_price-<?=$i?>" name="payment_initial_price-<?=$i?>" value="<?=$menu['initial_price'][$i]?>" autocomplete="off"></td>
                    <td class="payment_discount"><input type="text" id="payment_discount-<?=$i?>" default_discounted="<?=$menu['default_discounted'][$i]?>" name="payment_discount-<?=$i?>" value="0" autocomplete="off">%</td>
                    <td class="payment_price"><input type="text" id="payment_price-<?=$i?>" name="payment_price-<?=$i?>" value="<?=$menu['initial_price'][$i]?>" num="<?=$i?>" autocomplete="off"></td>
                </tr>
                <?php
            }
        ?>
        <tr class="table_summary">
            <td class="summary_label" colspan="4">Subtotal :</td>
            <td colspan="2"><input type="text" readonly="readonly" id="payment_subtotal" name="payment_subtotal"></td>
        </tr>
        <tr class="table_summary">
            <td class="summary_label" colspan="4">Discount :</td>
            <td colspan="2"><input type="text" id="payment_total_discount" name="payment_total_discount" value="0" autocomplete="off"></td>
        </tr>
        <tr class="table_summary">
            <td class="summary_label" colspan="4">Total :</td>
            <td colspan="2"><input type="text" readonly="readonly" id="payment_total" name="payment_total"></td>
        </tr>
        <tr class="table_summary">
            <td class="summary_label" colspan="4">Pay :</td>
            <td colspan="2"><input type="text" id="payment_pay" name="payment_pay" autocomplete="off"></td>
        </tr>
        <tr class="table_summary">
            <td class="summary_label" colspan="4">Change :</td>
            <td colspan="2"><input type="text" readonly="readonly" id="payment_change" name="payment_change"></td>
        </tr>
        <tr class="table_summary">
            <td class="summary_label" colspan="6"><input type="button" class="semi_disabled" value="Exact Payment!" onclick="copy_total_payment();"/></td>
        </tr>
    </table>
	
              
</form>
</div>