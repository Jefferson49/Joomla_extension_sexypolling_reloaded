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
 * @copyright Copyright (c) 2022 - 2025 Jefferson49
 * @license GNU/GPL v3.0
 * 
 * 
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Session\Session;

// no direct access
defined('_JEXEC') or die('Restircted access');

class SexyPollingControllerSexyTemplate extends FormController
{
	protected $view_item = 'aaa';
	public function edit($key = null, $urlVar = null)
	{
		$cid  = Factory::getApplication()->input->get('cid');

		if ($cid !== null) {
			$id = $cid[0];
		}
		else {
			$id = 0;			
		}
		
		$id = $id == 0 ? Factory::getApplication()->input->getInt('id',0) : $id;
		Factory::getApplication()->input->set( 'view', 'sexytemplate' );
		Factory::getApplication()->input->set( 'layout', 'form'  );
		Factory::getApplication()->input->set('hidemainmenu', 1);
		
		$link = 'index.php?option=com_sexypolling&view=sexytemplate&layout=form&id='.$id;
		$msg = '';
		$this->setRedirect($link, $msg);
		//parent::display();

		return true;
	}
	
	
	public function add()
	{
		Factory::getApplication()->input->set( 'view', 'sexytemplate' );
		Factory::getApplication()->input->set( 'layout', 'add'  );
		Factory::getApplication()->input->set('hidemainmenu', 1);
	
		parent::display();

		return true;
	}
	
	public function save($key = null, $urlVar = null)
	{
		$cid  = Factory::getApplication()->input->get('cid');

		if ($cid !== null) {
			$id = $cid[0];
		}
		else {
			$id = 0;			
		}

		$id = $id == 0 ? Factory::getApplication()->input->getInt('id',0) : $id;
		
		$task = Factory::getApplication()->input->getCmd('task');
		$model = $this->getModel('sexytemplate');
	
		if ($model->store()) {
			$msg = Text::_( 'COM_SEXYPOLLING_TEMPLATE_SAVED' );
		} else {
			$msg = Text::_( 'COM_SEXYPOLLING_ERROR_SAVING_TEMPLATE' );
		}
	
		// Check the table in so it can be edited.... we are done with it anyway
		if($task == 'apply' && $id != 0) {

			$link = 'index.php?option=com_sexypolling&view=sexytemplate&layout=form&id='.$id;
		}
		else
			$link = 'index.php?option=com_sexypolling&view=sexytemplates';
		$this->setRedirect($link, $msg);

		return true;
	}
	
	public function cancel($key = null, $urlVar = null)
	{
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		
		$msg = Text::_( 'COM_SEXYPOLLING_OPERATION_CANCELLED' );
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexytemplates', $msg );

		return true;
	}
}
