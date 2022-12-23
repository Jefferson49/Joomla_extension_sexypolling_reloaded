<?php 
/**
 * Joomla! component sexypolling
 *
 * @version $Id: add.php 2012-04-05 14:30:25 svn $
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

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.formvalidator');
?>
<script type="text/javascript">
Joomla.submitbutton = function(task) {
	var form = document.adminForm;
	if (task == 'sexytemplate.cancel') {
		Joomla.submitform(task);   
	}
	else {
		if (form.name.value != ""){
			form.name.style.border = "1px solid green";
		} 
		
		if (form.name.value == ""){
			form.name.style.border = "1px solid red";
			form.name.focus();
		} 
		else {
			Joomla.submitform(task);   
		}
	}
	
}
</script>
<?php if(JV == 'j2') {//////////////////////////////////////////////////////////////////////////////////////Joomla2.x/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<form action="<?php echo JRoute::_('index.php?option=com_sexypolling&layout=add&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_SEXYPOLLING_DETAILS' ); ?></legend>
		<ul class="adminformlist">
<?php foreach($this->form->getFieldset() as $field): ?>
			<li><?php echo $field->label;echo $field->input;?></li>
<?php endforeach; ?>
		</ul>
	</fieldset>
	<div>
		<input type="hidden" name="task" value="sexytemplate.add" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<?php include (JPATH_BASE.'/components/com_sexypolling/helpers/footer.php'); ?>
<?php }elseif(JV == 'j3') {//////////////////////////////////////////////////////////////////////////////////////Joomla3.x/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////?>
<?php 
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');
?>
<form action="<?php echo JRoute::_('index.php?option=com_sexypolling&layout=add&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal">
	<div class="row-fluid">
		<!-- Begin Newsfeed -->
		<div class="span10 form-horizontal">
			<fieldset>
				<div class="tab-content">
					<div class="tab-pane active" id="details">
						<div class="control-group">
							<?php foreach($this->form->getFieldset() as $field): ?>
								<div class="control-label" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo JText::_($field->description); ?>"><?php echo $field->label;?></div>
								<div class="controls"><?php echo $field->input;?></div>
								<div style="clear: both;height: 8px;">&nbsp;</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
<input type="hidden" name="task" value="sexytemplate.add" />
<?php echo JHtml::_('form.token'); ?>
</form>
<?php include (JPATH_BASE.'/components/com_sexypolling/helpers/footer.php'); ?>
<?php }?>
