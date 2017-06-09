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
    <!--Filter Start-->
    <div class="tkgi-filter-box">
        <div class="tkgi-filter-order">
            <select name="sort_by">
                <option value="priority"><?php echo _x('by proirity', 'Default style', 'tk-style'); ?></option>
                <option value="popularity"><?php echo _x('by popularity', 'Default style', 'tk-style'); ?></option>
                <option value="date"><?php echo _x('by date', 'Default style', 'tk-style'); ?></option>
                <option value="title"><?php echo _x('by title', 'Default style', 'tk-style'); ?></option>
            </select>
            <select name="order_by">
                <option value="desc"><?php echo _x('DESC', 'Default style', 'tk-style'); ?></option>
                <option value="asc"><?php echo _x('ASC', 'Default style', 'tk-style'); ?></option>
            </select>
        </div>
    </div>
    <!--Filter End-->
    <!--Projects List Start-->
    <ul class="tkgi-proj">
        <?php
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
        }
        ?>
    </ul>
    <!--Projects List End-->
    <?php
    if ($page->hasMore()) {
        ?>
        <div id="tk-page-more" class="tk-button"><?php echo _x('More', 'Default style', 'tk-style'); ?></div>
        <?php
    }
} else {
    ?>

    <?php
}