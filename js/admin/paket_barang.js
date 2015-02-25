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
	
	$.ajax({
		type: 'POST',
		url: "get_all_paket",
		data: "",
		dataType: "json",
		success: function(result){
			$("#nama_paket").autocomplete({
			  source: result
			});
		}
	});
	
	$("#nama_paket").focusout(function(){
		if ($(this).val() != "")
		{
			if ($(this).val() != $(this).attr("default_value"))
			{
				check_nama_paket($(this).val());
			}
			else
			{
				$("#button_tambah_paket").removeAttr("disabled");
			}
		}
		else
		{
			$(this).removeClass("changed");
			$("#button_tambah_paket").attr("disabled", "disabled");
		}
	});
	
	$("#keterangan").focusout(function(){
		check_changed(this);
	});
	
	$("[id|=menu_nama]").focusout(function(){
		if ($(this).val() != "")
		{
			check_nama_menu($(this).attr('krow'), $(this).val());
		}
		else
		{
			reset_menu_attribute_value($(this).attr('krow'));
		}
	});
	
	$("[id|=menu_jml]").focusout(function(){
		if ($(this).val() != "")
		{
			update_harga_total($(this).attr('krow'));
		}
	});
	
	$("[id|=menu_discount_rp]").focusout(function(){
		if ($(this).val() != "")
		{
			update_harga($(this).attr('krow'));
			update_harga_total($(this).attr('krow'));
		}
		check_changed(this);
	});
	
	$("[id|=menu_harga]").focusout(function(){
		if ($(this).val() != "")
		{
			update_discount_rp_from_harga($(this).attr('krow'));
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

function update_discount_rp_from_harga(krow)
{
	harga_default = $("#menu_harga_default-"+krow).val();
	harga = $("#menu_harga-"+krow).val();
	
	$("#menu_discount_rp-"+krow).val(harga_default - harga);
	check_changed("#menu_discount_rp-"+krow);
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
                alert('Nama barang tidak ditemukan');
				$(element_id).val("");
            }
			else if ($(this).val() != $(this).attr("default_value"))
			{
				get_detail_barang(krow, nama_menu);
			}
			$(element_id).removeClass("changed");
        }
    });
}

function check_nama_paket(nama_paket)
{
    //cek dulu namanya
    $.ajax({
        type: 'POST',
        url: "check_nama_paket/",
        data: {nama_paket: nama_paket},
        success: function(result){
			element_id = "#nama_paket";
            if (result == "false") //kalo nama blm ada
            {
                if(confirm("Tambah paket ["+nama_paket+"] ?"))
                {
					add_paket_nama_only(nama_paket);
					$(element_id).addClass("changed");
					$("#button_tambah_paket").removeAttr("disabled");
				}
                else
                {
                    $(element_id).val("");
					$(element_id).removeClass("changed");
					$("#button_tambah_paket").attr("disabled", "disabled");
                }
            }
			else
			{
				get_detail_paket(nama_paket);
				$(element_id).removeClass("changed");
				$("#button_tambah_paket").removeAttr("disabled");
				$("#button_tambah_paket").val("Update Paket!");
			}
        }
    });
}

function add_paket_nama_only(nama_paket)
{
    $.ajax({
        type: 'POST',
        url: "add_paket_nama_only/",
        data:
        {
            nama: nama_paket
        },
        success: function(result){
            alert("Paket ["+nama_paket+"] berhasil ditambahkan, silakan masukkan atribut lain untuk mengupdate paket");
			get_detail_paket(nama_paket);
        }
    });
}

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
			if (result_array[1] != "")
			{
				tipe = result_array[0];
				harga_default = result_array[1];
				harga = result_array[1];
				discount_rp = 0;
				
				$("#menu_tipe-"+krow).val(tipe);
				$("#menu_harga_default-"+krow).val(harga_default);
				$("#menu_discount_rp-"+krow).val(discount_rp);
				$("#menu_harga-"+krow).val(harga);
				
				$("#menu_discount_rp-"+krow).attr("default_value", discount_rp);
				$("#menu_harga-"+krow).attr("default_value", harga);
				
				update_harga_total(krow);
			}
		}
	});
}

function get_detail_paket(nama_paket)
{
	$.ajax({
		type: 'POST',
		url: "get_detail_paket",
		data: {
				nama_paket : nama_paket
			  },
		success: function(result){
			result_array = result.split("###");
			if (result_array[2] != "")
			{
				$("#nama_paket").attr("default_value", nama_paket);
				$("#id_paket").val(result_array[0]);
				$("#keterangan").val(result_array[1]);
				$("#keterangan").attr("default_value", result_array[1]);
				jumlah_menu_valid = parseInt(result_array[2]);
				i_index = 3;
				for(i=0; i < jumlah_menu_valid; i++)
				{
					nama = result_array[(i*5) + i_index]; i_index++;
					tipe = result_array[(i*5) + i_index]; i_index++;
					keterangan = result_array[(i*5) + i_index]; i_index++;
					harga_default = result_array[(i*5) + i_index]; i_index++;
					harga_akhir = result_array[(i*5) + i_index]; i_index = 3;
					discount_rp = harga_default - harga_akhir;
				
					$("#menu_nama-"+i).val(nama);
					$("#menu_tipe-"+i).val(tipe);
					$("#menu_keterangan-"+i).val(keterangan);
					$("#menu_harga_default-"+i).val(harga_default);
					$("#menu_discount_rp-"+i).val(discount_rp);
					$("#menu_harga-"+i).val(harga_akhir);
					
					$("#menu_nama-"+i).attr("default_value", nama);
					$("#menu_keterangan-"+i).attr("default_value", keterangan);
					$("#menu_discount_rp-"+i).attr("default_value", discount_rp);
					$("#menu_harga-"+i).attr("default_value", harga_akhir);
					
					update_harga_total(i);
					reset_changed(i);
				}
			}
		}
	});
}

function update_paket_menu()
{
	id_paket = $("#id_paket").val();
    $.ajax({
        type: 'POST',
        url: "delete_paket_menu_from_id_paket/",
        data: 
		{
			id_paket : id_paket
		},
        success: function(result){
		}
    });
    $("#form_add_paket_barang").attr('action', 'add_paket_menu');
    $("#form_add_paket_barang").attr('target', 'admin_view');
    $("#form_add_paket_barang").submit();
}

function add_paket_menu()
{
	/*nama_paket = $("#nama_paket").val();
	keterangan = $("#keterangan").val();
	menu_limit = $("#menu_limit").val();
    $.ajax({
        type: 'POST',
        url: "add_paket_menu/",
        data: 
		{
			nama_paket : nama_paket,
			keterangan : keterangan,
			menu_limit : menu_limit
		},
        success: function(result){
		}
    });*/
    $("#form_add_paket_barang").attr('action', 'add_paket_menu');
    $("#form_add_paket_barang").attr('target', 'admin_view');
    $("#form_add_paket_barang").submit();
}

function reset_menu_attribute_value(krow)
{
	$("#menu_tipe-"+krow).val("");
	$("#menu_harga_default-"+krow).val("");
	$("#menu_harga-"+krow).val("");
	$("#menu_discount_rp-"+krow).val("");
	$("#menu_harga_total-"+krow).val("");
	
	$("#menu_nama-"+krow).attr("default_value", "");
	$("#menu_keterangan-"+krow).attr("default_value", "");
	$("#menu_harga-"+krow).attr("default_value", "");
	$("#menu_discount_rp-"+krow).attr("default_value", "");
}

function reset_changed(krow)
{
	$("#menu_nama-"+krow).removeClass("changed");
	$("#menu_keterangan-"+krow).removeClass("changed");
	$("#menu_harga-"+krow).removeClass("changed");
	$("#menu_discount_rp-"+krow).removeClass("changed");
}

function add_paket_barang()
{
	$("#form_add_paket_barang").attr('action', 'add_paket_barang');
    $("#form_add_paket_barang").attr('target', '');
    $("#form_add_paket_barang").submit();
}

function count_paket(menu_limit)
{
	harga_paket = 0;
	for(i=0; i<menu_limit; i++)
	{
		harga_total_per_item = $("#menu_harga_total-"+i).val();
		if (harga_total_per_item != "")
		{
			harga_paket += parseInt(harga_total_per_item);
		}
	}
	$("#harga_paket").html("Harga Paket : "+harga_paket);
}