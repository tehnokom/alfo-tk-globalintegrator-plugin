var $j = jQuery.noConflict();

$j(document).ready(function ($j) {
    tk_morebtn_connect();
});

function tk_morebtn_connect() {
    $j('#tkgi-page-more').on('click', tk_get_more);
}

function tk_get_more(e) {
    var nex_page = 2;
    $j('#tkgi-page-more').unbind('click', tk_get_more);
    if(!$j('input[name="tkgi_pages_loaded"]').length) {
        $j('.tkgi-proj').before('<input type="hidden" name="tkgi_pages_loaded" value="1" />');
    } else {
        nex_page = parseInt($j('input[name="tkgi_pages_loaded"]').val()) + 1;
    }

    $j.ajax({
        url: tkgi_js_vars.ajax_url,
        type: 'POST',
        data: {
            action: 'tkgi_get_projects',
            page_method: 'ajax',
            page: nex_page
        }
    })
        .done(function (result) {
            $j('input[name="tkgi_pages_loaded"]').val(nex_page);
            tk_update_project_page(result);
        })
        .fail(function (jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
        });
}

function tk_update_project_page(content) {
    $j('#tkgi-page-more').hide();
    $j('body').append('<div id="tkgi_ajax_tmp" hidden="hidden"></div>');
    $j('#tkgi_ajax_tmp').append(content);

    if($j('input[name="tkgi_has_more"]').length) {
        $j('input[name="tkgi_has_more"]').remove();
    } else {
        $j('#tkgi-page-more').remove();
    }

    $j('.tkgi-proj').append($j('#tkgi_ajax_tmp').html());
    $j('#tkgi_ajax_tmp').remove();
    $j('#tkgi-page-more').show();
    tk_morebtn_connect();

}