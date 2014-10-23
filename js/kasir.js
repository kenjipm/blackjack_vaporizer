function reload_order_list()
{
    $('#order_list').attr('src', 'kasir/order_list_view');
}

function reload_tambah_menu()
{
    $('#tambah_menu').attr('src', 'kasir/new_order_view');
}

function reload_payment()
{
    $('#payment').attr('src', 'kasir/payment_view');
}

// function check_order_list_payment(session_no, no_pembeli)
// {
    // var exist = $("#order_unique-"+session_no+"-"+no_pembeli).length > 0;
    // if (!exist)
    // {
        // alert('Sepertinya pembayaran ini belum diorder, silakan lakukan order terlebih dahulu');
    // }
    // return exist;
// }

// function order_to_payment()
// {
    // //iframe id : order_list
    // //iframe id : tambah_menu
    // //iframe id : payment
    
    // // === Masuk2in dulu value2 di "new order" ke variabel === //
    // // var no_pembeli = $('#tambah_menu').contents().find('#no_pembeli').val();
    // // var menu_limit = $('#tambah_menu').contents().find('#menu_limit').val();
    // // var nama_customer = $('#tambah_menu').contents().find('#nama_customer').val();
    // // var keterangan = $('#tambah_menu').contents().find('#keterangan').val();
    
    
    // // === Masuk2in variabel sederhana ke payment === //
    // // $('#payment').contents().find('#nama_customer').val(nama_customer);
    // // $('#payment').contents().find('#no_pembeli').val(no_pembeli);
    // // $('#payment').contents().find('#no_pembeli_display').html(no_pembeli);
    // // $('#payment').contents().find('#keterangan').val(keterangan);
    
    // $("#form_menu_tambah").attr('action', 'order/kasir_payment');
    // $("#form_menu_tambah").attr('target', 'payment');
    // $("#form_menu_tambah").submit();
// }

/*
$(document).ready(function(){
    load_order_list();
    load_tambah_menu();
    load_payment();
});

function load_order_list()
{
    $.ajax({
		type: 'POST',
		url: "order/kasir_list/",
		data: "",
		success: function(result){
			$("#order_list").html(result);
		}
	});
}

function load_tambah_menu()
{
    $.ajax({
		type: 'POST',
		url: "menu/kasir_tambah/",
		data: "",
		success: function(result){
			$("#tambah_menu").html(result);
		}
	});
}

function load_payment()
{
    $.ajax({
		type: 'POST',
		url: "order/kasir_payment/",
		data: "",
		success: function(result){
			$("#payment").html(result);
		}
	});
}
*/
