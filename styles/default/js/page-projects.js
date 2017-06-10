var $j = jQuery.noConflict();
var tkgi_filter_state;

$j(document).ready(function ($j) {
    tk_morebtn_connect();
    tkgi_reset_filter();
    $j('.tkgi-apply-filter').on('click', tkgi_apply_filter);
});

function tkgi_reset_filter() {
    tkgi_filter_state = {sort_by: 'priority', order_by: 'desc'};
    $j('select[name="sort_by"]').val('priority');
    $j('select[name="order_by"]').val('desc');
}

function tkgi_get_filter_status() {
    return {
        sort_by: $j('select[name="sort_by"]').val(),
        order_by: $j('select[name="order_by"]').val()
    };
}

function tkgi_save_filter_status() {
    tkgi_filter_state = tkgi_get_filter_status();
}

function tk_morebtn_connect() {
    $j('#tkgi-page-more').on('click', tk_get_more);
}

function tk_get_more() {
    var nex_page = 2;
    $j('#tkgi-page-more').unbind('click', tk_get_more);
    if (!$j('input[name="tkgi_pages_loaded"]').length) {
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
            sort_by: $j('select[name="sort_by"]').val(),
            order_by: $j('select[name="order_by"]').val(),
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

function tk_update_project_page(content, replace) {
    replace = replace !== undefined ? true : false;

    $j('#tkgi-page-more').hide();
    $j('body').append('<div id="tkgi_ajax_tmp" hidden="hidden"></div>');
    $j('#tkgi_ajax_tmp').append(content);

    if ($j('input[name="tkgi_has_more"]').length) {
        $j('input[name="tkgi_has_more"]').remove();
    } else {
        $j('#tkgi-page-more').remove();
    }

    if(replace) {
        $j('.tkgi-proj > li').remove();
    }

    $j('.tkgi-proj').append($j('#tkgi_ajax_tmp').html());
    $j('#tkgi_ajax_tmp').remove();
    $j('#tkgi-page-more').show();
    tk_morebtn_connect();

}

function tkgi_apply_filter() {
    var need_units = $j('.tkgi-proj > li').length;

    $j.ajax({
        url: tkgi_js_vars.ajax_url,
        type: 'POST',
        data: {
            action: 'tkgi_get_projects',
            page_method: 'ajax',
            sort_by: $j('select[name="sort_by"]').val(),
            order_by: $j('select[name="order_by"]').val() ,
            units: need_units
        }
    })
        .done(function (result) {
            //$j('input[name="tkgi_pages_loaded"]').val(1);
            tk_update_project_page(result, true);
        })
        .fail(function (jqXHR, textStatus) {
            console.log("Request failed: " + textStatus);
        });
}