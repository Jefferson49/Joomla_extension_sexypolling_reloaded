<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: scriptfile.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 * Extended by:
 * @version v3.0.0
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

defined('_JEXEC') or die('Restricted access');

// Import library dependencies
jimport('joomla.plugin.plugin');
jimport('joomla.event.plugin');

class plgSystemSexypolling extends JPlugin {
    function __construct( &$subject ) {
      parent::__construct( $subject );
      // load plugin parameters and language file
      $this->_plugin = JPluginHelper::getPlugin( 'system', 'sexypolling' );
      $this->_params = json_decode( $this->_plugin->params );
      JPlugin::loadLanguage('plg_system_sexypolling', JPATH_ADMINISTRATOR);
    }

    function sp_make_poll($m) {
        $id_poll = (int) $m[2];

        //include helper class
        require_once JPATH_SITE.'/components/com_sexypolling/helpers/helper.php';

        $sp_class = new SexypollingHelper;
        $sp_class->id_poll = $id_poll;
        $sp_class->id_category = 0;
        $sp_class->module_id = $this->plg_order;
        $sp_class->type = 'plugin';
        $sp_class->class_suffix = 'plg';

        $this->plg_order ++;
        return $sp_class->render_html();
    }

    function sp_make_poll_category($m) {
        $id_category = (int) $m[2];

        //include helper class
        require_once JPATH_SITE.'/components/com_sexypolling/helpers/helper.php';

        $sp_class = new SexypollingHelper;
        $sp_class->id_poll = 0;
        $sp_class->id_category = $id_category;
        $sp_class->module_id = $this->plg_order_cat;
        $sp_class->type = 'plugin';
        $sp_class->class_suffix = 'plg_cat';

        $this->plg_order_cat ++;
        return $sp_class->render_html();
    }

    //function onBeforeCompileHead() {
    function render_styles_scripts() {
        $document = JFactory::getApplication()->getDocument();
        $content = JFactory::getApplication()->getBody();

        //check if the scripts did not included
        if (strpos($content,'components/com_sexypolling/assets/css/main.css') !== false) {
            return $content;
        }

        $cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/main.css';
        $scripts = '<link rel="stylesheet" href="'.$cssFile.'" type="text/css" />'."\n";

        $cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/sexycss-ui.css';
        $scripts .= '<link rel="stylesheet" href="'.$cssFile.'" type="text/css" />'."\n";

        $cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/countdown.css';
        $scripts .= '<link rel="stylesheet" href="'.$cssFile.'" type="text/css" />'."\n";

        $jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/sexylib.js';
        $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";

        $jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/sexylib-ui.js';
        $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";

        $jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/selectToUISlider.jQuery.js';
        $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";

        $jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/color.js';
        $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";

        $jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/countdown.js';
        $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";

        $jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/sexypolling.js';
        $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";

        $content = str_replace('</head>', $scripts . '</head>', $content);
        return $content;
    }

    function onAfterRender() {
      $mainframe = JFactory::getApplication();
      if($mainframe->isClient('administrator'))
        return;

      $plugin = JPluginHelper::getPlugin('system', 'sexypolling');
      $pluginParams = json_decode( $plugin->params );

      $content = JFactory::getApplication()->getBody();

      //add scripts
      if(preg_match('/(\[(?:sexy|fancy)polling id|category="([0-9]+)"\])/s',$content))
        $content = $this->render_styles_scripts();
      else
        return;

      $this->plg_order = 10000;
      //plugin
      $c = preg_replace_callback('/(\[(?:sexy|fancy)polling id="([0-9]+)"\])/s',array($this, 'sp_make_poll'),$content);
      preg_match_all('/(\[(?:sexy|fancy)polling id="([0-9]+)"\])/s',$content,$m);

      if(is_array($m[2])) {
        $module_id = 10000;
        $plg_order_index = 0;
        foreach($m[2] as $poll_id) {
            $cssFileSrc = JURI::base(true).'/components/com_sexypolling/generate.css.php?id_poll='.$poll_id.'&module_id='.$module_id;
            $cssFile = '<link rel="stylesheet" href="'.$cssFileSrc.'" type="text/css" />'."\n";
            $c = str_replace('</head>', $cssFile . '</head>', $c);

            //$plg_order_index ++;
            $module_id += 1;
        }
      }

      //category check
      $this->plg_order_cat = 20000;
      //plugin
      $c = preg_replace_callback('/(\[(?:sexy|fancy)polling category="([0-9]+)"\])/s',array($this, 'sp_make_poll_category'),$c);
      preg_match_all('/(\[(?:sexy|fancy)polling category="([0-9]+)"\])/s',$content,$m);

      if(is_array($m[2])) {
        $module_id = 20000;
        $plg_order_index = 0;
        foreach($m[2] as $category_id) {
            $cssFileSrc = JURI::base(true).'/components/com_sexypolling/generate.css.php?id_category='.$category_id.'&module_id='.$module_id;
            $cssFile = '<link rel="stylesheet" href="'.$cssFileSrc.'" type="text/css" />'."\n";
            $c = str_replace('</head>', $cssFile . '</head>', $c);

            $plg_order_index ++;
            $module_id += $plg_order_index;
        }
      }

      JFactory::getApplication()->setBody($c);
    }

}