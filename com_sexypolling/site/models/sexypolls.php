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
 */

use Joomla\CMS\MVC\Model\BaseDatabaseModel;

// no direct access
defined('_JEXEC') or die('Restircted access');

class SexypollingModelSexypolls extends BaseDatabaseModel {
    function __construct() {
		parent::__construct();
    }
}
?>