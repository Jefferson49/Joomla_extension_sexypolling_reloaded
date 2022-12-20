<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: default.php 2012-04-05 14:30:25 svn $
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

$id_15 = JFactory::getApplication()->input->getInt('category',  0);
$sp_class = new SexypollingHelper;
$sp_class->id_poll = 0;
$sp_class->id_category = $id_15;
$sp_class->module_id = 0;
$sp_class->type = 'component';
$sp_class->class_suffix = '';
echo $sp_class->render_html();
?>