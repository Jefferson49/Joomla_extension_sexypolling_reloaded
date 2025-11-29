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
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 - 2025 Jefferson49
 * @license GNU/GPL v3.0
 * 
 * JavaScript window.jSelectSexypoll, document.addEventListener from JDownloads:
 * @version 3.8
 * @package JDownloads
 * @copyright (C) 2007/2018 www.jdownloads.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * 
 */

 use Joomla\CMS\Factory;
 use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

// no direct access
defined('_JEXEC') or die('Restircted access');

HTMLHelper::addIncludePath(JPATH_COMPONENT.'/helpers/html');
HTMLHelper::_('bootstrap.tooltip');
HTMLHelper::_('behavior.multiselect');
HTMLHelper::_('dropdown.init');
HTMLHelper::_('formbehavior.chosen', 'select');

$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
$archived   = $this->state->get('filter.published') == 2 ? true : false;
$trashed    = $this->state->get('filter.published') == -2 ? true : false;
$saveOrder  = $listOrder == 'sp.ordering';
if ($saveOrder)
{
    $saveOrderingUrl = 'index.php?option=com_sexypolling&task=sexypolls.saveOrderAjax&tmpl=component';
    HTMLHelper::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn ?? ''), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();

$editor = Factory::getApplication()->input->getCmd('editor', '');

// Provide used editor to the script environment 
if (!empty($editor))
{
    $this->document->addScriptOptions('xtd-sexypolling', array('editor' => $editor));
    $onclick = "jSelectSexypoll";
}
?>

<script type="text/javascript">
    Joomla.orderTable = function() {
        table = document.getElementById("sortTable");
        direction = document.getElementById("directionTable");
        order = table.options[table.selectedIndex].value;
        if (order != '<?php echo $listOrder; ?>') {
            dirn = 'asc';
        } else {
            dirn = direction.options[direction.selectedIndex].value;
        }
        Joomla.tableOrdering(order, dirn, '');   
    }

    window.jSelectSexypoll = function (id) {
		var editor, tag;

        if (!Joomla.getOptions('xtd-sexypolling')) {
			// Something went wrong!
			return false;
		}

		editor = Joomla.getOptions('xtd-sexypolling').editor;

		tag = '[sexypolling id="'+ id + '"]';

		if (window.parent.Joomla && window.parent.Joomla.editors && window.parent.Joomla.editors.instances && window.parent.Joomla.editors.instances.hasOwnProperty(editor)) {
			window.parent.Joomla.editors.instances[editor].replaceSelection(tag)
		} else {
			window.parent.jInsertEditorText(tag, editor);
		}

<?php if(version_compare(JVERSION, '4', '>=')): ?>
        if (window.parent.Joomla.Modal) {
	      window.parent.Joomla.Modal.getCurrent().close();
	    }
<?php else : ?>
        window.parent.jModalClose();
<?php endif;?>

		return true;
	};

	document.addEventListener('DOMContentLoaded', function(){
		// Get the elements
		var elements = document.querySelectorAll('.select-link');

		for(var i = 0, l = elements.length; l>i; i++) {
			// Listen for click event
			elements[i].addEventListener('click', function (event) {
				event.preventDefault();
				const {
	          		target
	        	} = event;
				var functionName = target.getAttribute('data-function');

				if (functionName === 'jSelectSexypoll') {
					// Used in xtd_contacts
					window[functionName](target.getAttribute('data-id'), target.getAttribute('data-title'), event.target.getAttribute('data-cat-id'), null, target.getAttribute('data-uri'), target.getAttribute('data-language'));
				} else {
					// Used in com_menus
					window.parent[functionName](target.getAttribute('data-id'), target.getAttribute('data-title'), target.getAttribute('data-cat-id'), null, target.getAttribute('data-uri'), target.getAttribute('data-language'));
				}

<?php if(version_compare(JVERSION, '4', '>=')): ?>
                if (window.parent.Joomla.Modal) {
                window.parent.Joomla.Modal.getCurrent().close();
                }
<?php else : ?>
                window.parent.jModalClose();
<?php endif;?>

			})
		}
	});
</script>
    
<form action="<?php echo Route::_('index.php?option=com_sexypolling&amp;view=sexypolls&amp;layout=modal&amp;tmpl=component&amp;editor=' . $editor . '&amp;' . Session::getFormToken() . '=1'); ?>" method="post" name="adminForm" id="adminForm">
<?php if(!empty( $this->sidebar)): ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
<?php else : ?>
    <div id="j-main-container">
<?php endif;?>
        <div id="filter-bar" class="btn-toolbar">
            <div class="filter-search btn-group pull-left">
                <label for="filter_search" class="element-invisible"><?php echo Text::_('COM_SEXYPOLLING_SEARCH_BY_NAME');?></label>
                <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo Text::_('COM_SEXYPOLLING_SEARCH_BY_NAME'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo Text::_('COM_SEXYPOLLING_SEARCH_BY_NAME'); ?>" />
            </div>
            <div class="btn-group pull-left">
                <button class="btn hasTooltip" type="submit" title="<?php echo Text::_('COM_SEXYPOLLING_SEARCH'); ?>"><i class="icon-search"></i></button>
                <button class="btn hasTooltip" type="button" title="<?php echo Text::_('COM_SEXYPOLLING_RESET'); ?>" onclick="document.getElementById('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
            </div>
            <div class="btn-group pull-right hidden-phone">
                <label for="limit" class="element-invisible"><?php echo Text::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
                <?php echo $this->pagination->getLimitBox(); ?>
            </div>
            <div class="btn-group pull-right hidden-phone">
                <label for="directionTable" class="element-invisible"><?php echo Text::_('JFIELD_ORDERING_DESC');?></label>
                <select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
                    <option value=""><?php echo Text::_('JFIELD_ORDERING_DESC');?></option>
                    <option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo Text::_('JGLOBAL_ORDER_ASCENDING');?></option>
                    <option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo Text::_('JGLOBAL_ORDER_DESCENDING');?></option>
                </select>
            </div>
            <div class="btn-group pull-right">
                <label for="sortTable" class="element-invisible"><?php echo Text::_('JGLOBAL_SORT_BY');?></label>
                <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
                    <option value=""><?php echo Text::_('JGLOBAL_SORT_BY');?></option>
                    <?php echo HTMLHelper::_('select.options', $sortFields, 'value', 'text', $listOrder);?>
                </select>
            </div>
        </div>
        <div class="clearfix"> </div>
        <table class="table table-striped" id="articleList">
            <thead>
                <tr>
                    <th width="1%" style="min-width:55px" class="nowrap center">
                        <?php echo HTMLHelper::_('grid.sort', 'JSTATUS', 'sp.published', $listDirn, $listOrder); ?>
                    </th>
                    <th>
                        <?php echo HTMLHelper::_('grid.sort', 'COM_SEXYPOLLING_NAME', 'sp.name', $listDirn, $listOrder); ?>
                    </th>
                    <th>
                        <?php echo HTMLHelper::_('grid.sort', 'COM_SEXYPOLLING_QUESTION', 'sp.question', $listDirn, $listOrder); ?>
                    </th>

                    <th width="15%" class="nowrap hidden-phone center">
                        Shortcode
                    </th>
                    <th width="10%">
                        <?php echo HTMLHelper::_('grid.sort', 'JCATEGORY', 'category_title', $listDirn, $listOrder); ?>
                    </th>
                    <th width="10%">
                        <?php echo HTMLHelper::_('grid.sort', 'COM_SEXYPOLLING_TEMPLATE', 'template_title', $listDirn, $listOrder); ?>
                    </th>
                    <th width="5%">
                        <?php echo HTMLHelper::_('grid.sort', 'COM_SEXYPOLLING_NUM_ANSWERS', 'num_answers', $listDirn, $listOrder); ?>
                    </th>
                    <th width="1%" class="nowrap center hidden-phone">
                        <?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_ID', 'sp.id', $listDirn, $listOrder); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php
            $n = count($this->items);
            foreach ($this->items as $i => $item) :
                $ordering   = $listOrder == 'sp.ordering';
                ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td class="center">
                        <?php echo HTMLHelper::_('jgrid.published', $item->published, $i, 'sexypolls.', true, 'cb', $item->publish_up, $item->publish_down); ?>
                    </td>
                    <td class="nowrap has-context">
                        <div class="pull-left">
                            <?php $attribs = 'data-function="' . 'jSelectSexypoll' . '"' . ' data-id="' . $item->id . '"'?>
                            <a class="select-link" href="javascript:void(0)" <?php echo $attribs; ?>>
                                <?php echo $this->escape($item->name); ?>
                            </a>
                        </div>
                    </td>
                    <td class="nowrap has-context">
                        <div class="pull-left">
                            <?php echo $this->escape($item->question); ?>
                        </div>
                    </td>
                    <td class="center hidden-phone">
                        <input class="creative_shortcode" value='[sexypolling id=&quot;<?php echo $item->id;?>&quot;]' onclick="this.select()" readonly="readonly" />
                    </td>
                    <td align="small hidden-phone">
                        <?php echo $item->category_title; ?>
                    </td>
                    <td align="small hidden-phone">
                        <?php echo $item->template_title; ?>
                    </td>
                    <td align="center hidden-phone">
                        <?php echo $item->num_answers; ?>
                    </td>
                    <td align="center hidden-phone">
                        <?php echo $item->id; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="11">
                        <?php echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <input type="hidden" name="view" value="sexypolls" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo HTMLHelper::_('form.token'); ?>

    </div>
</form>
