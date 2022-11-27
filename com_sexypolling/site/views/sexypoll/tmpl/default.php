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
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

$id_15 = JRequest::getVar('poll',  0, '', 'int');
$sp_class = new SexypollingHelper;
$sp_class->id_poll = $id_15;
$sp_class->id_category = 0;
$sp_class->module_id = 0;
$sp_class->type = 'component';
$sp_class->class_suffix = '';
echo $sp_class->render_html();
?>
