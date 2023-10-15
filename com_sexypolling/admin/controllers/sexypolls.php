<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: sexypolls.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 * Extended by:
 * @version v3.0.0
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 - 2023 Jefferson49
 * @license GNU/GPL v3.0
 * 

 */
 
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\Session\Session;

// no direct access
defined('_JEXEC') or die('Restircted access');

class SexyPollingControllerSexyPolls extends AdminController
{
	/**
	 * Constructor.
	 *
	 * @param	array	$config	An optional associative array of configuration settings.
	 *
	 * @return	ContactControllerContacts
	 * @see		AdminController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->registerTask('unfeatured',	'featured');
	}

	/**
	 * Method to toggle the featured setting of a list of polls.
	 *
	 * @return	void
	 * @since	1.6
	 */
	function featured()
	{
		// Check for request forgeries
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

		// Initialise variables.
		$ids	= Factory::getApplication()->input->get('cid');
		$values	= array('featured' => 1, 'unfeatured' => 0);
		$task	= $this->getTask();
		$value	= \Joomla\Utilities\ArrayHelper::getValue($values, $task, 0, 'int');
		// Get the model.
		$model = $this->getModel();

		if (empty($ids)) {
			Factory::getApplication()->enqueueMessage(500, Text::_('COM_CONTACT_NO_ITEM_SELECTED'));
		} else {
			// Publish the items.
			if (!$model->featured($ids, $value)) {
				Factory::getApplication()->enqueueMessage(500, $model->getError());
			}
		}

		$this->setRedirect('index.php?option=com_sexypolling&view=sexypolls');
	}

	/**
	 * Proxy for getModel.
	 *
	 * @param	string	$name	The name of the model.
	 * @param	string	$prefix	The prefix for the PHP class name.
	 *
	 * @return	AdminModel
	 * @since	1.6
	 */
	public function getModel($name = 'sexypoll', $prefix = 'SexyPollingModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
	
		/**
		 * Method to save the submitted ordering values for records via AJAX.
		 *
		 * @return	void
		 *
		 * @since   3.0
		 */
		public function saveOrderAjax()
		{
			// Get the input
			$pks   = $this->input->post->get('cid', array(), 'array');
			$order = $this->input->post->get('order', array(), 'array');
			// Sanitize the input
			\Joomla\Utilities\ArrayHelper::toInteger($pks);
			\Joomla\Utilities\ArrayHelper::toInteger($order);
		
			// Get the model
			$model = $this->getModel();
		
			// Save the ordering
			$return = $model->saveorder($pks, $order);
		
			if ($return)
			{
				echo "1";
			}
		
			// Close the application
			Factory::getApplication()->close();
		}
}
