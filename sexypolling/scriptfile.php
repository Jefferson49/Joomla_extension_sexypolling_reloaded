<?php
/**
 * Joomla! extension sexypolling
 *
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 - 2025 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

use Joomla\CMS\Factory;
use Joomla\Database\DatabaseInterface;


// no direct access
defined('_JEXEC') or die('Restircted access');


class pkg_sexypollingInstallerScript
{
    /**
     * Called on package uninstall
     *
     * @param  object  $parent  The class calling this method (installer adapter)
     * @return void
     */
    public function uninstall($parent)
    {
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

        $db = Factory::getContainer()->get(DatabaseInterface::class);

        // enabling the plugins
        $db->setQuery('UPDATE #__extensions SET enabled = 1 WHERE element = "sexypolling" AND folder = "system"');
        $db->execute();
        $db->setQuery('UPDATE #__extensions SET enabled = 1 WHERE element = "sexypolling" AND folder = "editors-xtd"');
        $db->execute();
    }  
}
