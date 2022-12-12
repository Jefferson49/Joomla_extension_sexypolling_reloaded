<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: mod_sexypolling.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

// get a parameter from the module's configuration
$module_id = $module->id;
$id_poll = $params->get('poll_id',1);
$poll_type = $params->get('poll_type',0);
$category_id = $params->get('category_id');
$class_suffix = $params->get('class_suffix','');

//include helper class
require_once JPATH_SITE.'/components/com_sexypolling/helpers/helper.php';

$sp_class = new SexypollingHelper;
$sp_class->id_poll = $id_poll;
//ToDo: Check if id_category is the correct variable name
$sp_class->id_category = $poll_type == 0 ? 0 : $category_id;
$sp_class->module_id = $module_id;
$sp_class->type = 'module';
$sp_class->class_suffix = $class_suffix;
echo $sp_class->render_html();
?>