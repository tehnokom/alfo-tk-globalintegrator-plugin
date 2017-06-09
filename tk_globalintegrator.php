<?php
/*
* Plugin Name: TehnoKom Global Integrator
* Plugin URI: https://github.com/tehnokom/alfo-tk-globalintegrator-plugin
* Text Domain: tkgi
* Description: Allows you to combine the TK Global Project with other social systems WordPress
* Version: 0.1a
* Author: Ravil Sarvaritdinov <ra9oaj@gmail.com>
* Author URI: http://github.com/RA9OAJ/
* License: GPLv2
*/
/** This file is part of TKGIntegrator project
 *
 *      @desc Initial WP plugin script
 *   @package TKGIntegrator
 *   @version 0.1a
 *    @author Ravil Sarvaritdinov <ra9oaj@gmail.com>
 * @copyright 2017 KCFinder Project
 *   @license http://opensource.org/licenses/GPL-3.0 GPLv3
 *   @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
 *      @link https://github.com/tehnokom/alfo-tk-globalintegrator-plugin
 */

define(TKGI_ROOT, plugin_dir_path(__FILE__));
define(TKGI_URL, plugin_dir_url(__FILE__));
define(TKGI_STYLE_ROOT, TKGI_ROOT . 'styles/');
define(TKGI_STYLE_URL, TKGI_URL . 'styles/');

require_once (TKGI_ROOT . 'lib/db_init.php');
require_once (TKGI_ROOT . 'lib/core.php');

register_activation_hook(__FILE__, 'tkgi_check_version');

/**
 * Creates the plug-in settings menu in the administrative panel
 */
function tkgi_add_admin_menu() {
    add_menu_page( _x('TK Global Integration Settings', 'Admin menu', 'tkgi'),
        _x('Global Integration', 'Admin menu', 'tkgi'),
        'manage_options',
        TKGI_ROOT . 'admin/settings.php',
        '',
        '',
        "16.1");
}
add_action('admin_menu', tkgi_add_admin_menu);



