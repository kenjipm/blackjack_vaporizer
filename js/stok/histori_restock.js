function cancel_belanja(id_belanja)
{
	if (confirm("Cancel belanja ini?"))
	{
		$.ajax({
			type: 'POST',
			url: "cancel_belanja/",
			data: 
			{
				id_belanja : id_belanja
			},
			success: function(result){
				location.reload();
			}
		});
	}
}

function next_session()
{
    $.ajax({
		type: 'POST',
		url: "next_session_belanja/",
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
		url: "prev_session_belanja/",
		data: "",
		success: function(result){
			location.reload();
		}
	});
}