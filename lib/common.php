<?php
/** This file is part of TKGIntegrator project
 *
 *      @desc Common functions
 *   @package TKGIntegrator
 *   @version 0.1a
 *    @author Ravil Sarvaritdinov <ra9oaj@gmail.com>
 * @copyright 2017 KCFinder Project
 *   @license http://opensource.org/licenses/GPL-3.0 GPLv3
 *   @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
 *      @link https://github.com/tehnokom/alfo-tk-globalintegrator-plugin
 */

function tkgi_check_subpage()
{
    switch (tkgi_get_subpage()) {
        case 'socio':
        case 'projektoj':
        case 'grupoj':
        case 'miakom':
        case 'konsidero':
        case 'nova':
            return true;
        default:
            return false;
    }
}

function tkgi_get_subpage()
{
    return get_query_var('tkgi_page');
}

function tkgi_is_current_page($page) {
    $cur_page = tkgi_get_subpage();

    if($cur_page === $page ||
        ($page === 'socio' && preg_match('/^(projektoj|grupoj)$/', $cur_page))
    ) {
        echo 'class="current selected"';
        return true;
    }

    return false;
}