<?php
/** This file is part of TKGIntegrator project
 *
 * @desc Functions for initializing and checks DB
 * @package TKGIntegrator
 * @version 0.1a
 * @author Ravil Sarvaritdinov <ra9oaj@gmail.com>
 * @copyright 2017 KCFinder Project
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 * @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
 * @link https://github.com/tehnokom/alfo-tk-globalintegrator-plugin
 */


function tkgi_check_version()
{
    $cur_version = '0.1';
    $installed_version = tkgi_prepare_version(get_option('tkgi_db_version'));

    if (empty($installed_version)) {
        tkgi_db_install($cur_version);
    } elseif (floatval($cur_version) > floatval($installed_version)) {
        tkgi_upgrade_log("Start upgrading DB from {$installed_version} to {$cur_version}");
        tkgi_db_update($installed_version, $cur_version);
    }
}

function tkgi_prepare_version($ver)
{
    return (preg_replace('/([a-zA-Z]+)/', '', $ver));
}

function tkgi_upgrade_log($msg, $type = 'i')
{
    $prefix = date("[Y-m-d H:i:s]:");
    $type_str = 'Info';

    switch (variable) {
        case 'w':
            $type_str = 'Warning';
            break;

        case 'e':
            $type_str = 'Error';
            break;

        default:
            break;
    }

    file_put_contents(TKGI_ROOT . 'upgrade.log', "{$prefix} {$type_str}: {$msg}\r\n", FILE_APPEND);
}

function tkgi_db_install($cur_version)
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'tkgi_likes';
    $charset_collate = " DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
        $sql = "CREATE TABLE `{$table_name}` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `item_type` varchar(32) NOT NULL,
  `likes` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `unlikes` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `item_uniq` (`item_id`,`item_type`)
  ){$charset_collate};";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
    }

    $table_name = $wpdb->prefix . 'tkgi_favorites';

    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
        $sql = "CREATE TABLE `wp_tkgi_favorites` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `item_type` varchar(32) NOT NULL,
  `item_link` varchar(255) DEFAULT NULL,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_item_uniq` (`user_id`,`item_id`,`item_type`)
  ){$charset_collate};";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
    }

    update_option('tkgi_db_version', $cur_version);
}

function tkgi_db_update($installed_version, $cur_version)
{
    global $wpdb;

    $slug = TK_GProject::slug;

    $patches = array(/*'0.13' => array(
            'sql' => array("CREATE TABLE `{$wpdb->prefix}tkgp_tasks_links` (
									`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
									`parent_id` bigint(20) unsigned NOT NULL,
									`parent_type` tinyint(3) NOT NULL,
									`child_id` bigint(20) unsigned NOT NULL,
									`child_type` tinyint(3) NOT NULL,
									`create_date` timestamp DEFAULT NOW(),
									PRIMARY KEY (`id`),
									INDEX `parent_id` (`parent_id`),
									INDEX `child_id` (`child_id`),
									UNIQUE KEY `child_unique` (`child_id`,`child_type`),
									UNIQUE KEY `link_unique` (`parent_id`,`parent_type`,`child_id`,`child_type`)
									) DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate};",
            ),
            'ver_after' => '0.14'),*/

    );

    if (!empty($patches[$installed_version])) {
        tkgi_upgrade_log("	Patching DB {$installed_version} => {$patches[$installed_version]['ver_after']}");

        if ($patches[$installed_version]['sql'] == 'none') {
            update_option('tkgi_db_version', $patches[$installed_version]['ver_after']);
        } else {
            $result = false;

            foreach ($patches[$installed_version]['sql'] as $path) {
                tkgi_upgrade_log("		SQL: {$path}");

                $result = $wpdb->query($path);

                if (!$result) {
                    if (!empty($wpdb->last_error)) {
                        //ошибка - не прошел патч SQL
                        tkgi_upgrade_log("Error during patch installation!", 'e');
                        tkgi_upgrade_log("SQL messages text: {$wpdb->last_error}", 'e');
                        return;
                    }

                    $result = true; //не критичная ошибка
                    tkgi_upgrade_log("The patch is not changed. Maybe there is nothing to fix or fixes have been made earlier.", 'w');
                } else {
                    tkgi_upgrade_log("		SQL: ОК");
                }
            }

            if ($result) {
                tkgi_upgrade_log("	End patching DB {$installed_version} => {$cur_version}");
                update_option('tkgi_db_version', $patches[$installed_version]['ver_after']); //обновились до следующей версии
                $new_version = tkgi_prepare_version(get_option('tkgi_db_version'));

                if (floatval($new_version) < floatval($cur_version)) {
                    tkgi_db_update($new_version, $cur_version);
                } else {
                    tkgi_upgrade_log("End upgrading DB from {$installed_version} to {$cur_version}");
                }
            }
        }
    } else {
        tkgi_upgrade_log("You can not upgrade from version {$installed_version}!", 'e');
    }
}
