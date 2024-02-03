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
 * @copyright Copyright (c) 2022 - 2024 Jefferson49
 * @license GNU/GPL v3.0
 * 
 * @todo Function 'addIncludePath' has been deprecated. will be removed in 6.0 Use the service registry instead
 */

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

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
$saveOrder  = $listOrder == 'sa.ordering';
if ($saveOrder)
{
    $saveOrderingUrl = 'index.php?option=com_sexypolling&task=sexyanswers.saveOrderAjax&tmpl=component';
    HTMLHelper::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn ?? ''), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();

$application = Factory::getApplication();
$user = $application->getIdentity();

if ($application->isClient('site')) {
    $params = $application->getParams('com_sexypolling');
} else {
    $params = ComponentHelper::getParams('com_sexypolling');
}

//if permission control for answers is activated, use permission settings for viewing answers
if ($params->get('permission_control_for_answers_and_votes', 0)) {
    $show_answers = $user !== null && $user->authorise('core.view.answers', 'com_sexypolling');
} else {
    $show_answers = true;
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
</script>
<form action="<?php echo Route::_('index.php?option=com_sexypolling'); ?>" method="post" name="adminForm" id="adminForm">
<?php if(!empty( $this->sidebar)): ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
<?php else : ?>
    <div id="j-main-container">
<?php endif;?>
<?php if(!$show_answers): ?>
    <h3 style="color: red;"><?php echo Text::_('COM_SEXYPOLLING_ACTION_VIEW_VOTES_NO_PERMISSION');?></h3>
<?php else : ?>
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
                    <th width="1%" class="nowrap center hidden-phone">
                        <?php echo HTMLHelper::_('grid.sort', '<i class="icon-menu-2"></i>', 'sa.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
                    </th>
                    <th width="1%" class="hidden-phone">
                        <input type="checkbox" name="checkall-toggle" value="" title="<?php echo Text::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
                    </th>
                    <th width="1%" style="min-width:55px" class="nowrap center">
                        <?php echo HTMLHelper::_('grid.sort', 'JSTATUS', 'sa.published', $listDirn, $listOrder); ?>
                    </th>
                    <th>
                        <?php echo HTMLHelper::_('grid.sort', 'COM_SEXYPOLLING_NAME', 'sa.name', $listDirn, $listOrder); ?>
                    </th>
                    <th width="10%">
                        <?php echo HTMLHelper::_('grid.sort', 'COM_SEXYPOLLING_POLL', 'poll_name', $listDirn, $listOrder); ?>
                    </th>
                    <th width="5%">
                        <?php echo HTMLHelper::_('grid.sort', 'COM_SEXYPOLLING_NUM_VOTES', 'count_votes', $listDirn, $listOrder); ?>
                    </th>
                    <th width="1%" class="nowrap center hidden-phone">
                        <?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_ID', 'sa.id', $listDirn, $listOrder); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php
            $n = count($this->items);
            foreach ($this->items as $i => $item) :
                $ordering   = $listOrder == 'sa.ordering';
                ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td class="order nowrap center hidden-phone">
                        <?php
                            $disableClassName = '';
                            $disabledLabel    = '';
                            if (!$saveOrder) :
                                $disabledLabel    = Text::_('JORDERINGDISABLED');
                                $disableClassName = 'inactive tip-top';
                            endif; ?>
                            <span class="sortable-handler hasTooltip<?php echo $disableClassName?>" title="<?php echo $disabledLabel?>">
                                <i class="icon-menu"></i>
                            </span>
                            <input type="text" style="display:none" name="order[]" size="5"
                            value="<?php echo $item->ordering;?>" class="width-20 text-area-order " />
                    </td>
                    <td class="center hidden-phone">
                        <?php echo HTMLHelper::_('grid.id', $i, $item->id); ?>
                    </td>
                    <td class="center">
                        <?php echo HTMLHelper::_('jgrid.published', $item->published, $i, 'sexyanswers.', true, 'cb', $item->publish_up, $item->publish_down); ?>
                    </td>
                    <td class="nowrap has-context">
                        <div class="pull-left">
                            <a href="<?php echo Route::_('index.php?option=com_sexypolling&task=sexyanswer.edit&id='.(int) $item->id); ?>">
                                <?php echo $this->escape(strip_tags($item->name ?? '')); ?>
                            </a>
                        </div>
                    </td>
                    <td class="nowrap has-context">
                        <div class="pull-left">
                            <a href="<?php echo Route::_('index.php?option=com_sexypolling&task=sexypoll.edit&id='.(int) $item->poll_id); ?>">
                                <?php echo $this->escape($item->poll_name); ?>
                            </a>
                        </div>
                    </td>
                    <td align="center hidden-phone">
                        <?php echo $item->count_votes; ?>
                    </td>
                    <td align="center hidden-phone">
                        <?php echo $item->id; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">
                        <?php echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <input type="hidden" name="view" value="sexyanswers" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo HTMLHelper::_('form.token'); ?>

        <?php include (JPATH_BASE.'/components/com_sexypolling/helpers/footer.php'); ?>
    </div>
<?php endif;?>
</form>
