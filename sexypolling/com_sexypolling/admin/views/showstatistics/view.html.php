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

use Joomla\CMS\HTML\Helpers\Sidebar;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

// no direct access
defined('_JEXEC') or die('Restircted access');

class SexypollingViewShowstatistics extends HtmlView {

    function display($tpl = null) {
        ToolbarHelper::cancel( 'showstatistics.cancel', 'JTOOLBAR_CLOSE' );
        $this->addToolbar();
		$this->sidebar = Sidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     */
    protected function addToolbar()
    {
		ToolbarHelper::preferences('com_sexypolling');
    }
}
