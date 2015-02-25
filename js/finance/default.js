// Fungsi - fungsi load view biasa
function load_tutup_buku_view()
{
	$("#iframe_finance_view").attr('src', 'finance/tutup_buku_view');
}

function load_kas_overview_view()
{
    $("#iframe_finance_view").attr('src', 'finance/kas_overview_view');
}

function load_kas_tunai_view()
{
    $("#iframe_finance_view").attr('src', 'finance/kas_tunai_view');
}

function load_kas_rekening_view()
{
    $("#iframe_finance_view").attr('src', 'finance/kas_rekening_view');
}

function load_kas_piutang_view()
{
    $("#iframe_finance_view").attr('src', 'finance/kas_piutang_view');
}

function load_kas_migrasi_view()
{
    $("#iframe_finance_view").attr('src', 'finance/kas_migrasi_view');
}

function load_kas_penyesuaian_view()
{
    $("#iframe_finance_view").attr('src', 'finance/kas_penyesuaian_view');
}

function load_alokasi_overview_view()
{
    $("#iframe_finance_view").attr('src', 'finance/alokasi_overview_view');
}

function load_alokasi_modal_view()
{
    $("#iframe_finance_view").attr('src', 'finance/alokasi_modal_view');
}

function load_alokasi_bonus_view()
{
    $("#iframe_finance_view").attr('src', 'finance/alokasi_bonus_view');
}

function load_alokasi_migrasi_view()
{
    $("#iframe_finance_view").attr('src', 'finance/alokasi_migrasi_view');
}

function load_transaksi_overview_view()
{
    $("#iframe_finance_view").attr('src', 'finance/transaksi_overview_view');
}

function load_omzet_view()
{
    $("#iframe_finance_view").attr('src', 'finance/omzet_view');
}

function load_omzet_view_month(month, year)
{
    $("#iframe_finance_view").attr('src', 'finance/omzet_view/'+month+'/'+year);
}

// Fungsi - fungsi load view dengan parameter get
// function reload_kas_tunai_view(session_tutup_buku_no, str_array_kas_tunai_selected)
// {
    // $("#iframe_finance_view").attr('src', 'finance/kas_tunai_view/'+session_tutup_buku_no+'/'+str_array_kas_tunai_selected);
// }