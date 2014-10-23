$(document).ready(function()
{
	// $("[class|=menu_detail]").fadeOut();
	$("[class|=menu_detail]").hide();
	$("[class|=menu_setor_detail]").hide();
});

function toggle_menu(id)
{
	$(".menu_detail-"+id).toggle();
}

function toggle_menu_setor(it)
{
	$(".menu_setor_detail-"+it).toggle();
}

function next_session()
{
    $.ajax({
		type: 'POST',
		url: "laporan/next_session/",
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
		url: "laporan/prev_session/",
		data: "",
		success: function(result){
			location.reload();
		}
	});
}
