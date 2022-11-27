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
 */

// no direct access
defined('_JEXEC') or die('Restircted access');
?>
<?php if(JV == 'j2') {//////////////////////////////////////////////////////////////////////////////////////Joomla2.x/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<?php
    JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
    JHtml::_('behavior.tooltip');
    JHtml::_('behavior.multiselect');

    $user       = JFactory::getUser();
    $userId     = $user->get('id');
    $listOrder  = $this->escape($this->state->get('list.ordering'));
    $listDirn   = $this->escape($this->state->get('list.direction'));
    $saveOrder  = $listOrder == 'sp.ordering';
?>
<form action="<?php echo JRoute::_('index.php?option=com_sexypolling'); ?>" method="post" name="adminForm" id="adminForm">
    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('COM_SEXYPOLLING_FILTER_LABEL'); ?></label>
            <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_SEXYPOLLING_SEARCH_BY_NAME'); ?>" />
            <button type="submit"><?php echo JText::_('COM_SEXYPOLLING_SEARCH'); ?></button>
            <button type="button" onclick="document.getElementById('filter_search').value='';this.form.submit();"><?php echo JText::_('COM_SEXYPOLLING_RESET'); ?></button>
        </div>
        <div class="filter-select fltrt">

            <select name="filter_published" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('COM_SEXYPOLLING_SELECT_STATUS');?></option>
                <?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true);?>
            </select>

            <select name="filter_category_id" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('COM_SEXYPOLLING_SELECT_CATEGORY');?></option>
                <?php echo JHtml::_('select.options', $this->category_options, 'value', 'text', $this->state->get('filter.category_id'));?>
            </select>

            <select name="filter_access" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('COM_SEXYPOLLING_SELECT_ACCESS');?></option>
                <?php echo JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'));?>
            </select>
        </div>
    </fieldset>
    <div class="clr"> </div>

    <table class="adminlist">
        <thead>
            <tr>
                <th width="1%">
                    <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_NAME', 'sp.name', $listDirn, $listOrder); ?>
                </th>
                <th>
                    <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_QUESTION', 'sp.question', $listDirn, $listOrder); ?>
                </th>
                <th width="10%">
                    <?php echo JHtml::_('grid.sort', 'JCATEGORY', 'category_title', $listDirn, $listOrder); ?>
                </th>
                <th width="10%">
                    <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_TEMPLATE', 'template_title', $listDirn, $listOrder); ?>
                </th>

                <th width="5%">
                    <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ACCESS', 'sp.access', $listDirn, $listOrder); ?>
                </th>
                <th width="5%">
                    <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_NUM_ANSWERS', 'num_answers', $listDirn, $listOrder); ?>
                </th>
                <th width="1%">
                    <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'sp.id', $listDirn, $listOrder); ?>
                </th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="11">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
        <tbody>
        <?php
        $n = count($this->items);
        foreach ($this->items as $i => $item) :
            $ordering   = $listOrder == 'sp.ordering';

            ?>
            <tr class="row<?php echo $i % 2; ?>">
                <td class="center">
                    <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                </td>
                <td>
                    <a href="<?php echo JRoute::_('index.php?option=com_sexypolling&view=showstatistics&id='.(int) $item->id); ?>">
                        <?php echo $this->escape($item->name); ?>
                    </a>
                </td>
                <td>
                    <a href="<?php echo JRoute::_('index.php?option=com_sexypolling&view=showstatistics&id='.(int) $item->id); ?>">
                        <?php echo $this->escape($item->question); ?>
                    </a>
                </td>
                <td align="center">
                    <a href="<?php echo JRoute::_('index.php?option=com_sexypolling&task=sexypoll.edit&id='.(int) $item->id); ?>">
                        <?php echo $item->category_title; ?>
                    </a>
                </td>
                <td align="center">
                    <a href="<?php echo JRoute::_('index.php?option=com_sexypolling&task=sexypoll.edit&id='.(int) $item->id); ?>">
                        <?php echo $item->template_title; ?>
                    </a>
                </td>
                <td align="center">
                    <?php echo $item->access_level; ?>
                </td>
                <td align="center">
                    <?php echo $item->num_answers; ?>
                </td>
                <td align="center">
                    <?php echo $item->id; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <input type="hidden" name="view" value="sexystatistics" />
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
$saveOrder  = $listOrder == 'sp.ordering';
if ($saveOrder)
{
    $saveOrderingUrl = 'index.php?option=com_sexypolling&task=sexypolls.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
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
                <label for="filter_search" class="element-invisible"><?php echo JText::_('COM_SEXYPOLLING_SEARCH_BY_NAME');?></label>
                <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_SEXYPOLLING_SEARCH_BY_NAME'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_SEXYPOLLING_SEARCH_BY_NAME'); ?>" />
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
                    <th>
                        <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_NAME', 'sp.name', $listDirn, $listOrder); ?>
                    </th>
                    <th>
                        <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_QUESTION', 'sp.question', $listDirn, $listOrder); ?>
                    </th>

                    <th width="10%">
                        <?php echo JHtml::_('grid.sort', 'JCATEGORY', 'category_title', $listDirn, $listOrder); ?>
                    </th>
                    <th width="10%">
                        <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_TEMPLATE', 'template_title', $listDirn, $listOrder); ?>
                    </th>
                    <th width="5%">
                        <?php echo JHtml::_('grid.sort', 'COM_SEXYPOLLING_NUM_ANSWERS', 'num_answers', $listDirn, $listOrder); ?>
                    </th>
                    <th width="1%" class="nowrap center hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'sp.id', $listDirn, $listOrder); ?>
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
                    <td class="nowrap has-context">
                        <div class="pull-left">
                            <a href="<?php echo JRoute::_('index.php?option=com_sexypolling&view=showstatistics&id='.(int) $item->id); ?>">
                                <?php echo $this->escape($item->name); ?>
                            </a>
                        </div>
                    </td>
                    <td class="nowrap has-context">
                        <div class="pull-left">
                            <a href="<?php echo JRoute::_('index.php?option=com_sexypolling&view=showstatistics&id='.(int) $item->id); ?>">
                                <?php echo $this->escape($item->question); ?>
                            </a>
                        </div>
                    </td>
                    <td align="small hidden-phone">
                        <a href="<?php echo JRoute::_('index.php?option=com_sexypolling&task=sexycategory.edit&id='.(int) $item->category_id); ?>">
                            <?php echo $item->category_title; ?>
                        </a>
                    </td>
                    <td align="small hidden-phone">
                        <a href="<?php echo JRoute::_('index.php?option=com_sexypolling&task=sexytemplate.edit&id='.(int) $item->template_id); ?>">
                            <?php echo $item->template_title; ?>
                        </a>
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
        <input type="hidden" name="view" value="sexystatistics" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>

        <?php include (JPATH_BASE.'/components/com_sexypolling/helpers/footer.php'); ?>
    </div>
</form>
<?php }?>