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