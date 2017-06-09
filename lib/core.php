<?php
/** This file is part of TKGIntegrator project
 *
 * @desc Main functions of the plugin
 * @package TKGIntegrator
 * @version 0.1a
 * @author Ravil Sarvaritdinov <ra9oaj@gmail.com>
 * @copyright 2017 KCFinder Project
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 * @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
 * @link https://github.com/tehnokom/alfo-tk-globalintegrator-plugin
 */

/**
 * Rewrites the addresses of the plug-in pages
 */
function tkgi_create_pages()
{
    global $wp_rewrite;
    $tkgi_tag = 'socio';

    add_rewrite_tag('%tkgi_page%', '([^&]+)');

    add_rewrite_rule('^' . $tkgi_tag . '/([^/]+)$',
        'index.php?tkgi_page=$matches[1]', 'top');
    add_rewrite_rule('^' . $tkgi_tag . '$', 'index.php?tkgi_page=' . $tkgi_tag, 'top');

    $wp_rewrite->flush_rules();
}
add_action('init', 'tkgi_create_pages');


function tkgi_page_title($_title)
{
    $_title = _x('Communities', 'Page title', 'tkgi');

    if (function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')) {
        $_title = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($_title);
    }

    $_title = apply_filters('localization', $_title);

    return $_title;
}

function tkgi_template_redirect()
{
    global $wp_query;

    if(!empty(get_query_var('tkgi_page'))) {
        if(tkgi_check_subpage()) {
            if(tkgi_get_subpage() === 'socio') {
                wp_redirect( home_url('/socio/projektoj'));
                exit;
            }

            $wp_query->is_home = false;
            $wp_query->is_page = true;

            add_filter('wp_title', 'tkgi_page_title');
            add_filter('aioseop_title_page', 'tkgi_page_title');
        } else {
            $wp_query->set_404();
            status_header(404);
            get_template_part(404);
            exit();
        }
    }
}
add_filter('template_redirect', 'tkgi_template_redirect',1);


function tkgi_set_template($template_path)
{
    if(!empty(get_query_var('tkgi_page'))) {
        $template_path = TKGI_STYLES_ROOT . 'default/page.php';
    }

    return $template_path;
}
add_filter('template_include', 'tkgi_set_template');

