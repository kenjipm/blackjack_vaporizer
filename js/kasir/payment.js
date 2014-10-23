$(document).ready(function(){
    $.ajax({
		type: 'POST',
		url: "get_all_nama",
		data: "",
        dataType: "json",
		success: function(result){
            $("[id|=payment_nama]").autocomplete({
              source: result
            });
		}
	});
    update_payment_subtotal();
    
    //overall discount
    $("#discount").keyup(function(){
        update_payment_discount();
    });
    //keyup event buat semua initial price
    $("[id|=payment_initial_price]").keyup(function(){
        update_payment_subtotal();
        update_payment_price();
    });
    //keyup event buat semua persenan discount
    $("[id|=payment_discount]").keyup(function(){
        update_payment_price();
    });
    //keyup event buat semua final price
    $("[id|=payment_price]").keyup(function(){
        update_payment_total_discount();
        update_payment_discount_from_price($(this).attr("num"));
    });
    //keyup event buat total discount
    $("#payment_total_discount").keyup(function(){
        update_payment_total();
    });
    //keyup event buat jumlah payment dr customer
    $("#payment_pay").keyup(function(){
        update_payment_change();
    });
});

function update_payment_discount()
{
    var discount = $("#discount").val();
    $("[id|=payment_discount][default_discounted=1]").val(discount);
    update_payment_price();
}

function update_payment_discount_from_price(menu_num)
{
    var initial_price = parseInt($("#payment_initial_price-"+menu_num).val());
    var price = parseInt($("#payment_price-"+menu_num).val());
    $("#payment_discount-"+menu_num).val(Math.floor(100*(initial_price - price)/initial_price));
}

function update_payment_price()
{
    var jml_menu = $("#jml_menu").val();
    var initial_price;
    for(i=0; i<jml_menu; i++)
    {
        initial_price = $("#payment_initial_price-"+i).val();
        discount = $("#payment_discount-"+i).val();
        $("#payment_price-"+i).val(Math.round(initial_price*(1-(discount/100))));
    }
    update_payment_total_discount();
}

function update_payment_subtotal()
{
    var jml_menu = $("#jml_menu").val();
    var subtotal = 0;
    for(i=0; i<jml_menu; i++)
    {
        subtotal += parseInt($("#payment_initial_price-"+i).val());
    }
    $("#payment_subtotal").val(subtotal);
    update_payment_price();
}

function update_payment_total_discount()
{
    var subtotal = isNaNtoZero(parseInt($("#payment_subtotal").val()));
    var final_price = 0;
    var jml_menu = $("#jml_menu").val();
    for(i=0; i<jml_menu; i++)
    {
        final_price += parseInt($("#payment_price-"+i).val());
    }
    $("#payment_total_discount").val(subtotal - final_price);
    update_payment_total();
}

function update_payment_total()
{
    var subtotal = isNaNtoZero(parseInt($("#payment_subtotal").val()));
    var total_discount = isNaNtoZero(parseInt($("#payment_total_discount").val()));
    $("#payment_total").val(subtotal - total_discount);
    update_payment_change();
}

function update_payment_change()
{
    var final_price = isNaNtoZero(parseInt($("#payment_total").val()));
    var pay = isNaNtoZero(parseInt($("#payment_pay").val()));
    $("#payment_change").val(pay - final_price);
}

function isNaNtoZero(val)
{
    return isNaN(val)?0:val;
}

function do_payment()
{
    if ($("#payment_change").val() >= 0) //kalo bayar mencukupi
    {
        $("#form_order_payment").attr('action', 'pay_order');
        $("#form_order_payment").attr('target', 'print_nota');
        $("#form_order_payment").submit();
        setTimeout(function(){
            parent.reload_order_list();
            parent.reload_tambah_menu();
        }, 3000);
    }
    else // kalo bayar ga cukup
    {
        alert("Pembayaran tidak mencukupi");
    }
}

function copy_total_payment()
{
	$("#payment_pay").val($("#payment_total").val());
	update_payment_change();
}

// function do_payment(session_no, no_pembeli)
// {
    // // //cek dulu apa di OK apa di cancel sama user, kalau blm ada ordernya
    // // var order_id = parent.check_order_list_payment(session_no, no_pembeli);
    // // if (order_id)
    // // {
        // //set order udah di paid dulu
        // $.ajax({
            // type: 'POST',
            // url: "pay_order/"+order_id,
            // data: "",
            // success: function(result){
                // //baru print nota
                // print_nota();
            // }
        // });
    // // }
// }

// function print_nota()
// {
    // $.ajax({
        // type: 'POST',
        // url: "pay_order/"+order_id,
        // data: "",
        // success: function(result){
            // var WindowObject = window.open("", "PrintWindow",
            // "width=300,height=300,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
            // WindowObject.document.writeln("<link rel='stylesheet' href='css/print_bon.css' type='text/css' media='print'/>");
            // WindowObject.document.writeln(result);
            // WindowObject.document.close();
            // WindowObject.focus();
            // WindowObject.print();
            // WindowObject.close();
        // }
    // });
// }




















