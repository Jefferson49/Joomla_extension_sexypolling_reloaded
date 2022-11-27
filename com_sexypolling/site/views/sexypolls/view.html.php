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

class SexypollingViewsexypolls extends JViewLegacy {
    function display($tpl = null) {
        $items = $this->get( 'Data');
        $this->assignRef( 'items', $items );
        parent::display($tpl);
    }
}
?>