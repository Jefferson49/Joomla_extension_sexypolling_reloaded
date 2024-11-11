<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: scriptfile.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 * Extended by:
 * @version v3.0.0
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 - 2024 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Installer\Installer;
use Joomla\CMS\Language\Text;


// no direct access
defined('_JEXEC') or die('Restircted access');

class com_sexypollingInstallerScript {

    /**
     * method to install the component
     *
     * @return void
     */
    function install($parent) {
        // installing module
        $module_installer = new Installer;
        if(@$module_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'module')) {
            //echo '<p>'.Text::_('MOD_SEXYPOLLING_MODULE_INSTALL_SUCCESS').'</p>';
        } else
           echo '<p>'.Text::_('MOD_SEXYPOLLING_MODULE_INSTALL_FAILED').'</p>';

        // installing plugin
        $plugin_installer = new Installer;
        if($plugin_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'plugin')) {
            //echo '<p>'.Text::_('PLG_SEXYPOLLING_PLUGIN_INSTALL_SUCCESS').'</p>';
        } else
            echo '<p>'.Text::_('PLG_SEXYPOLLING_PLUGIN_INSTALL_FAILED').'</p>';

        // installing editor button plugin
        $plugin_installer = new Installer;
        if($plugin_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'editor_button')) {
            //echo '<p>'.Text::_('PLG_SEXYPOLLING_PLUGIN_INSTALL_SUCCESS').'</p>';
        } else
            echo '<p>'.Text::_('PLG_SEXYPOLLING_PLUGIN_INSTALL_FAILED').'</p>';

        // enabling plugins
        $db = Factory::getDBO();
        $db->setQuery('UPDATE #__extensions SET enabled = 1 WHERE element = "sexypolling" AND folder = "system"');
        $db->setQuery('UPDATE #__extensions SET enabled = 1 WHERE element = "sexypolling" AND folder = "editors-xtd"');
        $db->execute();
    }

    /**
     * method to uninstall the component
     *
     * @return void
     */
    function uninstall($parent) {

        //we do not need to uninstall the module and plugin, because it is handled by Joomla already
        return;
    }

    /**
     * method to update the component
     *
     * @return void
     */
    function update($parent) {
        $module_installer = new Installer;
        if(@$module_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'module')) {
            //echo '<p>'.Text::_('MOD_SEXYPOLLING_MODULE_INSTALL_SUCCESS').'</p>';
        } else
           echo '<p>'.Text::_('MOD_SEXYPOLLING_MODULE_INSTALL_FAILED').'</p>';

        $plugin_installer = new Installer;
        if(@$plugin_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'plugin')) {
            //echo '<p>'.Text::_('PLG_SEXYPOLLING_PLUGIN_INSTALL_SUCCESS').'</p>';
        } else
            echo '<p>'.Text::_('PLG_SEXYPOLLING_PLUGIN_INSTALL_FAILED').'</p>';

        // installing editor button plugin
        $plugin_installer = new Installer;
        if($plugin_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'editor_button')) {
            //echo '<p>'.Text::_('PLG_SEXYPOLLING_PLUGIN_INSTALL_SUCCESS').'</p>';
        } else
            echo '<p>'.Text::_('PLG_SEXYPOLLING_PLUGIN_INSTALL_FAILED').'</p>';

        // enabling plugins
        $db = Factory::getDBO();
        $db->setQuery('UPDATE #__extensions SET enabled = 1 WHERE element = "sexypolling" AND folder = "system"');
        $db->setQuery('UPDATE #__extensions SET enabled = 1 WHERE element = "sexypolling" AND folder = "editors-xtd"');
        $db->execute();
    }

    /**
     * method to run before an install/update/uninstall method
     * 
     * @param $parent   is the class calling this method
     * @param $type     is the type of change (install, update or discover_install)
     * 
     * @return void
     */
    function preflight($type, $parent) {
        return;
    }

    /**
     * method to run after an install/update/uninstall method
     *
     * @return void
     */
    function postflight($type, $parent) {

        if ($type === 'uninstall') { 
            return; 
        }

        $db = Factory::getDBO();
        $query = "SELECT * FROM `#__sexy_polls` LIMIT 1";
        $db->setQuery($query);
        $columns_data = $db->LoadAssoc();
        $columns_titles = array_keys($columns_data);

        //add additional columns
        if(is_array($columns_titles)) {
            if(!in_array('showvotesperiod',$columns_titles)) {
                $query_update = "
                    ALTER TABLE  `#__sexy_polls`
                        ADD `showvotesperiod` tinyint unsigned NOT NULL DEFAULT  '1',
                        ADD `stringdateformat` text NOT NULL,
                        ADD `votescountformat` tinyint unsigned NOT NULL DEFAULT  '2',
                        ADD `scaledefault` tinyint unsigned NOT NULL DEFAULT  '1',
                        ADD `showaddanswericon` tinyint unsigned NOT NULL DEFAULT  '1',
                        ADD `showscaleicon` tinyint unsigned NOT NULL DEFAULT  '1',
                        ADD `showbackicon` tinyint unsigned NOT NULL DEFAULT  '1',
                        ADD `showtimelineicon` tinyint unsigned NOT NULL DEFAULT  '1',
                        ADD `showtimeline` tinyint unsigned NOT NULL DEFAULT  '1',
                        ADD `showvotescountinfo` tinyint unsigned NOT NULL DEFAULT  '1',
                        ADD `poll_width` text NOT NULL,
                        ADD `pollalign` tinyint unsigned NOT NULL DEFAULT  '2',
                        ADD `addclearboth` tinyint unsigned NOT NULL DEFAULT  '1',
                        ADD `poll_margintop` smallint unsigned NOT NULL DEFAULT  '5',
                        ADD `poll_marginbottom` smallint unsigned NOT NULL DEFAULT  '5',
                        ADD `poll_marginleft` smallint unsigned NOT NULL DEFAULT  '5',
                        ADD `poll_marginright` smallint unsigned NOT NULL DEFAULT  '5',
                        ADD `classsuffix` text NOT NULL,
                        ADD `checktoken` tinyint unsigned NOT NULL DEFAULT  '1',
                        ADD `ipcount` INT unsigned NOT NULL DEFAULT  '0',
                        ADD `checkacl` tinyint unsigned NOT NULL DEFAULT  '1',
                        ADD `votechecks` tinyint unsigned NOT NULL DEFAULT  '0'
                ";
                $db->setQuery($query_update);
                $db->execute();

                //update columns
                $query_update = "UPDATE `#__sexy_polls` SET `stringdateformat` = 'F j, Y'";
                $db->setQuery($query_update);
                $db->execute();

                $query_update = "
                    ALTER TABLE  `#__sexy_answers`
                        ADD `show_name` tinyint unsigned NOT NULL DEFAULT  '1',
                        ADD `img_width` INT unsigned NOT NULL DEFAULT  '100',
                        ADD `img_name` text NOT NULL,
                        ADD `img_url` text NOT NULL,
                        ADD `embed` text NOT NULL
                ";
                $db->setQuery($query_update);
                $db->execute();

                $query_update = "ALTER TABLE  `#__sexy_votes` ADD  `id_user` INT unsigned NOT NULL DEFAULT  '0' AFTER  `id_answer`";
                $db->setQuery($query_update);
                $db->execute();
            }

            //add column for "showresultsduringpoll"
            if(!in_array('showresultsduringpoll',$columns_titles)) {
                $query_update = "ALTER TABLE `#__sexy_polls` ADD `showresultsduringpoll` tinyint(3) unsigned NOT NULL DEFAULT '1' AFTER `date_end`";
                $db->setQuery($query_update);
                $db->execute();
            }

            //add column for "showbackbutton" option
            if(!in_array('showbackbutton',$columns_titles)) {
                $query_update = "ALTER TABLE  `#__sexy_polls` ADD   `showbackbutton` enum('0','1') NOT NULL DEFAULT '1' AFTER `showresultbutton`";
                $db->setQuery($query_update);
                $db->execute();
            }
        }

        $query = "SELECT * FROM `#__sexy_votes` LIMIT 1";
        $db->setQuery($query);
        $columns_data = $db->LoadAssoc();
        $columns_titles = array_keys($columns_data);

        if(is_array($columns_titles)) {
            if(!in_array('id_vote', $columns_titles)) {
                //add required columns
                $query_update = "alter table #__sexy_votes ADD COLUMN id_vote int(10) unsigned PRIMARY KEY NOT NULL AUTO_INCREMENT FIRST";
                $db->setQuery($query_update);
                $db->execute();
            }
        }

        //Add certain default values to the database in order to avoid errors of type: Field '...' doesn't have a default value

        $query = "SHOW COLUMNS FROM #__sexy_polls LIKE 'checked_out'";
        $db->setQuery($query);
        $columns_data = $db->LoadAssoc();
        $columns_titles = array_keys($columns_data);

        if(is_array($columns_titles)) {
            if($columns_data['Null'] === "NO") {
                $query_update = "
                    ALTER TABLE `#__sexy_polls` MODIFY  `checked_out` int(10) unsigned NOT NULL DEFAULT 0
                ";
                $db->setQuery($query_update);
                $db->execute();
            }
        }

        $query = "SHOW COLUMNS FROM #__sexy_answers LIKE 'id_user'";
        $db->setQuery($query);
        $columns_data = $db->LoadAssoc();
        $columns_titles = array_keys($columns_data);

        if(is_array($columns_titles)) {
            if($columns_data['Default'] != "0") {
                $query_update = "
                    ALTER TABLE  `#__sexy_answers` MODIFY   `id_user` int(10) unsigned NOT NULL DEFAULT 0
                ";
                $db->setQuery($query_update);
                $db->execute();
            }
        }

        //Update example poll images
        $query_update = "
            UPDATE `#__sexy_answers` SET `img_name`='components/com_sexypolling/assets/images/poll_example/nokia.jpg?raw=true',`img_url`='' WHERE `name` = 'Nokia LUMIA 520!\r\n<br /><a href=\"https://en.wikipedia.org/wiki/Nokia_Lumia_520\" target=\"_blank\">Read more.</a>'
        ";
        $db->setQuery($query_update);
        $db->execute();

        $query_update = "
            UPDATE `#__sexy_answers` SET `img_name`='components/com_sexypolling/assets/images/poll_example/samsung.jpg?raw=true',`img_url`='' WHERE `name` = 'Samsung Galaxy S5!\r\n<br /><a href=\"https://en.wikipedia.org/wiki/Samsung_Galaxy_S5\" target=\"_blank\">Read more.</a>';
        ";
        $db->setQuery($query_update);
        $db->execute();

        $query_update = "
            UPDATE `#__sexy_answers` SET `img_name`='components/com_sexypolling/assets/images/poll_example/iphone.jpg?raw=true',`img_url`='' WHERE `name` = 'Apple iPhone 5S!\r\n<br /><a href=\"https://en.wikipedia.org/wiki/IPhone_5s\" target=\"_blank\">Read more.</a>';
        ";
        $db->setQuery($query_update);
        $db->execute();

        $query_update = "
            UPDATE `#__sexy_answers` SET `img_name`='components/com_sexypolling/assets/images/poll_example/lg.jpg?raw=true',`img_url`='' WHERE `name` = 'LG Optimus G Pro!\r\n<br /><a href=\"https://en.wikipedia.org/wiki/LG_Optimus_G_Pro\" target=\"_blank\">Read more.</a>';
        ";
        $db->setQuery($query_update);
        $db->execute();

        $query_update = "
            UPDATE `#__sexy_answers` SET `img_name`='components/com_sexypolling/assets/images/poll_example/htc.jpg?raw=true',`img_url`='' WHERE `name` = 'HTC One max!\r\n<br /><a href=\"https://en.wikipedia.org/wiki/HTC_One_Max\" target=\"_blank\">Read more.</a>';
        ";
        $db->setQuery($query_update);
        $db->execute();
    }
}