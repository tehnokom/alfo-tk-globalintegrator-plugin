<?php
/** This file is part of TKGIntegrator project
 *
 *      @desc Generates content for a consolidated social group page
 *   @package TKGIntegrator
 *   @version 0.1a
 *    @author Ravil Sarvaritdinov <ra9oaj@gmail.com>
 * @copyright 2017 KCFinder Project
 *   @license http://opensource.org/licenses/GPL-3.0 GPLv3
 *   @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
 *      @link https://github.com/tehnokom/alfo-tk-globalintegrator-plugin
 */
?>
<div class="tkgi-block">
    <div class="tkgi-social-nav">
        <ul>
            <li <?php tkgi_is_current_page('projektoj'); ?> ><a href="/socio/projektoj">Общественные проекты</a></li>
            <li <?php tkgi_is_current_page('grupoj'); ?> ><a href="/socio/grupoj">Группы</a></li>
            <li <?php tkgi_is_current_page('org'); ?> ><a href="javascript:void(0);">Организации</a></li>
        </ul>
    </div>

    <?php
    if($cur_subpage === 'projektoj') {
        require_once (TKGI_STYLE_ROOT . 'page-projects.php');
    } else {
        require_once (TKGI_STYLE_ROOT . 'page-buddypress.php');
    }
    ?>
</div>
