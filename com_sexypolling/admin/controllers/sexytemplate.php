<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: sexytemplate.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 * Extended by:
 * @version v3.0.0
 * @author Jefferson49
 * @link https://github.com/Jefferson49/joomla4_plugin_sexy_polling
 * @copyright Copyright (c) 2022 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

jimport('joomla.application.component.controllerform');

class SexyPollingControllerSexyTemplate extends JControllerForm
{
	protected $view_item = 'aaa';
	public function edit($key = null, $urlVar = null)
	{
		$id = $_POST['cid'][0];
		$id = $id == 0 ? (int)$_GET['id'] : $id;
		JFactory::getApplication()->getInput()->set( 'view', 'sexytemplate' );
		JFactory::getApplication()->getInput()->set( 'layout', 'form'  );
		JFactory::getApplication()->getInput()->set('hidemainmenu', 1);
		
		$link = 'index.php?option=com_sexypolling&view=sexytemplate&layout=form&id='.$id;
		$this->setRedirect($link, $msg);
		//parent::display();
	}
	
	
	public function add()
	{
		JFactory::getApplication()->getInput()->set( 'view', 'sexytemplate' );
		JFactory::getApplication()->getInput()->set( 'layout', 'add'  );
		JFactory::getApplication()->getInput()->set('hidemainmenu', 1);
	
		parent::display();
	}
	
	public function save($key = null, $urlVar = null)
	{
		$id = $_POST['cid'][0];
		$id = $id == 0 ? (int)$_GET['id'] : $id;
		
		$task = $_REQUEST['task'];
		$model = $this->getModel('sexytemplate');
	
		if ($model->store($post)) {
			$msg = JText::_( 'COM_SEXYPOLLING_TEMPLATE_SAVED' );
		} else {
			$msg = JText::_( 'COM_SEXYPOLLING_ERROR_SAVING_TEMPLATE' );
		}
	
		// Check the table in so it can be edited.... we are done with it anyway
		if($task == 'apply' && $id != 0) {

			$link = 'index.php?option=com_sexypolling&view=sexytemplate&layout=form&id='.$id;
		}
		else
			$link = 'index.php?option=com_sexypolling&view=sexytemplates';
		$this->setRedirect($link, $msg);
	}
	
	public function cancel($key = null, $urlVar = null)
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		$msg = JText::_( 'COM_SEXYPOLLING_OPERATION_CANCELLED' );
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexytemplates', $msg );
	}
}
