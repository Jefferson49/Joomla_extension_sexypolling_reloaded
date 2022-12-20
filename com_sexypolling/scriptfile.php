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
 * @copyright Copyright (c) 2022 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

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
        $module_installer = new JInstaller;
        if(@$module_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'module')) {
            //echo '<p>'.JText::_('COM_SEXYPOLLING_MODULE_INSTALL_SUCCESS').'</p>';
        } else
           echo '<p>'.JText::_('COM_SEXYPOLLING_MODULE_INSTALL_FAILED').'</p>';

        // installing plugin
        $plugin_installer = new JInstaller;
        if($plugin_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'plugin')) {
            //echo '<p>'.JText::_('COM_SEXYPOLLING_PLUGIN_INSTALL_SUCCESS').'</p>';
        } else
            echo '<p>'.JText::_('COM_SEXYPOLLING_PLUGIN_INSTALL_FAILED').'</p>';

        // enabling plugin
        $db = JFactory::getDBO();
        $db->setQuery('UPDATE #__extensions SET enabled = 1 WHERE element = "sexypolling" AND folder = "system"');
        $db->execute();
    }

    /**
     * method to uninstall the component
     *
     * @return void
     */
    function uninstall($parent) {
        $db = JFactory::getDBO();

        $sql = 'SELECT `extension_id` AS id, `name`, `element`, `folder` FROM #__extensions WHERE `type` = "module" AND ( (`element` = "mod_sexypolling") ) ';
        $db->setQuery($sql);
        $sexy_polling_module = $db->loadObject();
        $module_uninstaller = new JInstaller;
        if($module_uninstaller->uninstall('module', $sexy_polling_module->id))
             echo '<p>'.JText::_('COM_SEXYPOLLING_MODULE_UNINSTALL_SUCCESS').'</p>';
        else
            echo '<p>'.JText::_('COM_SEXYPOLLING_MODULE_UNINSTALL_FAILED').'</p>';

        // uninstalling sexy polling plugin
        $db->setQuery("select extension_id from #__extensions where name = 'PLG_SEXYPOLLING_NAME' and type = 'plugin' and element = 'sexypolling'");
        $cis_plugin = $db->loadObject();
        $plugin_uninstaller = new JInstaller;
        if($plugin_uninstaller->uninstall('plugin', $cis_plugin->extension_id))
            echo '<p>'.JText::_('COM_SEXYPOLLING_PLUGIN_UNINSTALL_SUCCESS').'</p>';
        else
            echo '<p>'.JText::_('COM_SEXYPOLLING_PLUGIN_UNINSTALL_FAILED').'</p>';
    }

    /**
     * method to update the component
     *
     * @return void
     */
    function update($parent) {
        $module_installer = new JInstaller;
        if(@$module_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'module')) {
            //echo '<p>'.JText::_('COM_SEXYPOLLING_MODULE_INSTALL_SUCCESS').'</p>';
        } else
           echo '<p>'.JText::_('COM_SEXYPOLLING_MODULE_INSTALL_FAILED').'</p>';

        $plugin_uninstaller = new JInstaller;
        if(@$plugin_uninstaller->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'plugin')) {
            //echo '<p>'.JText::_('COM_SEXYPOLLING_PLUGIN_INSTALL_SUCCESS').'</p>';
        } else
            echo '<p>'.JText::_('COM_SEXYPOLLING_PLUGIN_INSTALL_FAILED').'</p>';

        // enabling plugin
        $db = JFactory::getDBO();
        $db->setQuery('UPDATE #__extensions SET enabled = 1 WHERE element = "sexypolling" AND folder = "system"');
        $db->execute();
    }

    /**
     * method to run before an install/update/uninstall method
     *
     * @return void
     */
    function preflight($type, $parent) {
        // $parent is the class calling this method
        // $type is the type of change (install, update or discover_install)
        //echo '<p>' . JText::_('COM_HELLOWORLD_PREFLIGHT_' . $type . '_TEXT') . '</p>';
    }

    /**
     * method to run after an install/update/uninstall method
     *
     * @return void
     */
function postflight($type, $parent) {
        $db = JFactory::getDBO();
        $query = "SELECT * FROM `#__sexy_polls` LIMIT 1";
        $db->setQuery($query);
        $columns_data = $db->LoadAssoc();
        $columns_titles = array_keys($columns_data);

        if(is_array($columns_titles)) {
            if(!in_array('showvotesperiod',$columns_titles)) {
                //add required columns
                $query_update = "
                                    ALTER TABLE  `#__sexy_polls`
                                        ADD `showvotesperiod` TINYINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `stringdateformat` TEXT NOT NULL,
                                        ADD `votescountformat` TINYINT UNSIGNED NOT NULL DEFAULT  '2',
                                        ADD `scaledefault` TINYINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `showaddanswericon` TINYINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `showscaleicon` TINYINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `showbackicon` TINYINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `showtimelineicon` TINYINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `showtimeline` TINYINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `showvotescountinfo` TINYINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `poll_width` TEXT NOT NULL,
                                        ADD `pollalign` TINYINT UNSIGNED NOT NULL DEFAULT  '2',
                                        ADD `addclearboth` TINYINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `poll_margintop` SMALLINT UNSIGNED NOT NULL DEFAULT  '5',
                                        ADD `poll_marginbottom` SMALLINT UNSIGNED NOT NULL DEFAULT  '5',
                                        ADD `poll_marginleft` SMALLINT UNSIGNED NOT NULL DEFAULT  '5',
                                        ADD `poll_marginright` SMALLINT UNSIGNED NOT NULL DEFAULT  '5',
                                        ADD `classsuffix` TEXT NOT NULL,
                                        ADD `checktoken` TINYINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `ipcount` INT UNSIGNED NOT NULL DEFAULT  '0',
                                        ADD `checkacl` TINYINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `votechecks` TINYINT UNSIGNED NOT NULL DEFAULT  '0'
                                ";
                $db->setQuery($query_update);
                $db->execute();

                //update columns
                $query_update = "UPDATE `#__sexy_polls` SET `stringdateformat` = 'F j, Y'";
                $db->setQuery($query_update);
                $db->execute();

                $query_update = "
                                    ALTER TABLE  `#__sexy_answers`
                                        ADD `show_name` TINYINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `img_width` INT UNSIGNED NOT NULL DEFAULT  '100',
                                        ADD `img_name` TEXT NOT NULL,
                                        ADD `img_url` TEXT NOT NULL,
                                        ADD `embed` TEXT NOT NULL
                                ";
                $db->setQuery($query_update);
                $db->execute();

                $query_update = "ALTER TABLE  `#__sexy_votes` ADD  `id_user` INT UNSIGNED NOT NULL DEFAULT  '0' AFTER  `id_answer`";
                $db->setQuery($query_update);
                $db->execute();
            }

            if(!in_array('showresultsduringpoll',$columns_titles)) {
                $query_update = "ALTER TABLE `#__sexy_polls` ADD `showresultsduringpoll` tinyint(3) unsigned NOT NULL DEFAULT '1' AFTER `date_end`";
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
                $query_update = "alter table #__sexy_votes add column id_vote int(10) unsigned primary key NOT NULL AUTO_INCREMENT FIRST";
                $db->setQuery($query_update);
                $db->execute();
            }
        }

    }
}