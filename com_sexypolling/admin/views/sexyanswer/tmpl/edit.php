<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: edit.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 * Extended by:
 * @version v3.0.0
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 - 2023 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

// no direct access
defined('_JEXEC') or die('Restircted access');

HTMLHelper::_('bootstrap.tooltip');
HTMLHelper::_('behavior.formvalidator');
?>

<script type="text/javascript">
Joomla.submitbutton = function(task) {
    var form = document.adminForm;
    if (task == 'sexyanswer.cancel') {
		Joomla.submitform(task);    
	}
    else {
        if (form.jform_name.value != ""){
            form.jform_name.style.border = "1px solid green";
        }

        if (form.jform_name.value == ""){
            form.jform_name.style.border = "1px solid red";
            form.jform_name.focus();
        }
        else {
			Joomla.submitform(task);    
        }
    }
}
</script>
<?php
HTMLHelper::_('bootstrap.tooltip');
HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('formbehavior.chosen', 'select');
?>
<form action="<?php echo Route::_('index.php?option=com_sexypolling&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal">
    <div class="row-fluid">
        <!-- Begin Newsfeed -->
        <div class="span10 form-horizontal">
            <fieldset>
                <div class="tab-content">
                    <div class="tab-pane active" id="details">
                        <div class="control-group">
                            <?php foreach($this->form->getFieldset() as $field): ?>
								<div class="control-label" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo Text::_($field->description); ?>"><?php echo $field->label;?></div>
                                <div class="controls"><?php echo $field->input;?></div>
                                <div style="clear: both;height: 8px;">&nbsp;</div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
<input type="hidden" name="task" value="sexyanswer.edit" />
<?php echo HTMLHelper::_('form.token'); ?>
</form>
<?php include (JPATH_BASE.'/components/com_sexypolling/helpers/footer.php'); ?>
<style>
#jform_name {
    width: 650px;
}
</style>