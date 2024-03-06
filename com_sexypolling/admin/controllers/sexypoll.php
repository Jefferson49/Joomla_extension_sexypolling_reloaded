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
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die('Restircted access');

class SexyPollingControllerSexyPoll extends FormController
{
    /**
	 * Method to create a new poll based on the settings of an existing poll
	 *
	 * @return	void
	 */
	function copy()
	{
		// Check for request forgeries
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

		$app   	 = Factory::getApplication();
		$input   = $app->getInput();
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

		// Save the data to the session in post->jform
		$data = [];
		$table->load($recordId);

		$fields = $table->getFields();

		foreach ($fields as $field) {
			if (array_key_exists($field->Field, $data)) {
				continue;
			}

			$data[$field->Field] = $table->{$field->Field};
		}

		$input->post->set('jform', $data);

		// Set task to save2copy
		$this->task='save2copy';

		// Call parent for save2copy
		parent::save();

		$this->setRedirect('index.php?option=com_sexypolling&view=sexypolls');
	}	
}
