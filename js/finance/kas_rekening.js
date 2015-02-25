// Fungsi - fungsi load view dengan parameter get
function reload_kas_rekening()
{
	get_kas_rekening_checked();
	$("#form_add_finance_transaksi_kas_rekening").submit();
}

// function load_kas_rekening_view_change_kas()
// {
	// get_kas_rekening_checked();
    // reload_kas_rekening();
// }

function prev_session()
{
	$("#session_tutup_buku_no").val(parseInt($("#session_tutup_buku_no").val()) - 1);
    reload_kas_rekening();
}

function next_session()
{
	$("#session_tutup_buku_no").val(parseInt($("#session_tutup_buku_no").val()) + 1);
    reload_kas_rekening();
}

function add_finance_transaksi_kas_rekening()
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
			tipe_kas : "rekening"
		},
		success: function(result){
			//load_kas_rekening_view_change_kas();
			// self.location.reload();
			reload_kas_rekening();
		}
	});
}

function get_kas_rekening_checked()
{
	kas_rekening_limit = $("#kas_rekening_limit").val();
	str_array_kas_rekening_selected = "";
	for (i=0; i<kas_rekening_limit; i++)
	{
		id_finance_kas_rekening_cur = $("#finance_kas_rekening-"+i).val();
		if ($("#finance_kas_rekening-"+i).is(":checked"))
		{
			str_array_kas_rekening_selected += id_finance_kas_rekening_cur + "-";
		}
	}
	
	$("#str_array_kas_rekening_selected").val(str_array_kas_rekening_selected);
}