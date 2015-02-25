function do_migrasi_alokasi()
{
    $.ajax({
		type: 'POST',
		url: "do_migrasi_alokasi/",
		data:
		{
			id_alokasi_sumber : ""+$("#id_alokasi_sumber").val(),
			tipe_alokasi_sumber : ""+$("#tipe_alokasi_sumber").val(),
			jumlah : ""+$("#jumlah").val(),
			id_alokasi_tujuan : ""+$("#id_alokasi_tujuan").val(),
			tipe_alokasi_tujuan : ""+$("#tipe_alokasi_tujuan").val(),
			keterangan : ""+$("#keterangan").val()
		},
		success: function(result){
			$("#form_alokasi_migrasi").submit();
		}
	});
}