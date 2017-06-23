<?php
/** This file is part of TKGIntegrator project
 *
 * @desc Generates front-end page
 * @package TKGIntegrator
 * @version 0.1a
 * @author Ravil Sarvaritdinov <ra9oaj@gmail.com>
 * @copyright 2017 KCFinder Project
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 * @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
 * @link https://github.com/tehnokom/alfo-tk-globalintegrator-plugin
 */
define('TKGI_STYLE_ROOT', plugin_dir_path(__FILE__));
define('TKGI_STYLE_URL', plugin_dir_url(__FILE__));

$subpage = '';
$cur_subpage = tkgi_get_subpage();
$css_deps = array('tkgi-common-css');
$js_deps = array('jquery');

switch ($cur_subpage) {
    case 'miakom':
    case 'konsidero':
    case 'nova':
        $subpage = 'social.php';
        break;
    case 'grupoj':
        wp_register_style('tkgi-buddypress-css', TKGI_STYLE_URL . 'css/buddypress.css');
        wp_register_script('tkgi-buddypress-js', TKGI_STYLE_URL . 'js/page-buddypress.js');
        $css_deps[] = 'tkgi-buddypress-css';
        $js_deps[] = 'tkgi-buddypress-js';
    default: //projektoj
        if (!in_array('tkgi-buddypress-css', $css_deps)) {
            wp_register_style('tkgi-projects-css', TKGI_STYLE_URL . 'css/projects.css');
            $css_deps[] = 'tkgi-projects-css';
        }

        if (!in_array('tkgi-projects-js', $js_deps)) {
            wp_register_script('tkgi-projects-js', TKGI_STYLE_URL . 'js/page-projects.js', array('jquery'));
            $js_deps[] = 'tkgi-projects-js';
        }

        $subpage = 'social.php';
        break;
}

wp_register_style('tkgi-common-css', TKGI_URL . 'css/common.css');
wp_register_style('tkgi-page-css', TKGI_STYLE_URL . 'css/page.css', $css_deps);
wp_enqueue_style('tkgi-page-css');

wp_register_script('tkgi-page-js', TKGI_STYLE_URL . 'js/page.js', $js_deps);
wp_enqueue_script('tkgi-page-js');

get_header();
?>

    <div class="tkgi-nav">
        <ul>
            <li <?php tkgi_ifelse(tkgi_is_current_page('socio'), 'class="current selected"', '', true); ?> >
                <a href="/socio"><?php echo _x('All communities', 'Default style menu', 'tkgi-style'); ?>
                    <span <?php tkgi_ifelse(tkgi_total_groups() > 99, 'class="tkgi-large"', '', true) ?> >
                        <?php echo tkgi_total_groups(); ?>
                    </span>
                </a>
            </li>
            <?php if (is_user_logged_in()) { ?>
                <li <?php tkgi_ifelse(tkgi_is_current_page('miakom'), 'class="current selected"', '', true); ?> >
                    <a href="/socio/miakom"><?php echo _x('My Communities', 'Default style menu', 'tkgi-style'); ?></a>
                </li>
                <li <?php tkgi_ifelse(tkgi_is_current_page('konsidero'), 'class="current selected"', '', true); ?> >
                    <a href="/socio/konsidero"><?php echo _x('Under consideration', 'Default style menu', 'tkgi-style'); ?></a>
                </li>
                <li <?php tkgi_ifelse(tkgi_is_current_page('nova'), 'class="current selected"', '', true); ?> >
                    <a href="/socio/nova"><?php echo _x('Create community', 'Default style menu', 'tkgi-style'); ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>

<?php
require_once(TKGI_STYLE_ROOT . $subpage);

get_footer(); ?>