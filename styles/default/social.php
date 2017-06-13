<?php
/** This file is part of TKGIntegrator project
 *
 * @desc Generates content for a consolidated social group page
 * @package TKGIntegrator
 * @version 0.1a
 * @author Ravil Sarvaritdinov <ra9oaj@gmail.com>
 * @copyright 2017 KCFinder Project
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 * @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
 * @link https://github.com/tehnokom/alfo-tk-globalintegrator-plugin
 */
?>
<div class="tkgi-block">
    <div class="tkgi-social-nav">
        <ul>
            <li <?php tkgi_ifelse(tkgi_is_current_page('projektoj'), 'class="current selected"', '', true); ?> >
                <a href="/socio/projektoj"><?php echo _x('Public projects', 'Default style menu', 'tkgi-style'); ?></a>
            </li>
            <li <?php tkgi_ifelse(tkgi_is_current_page('grupoj'), 'class="current selected"', '', true); ?> >
                <a href="/socio/grupoj"><?php echo _x('Groups', 'Default style menu', 'tkgi-style'); ?></a>
            </li>
            <li <?php tkgi_ifelse(tkgi_is_current_page('org'), 'class="current selected"', '', true); ?> >
                <a href="javascript:void(0);"><?php echo _x('Organizations', 'Default style menu', 'tkgi-style'); ?></a>
            </li>
        </ul>
    </div>

    <?php
    if ($cur_subpage === 'projektoj') {
        ?>
        <!--Filter Start-->
        <div class="tkgi-filter-box">
            <div class="tkgi-filter-order">
                <select name="sort_by">
                    <option value="priority"><?php echo _x('by proirity', 'Projects filter', 'tkgi-style'); ?></option>
                    <option value="popularity"><?php echo _x('by popularity', 'Projects filter', 'tkgi-style'); ?></option>
                    <option value="date"><?php echo _x('by date', 'Projects filter', 'tkgi-style'); ?></option>
                    <option value="title"><?php echo _x('by title', 'Projects filter', 'tkgi-style'); ?></option>
                </select>
                <select name="order_by">
                    <option value="desc"><?php echo _x('DESC', 'Projects filter', 'tkgi-style'); ?></option>
                    <option value="asc"><?php echo _x('ASC', 'Projects filter', 'tkgi-style'); ?></option>
                </select>
                <div class="tkgi-apply-filter tkgi_button"><a><?php echo __('Apply'); ?></a></div>
            </div>
        </div>
        <!--Filter End-->
        <?php
        require_once(TKGI_STYLE_ROOT . 'page-projects.php');
    } else {
        require_once(TKGI_STYLE_ROOT . 'page-buddypress.php');
    }
    ?>
</div>
