<?php
/** This file is part of TKGIntegrator project
 *
 * @desc Common functions
 * @package TKGIntegrator
 * @version 0.1a
 * @author Ravil Sarvaritdinov <ra9oaj@gmail.com>
 * @copyright 2017 KCFinder Project
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 * @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
 * @link https://github.com/tehnokom/alfo-tk-globalintegrator-plugin
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

function tkgi_is_current_page($page)
{
    $cur_page = tkgi_get_subpage();

    if ($cur_page === $page ||
        ($page === 'socio' && preg_match('/^(projektoj|grupoj)$/', $cur_page))
    ) {
        echo 'class="current selected"';
        return true;
    }

    return false;
}

function tkgi_ifelse(bool $expression, $then, $else = null, bool $print_this = false)
{
    $out = $expression ? $then : $else;

    if($print_this) {
        switch (gettype($out)) {
            case 'object':
            case 'array':
                echo serialize($out);
                break;

            case 'boolean':
                echo $out ? 'true' : 'false';
                break;

            default:
                echo $out;
        }
    }

    return $out;
}

function tkgi_total_groups()
{
    $bp_groups = defined('BP_PLUGIN_DIR') ? bp_get_total_group_count() : 0;
    $projects = defined('TKGP_ROOT') ? TK_GPage::getTotalProjectCount() : 0;

    return $bp_groups + $projects;
}