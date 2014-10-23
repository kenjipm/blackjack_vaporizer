<h2>Welcome, <?=$username?>!</h2>
<div id="header_link">
    <a class="button" href="login/logout">Logout</a>
</div>
<div id="body">
    <iframe id="order_list" name="order_list" src="kasir/order_list_view"></iframe>
    <iframe id="tambah_menu" name="tambah_menu" src="kasir/new_order_view"></iframe>
    <iframe id="payment" name="payment" src="kasir/payment_view"></iframe>
    <iframe id="print_nota" name="print_nota" style="display:none"></iframe>
    <!--iframe id="debug" name="debug"></iframe-->
</div>