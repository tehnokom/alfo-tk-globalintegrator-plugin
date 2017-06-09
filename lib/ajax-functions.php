<?php
/** This file is part of TKGIntegrator project
 *
 * @desc AJAX functions
 * @package TKGIntegrator
 * @version 0.1a
 * @author Ravil Sarvaritdinov <ra9oaj@gmail.com>
 * @copyright 2017 KCFinder Project
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 * @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
 * @link https://github.com/tehnokom/alfo-tk-globalintegrator-plugin
 */

function tkgi_get_projects()
{
    require_once (TKGI_STYLES_ROOT . 'default/page-projects.php');
    wp_die();
}
add_action('wp_ajax_tkgi_get_projects', 'tkgi_get_projects');
add_action('wp_ajax_nopriv_tkgi_get_projects', 'tkgi_get_projects');