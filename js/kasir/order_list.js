$(document).ready(function(){
    new_order_id = $("#new_order_id").val();
    if (new_order_id != 0)
    {
        copy_to_new_order(new_order_id);
    }
    $(document).scrollTop( $("#anchor").offset().top - 30);  
});

function set_menu_done(id_order_menu)
{
    var done = $("#order_menu-"+id_order_menu).is(":checked");
    $.ajax({
		type: 'POST',
		url: "kasir_set_menu_done/"+id_order_menu+"/"+done,
		data: "",
		success: function(result){
			$("#time_elapsed-"+id_order_menu).html(result);
		}
	});
}

function copy_to_new_order(order_id)
{
    $("#form_order_list-"+order_id).attr('action', 'kasir_copy_to_new_order');
    $("#form_order_list-"+order_id).attr('target', 'tambah_menu');
    $("#form_order_list-"+order_id).submit();
}

function edit_order(order_id)
{
    $("#form_order_list-"+order_id).attr('action', 'kasir_edit_order');
    $("#form_order_list-"+order_id).attr('target', 'tambah_menu');
    $("#form_order_list-"+order_id).submit();
}

function delete_order(order_id, nama_pembeli, paid)
{
    var allowed = false;
    // konfirmasi dulu apa bener mau hapus
    if (confirm("Cancel order oleh "+nama_pembeli+"?"))
    {
        if (paid)
        {
            // kalau udah dibayar diyakinin lagi
            if (confirm("Yakin? Sudah dibayar lho?"))
            {
                allowed = true;
            }
        }
        else
        {
            allowed = true;
        }
    }
    if (allowed)
    {
        $.ajax({
            type: 'POST',
            url: "kasir_delete_order/"+order_id,
            data: "",
            success: function(result){
                parent.reload_order_list();
            }
        });
    }
}