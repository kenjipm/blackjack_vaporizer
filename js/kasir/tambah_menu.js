$(document).ready(function(){
    if ($("#tipe").val() != "count") // kalau default kosong, get all nama menu. kalo readonly mah kan ga usah
    {
        $.ajax({
            type: 'POST',
            url: "get_all_nama",
            data: "",
            dataType: "json",
            success: function(result){
                $("[id|=menu_nama]").autocomplete({
                  source: result
                });
            }
        });
        
        //
        $("[id|=menu_nama]").focusout(function(){
            if ($(this).val() != "")
            {
                check_nama_menu($(this).attr('id'), $(this).val());
            }
            
        });
		$("[id|=customer_id]").focusout(function(){
            if ($(this).val() != "")
            {
                check_customer_id($(this).attr('id'), $(this).val());
            }
        });
    }
    else // kalo count dari orderlist, lgsg forward ke payment
    {
        order_to_payment();
    }
});

function order_to_payment()
{
    $("#form_menu_tambah").attr('action', 'payment_view');
    $("#form_menu_tambah").attr('target', 'payment');
    $("#form_menu_tambah").submit();
}

function order_to_list()
{
    $("#form_menu_tambah").attr('action', 'kasir_add_order');
    $("#form_menu_tambah").attr('target', 'order_list');
    $("#form_menu_tambah").submit();
}

function order_to_list_edit()
{
    $.ajax({
        type: 'POST',
        url: "kasir_delete_order/"+$("#id_order").val(),
        data: "",
        success: function(result){}
    });
    $("#form_menu_tambah").attr('action', 'kasir_add_order');
    $("#form_menu_tambah").attr('target', 'order_list');
    $("#form_menu_tambah").submit();
}

//agak rese emang, tapi jarang2 lah sampe nambah menu gini mah. pelengkap aja
function check_nama_menu(element_id, nama_menu)
{
    //cek dulu namanya
    $.ajax({
        type: 'POST',
        url: "check_nama_menu/",
        data: {nama: nama_menu},
        success: function(result){
            if (result == "false") //kalo nama blm ada
            {
                if(confirm("Tambah menu ["+nama_menu+"] ?"))
                {
                    //masukkan harga
                    var harga_menu = prompt("Harga JUAL untuk menu ["+nama_menu+"] : ", "0");
                    if (harga_menu != null)
                    {
						var harga_min_menu = prompt("Harga MINIMUM untuk menu ["+nama_menu+"] : ", "0");
						if (harga_min_menu != null)
						{
							add_menu(element_id, nama_menu, harga_menu, harga_min_menu);
						}
						else
						{
							$("#"+element_id).val("");
						}
                    }
                    else
                    {
                        $("#"+element_id).val("");
                    }
                }
                else
                {
                    $("#"+element_id).val("");
                }
            }
        }
    });
}

function add_menu(element_id, nama_menu, harga_menu, harga_min_menu)
{
    $.ajax({
        type: 'POST',
        url: "add_menu/",
        data:
        {
            nama: nama_menu,
            harga: harga_menu,
            harga_min: harga_min_menu
        },
        success: function(result){
            alert("Menu ["+nama_menu+"] dengan harga ["+harga_menu+"] & harga minimum ["+harga_min_menu+"] berhasil ditambahkan");
        }
    });
}


function get_detail_customer(customer_id)
{
	$.ajax({
		type: 'POST',
		url: "get_detail_customer/",
		data: {id: customer_id},
		success: function(result){
			if (result == "false") //kalo error
			{
				$("#detail_customer").html("Mohon maaf, terjadi kesalahan sistem");
			}
			else
			{
				$("#detail_customer").html(result);
			}
		}
	});
}

function check_customer_id(element_id, customer_id)
{
    //cek dulu id nya
    $.ajax({
        type: 'POST',
        url: "check_customer_id/",
        data: {id: customer_id},
        success: function(result){
            if (result == "false") //kalo id blm ada
            {
                if(confirm("Daftarkan customer baru ["+customer_id+"] ?"))
                {
                    //masukkan harga
                    var nama = prompt(" ["+customer_id+"] Nama: ", "");
                    if (nama != null)
                    {
						tgl_lahir = "";
						alamat = "";
						no_ktp = "";
						customer_tipe = "";
						//perc_sharing_service = 0;
						reseller_customer_id = "";
						// var tgl_lahir = prompt(" ["+customer_id+"] Tgl Lahir (YYYY-MM-DD): ", "");
						// if (tgl_lahir != null)
						// {
							// var alamat = prompt(" ["+customer_id+"] Alamat: ", "");
							// if (alamat != null)
							// {
								// var no_ktp = prompt(" ["+customer_id+"] No KTP: ", "");
								// if (no_ktp != null)
								// {
									// var customer_tipe = prompt(" ["+customer_id+"] Tipe Customer (member / reseller): ", "");
									// if (customer_tipe != null)
									// {
										// var reseller_customer_id = prompt(" ["+customer_id+"] Reseller ID: ", "");
										// if (reseller_customer_id != null)
										// {
											add_customer(customer_id, nama, tgl_lahir, alamat, no_ktp, customer_tipe, reseller_customer_id);
											return 0;
										// }
									// }
								// }
							// }
						// }
                    }
                }
                // kalo ada yg gagal, ga return, masuk sini trs kosongin value nya
				$("#"+element_id).val("");
            }
			else //kalo id udah ada
			{
				get_detail_customer(customer_id);
			}
        }
    });
}


function add_customer(customer_id_customer, nama_customer, tgl_lahir_customer, alamat_customer, no_ktp_customer, customer_tipe_customer, reseller_customer_id_customer)
{
    $.ajax({
        type: 'POST',
        url: "add_customer/",
        data:
        {
            customer_id:			customer_id_customer,
            nama:					nama_customer,
            tgl_lahir:				tgl_lahir_customer,
            alamat:					alamat_customer,
            no_ktp:					no_ktp_customer,
            customer_tipe:			customer_tipe_customer,
            reseller_customer_id:	reseller_customer_id_customer,
        },
        success: function(result){
            alert("Customer Baru Berhasil Didaftarkan!\r\nCustomer ID : "+customer_id_customer+"\r\nNama : "+nama_customer+"\r\nTgl Lahir : "+tgl_lahir_customer+"\r\nAlamat : "+alamat_customer+"\r\nNo KTP : "+no_ktp_customer+"\r\nTipe Customer: "+customer_tipe_customer+"\r\nReseller ID : "+reseller_customer_id_customer+"");
			
			get_detail_customer(customer_id_customer);
        }
    });
}








