// Fungsi - fungsi load view dengan parameter get
function reload_kas_tunai()
{
	get_kas_tunai_checked();
	$("#form_add_finance_transaksi_kas_tunai").submit();
	// $.ajax({
		// type: 'POST',
		// url: "kas_tunai_view/",
		// data:
		// {
			// session_tutup_buku_no : session_tutup_buku_no,
			// str_array_kas_tunai_selected : str_array_kas_tunai_selected
		// },
		// success: function(result){
			// $("#form_add_finance_transaksi_kas_tunai").submit();
		// }
	// });
}

// function load_kas_tunai_view_change_kas()
// {
	// get_kas_tunai_checked();
    // reload_kas_tunai();
// }

function prev_session()
{
	$("#session_tutup_buku_no").val(parseInt($("#session_tutup_buku_no").val()) - 1);
    reload_kas_tunai();
}

function next_session()
{
	$("#session_tutup_buku_no").val(parseInt($("#session_tutup_buku_no").val()) + 1);
    reload_kas_tunai();
}

function add_finance_transaksi_kas_tunai()
{
    $.ajax({
		type: 'POST',
		url: "add_finance_transaksi_kas/",
		data:
		{
			id_tipe_kas : ""+$("#id_tipe_kas").val(),
			id_finance_alokasi : ""+$("#id_finance_alokasi").val(),
			jumlah : ""+$("#jumlah").val(),
			keterangan : ""+$("#keterangan").val(),
			tipe_kas : "tunai"
		},
		success: function(result){
			//load_kas_tunai_view_change_kas();
			// self.location.reload();
			reload_kas_tunai();
		}
	});
}

function get_kas_tunai_checked()
{
	kas_tunai_limit = $("#kas_tunai_limit").val();
	str_array_kas_tunai_selected = "";
	for (i=0; i<kas_tunai_limit; i++)
	{
		id_finance_kas_tunai_cur = $("#finance_kas_tunai-"+i).val();
		if ($("#finance_kas_tunai-"+i).is(":checked"))
		{
			str_array_kas_tunai_selected += id_finance_kas_tunai_cur + "-";
		}
	}
	
	$("#str_array_kas_tunai_selected").val(str_array_kas_tunai_selected);
}