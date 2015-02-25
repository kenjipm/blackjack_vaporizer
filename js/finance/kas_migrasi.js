function do_migrasi_kas()
{
    $.ajax({
		type: 'POST',
		url: "do_migrasi_kas/",
		data:
		{
			id_tipe_kas_sumber : ""+$("#id_tipe_kas_sumber").val(),
			jumlah : ""+$("#jumlah").val(),
			id_tipe_kas_tujuan : ""+$("#id_tipe_kas_tujuan").val(),
			keterangan : ""+$("#keterangan").val()
		},
		success: function(result){
			$("#form_kas_migrasi").submit();
		}
	});
}