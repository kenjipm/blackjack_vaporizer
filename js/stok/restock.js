$(document).ready(function(){
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
	
	$("[id|=menu_nama]").focusout(function(){
		if ($(this).val() != "")
		{
			//if ($(this).val() != $(this).attr("default_value"))
			//{
				check_nama_menu($(this).attr('krow'), $(this).val());
			//}
		}
		else
		{
			reset_menu_attribute_value($(this).attr('krow'));
		}
	});
	
	$("[id|=menu_tipe]").focusout(function(){
		//if (($(this).val() != "") && ($(this).attr("default_value") != ""))
		{
			check_changed(this);
		}
	});
	
	$("[id|=menu_jml]").focusout(function(){
		if ($(this).val() != "")
		{
			update_harga_total($(this).attr('krow'));
		}
	});
	
	$("[id|=menu_harga_jual]").focusout(function(){
		//if (($(this).val() != "") && ($(this).attr("default_value") != ""))
		{
			check_changed(this);
		}
	});
	
	$("[id|=menu_harga_default]").focusout(function(){
		if ($(this).val() != "")
		{
			update_discount_rp($(this).attr('krow'));
			update_harga_total($(this).attr('krow'));
		}
		check_changed(this);
	});
	
	$("[id|=menu_discount_rp]").focusout(function(){
		if ($(this).val() != "")
		{
			update_discount($(this).attr('krow'));
			update_harga($(this).attr('krow'));
			update_harga_total($(this).attr('krow'));
		}
		check_changed(this);
	});
	
	$("[id|=menu_discount]").focusout(function(){
		if ($(this).val() != "")
		{
			update_discount_rp($(this).attr('krow'));
			update_harga($(this).attr('krow'));
			update_harga_total($(this).attr('krow'));
		}
		check_changed(this);
	});
	
	$("[id|=menu_harga]").focusout(function(){
		if ($(this).val() != "")
		{
			update_discount_rp_from_harga($(this).attr('krow'));
			update_discount($(this).attr('krow'));
			update_harga_total($(this).attr('krow'));
		}
		check_changed(this);
	});
	
	$("#supplier").change(function(){
		get_dana_tersimpan($(this).val());
	});
	
	$("[id|=menu_harga_default], [id|=menu_discount], [id|=menu_discount_rp], [id|=menu_harga]").change(function(){
	});
});

function get_detail_barang(krow, nama_barang)
{
	$.ajax({
		type: 'POST',
		url: "get_detail_barang",
		data: {
				"nama_barang": nama_barang
			  },
		success: function(result){
			result_array = result.split("###");
			if (result_array[2] != "")
			{
				tipe = result_array[0];
				harga_jual = result_array[1];
				harga_default = result_array[2];
				harga_base = result_array[3];
				discount_rp = harga_default - harga_base;
				discount = discount_rp / harga_default * 100;
				
				$("#menu_tipe-"+krow).val(tipe);
				$("#menu_harga_jual-"+krow).val(harga_jual);
				$("#menu_harga_default-"+krow).val(harga_default);
				$("#menu_harga-"+krow).val(harga_base);
				$("#menu_discount-"+krow).val(discount);
				$("#menu_discount_rp-"+krow).val(discount_rp);
				
				$("#menu_tipe-"+krow).attr("default_value", tipe);
				$("#menu_harga_jual-"+krow).attr("default_value", harga_jual);
				$("#menu_harga_default-"+krow).attr("default_value", harga_default);
				$("#menu_harga-"+krow).attr("default_value", harga_base);
				$("#menu_discount-"+krow).attr("default_value", discount);
				$("#menu_discount_rp-"+krow).attr("default_value", discount_rp);
				
				$("#menu_nama-"+krow).attr("default_value", nama_barang);
				
				update_harga_total(krow);
			}
		}
	});
}

function update_harga_total(krow)
{
	jml = $("#menu_jml-"+krow).val();
	harga = $("#menu_harga-"+krow).val();
	
	$("#menu_harga_total-"+krow).val(jml * harga);
}

function update_harga(krow)
{
	harga_default = $("#menu_harga_default-"+krow).val();
	discount_rp = $("#menu_discount_rp-"+krow).val();
	
	$("#menu_harga-"+krow).val(harga_default - discount_rp);
	check_changed("#menu_harga-"+krow);
}

function update_discount_rp(krow)
{
	harga_default = $("#menu_harga_default-"+krow).val();
	discount = $("#menu_discount-"+krow).val();
	
	$("#menu_discount_rp-"+krow).val(discount / 100 * harga_default);
	check_changed("#menu_discount_rp-"+krow);
}

function update_discount_rp_from_harga(krow)
{
	harga_default = $("#menu_harga_default-"+krow).val();
	harga = $("#menu_harga-"+krow).val();
	
	$("#menu_discount_rp-"+krow).val(harga_default - harga);
	check_changed("#menu_discount_rp-"+krow);
}

function update_discount(krow)
{
	harga_default = $("#menu_harga_default-"+krow).val();
	discount_rp = $("#menu_discount_rp-"+krow).val();
	
	$("#menu_discount-"+krow).val(discount_rp / harga_default * 100);
	check_changed("#menu_discount-"+krow);
}

function check_changed(element_id)
{
	if ($(element_id).val() != $(element_id).attr("default_value"))
	{
		$(element_id).addClass("changed");
	}
	else
	{
		$(element_id).removeClass("changed");
	}
}

function check_nama_menu(krow, nama_menu)
{
    //cek dulu namanya
    $.ajax({
        type: 'POST',
        url: "check_nama_menu/",
        data: {nama: nama_menu},
        success: function(result){
			element_id = "#menu_nama-"+krow;
            if (result == "false") //kalo nama blm ada
            {
                if(confirm("Tambah barang ["+nama_menu+"] ?"))
                {
					add_menu_nama_only(krow, nama_menu);
					$(element_id).addClass("changed");
				}
                else
                {
                    $(element_id).val("");
					$(element_id).removeClass("changed");
					
					reset_menu_attribute_value(krow);
                }
            }
			else if ($(element_id).val() != $(element_id).attr("default_value"))
			{
				get_detail_barang(krow, nama_menu);
				$(element_id).removeClass("changed");
			}
        }
    });
}

function add_menu_nama_only(krow, nama_menu)
{
    $.ajax({
        type: 'POST',
        url: "add_menu_nama_only/",
        data:
        {
            nama: nama_menu
        },
        success: function(result){
            alert("Barang ["+nama_menu+"] berhasil ditambahkan, silakan masukkan atribut lain untuk mengupdate barang");
			reset_menu_attribute_value(krow);
        }
    });
}

function reset_menu_attribute_value(krow)
{
	$("#menu_tipe-"+krow).val("");
	$("#menu_harga_jual-"+krow).val("");
	$("#menu_harga_default-"+krow).val("");
	$("#menu_harga-"+krow).val("");
	$("#menu_discount-"+krow).val("");
	$("#menu_discount_rp-"+krow).val("");
	$("#menu_harga_total-"+krow).val("");
				
	$("#menu_tipe-"+krow).attr("default_value", "");
	$("#menu_harga_jual-"+krow).attr("default_value", "");
	$("#menu_harga_default-"+krow).attr("default_value", "");
	$("#menu_harga-"+krow).attr("default_value", "");
	$("#menu_discount-"+krow).attr("default_value", "");
	$("#menu_discount_rp-"+krow).attr("default_value", "");
}

function count_belanja(menu_limit)
{
	harga_akhir = 0;
	for(i=0; i<menu_limit; i++)
	{
		harga_total_per_item = $("#menu_harga_total-"+i).val();
		if (harga_total_per_item != "")
		{
			harga_akhir += parseInt(harga_total_per_item);
		}
	}
	$("#harga_akhir").html("Harga Total : "+harga_akhir);
}

function buy_belanja()
{
	$("#form_menu_belanja").attr('action', 'do_belanja');
    $("#form_menu_belanja").attr('target', '');
    $("#form_menu_belanja").submit();
}

function get_dana_tersimpan(id_supplier)
{
	$.ajax({
        type: 'POST',
        url: "get_dana_tersimpan/",
        data:
        {
            id_supplier: id_supplier
        },
        success: function(result){
            $("#jumlah_dana_tersimpan").val(result);
        }
    });
}