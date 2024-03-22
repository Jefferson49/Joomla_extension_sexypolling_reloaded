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
use Joomla\CMS\Date\Date;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die('Restircted access');

class SexyPollingControllerSexyPoll extends FormController
{
	/**
	 * Method to save a record.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if successful, false otherwise.
	 *
	 * @since   1.6
	 */
	public function save($key = null, $urlVar = null)
	{
		$post = Factory::getApplication()->input->post;
		$data = $post->get('jform', array(), 'array');

		$data_time_zone = 'UTC';
		$current_date   = new Date("now", $data_time_zone);
        $datenow        = HTMLHelper::date("now", "Y-m-d H:i:s", $data_time_zone);
		$datenow_sql    = HTMLHelper::date($current_date, "Y-m-d", $data_time_zone);

		//Modify start/end dates if they contain wrong default values
		if($data['date_start'] === "0000-00-00 00:00:00" OR $data['date_start'] === ""){		
			$data['date_start'] = $datenow_sql;
			$post->set('jform', $data);
		}

		if($data['date_end'] === "0000-00-00 00:00:00"){
			$data['date_end'] = "";
			$post->set('jform', $data);
		}		

		//Modify created date if it contains wrong default values
		if($data['created'] === "0000-00-00 00:00:00" OR $data['created'] === ""){		
			$data['created'] = $datenow;
			$post->set('jform', $data);
		}

		return parent::save($key, $urlVar);
	}
		
    /**
	 * Method to create a new poll based on the settings of an existing poll
	 *
	 * @return	void
	 */
	function copy()
	{
		// Check for request forgeries
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

		$input	 = Factory::getApplication()->input;
		$model   = $this->getModel();
        $table   = $model->getTable();
		
		// Determine the name of the primary key for the data.
		if (empty($key)) {
			$key = $table->getKeyName();
		}

		// To avoid data collisions the urlVar may be different from the primary key.
		if (empty($urlVar)) {
			$urlVar = $key;
		}

		// Get selected id
		$cid     = (array) $this->input->post->get('cid', [], 'int');

		// Get the previous record id (if any) and the current record id.
		$recordId = (int) (\count($cid) ? $cid[0] : $this->input->getInt($urlVar));

		// Create array with poll settings
		$data = [];
		$table->load($recordId);

		$fields = $table->getFields();

		foreach ($fields as $field) {
			if (array_key_exists($field->Field, $data)) {
				continue;
			}

			$data[$field->Field] = $table->{$field->Field};
		}

		// Create poll name for copy
		$poll_names = $this->getPollNames();
		$poll_name = $data['name'];

		$i = 2;
		while(in_array($copy_poll_name = $poll_name . ' (' . (string) $i  . ')', $poll_names)) {
			$i++;
		}

		$data['name'] = $copy_poll_name;		

		// Save the data to the session in post->jform
		$input->post->set('jform', $data);

		// Set task to save2copy
		$this->task='save2copy';

		// Call parent for save2copy
		parent::save();

		$this->setRedirect('index.php?option=com_sexypolling&view=sexypolls');
	}
    /**
	 * Create a list of all existing poll names
	 *
	 * @return	array
	 */
	function getPollNames(): array
	{
		$db = Factory::getDBO();
		$query = "SELECT * FROM `#__sexy_polls`";
		$db->setQuery( $query );
		$polls = $db->loadAssocList();

		$poll_names = [];

		foreach($polls as $poll) {
			$poll_names[] = $poll['name'];
		}

		return $poll_names;
	}
}
