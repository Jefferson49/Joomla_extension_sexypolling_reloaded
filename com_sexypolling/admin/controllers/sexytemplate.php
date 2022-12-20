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
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
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
		$cid  = JFactory::getApplication()->input->post->get('cid');

		if ($cid !== null) {
			$id = $cid[0];
		}
		else {
			$id = 0;			
		}
		
		$id = $id == 0 ? JFactory::getApplication()->input->get->getInt('id',0) : $id;
		JFactory::getApplication()->input->set( 'view', 'sexytemplate' );
		JFactory::getApplication()->input->set( 'layout', 'form'  );
		JFactory::getApplication()->input->set('hidemainmenu', 1);
		
		$link = 'index.php?option=com_sexypolling&view=sexytemplate&layout=form&id='.$id;
		$msg = '';
		$this->setRedirect($link, $msg);
		//parent::display();
	}
	
	
	public function add()
	{
		JFactory::getApplication()->input->set( 'view', 'sexytemplate' );
		JFactory::getApplication()->input->set( 'layout', 'add'  );
		JFactory::getApplication()->input->set('hidemainmenu', 1);
	
		parent::display();
	}
	
	public function save($key = null, $urlVar = null)
	{
		$cid  = JFactory::getApplication()->input->post->get('cid');

		if ($cid !== null) {
			$id = $cid[0];
		}
		else {
			$id = 0;			
		}

		$id = $id == 0 ? JFactory::getApplication()->input->get->getInt('id',0) : $id;
		
		$task = JFactory::getApplication()->input->getCmd('task');
		$model = $this->getModel('sexytemplate');
	
		if ($model->store()) {
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
