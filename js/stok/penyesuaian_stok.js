$(document).ready(function(){
	$("[id|=stok_real]").focusout(function(){
		check_stok_changed(krow);
	});
});

function check_stok_changed(krow)
{
	if (($("#stok_real-"+krow).val() == "") || ($("#stok_real-"+krow).val() == $("#stok_data-"+krow).val()))
	{
		$("#stok_real-"+krow).removeClass("changed");
	}
	else
	{
		$("#stok_real-"+krow).addClass("changed");
	}
}

function do_penyesuaian_stok()
{
	$("#form_penyesuaian_stok").attr('action', 'do_penyesuaian_stok');
    $("#form_penyesuaian_stok").attr('target', '');
    $("#form_penyesuaian_stok").submit();
}

function next_session()
{
    $.ajax({
		type: 'POST',
		url: "next_session_penyesuaian_stok/",
		data: "",
		success: function(result){
			location.reload();
		}
	});
}

function prev_session()
{
    $.ajax({
		type: 'POST',
		url: "prev_session_penyesuaian_stok/",
		data: "",
		success: function(result){
			location.reload();
		}
	});
}