<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: sexypoll.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Table\Table;

// no direct access
defined('_JEXEC') or die('Restircted access');

class SexypollingModelSexypoll extends AdminModel
{
	//get max id
	public function getMax_id()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query = 'SELECT COUNT(id) AS count_id FROM #__sexy_polls';
		$db->setQuery($query);
		$max_id = $db->loadResult();
		return $max_id;
	}
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	string	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	Table	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'SexyPoll', $prefix = 'SexyPollTable', $config = array()) 
	{
		return Table::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_sexypolling.sexypoll', 'sexypoll', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = Factory::getApplication()->getUserState('com_sexypolling.edit.sexypoll.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
			$data = $this->getItem();
		return $data;
	}
	
	protected function canEditState($record)
	{
		return parent::canEditState($record);
	}
	
	
	/**
	 * Method to toggle the featured setting of contacts.
	 *
	 * @param	array	$pks	The ids of the items to toggle.
	 * @param	int		$value	The value to toggle to.
	 *
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	public function featured($pks, $value = 0)
	{
		$app = Factory::getApplication();

		// Sanitize the ids.
		$pks = (array) $pks;
		\Joomla\Utilities\ArrayHelper::toInteger($pks);
	
		if (empty($pks)) {
			$app->enqueueMessage(Text::_('COM_SEXYPOLLING_NO_ITEM_SELECTED'), 'error');
		}
	
		$table = $this->getTable();
	
		try
		{
			$db = $this->getDbo();
	
			$db->setQuery(
					'UPDATE #__sexy_polls' .
					' SET featured = '.(int) $value.
					' WHERE id IN ('.implode(',', $pks).')'
			);
			
			$db->execute();
		}
		catch (Exception $e)
		{
			$app->enqueueMessage(JText::_($e->getMessage()), 'error');
		}
	
		$table->reorder();
	
		// Clean component's cache
		$this->cleanCache();
	
		return true;
	}
}