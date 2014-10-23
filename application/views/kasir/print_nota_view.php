<!DOCTYPE html>
<html lang='en'>
    <head>
        <link rel='stylesheet' href='<?=base_url();?>css/kasir/print_nota.css' type='text/css'/>
        <script type='text/javascript' src='<?=base_url();?>js/jquery-1.9.1.min.js'></script>
        <script type='text/javascript'>
            $(document).ready(function(){
                //print_struk
				var DocumentContainer = document.getElementById("print_area");
                var WindowObject = window.open("", "PrintWindow", "width=300,height=300,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
                WindowObject.document.writeln("<link rel='stylesheet' href='<?=base_url();?>css/kasir/print_nota.css' type='text/css' media='print'/>");
                WindowObject.document.writeln(DocumentContainer.innerHTML);
                WindowObject.document.close();
                WindowObject.focus();
                WindowObject.print();
                WindowObject.close();
            });
        </script>
    </head>
    <body>
        <div id="print_area">
            <div id="header_nota">
				<img id="logo" src="../img/logo.png" alt="" />
				<div id="header_except_logo">
					<span id="company_name">BLACKJACK VAPORIZER</span>
					<span id="label_user_header"><?=$user->header?"<br/>":""?></span><span id="user_header"><?=$user->header?></span>
					<br/>
					<span id="label_alamat"></span><span id="alamat"><?=$user->alamat?></span>
					<span id="label_kota"><?=$user->kota?", ":""?></span><span id="kota"><?=$user->kota?></span>
					<span id="label_telepon"><?=$user->telepon?", ":""?></span><span id="telepon"><?=$user->telepon?></span>
					<span id="label_user_header2"><?=$user->header2?"<br/>":""?></span><span id="user_header2"><?=$user->header2?></span>
					<br/>
					<span id="label_nama_kasir">Cashier : </span><span id="nama_kasir"><?=$user->username?></span>
				</div>
            </div>
			
			<?php for($dash=0;$dash<40;$dash++) echo "&#9472;";?>
            
			<div id="start_nota">
				<span id="label_id_customer"></span><span id="id_customer"><?=$customer_id?></span>
				<span id="label_nama_customer"></span><span id="nama_customer">(<?=$customer_nama?>)</span>
				<span id="label_keterangan"><?=$keterangan?", ":""?></span><span id="keterangan"><?=$keterangan?></span>
            </div>
			
            <br/>

            <table id="tabel_menu">
                <tr class="table_header">
                    <td>Item</td>
                    <td>Qty</td>
                    <td class="price">Price</td>
                </tr>
                <?php
                    for ($i=0; $i<$jml_menu; $i++)
                    {
                        ?>
                        <tr class="table_row">
                            <td class="payment_nama"><?=$order_menu[$i]['nama']?><span id="payment_keterangan"><?=($order_menu[$i]['keterangan']?" (".$order_menu[$i]['keterangan'].")":"")?></span></td>
                            <td class="payment_jml"><?=$order_menu[$i]['jml']?></td>
                            <td class="price payment_initial_price"><?=$order_menu[$i]['harga_awal']?></td>
                        </tr>
                        <?php
                    }
                ?>
                <tr class="table_summary">
                    <td class="summary_label" colspan="2"></td>
                    <td class="price" id="payment_separator"><?php for($dash=0;$dash<8;$dash++) echo "&#9472;";?></td>
                </tr>
                <?php
					if ($payment_total_discount_value != 0)
					{
						?>
						<tr class="table_summary">
							<td class="summary_label" colspan="2">Subtotal :</td>
							<td class="price" id="payment_subtotal"><?=$payment_subtotal?></td>
						</tr>
						<tr class="table_summary">
							<td class="summary_label" colspan="2">Discount :</td>
							<td class="price" id="payment_total_discount"><?=$payment_total_discount?></td>
						</tr>
						<?php
					}
				?>
                <tr class="table_summary">
                    <td class="summary_label" colspan="2">Total :</td>
                    <td class="price" id="payment_total"><?=$payment_total?></td>
                </tr>
                <tr class="table_summary">
                    <td class="summary_label" colspan="2">Pay :</td>
                    <td class="price" id="payment_pay"><?=$payment_pay?></td>
                </tr>
                <tr class="table_summary">
                    <td class="summary_label" colspan="2">Change :</td>
                    <td class="price" id="payment_change"><?=$payment_change?></td>
                </tr>
            </table>
            
			<?php for($dash=0;$dash<40;$dash++) echo "&#9472;";?>
			
            <div id="footer_nota">
				<span id="label_footer"></span><span id="footer"><?=$user->footer?></span>
				<span id="label_user_footer2"><?=$user->footer2?"<br/>":""?></span><span id="user_footer2"><?=$user->footer2?></span>
				<br/>
				<span id="tanggal"><?=$tgl?></span>
				<?php
				/*<br/>
				<span id="label_no_pembeli_display">#</span><span id="no_pembeli_display"><?=$no_pembeli?></span>*/?>
            </div>
        </div>
	</body>
</html>