<?php
/**
 * @package jDownloads
 * @version 4.0  
 * @copyright (C) 2007 - 2022 - Arno Betz - www.jdownloads.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
 * 
 * jDownloads is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * Extended by:
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 - 2024 Jefferson49
 * @license GNU/GPL v3.0
 */

 
\defined( '_JEXEC' ) or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper;

/**
 * Sexypolling votes export controller
 *
 */

 class SexyPollingControllerVotesExport extends AdminController
{
	/**
	 * Constructor
	 *                                 
	 */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Logic for exporting votes into a file
	 *
	 */
    public function runExport()
    {
        $app = Factory::getApplication();
        
        // Check for request forgeries
        Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

        $db = Factory::getContainer()->get('DatabaseDriver');
        $params = ComponentHelper::getParams('com_sexypolling');

        $tempdir    = JPATH_ADMINISTRATOR.'/components/com_sexypolling/export';
        $separator  = $params->get('separator_for_csv_export');
        
        $sitename = $db->escape($app->get('sitename'));
        $sitename = substr($sitename, 0, 10);
  	    
        // Access check 
        if (!$app->getIdentity()->authorise('core.admin','com_sexypolling')){            
            Factory::getApplication()->enqueueMessage( Text::_('JERROR_ALERTNOAUTHOR'), 'warning');
            $this->setRedirect(ROUTE::_('index.php?option=com_sexypolling', true));
        } else {
                
            // Query the database to get the votes data 
            $query  = $db->getQuery(true);

            $query->select('id_vote, id_answer, id_poll, v.id_user, a.name as answer, p.name as poll, username, ip, date, country, city, region');
            $query->from('#__sexy_votes as v');
            $query->join('LEFT', '#__users AS u ON id_user = u.id');
            $query->join('LEFT', '#__sexy_answers AS a ON id_answer = a.id');
            $query->join('LEFT', '#__sexy_polls AS p ON a.id_poll = p.id');        
            
            $db->setQuery($query);
            $result = $db->execute();
            $rows = $db->loadAssocList();
            $columns_data = $db->LoadAssoc();
            $columns_titles = array_keys($columns_data);

            if ($result){
                
                // Create file with data             
                $date_current = HtmlHelper::_('date', '','Y-m-d_H-i-s');
                $filename = $sitename.'_com_sexypolling_votes_'.$date_current.'.csv';
                $path = $tempdir.'/'.$filename;                 
                $fp = fopen($path, 'w');
     
                fputcsv($fp, $columns_titles, $separator);
                
                foreach($rows as $row) {
                    fputcsv($fp, array_values($row), $separator);
                }

                //Export
                if ($result !== false && File::exists($path)){
               
                    $len = filesize($path);
                    $ctype = 'text/csv';

                    ob_end_clean();
                    
                    // Send the file
                    header("Content-Description: File Transfer");
                    header("Content-Type: " . $ctype);
                    header("Content-Length: ".(string)$len);
                    header('Content-Disposition: attachment; filename="'.$filename.'"');
                    header("Content-Transfer-Encoding: text\n");

                    if (!ini_get('safe_mode')){ 
                        @set_time_limit(0);
                    }

                    @readfile($path);                
                    exit;                 
                
                } else {
                    // We could not create the file
                    $this->setRedirect(ROUTE::_('index.php?option=com_sexypolling'),  Text::_('COM_SEXYPOLLING_VOTES_EXPORT_FILE_ERROR'), 'error');
                }
            } else {
                // We could not find any data
                $this->setRedirect(ROUTE::_('index.php?option=com_sexypolling'),  Text::_('COM_SEXYPOLLING_VOTES_EXPORT_DATA_ERROR'), 'error');
            }
            
        }     
    }	
}
