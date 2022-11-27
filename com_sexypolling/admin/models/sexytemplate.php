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
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

class SexypollingModelSexyTemplate extends JModelAdmin
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'SexyTemplate', $prefix = 'SexyPollTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	
	/**
	 * Method to get styles
	 *
	 */
	public function getStyles() {
		if(isset($_GET['id']))
			$id = (int)$_GET['id'];
		$db		= $this->getDbo();
		$sql = "SELECT `styles` FROM `#__sexy_templates` WHERE `id` = ".$id;
		$db->setQuery($sql);
		return $styles = $db->loadResult();
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_sexypolling.sexytemplate', 'sexytemplate', array('control' => '', 'load_data' => $loadData));
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
		$data = JFactory::getApplication()->getUserState('com_sexypolling.edit.sexytemplate.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
	
	/**
	 * Method to save data
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	public function store()
	{
		$id = (int)$_REQUEST['id'];
		$id_template = (int)$_REQUEST['id_template'];
		$published = (int)$_REQUEST['published'];
		$template_name = htmlspecialchars($_REQUEST['name'], ENT_QUOTES);
			
		//if id ==0, we add the record
		if($id == 0) {
	
			$query = ' SELECT * FROM #__sexy_templates '.
					'  WHERE id = '.$id_template;
			$this->_db->setQuery( $query );
			$tmp = $this->_db->loadObject();
	
	
	
			$new_template = new JObject();
			$new_template->id = NULL;
			$new_template->name = $template_name;
			$new_template->published = $published;
			$new_template->styles = $tmp->styles;
	
			if (!$this->_db->insertObject( '#__sexy_templates', $new_template, 'id' ))
				return false;
		}
		else { //else update the record
			$new_template = new JObject();
			$new_template->id = $id;
			$new_template->name = $template_name;
			$styles = $_REQUEST['styles'];
			$styles_formated = '';
			$ind = 0;
			foreach($styles as $k => $val) {
				$styles_formated .= $k.'~'.$val;
				if($ind != sizeof($styles) - 1)
					$styles_formated .= '|';
				$ind ++;
			}
	
			$new_template->styles = $styles_formated;
				
			if (!$this->_db->updateObject( '#__sexy_templates', $new_template, 'id' ))
				return false;
		}
		return true;
	}
}
