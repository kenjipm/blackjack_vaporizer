$(document).ready(function(){
	$("[id|=tipe], [id|=tipe_2], [id|=tipe_3], [id|=harga], [id|=harga_defaul], [id|=harga_min], [id|=harga_base], [id|=stok]").change(function(){
		$(this).addClass("changed");
		var item_id = $(this).attr("item_id");
		$("#update_button-"+item_id).removeClass("semi_disabled");
	});
});

function update_item_hidden(item_id)
{
	$.ajax({
		type: 'POST',
		url: "update_item_hidden/",
		data: 
		{
			id		: item_id,
			hidden	: $("#hidden-"+item_id).is(":checked")
		},
		success: function(result){
			if (result == "success")
			{
				$("#action_status-"+item_id).html("<b>&#x2713;Done</b>");
				$("#action_status-"+item_id).addClass("success");
			}
			else
			{
				$("#action_status-"+item_id).html("<b>&#x2717;Failed</b>");
				$("#action_status-"+item_id).addClass("failure");
			}
		}
	});
}

function update_item(item_id)
{
    $.ajax({
		type: 'POST',
		url: "update_item/",
		data: 
		{
			id				: item_id,
			tipe			: $("#tipe-"+item_id).val(),
			tipe_2			: $("#tipe_2-"+item_id).val(),
			tipe_3			: $("#tipe_3-"+item_id).val(),
			harga			: $("#harga-"+item_id).val(),
			harga_default	: $("#harga_default-"+item_id).val(),
			harga_min		: $("#harga_min-"+item_id).val(),
			harga_base		: $("#harga_base-"+item_id).val(),
			stok			: $("#stok-"+item_id).val()
		},
		success: function(result){
			if (result == "success")
			{
				$("#action_status-"+item_id).html("<b>&#x2713;Done</b>");
				$("#action_status-"+item_id).addClass("success");
				$("#update_button-"+item_id).addClass("semi_disabled");
			}
			else
			{
				$("#action_status-"+item_id).html("<b>&#x2717;Failed</b>");
				$("#action_status-"+item_id).addClass("failure");
			}
		}
	});
}