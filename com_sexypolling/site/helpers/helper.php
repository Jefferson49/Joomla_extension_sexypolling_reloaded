<?php
/**
 * Joomla! component com_sexypolling
 *
 * @version $Id$
 * @author 2GLux.com
 * @license GNU/GPL
 *
 * Extended by:
 * @version v3.0.0
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 - 2024 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

use Joomla\CMS\Access\Access;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;

// no direct access
defined('_JEXEC') or die('Restircted access');

class SexypollingHelper
{
    public $id_poll;
	public $id_category;
	public $module_id;
	public $type;
	public $class_suffix;
	public $_data;

    
    //function to add scripts/styles
    private function add_scripts() {
        //add scripts, styles
        /** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
        $wa = Factory::getApplication()->getDocument()->getWebAssetManager();
        $uri_base = '';

        $cssFile = $uri_base.'components/com_sexypolling/assets/css/main.css';
        $wa->registerAndUseStyle('main', $cssFile);

        $cssFile = $uri_base.'components/com_sexypolling/assets/css/sexycss-ui.css';
        $wa->registerAndUseStyle('sexycss-ui', $cssFile);

        $cssFile = $uri_base.'components/com_sexypolling/assets/css/countdown.css';
        $wa->registerAndUseStyle('countdown', $cssFile);

        $jsFile = $uri_base.'components/com_sexypolling/assets/js/sexylib.js';
        $wa->registerAndUseScript('sexylib', $jsFile);

        $jsFile = $uri_base.'components/com_sexypolling/assets/js/sexylib-ui.js';
        $wa->registerAndUseScript('sexylib-ui', $jsFile);

        $jsFile = $uri_base.'components/com_sexypolling/assets/js/selectToUISlider.jQuery.js';
        $wa->registerAndUseScript('selectToUISlider.jQuery', $jsFile);

        $jsFile = $uri_base.'components/com_sexypolling/assets/js/color.js';
        $wa->registerAndUseScript('color', $jsFile);

        $jsFile = $uri_base.'components/com_sexypolling/assets/js/countdown.js';
        $wa->registerAndUseScript('countdown', $jsFile);

        $jsFile = $uri_base.'components/com_sexypolling/assets/js/sexypolling.js';
        $wa->registerAndUseScript('sexypolling', $jsFile);

        require_once JPATH_BASE.'/modules/mod_sexypolling/helper.php';
        $styles = modSexypollingHelper::getCSS($this->module_id, $this->id_category, $this->id_poll);
        $wa->addInlineStyle($styles);
    }

    private function if_contain($array1,$array2) {
        if(is_array($array2))
            foreach($array1 as $val) {
                if(in_array($val,$array2))
                    return true;
            }
        return false;
    }

    private function get_data() {
        $db = Factory::getContainer()->get('DatabaseDriver');

                    $query = 'SELECT '.
                        'sp.id polling_id, '.
                        'sp.id_template id_template, '.
                        'sp.date_start date_start, '.
                        'sp.date_end date_end, '.
                        'sp.showresultsduringpoll showresultsduringpoll, '.
                        'sp.multiple_answers multiple_answers, '.
                        'sp.voting_period voting_period, '.
                        'sp.number_answers number_answers, '.
                        'sp.voting_permission voting_permission, '.
                        'sp.answerpermission answerpermission, '.
                        'sp.autopublish autopublish, '.
                        'sp.baranimationtype baranimationtype, '.
                        'sp.coloranimationtype coloranimationtype, '.
                        'sp.reorderinganimationtype reorderinganimationtype, '.
                        'sp.dateformat dateformat, '.
                        'sp.autoopentimeline autoopentimeline, '.
                        'sp.autoanimate autoanimate, '.
                        'sp.showresultbutton showresultbutton, '.
                        'sp.showbackbutton showbackbutton, '.
                        'sp.showvotesperiod showvotesperiod, '.
                        'sp.stringdateformat stringdateformat, '.
                        'sp.votescountformat votescountformat, '.
                        'sp.scaledefault scaledefault, '.
                        'sp.showaddanswericon showaddanswericon, '.
                        'sp.showscaleicon showscaleicon, '.
                        'sp.showbackicon showbackicon, '.
                        'sp.showtimelineicon showtimelineicon, '.
                        'sp.showtimeline showtimeline, '.
                        'sp.showvotescountinfo showvotescountinfo, '.
                        'sp.poll_width poll_width, '.
                        'sp.pollalign pollalign, '.
                        'sp.addclearboth addclearboth, '.
                        'sp.poll_margintop poll_margintop, '.
                        'sp.poll_marginbottom poll_marginbottom, '.
                        'sp.poll_marginleft poll_marginleft, '.
                        'sp.poll_marginright poll_marginright, '.
                        'sp.classsuffix classsuffix, '.
                        'sp.checktoken checktoken, '.
                        'sp.ipcount ipcount, '.
                        'sp.checkacl checkacl, '.
                        'sp.votechecks votechecks, '.
                        'st.styles styles, '.
                        'sp.name polling_name, '.
                        'sp.question polling_question, '.
                        'sa.id answer_id, '.
                        'sa.show_name show_name, '.
                        'sa.img_name img_name, '.
                        'sa.img_url img_url, '.
                        'sa.img_width img_width, '.
                        'sa.embed embed, '.
                        'sa.name answer_name '.
                    'FROM '.
                        '`#__sexy_polls` sp '.
                    'JOIN '.
                        '`#__sexy_answers` sa ON sa.id_poll = sp.id '.
                        'AND sa.published = \'1\' '.
                    'LEFT JOIN '.
                        '`#__sexy_templates` st ON st.id = sp.id_template '.
                    'WHERE sp.published = \'1\' ';
                    if((int) $this->id_category == 0)
                        $query .= 'AND sp.id = '.$this->id_poll.' ';
                    else
                        $query .= 'AND sp.id_category = '.$this->id_category.' ';
                    $query .= 'ORDER BY sp.ordering,sp.name,sa.ordering,sa.name';

        $db->setQuery( $query );
        $this->_data = $db->loadObjectList();
    }

    public function render_html()
    {
        //add scripts
        if($this->type != 'plugin')
            $this->add_scripts();

        //get ip address            
        $sexyip = self::getIp();

        //get user groups
        $levels = array();
        $groups = array();

		$user = Factory::getApplication()->getIdentity();
		$user_id = $user !== null ? $user->id : 0;

        $groups = Access::getGroupsByUser($user_id);
        $is_logged_in_user = ( in_array(2,$groups) || in_array(3,$groups) || in_array(6,$groups) || in_array(8,$groups) ) ? true : false;

		//load language and timezone
		$lang = Factory::getApplication()->getLanguage();
		$lang->load('com_sexypolling');
		$lang_tag = $lang->getTag();
        $user_time_zone = $user->getTimezone()->getName();
        if ($user_time_zone === 'UTC') {
            $iterator = new ArrayIterator(iterator_to_array(IntlTimeZone::createEnumeration(substr($lang_tag ?? '', -2))));
            $iterator->rewind();
            $user_time_zone = $iterator->current();    
        }
		
		//Set UTC as time zone for database values and calculations
		$data_time_zone = 'UTC';
        $debug_date_UTC =  HTMLHelper::date('now', 'F d, Y', $data_time_zone);
        $debug_date_user = HTMLHelper::date('now', 'F d, Y', $user_time_zone);

        //get data
        $this->get_data();

        $debug_date = HTMLHelper::date('2022-03-15', 'F d, Y', $data_time_zone);

        //create polls array
        $pollings = array();
        for ($i=0, $n=count( $this->_data ); $i < $n; $i++) {
            $pollings[$this->_data[$i]->polling_id][] = $this->_data[$i];
        }

        //initialaze variables
        $polling_select_id = array();
        $custom_styles = array();
        $voted_ids = array();
        $start_disabled_ids = array();
        $end_disabled_ids = array();
        $hide_results_ids = array();
        $date_now = strtotime(HTMLHelper::date("now", "Y-m-d H:i:s", $data_time_zone));
        $voting_periods = array();
        $voting_permissions = array();
        $number_answers_array = array();
        $answerPermission = array();
        $autoPublish = array();
        $autoOpenTimeline = array();
        $dateFormat = array();
        $autoAnimate = array();
        $sexyAnimationTypeBar = array();
        $sexyAnimationTypeContainer = array();
        $sexyAnimationTypeContainerMove = array();

        //strat buffer
        ob_start();

        if(sizeof($pollings) > 0) {

            $polling_words = array(Text::_("COM_SEXYPOLLING_WORD_1"),Text::_("COM_SEXYPOLLING_WORD_2"),Text::_("COM_SEXYPOLLING_WORD_3"),Text::_("COM_SEXYPOLLING_WORD_4"),Text::_("COM_SEXYPOLLING_WORD_5"),Text::_("COM_SEXYPOLLING_WORD_6"),Text::_("COM_SEXYPOLLING_WORD_7"),Text::_("COM_SEXYPOLLING_WORD_8"),Text::_("COM_SEXYPOLLING_WORD_9"),Text::_("COM_SEXYPOLLING_WORD_10"),Text::_("COM_SEXYPOLLING_WORD_11"),Text::_("COM_SEXYPOLLING_WORD_12"),Text::_("COM_SEXYPOLLING_WORD_13"),Text::_("COM_SEXYPOLLING_WORD_14"),Text::_("COM_SEXYPOLLING_WORD_15"),Text::_("COM_SEXYPOLLING_WORD_16"),Text::_("COM_SEXYPOLLING_WORD_17"),Text::_("COM_SEXYPOLLING_WORD_18"),Text::_("COM_SEXYPOLLING_WORD_19"),Text::_("COM_SEXYPOLLING_WORD_20"),Text::_("COM_SEXYPOLLING_WORD_21"),Text::_("COM_SEXYPOLLING_WORD_22"),Text::_("COM_SEXYPOLLING_WORD_23"),Text::_("COM_SEXYPOLLING_WORD_24"),Text::_("COM_SEXYPOLLING_WORD_25"),Text::_("COM_SEXYPOLLING_WORD_26"),Text::_("COM_SEXYPOLLING_WORD_27"));

            $module_id = $this->module_id;
            $db = Factory::getContainer()->get('DatabaseDriver');

            foreach ($pollings as $poll_index => $polling_array) {

                //create parameters array
                $autoPublish[$poll_index] = $polling_array[0]->autopublish;
                $autoOpenTimeline[$poll_index] = $polling_array[0]->autoopentimeline;
                $dateFormat[$poll_index] = $polling_array[0]->dateformat == 1 ? 'str' : 'digits';
                $autoAnimate[$poll_index] = $polling_array[0]->autoanimate;
                $sexyAnimationTypeBar[$poll_index] = $polling_array[0]->baranimationtype;
                $sexyAnimationTypeContainer[$poll_index] = $polling_array[0]->coloranimationtype;
                $sexyAnimationTypeContainerMove[$poll_index] = $polling_array[0]->reorderinganimationtype;
                $showresultbutton = $polling_array[0]->showresultbutton;
                $showbackbutton = $polling_array[0]->showbackbutton;

                $showvotesperiod = $polling_array[0]->showvotesperiod;
                $stringdateformat = $polling_array[0]->stringdateformat;
                $votescountformat = $polling_array[0]->votescountformat;
                $scaledefault = $polling_array[0]->scaledefault;
                $showaddanswericon = $polling_array[0]->showaddanswericon;
                $showscaleicon = $polling_array[0]->showscaleicon;
                $showbackicon = $polling_array[0]->showbackicon;
                $showtimelineicon = $polling_array[0]->showtimelineicon;
                $showtimeline = $polling_array[0]->showtimeline;
                $showvotescountinfo = $polling_array[0]->showvotescountinfo;
                $poll_width = $polling_array[0]->poll_width;
                $pollalign = $polling_array[0]->pollalign;
                $addclearboth = $polling_array[0]->addclearboth;
                $poll_margintop = $polling_array[0]->poll_margintop;
                $poll_marginbottom = $polling_array[0]->poll_marginbottom;
                $poll_marginleft = $polling_array[0]->poll_marginleft;
                $poll_marginright = $polling_array[0]->poll_marginright;

                $number_answers = $polling_array[0]->number_answers;
                $number_answers_array[$poll_index] = $number_answers;
                $voting_period = $polling_array[0]->voting_period;
                $voting_periods[$poll_index] = $voting_period;
                $ipcount = $polling_array[0]->ipcount;                

                //check ACL to add answer
                $add_answer_permissions_id = $polling_array[0]->answerpermission;
                $query = "SELECT `rules` FROM #__viewlevels WHERE id = '$add_answer_permissions_id'";
                $db->setQuery($query);
                $db->execute();
                $levels = explode(',',str_replace(array('[',']'),'',$db->loadResult()));
                $permission_to_show_add_answer_block = $this->if_contain($levels,$groups);
                if(sizeof($levels) == 0 || sizeof($groups) == 0) {
                    $permission_to_show_add_answer_block = true;
                }
                if($polling_array[0]->checkacl == 0)
                    $permission_to_show_add_answer_block = true;

                //check ACL to vote
                $voting_permission_id = $polling_array[0]->voting_permission;
                $query = "SELECT `rules` FROM #__viewlevels WHERE id = '$voting_permission_id'";
                $db->setQuery($query);
                $db->execute();
                $levels = explode(',',str_replace(array('[',']'),'',$db->loadResult()));
                $voting_permissions[$poll_index] = $this->if_contain($levels,$groups);
                if(sizeof($levels) == 0 || sizeof($groups) == 0) {
                    $voting_permissions[$poll_index] = true;
                }
                if($polling_array[0]->checkacl == 0)
                    $voting_permissions[$poll_index] = true;

                $registration_to_vote_required = ( in_array(2,$levels) || in_array(3,$levels) || in_array(6,$levels) || in_array(8,$levels) ) ? true : false;

                if($registration_to_vote_required && $user_id == 0 && sizeof($levels) > 0)
                    $voting_permissions[$poll_index] = false;

                //check start,end dates
                $params = ComponentHelper::getParams('com_sexypolling');
                $start_end_date_time_zone = $params->get('start_end_date_timezone', 'UTC');
                $timezone_offset = (new DateTimeZone($start_end_date_time_zone))->getOffset(new DateTime("now", new DateTimeZone('UTC')));
                $date_start = $polling_array[0]->date_start ?? '2020-01-01';
                $date_end   = $polling_array[0]->date_end   ?? '2040-12-31';
                $time_start = HTMLHelper::date($date_start .' 00:00:00' , "Y-m-d H:i:s", $data_time_zone);
                $time_end   = HTMLHelper::date($date_end.' 23:59:59', "Y-m-d H:i:s", $data_time_zone);

                if($date_start != '0000-00-00' &&  $date_now < strtotime($time_start) - $timezone_offset) {
                    $datevoted = strtotime($time_start) - $timezone_offset;
                    $hours_diff = ($datevoted - $date_now) / 3600;
                    $start_disabled_ids[] = array($poll_index, $polling_words[17] . ' ' . HTMLHelper::date($date_start, $stringdateformat, $start_end_date_time_zone), $hours_diff);
                }
                
                if($date_end != '0000-00-00' &&  $date_now > strtotime($time_end) - $timezone_offset) {
                    $end_disabled_ids[] = array($poll_index, $polling_words[18] . ' ' . HTMLHelper::date($date_end, $stringdateformat, $start_end_date_time_zone));
                }

                // disable results till poll is ended
                if($polling_array[0]->showresultsduringpoll == 0 && $date_now < strtotime($time_end) - $timezone_offset) {
                    $hide_results_ids[$poll_index] = $polling_words[25] . ' ' . HTMLHelper::date($date_end, $stringdateformat, $start_end_date_time_zone);
                }

                //if is logged in user, query votes per user
                if($is_logged_in_user) {
                    $query = "SELECT sv.`ip`,sv.`date` FROM #__sexy_votes sv JOIN #__sexy_answers sa ON sa.id_poll = '$poll_index' WHERE sv.id_answer = sa.id AND sv.id_user = '$user_id' ORDER BY sv.`date` DESC";
                }
                //otherwise query votes per IP
                else {
                    $query = "SELECT sv.`ip`,sv.`date` FROM #__sexy_votes sv JOIN #__sexy_answers sa ON sa.id_poll = '$poll_index' WHERE sv.id_answer = sa.id AND sv.ip = '$sexyip' ORDER BY sv.`date` DESC";
                }

                $db->setQuery($query);
                $db->execute();
                $num_rows = $db->getNumRows();
                $row = $db->loadAssoc();

                //Check time since last vote
                if($num_rows > 0) {
                    $datevoted = strtotime($row['date'] ?? '');
                    $hours_diff = ($date_now - $datevoted) / 3600;
                    if($voting_period == 0 && !in_array($poll_index,array_keys($voted_ids))) {
                        $voted_ids[$poll_index] = '17520';//two years
                    }
                    elseif(!in_array($poll_index,array_keys($voted_ids)) && ($hours_diff < $voting_period))
                        $voted_ids[$poll_index] = $voting_period - $hours_diff;
                }

                //Check if number of votes greater than allowed votes per user or per IP 
                if($ipcount != 0 && $num_rows >= $ipcount) {
                    $voted_ids[$poll_index] = -1; //No voting allowed
                }                         

                //set visibility options
                $add_asnwer_icon_visibility = $showaddanswericon == 0 || !$permission_to_show_add_answer_block ? 'style="display: none !important;" rell="noanimate"' : '';
                $scaling_icon_visibility = $showscaleicon == 0 ? 'style="display: none !important;" rell="noanimate"' : '';
                $back_icon_visibility = $showbackicon == 0 ? 'style="display: none !important;" rell="noanimate"' : '';
                $timeline_icon_visibility = $showtimelineicon == 0 ? 'style="display: none !important;" rell="noanimate"' : '';
                $timeline_visibility = $showtimeline == 0 ? 'style="display: none !important;" rell="noanimate"' : '';
                $votes_data_visibility = $showvotescountinfo == 0 ? 'style="display: none !important;" rell="noanimate"' : '';
                $votes_data_visibility_class = $showvotescountinfo == 0 ? ' sexy_hidden' : '';

                $est_time = isset($voted_ids[$poll_index]) ? (float)$voted_ids[$poll_index] : -1;

                //set styles
                $custom_styles[$poll_index] = $polling_array[0]->styles;
                $container_class_suffix = $polling_array[0]->classsuffix == '' ? '' : ' '.$polling_array[0]->classsuffix;

                $container_styles = '';
                if($poll_width != '') $container_styles = 'width: '.$poll_width.';';
                $container_styles .= $pollalign == 0 ? 'float: left;' : ($pollalign == 1 ? 'float: right;' : 'float: none;');
                $container_styles .= $addclearboth == 1 ? 'clear: both;' : '';
                $container_styles .= $pollalign == 2 ? 'margin: '.$poll_margintop.'px auto '.$poll_marginbottom.'px;' : 'margin: '.$poll_margintop.'px '.$poll_marginright.'px '.$poll_marginbottom.'px '.$poll_marginleft.'px;';

                echo '<div class="polling_container_wrapper'.$container_class_suffix.'" id="mod_'.$module_id.'_'.$poll_index.'" roll="'.$module_id.'" style="'.$container_styles.'"><div class="polling_container" id="poll_'.$poll_index.'">';
                echo '<div class="polling_name">'.stripslashes($polling_array[0]->polling_question ?? '').'</div>';

                $multiple_answers = $polling_array[0]->multiple_answers;
                $multiple_answers_info_array[$poll_index] = $multiple_answers;

                $colors_array = array("black","blue","red","litegreen","yellow","liteblue","green","crimson","litecrimson");

                $cache_dir = __DIR__ . '/../../../cache/com_sexypolling/';
                $cached_img_dir = Uri::base(true) . '/cache/com_sexypolling/';
                $uploaded_img_dir = Uri::base(true) . '/';

                echo '<ul class="polling_ul">';
                foreach ($polling_array as $k => $poll_data) {
                    $color_index = $k % 20 + 1;
                    $data_color_index = $k % 9;
                    //get answer name
                    $answer_name = stripslashes($poll_data->answer_name ?? '');
                    //get image
                    $img_path = $poll_data->img_name != '' ? $poll_data->img_name : $poll_data->img_url;
                    if($poll_data->img_name != '') {
                        //check to see if cached file exists
                        $img_parts = explode('/',$poll_data->img_name);
                        $filename = $img_parts[sizeof($img_parts) - 1];
                        preg_match('/^(.*)\.([a-z]{3,4})/i',$filename,$matches);
                        $img_path_cache = ($matches[1] ?? '') . '-tmb-w' . $poll_data->img_width . '.' . ($matches[2] ?? '');
                        $img_fullpath_cache = $cache_dir . $img_path_cache;
                        if(file_exists($img_fullpath_cache)) {
                            $img_path = $cached_img_dir . $img_path_cache;
                        }
                        else {
                            $img_path = $uploaded_img_dir . $poll_data->img_name;
                        }
                    }

                    echo '<li id="answer_'.$poll_data->answer_id.'" class="polling_li"><div class="animation_block"></div>';
                    echo '<div class="answer_name"><label uniq_index="'.$module_id.'_'.$poll_data->answer_id.'" class="twoglux_label">';
                    if($img_path != '') {
                        echo '<img alt="Image for answer '.$poll_data->answer_id.'" src='.$img_path.' class="poll_answer_img" style="width: '.$poll_data->img_width.'px;" />';
                    }
                    if($poll_data->show_name == 1)
                        echo $answer_name;
                    if($poll_data->embed != '') {
                        echo '<div class="poll_answer_embed_code">'.$poll_data->embed.'</div>';
                    }
                    echo '<div class="sexy_clear"></div>';
                    echo '</label></div>';
                    echo '<div class="answer_input">';

                    if($multiple_answers == 0)
                        echo '<input uniq_index="'.$module_id.'_'.$poll_data->answer_id.'" type="radio" class="poll_answer '.$poll_data->answer_id.' twoglux_styled" value="'.$poll_data->answer_id.'" name="'.$poll_data->polling_id.'" data-color="'.$colors_array[$data_color_index].'" aria-label="answer_'.$module_id.'_'.$poll_data->answer_id.'"/>';
                    else
                        echo '<input uniq_index="'.$module_id.'_'.$poll_data->answer_id.'" type="checkbox" class="poll_answer '.$poll_data->answer_id.' twoglux_styled" value="'.$poll_data->answer_id.'" name="'.$poll_data->polling_id.'"  data-color="'.$colors_array[$data_color_index].'" aria-label="answer_'.$module_id.'_'.$poll_data->answer_id.'"/>';

                    echo '</div><div class="sexy_clear"></div>';
                    echo '<div class="answer_result">';
                    echo '<div class="answer_navigation polling_bar_'.$color_index.'" id="answer_navigation_'.$poll_data->answer_id.'"><div class="grad"></div></div>';
                    echo '<div class="answer_votes_data" id="answer_votes_data_'.$poll_data->answer_id.'">'.$polling_words[0].': ';

                    $votes_count_visibility = $votescountformat == 1 ? 'style="display: none" ' : '';
                    echo '<span '.$votes_count_visibility.'id="answer_votes_data_count_'.$poll_data->answer_id.'"></span><span id="answer_votes_data_count_val_'.$poll_data->answer_id.'" style="display:none"></span>';

                    $votes_percen_count_visibility = $votescountformat == 0 ? 'style="display: none" ' : '';
                    $votes_percen_sign = $votescountformat == 0 ? '' : '%';
                    $votes_percen_pre_symbol = $votescountformat == 2 ? ' (' : '';
                    $votes_percen_after_symbol = $votescountformat == 2 ? ')' : '';
                    echo $votes_percen_pre_symbol.'<span '.$votes_percen_count_visibility.'id="answer_votes_data_percent_'.$poll_data->answer_id.'">0</span><span style="display:none" id="answer_votes_data_percent_val_'.$poll_data->answer_id.'"></span>'.$votes_percen_sign.$votes_percen_after_symbol.'</div>';
                    echo '<div class="sexy_clear"></div>';
                    echo '</div>';
                    echo '</li>';
                }
                echo '</ul>';

                //check permission, to show add answer option
                if($permission_to_show_add_answer_block) {
                    echo '<div class="answer_wrapper opened" ><div style="padding:6px">';

                    //If voting is not allowed add voted button to class
                    $voted_ids_value = $voted_ids[$poll_index] ?? 0;
                    $add_answers_voted_button_class = !in_array($poll_index,$voted_ids) && $voted_ids_value !== -1 ? '' : ' voted_button';

                    echo '<div class="add_answer"><input name="answer_name" class="add_ans_name" value="'.$polling_words[11].'" aria-label="Answer name" />
                    <input type="button" value="'.$polling_words[12].'" class="add_ans_submit'.$add_answers_voted_button_class.'" /><input type="hidden" value="'.$poll_index.'" class="poll_id" /><img alt="Loading icon small" class="loading_small" src="'.Uri::base(true).'/components/com_sexypolling/assets/images/loading_small.gif" /></div>';
                    echo '</div></div>';
                }

                //If option to show back button is activated, add back button
                if ($showbackbutton) {
                    echo '<input type="button" value="'.$polling_words[19].'" class="back_button hide_back_button" />';    
                }

                $new_answer_bar_index = ($k + 1) % 20 + 1;

                echo '<span class="polling_bottom_wrapper1"><img alt="Icon loading polling" src="components/com_sexypolling/assets/images/loading_polling.gif" class="polling_loading" />';

                //If voting allowed add polling submit button else add voted button
                $voted_ids_value = $voted_ids[$poll_index] ?? 0;
                $polling_submit_voted_button_class = !in_array($poll_index,$voted_ids) && $voted_ids_value !== -1 ? '' : ' voted_button';
                echo '<input type="button" value="'.$polling_words[6].'" class="polling_submit' . $polling_submit_voted_button_class . '" id="poll_'.$module_id.'_'.$poll_index.'" />';

                $result_button_class = (($showresultbutton == 0 and $est_time < 0) or isset($hide_results_ids[$poll_index])) ? 'hide_sexy_button' : '';
                echo '<input type="button" value="'.$polling_words[7].'" class="polling_result '.$result_button_class.'" id="res_'.$module_id.'_'.$poll_index.'" />';
                echo '<input type="hidden" name="'.Session::getFormToken().'" class="sexypolling_token" value="1" />';
                echo '</span>';
                echo '<div '.$votes_data_visibility.' class="polling_info'.$votes_data_visibility_class.'"><table cellpadding="0" cellspacing="0" border="0"><tr><td class="left_col">'.$polling_words[1].':<span class="total_votes_val" style="display:none"></span> </td><td class="total_votes right_col"></td></tr><tr><td class="left_col">'.$polling_words[2].': </td><td class="first_vote right_col"></td></tr><tr><td class="left_col">'.$polling_words[3].': </td><td class="last_vote right_col"></td></tr></table></div>';

                //timeline
                $polling_select_id[$poll_index]['select1'] = 'polling_select_'.$module_id.'_'.$poll_index.'_1';
                $polling_select_id[$poll_index]['select2'] = 'polling_select_'.$module_id.'_'.$poll_index.'_2';

                //get count of total votes, min and max dates of voting
                $query = "SELECT COUNT(sv.`id_answer`) total_count, MAX(sv.`date`) max_date,MIN(sv.`date`) min_date FROM `#__sexy_votes` sv JOIN `#__sexy_answers` sa ON sa.id_poll = '$poll_index' WHERE sv.id_answer = sa.id";
                $db->setQuery($query);
                $row_total = $db->loadAssoc();
                $count_total_votes = $row_total['total_count'];
                $min_date = strtotime($row_total['min_date'] ?? '');

                //use current date as max date
                $max_date = $date_now;
                
                //if no votes, set time to current
                if((int)$min_date == 0) {
                    $min_date = $max_date = $date_now;
                }

                $timeline_array = array();

                for($current = $min_date; $current <= $max_date; $current += 86400) {
                    $timeline_array[] = $current;
                }

                //check, if max date is not included in timeline array, then add it.
                if(HTMLHelper::date($max_date,$stringdateformat, $data_time_zone) !== HTMLHelper::date($timeline_array[sizeof($timeline_array) - 1],$stringdateformat, $data_time_zone))
                    $timeline_array[] = $max_date;

                echo '<div class="timeline_wrapper">';
                echo '<div '.$timeline_icon_visibility.' class="timeline_icon" title="'.$polling_words[4].'"></div>';
                echo '<div '.$back_icon_visibility.' class="sexyback_icon" title="'.$polling_words[19].'"></div>';

                $voted_ids_value = $voted_ids[$poll_index] ?? 0;

                if(!in_array($poll_index,$voted_ids) && $voted_ids_value !== -1) {
                    $add_ans_txt = $polling_words[10];
                    $o_class = 'opened';
                }
                else {
                    $add_ans_txt = $polling_words[9];
                    $o_class = 'voted_button';
                }
                echo '<div '.$add_asnwer_icon_visibility.' class="add_answer_icon '.$o_class.'" title="'.$add_ans_txt.'"></div>';

                $scale_class = $scaledefault == 0 ? ' opened' : '';
                echo '<div '.$scaling_icon_visibility.' class="scale_icon'.$scale_class.'" title="'.$polling_words[14].'"></div>';

                echo '<div class="timeline_select_wrapper" '.$timeline_visibility.'>';
                echo '<div style="padding:5px 6px"><select class="polling_select1" id="polling_select_'.$module_id.'_'.$poll_index.'_1" name="polling_select_'.$module_id.'_'.$poll_index.'_1" aria-label="polling_select_'.$module_id.'_'.$poll_index.'_1">';

                if($showvotesperiod == 0)//last day
                    $checked_label = sizeof($timeline_array) - 1;
                elseif($showvotesperiod == 1)//last week
                    $checked_label = sizeof($timeline_array) - 8;
                elseif($showvotesperiod == 2) {//last month
                    //get last month label
                    $d =  (int) HTMLHelper::date($max_date,"d", $data_time_zone);
                    $m =  (int) HTMLHelper::date($max_date,"m", $data_time_zone);
                    $m --;
                    $y =  (int) HTMLHelper::date($max_date,"Y", $data_time_zone);
                    if($m == 1)
                        $days_ = 31;
                    else
                        echo $days_ = HTMLHelper::date($d.'-'.$m.'-'.$y,'t', $user_time_zone);
                    $checked_label = sizeof($timeline_array) - 1 - $days_;
                }
                elseif($showvotesperiod == 3)//last year
                    $checked_label = sizeof($timeline_array) - 366;
                else
                    $checked_label = 0;

                $checked_label = $checked_label < 0 ? 0 : $checked_label;

                $optionGroups = array();
                foreach ($timeline_array as $k => $curr_time) {
                    if(!in_array(HTMLHelper::date($curr_time,'F Y', $data_time_zone),$optionGroups)) {

                        if (sizeof($optionGroups) != 0)
                            echo '</optgroup>';

                        $optionGroups[] = HTMLHelper::date($curr_time,'F Y', $data_time_zone);
                        echo '<optgroup label="'.HTMLHelper::date($curr_time,'F Y', $user_time_zone).'">';
                    }

                    $selected = $k == $checked_label ? 'selected="selected"' : '';

                    $date_item = HTMLHelper::date($curr_time,$stringdateformat, $data_time_zone);

                    echo '<option '.$selected.' value="'.HTMLHelper::date($curr_time,'Y-m-d', $user_time_zone).'">'.$date_item.'</option>';
                }
                echo '</select>';
                echo '<select class="polling_select2" id="polling_select_'.$module_id.'_'.$poll_index.'_2" name="polling_select_'.$module_id.'_'.$poll_index.'_2" aria-label="polling_select_'.$module_id.'_'.$poll_index.'_1">';
                $optionGroups = array();
                foreach ($timeline_array as $k => $curr_time) {

                    if(!in_array(HTMLHelper::date($curr_time,'F Y', $data_time_zone),$optionGroups)) {

                        if (sizeof($optionGroups) != 0)
                            echo '</optgroup>';

                        $optionGroups[] = HTMLHelper::date($curr_time,'F Y', $data_time_zone);
                        echo '<optgroup label="'.HTMLHelper::date($curr_time,'F Y', $user_time_zone).'">';
                    }
                    $selected = $k == sizeof($timeline_array) - 1 ? 'selected="selected"' : '';

                    $date_item = HTMLHelper::date($curr_time,$stringdateformat, $data_time_zone);

                    echo '<option '.$selected.' value="'.HTMLHelper::date($curr_time,'Y-m-d', $user_time_zone).'">'.$date_item.'</option>';
                }
                echo '</select></div>';
                echo '</div>';
                echo '</div>';
                echo '</div></div>';
                echo '<!-- powered by 2glux.com Sexy Polling -->';
            }

            if(sizeof($custom_styles) > 0)
                foreach ($custom_styles as $poll_id => $styles_list) {
                $styles_array = explode('|', $styles_list ?? '');
                foreach ($styles_array as $val) {
                    $arr = explode('~', $val ?? '');
                    $styles_[$poll_id][$arr[0]] = $arr[1];
                }
            }


            //create javascript animation styles array
            $jsInclude = 'if (typeof animation_styles === \'undefined\') { var animation_styles = new Array();};';
            if(sizeof($styles_) > 0)
                foreach ($styles_ as $poll_id => $styles) {
                $s1 = $styles[12];//backround-color
                $s2 = $styles[73];//border-color
                $s3 = $styles[68].' '.$styles[69].'px '.$styles[70].'px '.$styles[71].'px '.$styles[72].'px '.$styles[11];//box-shadow
                $s4 = $styles[74].'px';//border-top-left-radius
                $s5 = $styles[75].'px';//border-top-right-radius
                $s6 = $styles[76].'px';//border-bottom-left-radius
                $s7 = $styles[77].'px';//border-bottom-right-radius
                $s8 = $styles[0];//static color
                $s9 = $styles[68];//shadow type
                $s9 = $styles[68];//shadow type
                $s10 = $styles[90];//navigation bar height
                $s11 = $styles[251];//Answer Color Inactive
                $s12 = $styles[270];//Answer Color Active
                $jsInclude .= 'animation_styles["'.$module_id.'_'.$poll_id.'"] = new Array("'.$s1.'", "'.$s2.'", "'.$s3.'", "'.$s4.'", "'.$s5.'", "'.$s6.'", "'.$s7.'","'.$s8.'","'.$s9.'","'.$s10.'","'.$s11.'","'.$s12.'");';
            }

            //new version added
            //add voting period to javascript
            $jsInclude .= ' if (typeof voting_periods === \'undefined\') { var voting_periods = new Array();};';
            if(sizeof($voting_periods) > 0)
                foreach ($voting_periods as $poll_id => $voting_period) {
                $jsInclude .= 'voting_periods["'.$module_id.'_'.$poll_id.'"] = "'.$voting_period.'";';
            }

            $jsInclude .= 'if (typeof sexyPolling_words === \'undefined\') { var sexyPolling_words = new Array();};';
            foreach ($polling_words as $k => $val) {
                $jsInclude .= 'sexyPolling_words["'.$k.'"] = "'.$val.'";';
            }
            $jsInclude .= 'if (typeof multipleAnswersInfoArray === \'undefined\') { var multipleAnswersInfoArray = new Array();};';
            foreach ($multiple_answers_info_array as $k => $val) {
                $jsInclude .= 'multipleAnswersInfoArray["'.$k.'"] = "'.$val.'";';
            }
            $jsInclude .= 'var newAnswerBarIndex = "'.$new_answer_bar_index.'";';
            $jsInclude .= 'var sexyIp = "'.$sexyip.'";';
            $jsInclude .= 'var sexyPath = "'.Uri::base(true).'/";';

            $jsInclude .= 'if (typeof sexyPollingIds === \'undefined\') { var sexyPollingIds = new Array();};';
            $k = 0;
            foreach ($polling_select_id as $poll_id) {
                $jsInclude .= 'sexyPollingIds.push(Array("'.$poll_id["select1"].'","'.$poll_id["select2"].'"));';
                $k ++;
            }
            $jsInclude .= 'if (typeof votingPermissions === \'undefined\') { var votingPermissions = new Array();};';
            foreach ($voting_permissions as $key => $voting_permission) {
				//Todo: Check if ['24'] is a wrong and should be [24]
                $message = $voting_permission ? 'allow_voting' : $polling_words['24'];
                $jsInclude .= 'votingPermissions.push("'.$key.'");';
                $jsInclude .= 'votingPermissions["'.$key.'"]="'.$message.'";';
            }
            $jsInclude .= 'if (typeof votedIds === \'undefined\') { var votedIds = new Array();};';
            foreach (array_keys($voted_ids) as $voted_id) {
                $hoursdiff = $voted_ids[$voted_id];
                $estimated_days = (int) ($hoursdiff / 24);
                $estimated_hours = ((int) $hoursdiff) % 24;
                $estimated_minutes = ((int) ($hoursdiff * 60)) % 60;
                $estimated_seconds = (((int) ($hoursdiff * 3600)) % 3600) % 60;

                $est_time = $estimated_days > 99 ? 'never' : $hoursdiff;
                $jsInclude .= 'votedIds.push(Array("'.$voted_id.'","'.$module_id.'","'.$est_time.'"));';
            }
            $jsInclude .= 'if (typeof startDisabledIds === \'undefined\') { var startDisabledIds = new Array();};';
            foreach ($start_disabled_ids as $start_disabled_data) {
                $hoursdiff = $start_disabled_data['2'];
                $estimated_days = (int) ($hoursdiff / 24);
                $est_time = $estimated_days > 99 ? 'never' : $hoursdiff;
                $jsInclude .= 'startDisabledIds.push(Array("'.$start_disabled_data[0].'","'.$start_disabled_data[1].'","'.$module_id.'","'.$est_time.'"));';
            }
            $jsInclude .= 'if (typeof endDisabledIds === \'undefined\') { var endDisabledIds = new Array();};';
            foreach ($end_disabled_ids as $end_disabled_data) {
                $jsInclude .= 'endDisabledIds.push(Array("'.$end_disabled_data[0].'","'.$end_disabled_data[1].'","'.$module_id.'"));';
            }
            $jsInclude .= 'if (typeof hideResultsIds === \'undefined\') { var hideResultsIds = new Array();};';
            foreach ($hide_results_ids as $poll_id => $hide_result_data) {
                $jsInclude .= 'hideResultsIds['.$poll_id.'] = "'.$hide_result_data.'";';
            }
            $jsInclude .= 'if (typeof allowedNumberAnswers === \'undefined\') { var allowedNumberAnswers = new Array();};';
            foreach ($number_answers_array as $poll_id => $number_answers_data) {
                $jsInclude .= 'allowedNumberAnswers.push("'.$poll_id.'");';
                $jsInclude .= 'allowedNumberAnswers["'.$poll_id.'"]="'.$number_answers_data.'";';
            }

            $jsInclude .= 'if (typeof autoOpenTimeline === \'undefined\') { var autoOpenTimeline = new Array();};';
            foreach ($autoOpenTimeline as $poll_id => $v) {
                $jsInclude .= 'autoOpenTimeline.push("'.$poll_id.'");';
                $jsInclude .= 'autoOpenTimeline["'.$poll_id.'"]="'.$v.'";';
            }

            $jsInclude .= 'if (typeof autoAnimate === \'undefined\') { var autoAnimate = new Array();};';
            foreach ($autoAnimate as $poll_id => $v) {

                //Autoanimation will show results; therefore, only apply if results are allowed to be shown
                if(($polling_array[0]->showresultsduringpoll == 0 && $date_now < strtotime($polling_array[0]->date_end ?? ''))) 
                {
                    $v = "0";
                }

                $jsInclude .= 'autoAnimate.push("'.$poll_id.'");';
                $jsInclude .= 'autoAnimate["'.$poll_id.'"]="'.$v.'";';
            }

            $jsInclude .= 'if (typeof sexyAutoPublish === \'undefined\') { var sexyAutoPublish = new Array();};';
            foreach ($autoPublish as $poll_id => $v) {
                $jsInclude .= 'sexyAutoPublish.push("'.$poll_id.'");';
                $jsInclude .= 'sexyAutoPublish["'.$poll_id.'"]="'.$v.'";';
            }

            $jsInclude .= 'if (typeof sexy_dateFormat === \'undefined\') { var sexy_dateFormat = new Array();};';
            foreach ($dateFormat as $poll_id => $v) {
                $jsInclude .= 'sexy_dateFormat.push("'.$poll_id.'");';
                $jsInclude .= 'sexy_dateFormat["'.$poll_id.'"]="'.$v.'";';
            }

            $jsInclude .= 'if (typeof sexyAnimationTypeBar === \'undefined\') { var sexyAnimationTypeBar = new Array();};';
            foreach ($sexyAnimationTypeBar as $poll_id => $v) {
                $jsInclude .= 'sexyAnimationTypeBar.push("'.$poll_id.'");';
                $jsInclude .= 'sexyAnimationTypeBar["'.$poll_id.'"]="'.$v.'";';
            }

            $jsInclude .= 'if (typeof sexyAnimationTypeContainer === \'undefined\') { var sexyAnimationTypeContainer = new Array();};';
            foreach ($sexyAnimationTypeContainer as $poll_id => $v) {
                $jsInclude .= 'sexyAnimationTypeContainer.push("'.$poll_id.'");';
                $jsInclude .= 'sexyAnimationTypeContainer["'.$poll_id.'"]="'.$v.'";';
            }

            $jsInclude .= 'if (typeof sexyAnimationTypeContainerMove === \'undefined\') { var sexyAnimationTypeContainerMove = new Array();};';
            foreach ($sexyAnimationTypeContainerMove as $poll_id => $v) {
                $jsInclude .= 'sexyAnimationTypeContainerMove.push("'.$poll_id.'");';
                $jsInclude .= 'sexyAnimationTypeContainerMove["'.$poll_id.'"]="'.$v.'";';
            }

            if($this->type != 'plugin') {
                $wa = Factory::getApplication()->getDocument()->getWebAssetManager();
                $wa->addInlineScript($jsInclude);
            }
            else {
                echo $jstoinclude = '<script type="text/javascript">'.$jsInclude.'</script>';
            }
        }
        else {
            echo Text::_( 'COM_SEXYPOLLING_NOTHING_TO_SHOW' );
        }

        return $render_html = ob_get_clean();
    }

    public static function getIp() : string {

		$server = Factory::getApplication()->input->server;        

		$REMOTE_ADDR = 'Unknown';
		if($server->get('HTTP_X_FORWARDED_FOR') !== null) { list($REMOTE_ADDR) = explode(',', $server->getString('HTTP_X_FORWARDED_FOR', 'Unknown')); }
		elseif($server->get('HTTP_X_REAL_IP') !== null) { $REMOTE_ADDR = $server->getString('HTTP_X_REAL_IP', 'Unknown'); }
		elseif($server->get('REMOTE_ADDR') !== null) { $REMOTE_ADDR = $server->getString('REMOTE_ADDR', 'Unknown'); }
		else { $REMOTE_ADDR = 'Unknown'; }

		return $REMOTE_ADDR;        
    }
}