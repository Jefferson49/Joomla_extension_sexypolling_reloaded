<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id$
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
<?php if(JV == 'j2') {//////////////////////////////////////////////////////////////////////////////////////Joomla2.x/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<?php
    JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
    JHtml::_('bootstrap.tooltip');
    JHtml::_('behavior.multiselect');

    $user       = JFactory::getUser();
    $userId     = $user->get('id');
    $listOrder  = $this->escape($this->state->get('list.ordering'));
    $listDirn   = $this->escape($this->state->get('list.direction'));
?>
<form action="<?php echo JRoute::_('index.php?option=com_sexypolling'); ?>" method="post" name="adminForm" id="adminForm">
    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('COM_SEXYPOLLING_FILTER_LABEL'); ?></label>
            <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_SEXYPOLLING_SEARCH'); ?>" />
            <button type="submit"><?php echo JText::_('COM_SEXYPOLLING_SEARCH'); ?></button>
            <button type="button" onclick="document.getElementById('filter_search').value='';this.form.submit();"><?php echo JText::_('COM_SEXYPOLLING_RESET'); ?></button>
        </div>
    </fieldset>
    <div class="clr"> </div>

    <table class="adminlist">
        <thead>
            <tr>
                <th width="1%">
                    <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
                </th>
                <th nowrap>
                    <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_ANSWER', 'id_answer', $listDirn, $listOrder); ?>
                </th>
                <th nowrap>
                    <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_POLL', 'id_poll', $listDirn, $listOrder); ?>
                </th>
                <th nowrap>
                    <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_USER', 'username', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_IP', 'ip', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort', 'JDATE', 'date', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_COUNTRY', 'country', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_CITY', 'city', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_REGION', 'region', $listDirn, $listOrder); ?>
                </th>
                <th width="1%">
                    <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'id_vote', $listDirn, $listOrder); ?>
                </th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="10">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
        <tbody>
        <?php
        $n = count($this->items);
        foreach ($this->items as $i => $item) :
            ?>
            <tr class="row<?php echo $i % 2; ?>">
                <td class="center">
                    <?php echo JHtml::_('grid.id', $i, $item->id_vote); ?>
                </td>
                <td>
                    <a href="<?php echo JRoute::_('index.php?option=com_sexypolling&task=sexyanswer.edit&id='.(int) $item->id_answer); ?>">
                        <?php echo $this->escape(strip_tags($item->answer)); ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo JRoute::_('index.php?option=com_sexypolling&task=sexypoll.edit&id='.(int) $item->id_poll); ?>">
                        <?php echo $this->escape($item->poll); ?>
                    </a>
                </td>
                <td>
                    <?php echo $item->username; ?>
                </td>
                <td>
                    <?php echo $item->ip; ?>
                </td>
                <td>
                    <?php echo $item->date; ?>
                </td>
                <td>
                    <?php echo $item->country; ?>
                </td>
                <td>
                    <?php echo $item->city; ?>
                </td>
                <td>
                    <?php echo $item->region; ?>
                </td>
                <td>
                    <?php echo $item->id_vote; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <input type="hidden" name="view" value="sexvotes" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
<?php include (JPATH_BASE.'/components/com_sexypolling/helpers/footer.php'); ?>
<?php }elseif(JV == 'j3') {//////////////////////////////////////////////////////////////////////////////////////Joomla3.x/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<?php
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
$archived   = $this->state->get('filter.published') == 2 ? true : false;
$trashed    = $this->state->get('filter.published') == -2 ? true : false;
$sortFields = $this->getSortFields();
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
<form action="<?php echo JRoute::_('index.php?option=com_sexypolling'); ?>" method="post" name="adminForm" id="adminForm">
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
                <label for="filter_search" class="element-invisible"><?php echo JText::_('COM_SEXYPOLLING_SEARCH');?></label>
                <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_SEXYPOLLING_SEARCH'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_SEXYPOLLING_SEARCH'); ?>" />
            </div>
            <div class="btn-group pull-left">
                <button class="btn hasTooltip" type="submit" title="<?php echo JText::_('COM_SEXYPOLLING_SEARCH'); ?>"><i class="icon-search"></i></button>
                <button class="btn hasTooltip" type="button" title="<?php echo JText::_('COM_SEXYPOLLING_RESET'); ?>" onclick="document.getElementById('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
            </div>
            <div class="btn-group pull-right hidden-phone">
                <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
                <?php echo $this->pagination->getLimitBox(); ?>
            </div>
            <div class="btn-group pull-right hidden-phone">
                <label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?></label>
                <select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
                    <option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
                    <option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?></option>
                    <option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?></option>
                </select>
            </div>
            <div class="btn-group pull-right">
                <label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?></label>
                <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
                    <option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
                    <?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder);?>
                </select>
            </div>
        </div>
        <div class="clearfix"> </div>
        <table class="table table-striped" id="articleList">
            <thead>
                <tr>
                    <th width="1%" class="hidden-phone">
                        <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
                    </th>
                    <th nowrap>
                        <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_ANSWER', 'id_answer', $listDirn, $listOrder); ?>
                    </th>
                    <th nowrap>
                        <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_POLL', 'id_poll', $listDirn, $listOrder); ?>
                    </th>
                    <th nowrap>
                        <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_USER', 'username', $listDirn, $listOrder); ?>
                    </th>
                    <th>
                        <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_IP', 'ip', $listDirn, $listOrder); ?>
                    </th>
                    <th>
                        <?php echo JHtml::_('grid.sort', 'JDATE', 'date', $listDirn, $listOrder); ?>
                    </th>
                    <th>
                        <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_COUNTRY', 'country', $listDirn, $listOrder); ?>
                    </th>
                    <th>
                        <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_CITY', 'city', $listDirn, $listOrder); ?>
                    </th>
                    <th>
                        <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_REGION', 'region', $listDirn, $listOrder); ?>
                    </th>
                    <th width="1%">
                        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'id_vote', $listDirn, $listOrder); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php
            $n = count($this->items);
            foreach ($this->items as $i => $item) :
                ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td class="center hidden-phone">
                        <?php echo JHtml::_('grid.id', $i, $item->id_vote); ?>
                    </td>
                    <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_sexypolling&task=sexyanswer.edit&id='.(int) $item->id_answer); ?>">
                            <?php echo $this->escape(strip_tags($item->answer)); ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo JRoute::_('index.php?option=com_sexypolling&task=sexypoll.edit&id='.(int) $item->id_poll); ?>">
                            <?php echo $this->escape($item->poll); ?>
                        </a>
                    </td>
                    <td>
                        <?php echo $item->username; ?>
                    </td>
                    <td class="nowrap">
                        <?php echo $item->ip; ?>
                    </td>
                    <td>
                        <?php echo $item->date; ?>
                    </td>
                    <td>
                        <?php echo $item->country; ?>
                    </td>
                    <td>
                        <?php echo $item->city; ?>
                    </td>
                    <td>
                        <?php echo $item->region; ?>
                    </td>
                    <td>
                        <?php echo $item->id_vote; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        <?php echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <input type="hidden" name="view" value="sexyvotes" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>

        <?php include (JPATH_BASE.'/components/com_sexypolling/helpers/footer.php'); ?>
    </div>
</form>
<?php }?>