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


function tkgi_set_template($template_path)
{
    if(!empty(get_query_var('tkgi_page'))) {
        $template_path = TKGI_STYLE_ROOT . 'default/page.php';
    }

    return $template_path;
}
add_filter('template_include', 'tkgi_set_template');

function tkgi_set_title($title) {
    echo serialize($title);
    return $title;
}
add_filter('document_title_parts','tkgi_set_title', 1, 1);