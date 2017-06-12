<?php
/** This file is part of TKGIntegrator project
 *
 *      @desc Generates a list of BuddyPress groups
 *   @package TKGIntegrator
 *   @version 0.1a
 *    @author Ravil Sarvaritdinov <ra9oaj@gmail.com>
 * @copyright 2017 KCFinder Project
 *   @license http://opensource.org/licenses/GPL-3.0 GPLv3
 *   @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
 *      @link https://github.com/tehnokom/alfo-tk-globalintegrator-plugin
 */

if(defined('BP_PLUGIN_DIR')) {
    $template_path = is_dir(TEMPLATEPATH . '/buddypress/groups') ? TEMPLATEPATH . '/buddypress/groups/index.php'
        : false;

    if($template_path) {
        require_once ($template_path);
    }
} else {

}