<?php
/**
 * Joomla! component sexypolling
 *
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 - 2024 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

defined( '_JEXEC' ) or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Session\Session;

class PlgButtonSexypolling extends CMSPlugin {
     
    protected $autoloadLanguage = true;
    
    function __construct(&$subject, $config)
    {
        parent::__construct($subject, $config);
    }    

	public function onDisplay($name, $asset, $author)
    {
        /*
         * Use the built-in element view to select the plugin.
         * Currently uses blank class.
         */

        $user  = Factory::getUser();

        if ($user->authorise('core.create', 'com_sexypolling')
            || $user->authorise('core.edit', 'com_sexypolling')
            || $user->authorise('core.edit.own', 'com_sexypolling')) {

            $link = 'index.php?option=com_sexypolling&amp;view=sexypolls&amp;layout=modal&amp;tmpl=component&amp;editor=' . $name . '&amp;' . Session::getFormToken() . '=1'; 
        }
        $button             = new CMSObject;
        $button->modal      = true;
        $button->link       = $link;
        $button->text       = Text::_('PLG_EDITORS_XTD_SEXYPOLLING_BUTTON_TEXT');                  
        $button->name       = $this->_type . '_' . $this->_name;
        $button->icon       = 'file-add';
        $button->iconSVG    = '<svg viewBox="0 0 32 32" width="24" height="24"><path d="M28 24v-4h-4v4h-4v4h4v4h4v-4h4v-4zM2 2h18v6h6v10h2v-10l-8-8h-20v32h18v-2h-16z"></path></svg>';
        $button->options    = "{handler: 'iframe', size: {x: 990, y: 500}}";		
		        
		return $button;
	}
}
