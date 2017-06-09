<?php
/** This file is part of TKGIntegrator project
 *
 * @desc Generates a list of projects
 * @package TKGIntegrator
 * @version 0.1a
 * @author Ravil Sarvaritdinov <ra9oaj@gmail.com>
 * @copyright 2017 KCFinder Project
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 * @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
 * @link https://github.com/tehnokom/alfo-tk-globalintegrator-plugin
 */

if (!defined(TKGI_STYLE_URL)) {
    define('TKGI_STYLE_URL', plugin_dir_url(__FILE__));
}

if (class_exists('TK_GProject')) {
    $page = new TK_GPage();

    if (!empty($_POST['sort_by'])) {
        $filters = array('sort_by' => explode(',', $_POST['sort_by']));
        if (!empty($_POST['order_by'])) {
            $filters['order_by'] = explode(',', $_POST['order_by']);
        }

        $page->query($filters);
    } else {
        $page->query(array('sort_by' => array('priority'), 'order_by' => array('desc')));
    }

    $page_num = empty($_POST['page']) ? 1 : intval($_POST['page']);
    $page->createPage($page_num);
    ?>
    <!--Projects List Start-->
    <?php if ($_POST['page_method'] !== 'ajax') { ?>
        <ul class="tkgi-proj">
        <?php
    }

    while ($page->nextProject()) {
        $project = $page->project();
        ?>
        <!--Project Start-->
        <li>
            <div class="tkgi-proj-unit">
                <div class="tkgi-proj-avatar">
                    <a href="<?php echo $project->permalink; ?>">
                        <img src="<?php echo TKGI_STYLE_URL . 'images/default-av-50.jpg' ?>">
                    </a>
                </div>
                <div class="tkgi-proj-info">
                    <div>
                        <div class="tkgi-proj-title">
                            <h2>
                                <a href="<?php echo $project->permalink; ?>">
                                    <?php echo apply_filters("the_title", $project->title); ?>
                                </a>
                            </h2>
                        </div>
                    </div>
                    <div>
                        <div class="tkgi-proj-target">
                            <?php echo apply_filters("the_content", $project->target); ?>
                        </div>
                    </div>
                </div>
                <div class="tkgi-proj-actions">
                </div>
            </div>
        </li>
        <!--Project End-->
        <?php
        $subprojects = $project->getChildProjects();

        if (count($subprojects)) {
            foreach ($subprojects as $subproject) {
                ?>
                <!--Subproject Start-->
                <li>
                    <div class="tkgi-proj-subunit">
                        <div class="tkgi-proj-sp">
                            <img src="<?php echo TKGI_STYLE_URL . (end($subprojects) === $subproject ?
                                    'images/sp2.png' : 'images/sp1.png');
                            ?>">
                        </div>
                        <div class="tkgi-proj-avatar">
                            <a href="<?php echo $subproject->permalink; ?>">
                                <img src="<?php echo TKGI_STYLE_URL . 'images/default-av-50.jpg' ?>">
                            </a>
                        </div>
                        <div class="tkgi-proj-info">
                            <div>
                                <div class="tkgi-proj-title">
                                    <h2>
                                        <a href="<?php echo $subproject->permalink; ?>">
                                            <?php echo apply_filters("the_title", $subproject->title); ?>
                                        </a>
                                    </h2>
                                </div>
                            </div>
                            <div>
                                <div class="tkgi-proj-target">
                                    <?php echo apply_filters("the_content", $subproject->target); ?>
                                </div>
                            </div>
                        </div>
                        <div class="tkgi-proj-actions">
                        </div>
                    </div>
                </li>
                <!--Subproject End-->
                <?php
            }
        }
        ?>
        <?php
    }
    ?>
    <?php if ($_POST['page_method'] !== 'ajax') { ?>
        </ul>
    <?php } ?>
    <!--Projects List End-->
    <?php
    if ($page->hasMore()) {
        if($_POST['page_method'] === 'ajax') {
            ?>
            <input type="hidden" name="tkgi_has_more" />
            <?php
        } else {
            ?>
            <div id="tkgi-page-more" class="tkgi_button"><?php echo _x('More', 'Default style', 'tk-style'); ?></div>
            <?php
        }
    }
} else {
    ?>

    <?php
}