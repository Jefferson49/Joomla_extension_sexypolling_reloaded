<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: view.html.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class SexypollingViewSexypoll extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');
		$max_id	= $this->get('max_id');
		$this->assignRef( 'max_id', $max_id );
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar($max_id);
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar($max_id)
	{
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		// Since we don't track these assets at the item level, use the category id.

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'JTOOLBAR_EDIT' );
		JToolBarHelper::title(   JText::_( 'COM_SEXYPOLLING_POLL' ).': <small><small>[ ' . $text.' ]</small></small>','manage.png' );
	
		JToolBarHelper::apply('sexypoll.apply');
		JToolBarHelper::save('sexypoll.save');
		
		// Build the actions for new and existing records.
		if ($isNew)  {
			JToolBarHelper::cancel('sexypoll.cancel');
		}
		else {
			JToolBarHelper::cancel('sexypoll.cancel','JTOOLBAR_CLOSE');
		}
	}
}