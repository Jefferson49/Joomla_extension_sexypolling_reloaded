<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: default.php 2012-04-05 14:30:25 svn $
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

// no direct access
defined('_JEXEC') or die('Restircted access');

?>
<div id="m_wrapper">
<div id="cpanel">
    <div class="icon">
        <a href="index.php?option=com_sexypolling&view=sexypolls" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_POLLS' ); ?>">
            <table style="width: 100%;height: 100%;text-decoration: none;">
                <tr>
                    <td align="center" valign="middle">
                        <img src="components/com_sexypolling/assets/images/statistics.png" /><br />
                        <?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_POLLS' ); ?>
                    </td>
                </tr>
            </table>
        </a>
    </div>
</div>
<div id="cpanel">
    <div class="icon">
        <a href="index.php?option=com_sexypolling&view=sexyanswers" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_ANSWERS' ); ?>">
            <table style="width: 100%;height: 100%;text-decoration: none;">
                <tr>
                    <td align="center" valign="middle">
                        <img src="components/com_sexypolling/assets/images/answer.png" /><br />
                        <?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_ANSWERS' ); ?>
                    </td>
                </tr>
            </table>
        </a>
    </div>
</div>
<div id="cpanel">
    <div class="icon">
        <a href="index.php?option=com_sexypolling&view=sexyvotes" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_VOTES' ); ?>">
            <table style="width: 100%;height: 100%;text-decoration: none;">
                <tr>
                    <td align="center" valign="middle">
                        <img src="components/com_sexypolling/assets/images/vote.png" /><br />
                        <?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_VOTES' ); ?>
                    </td>
                </tr>
            </table>
        </a>
    </div>
</div>
<div id="cpanel">
    <div class="icon">
        <a href="index.php?option=com_sexypolling&view=sexycategories" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_CATEGORIES' ); ?>">
            <table style="width: 100%;height: 100%;text-decoration: none;">
                <tr>
                    <td align="center" valign="middle">
                        <img src="components/com_sexypolling/assets/images/category.png" /><br />
                        <?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_CATEGORIES' ); ?>
                    </td>
                </tr>
            </table>
        </a>
    </div>
</div>
<div id="cpanel">
    <div class="icon">
        <a href="index.php?option=com_sexypolling&view=sexytemplates" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_TEMPLATES' ); ?>">
            <table style="width: 100%;height: 100%;text-decoration: none;">
                <tr>
                    <td align="center" valign="middle">
                        <img src="components/com_sexypolling/assets/images/template.png" /><br />
                        <?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_TEMPLATES' ); ?>
                    </td>
                </tr>
            </table>
        </a>
    </div>
<div id="cpanel">
    <div class="icon">
        <a href="index.php?option=com_sexypolling&view=sexystatistics" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_STATISTICS' ); ?>">
            <table style="width: 100%;height: 100%;text-decoration: none;">
                <tr>
                    <td align="center" valign="middle">
                        <img src="components/com_sexypolling/assets/images/statistics1.png" /><br />
                        <?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_STATISTICS' ); ?>
                    </td>
                </tr>
            </table>
        </a>
    </div>
</div>
<div id="cpanel">
    <div class="icon" style="float: right;">
        <a href="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_SUPPORT_FORUM_LINK' ); ?>" target="_blank" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_SUPPORT_FORUM_DESCRIPTION' ); ?>">
            <table style="width: 100%;height: 100%;text-decoration: none;">
                <tr>
                    <td align="center" valign="middle">
                        <img src="components/com_sexypolling/assets/images/forum.png" /><br />
                        <?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_SUPPORT_FORUM' ); ?>
                    </td>
                </tr>
            </table>
        </a>
    </div>
</div>
<div id="cpanel">
    <div class="icon" style="float: right;">
        <a href="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_PROJECT_HOMEPAGE_LINK' ); ?>" target="_blank" title="<?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_PROJECT_HOMEPAGE_DESCRIPTION' ); ?>">
            <table style="width: 100%;height: 100%;text-decoration: none;">
                <tr>
                    <td align="center" valign="middle">
                        <img src="components/com_sexypolling/assets/images/icon_homepage.png" /><br />
                        <?php echo JText::_( 'COM_SEXYPOLLING_SUBMENU_PROJECT_HOMEPAGE' ); ?>
                    </td>
                </tr>
            </table>
        </a>
    </div>
</div>

<?php include (JPATH_BASE.'/components/com_sexypolling/helpers/footer.php'); ?>
</div>
