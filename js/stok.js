

/*
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
*/
function load_restock_view()
{
    $("#iframe_stok_view").attr('src', 'stok/restock_view');
}

function load_histori_restock_view()
{
    $("#iframe_stok_view").attr('src', 'stok/histori_restock_view');
}

function load_review_stok_view()
{
    $("#iframe_stok_view").attr('src', 'stok/review_stok_view');
}

function load_penyesuaian_stok_view()
{
    $("#iframe_stok_view").attr('src', 'stok/penyesuaian_stok_view');
}

function load_belanja_view()
{
    $("#iframe_stok_view").attr('src', 'stok/belanja_view');
}

function load_penjualan_view()
{
    $("#iframe_stok_view").attr('src', 'stok/penjualan_view');
}

function load_belanja_view_month(month, year)
{
    $("#iframe_stok_view").attr('src', 'stok/belanja_view/'+month+'/'+year);
}

function load_penjualan_view_month(month, year)
{
    $("#iframe_stok_view").attr('src', 'stok/penjualan_view/'+month+'/'+year);
}
/*
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
*/