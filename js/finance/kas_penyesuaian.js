function sesuaikan_finance_transaksi_kas(tipe_kas, id_tipe_kas)
{
    $.ajax({
		type: 'POST',
		url: "set_finance_kas/",
		data:
		{
			tipe_kas : tipe_kas,
			id_tipe_kas : id_tipe_kas,
			id_alokasi : ""+$("#"+tipe_kas+"-alokasi-"+id_tipe_kas).val(),
			jumlah_sesuai : ""+$("#"+tipe_kas+"-jumlah-"+id_tipe_kas).val(),
			keterangan : ""+$("#"+tipe_kas+"-keterangan-"+id_tipe_kas).val()
		},
		success: function(result){
			$("#form_sesuaikan_finance_transaksi_kas_"+tipe_kas).submit();
		}
	});
}