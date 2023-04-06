<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: sexyanser.php 2012-04-05 14:30:25 svn $
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

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

class SexypollingModelSexyAnswer extends JModelAdmin
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'SexyAnswer', $prefix = 'SexyPollTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	//get max id
	public function getMax_id()
	{
		// Create a new query object.
		$db		= $this->getDbo();
		$query = 'SELECT COUNT(id) AS count_id FROM #__sexy_answers';
		$db->setQuery($query);
		$max_id = $db->loadResult();
		return $max_id;
	}
	
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_sexypolling.sexyanswer', 'sexyanswer', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_sexypolling.edit.sexyanswer.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
	
	
	protected function canEditState($record)
	{
		return parent::canEditState($record);
	}
	
	/**
	 * Method to toggle the featured setting of contacts.
	 *
	 * @param	array	$pks	The ids of the items to toggle.
	 * @param	int		$value	The value to toggle to.
	 *
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	public function featured($pks, $value = 0)
	{
		// Sanitize the ids.
		$pks = (array) $pks;
		\Joomla\Utilities\ArrayHelper::toInteger($pks);
	
		if (empty($pks)) {
			$this->setError(JText::_('COM_SEXYPOLLING_NO_ITEM_SELECTED'));
			return false;
		}
	
		$table = $this->getTable();
	
		try
		{
			$db = $this->getDbo();
	
			$db->setQuery(
					'UPDATE #__sexy_answers' .
					' SET featured = '.(int) $value.
					' WHERE id IN ('.implode(',', $pks).')'
			);
			if (!$db->execute()) {
				throw new Exception($db->getErrorMsg());
			}
	
		}
		catch (Exception $e)
		{
			$this->setError($e->getMessage());
			return false;
		}
	
		$table->reorder();
	
		// Clean component's cache
		$this->cleanCache();
	
		return true;
	}
	
	/**
	 * Method to save answer
	 */
	function saveAnswer()
	{
		$date = new JDate();
		$id = JFactory::getApplication()->input->request->getInt('id',0);
		$jform = JFactory::getApplication()->input->request->get('jform', null, null);
	
		$req = new JObject();
		$req->name =  $jform['name'];
		$req->show_name =  (int) $jform['show_name'];
		$req->embed =  $jform['embed'];
		$req->img_name =  $jform['img_name'];
		$req->img_url =  $jform['img_url'];
	
		$req->img_width = (int) $jform['img_width'];
		$req->img_width = $req->img_width == 0 ? 10 : $req->img_width;
		$req->id_poll = (int) $jform['id_poll'];
		$req->published = (int) $jform['published'];
		$req->id_user =  $jform['id_user'];
		$req->publish_up =  $jform['publish_up'];
		$req->publish_down =  $jform['publish_down'];
		$req->ordering =  $jform['ordering'];

		if($jform['img_name'] != '') {
				
			$img_width = $req->img_width;
			$img_height = 0;
			$img_crop = false;
			//resize image
			$this->resize_image($jform['img_name'],$img_width,$img_height,$img_crop);
		}
		
		if($req->id_poll == 0 || $req->name == "") {
			return false;
		}
		elseif($id == 0) {//if id ==0, we add the record
			$req->id = NULL;
			if(JV == 'j2')
				$req->created = $date->toMySQL();
			else
				$req->created = $date->toSql();
	
			if (!$this->_db->insertObject( '#__sexy_answers', $req, 'id' )) {
				return false;
			}
		}
		else { //else update the record
			$req->id = $id;
			//reset votes 
			$res = (int) $jform['reset_votes'];
			if($res == 1) {
				$sql = 'DELETE FROM `#__sexy_votes` '
				. ' WHERE `id_answer` = '.$id;
				$this->_db->setQuery($sql);
				$this->_db->execute();
			}
			//add votes
			$res = (int) $jform['insert_votes'];
			if($res > 0) {
				$query = 'INSERT INTO `#__sexy_votes` (`id_answer`, `ip`, `date`) VALUES ';
				for($i = 0; $i < $res; $i ++) {
					$query .= '('.$id.', \'\', NOW())';
					if($i != $res - 1)
						$query .= ',';
				}
				$this->_db->setQuery($query);
				$this->_db->execute();
			}
	
			if (!$this->_db->updateObject( '#__sexy_answers', $req, 'id' )) {
				return false;
			}
		}
	
		return true;
	}
	
	function resize_image($image,$width = 0,$height = 0, $crop = false)
	{
		$cache_dir = __DIR__ . '/../../../../cache/com_sexypolling/';
		if (!file_exists($cache_dir))
			@mkdir($cache_dir, 0755);
	
		// Make sure we can read and write the cache directory
		if (!is_readable($cache_dir))
		{
			//header('HTTP/1.1 500 Internal Server Error');
			$error = 'Error: the cache directory is not readable';
			return false;
		}
		else if (!is_writable($cache_dir))
		{
			$error = 'Error: the cache directory is not writable';
			return false;
		}
	
		//strip path
		$img_parts = explode('/',$image);
		$filename = $img_parts[sizeof($img_parts) - 1];
		preg_match('/^(.*)\.([a-z]{3,4}$)/i',$filename,$matches);
		$resized = $matches[1] . '-tmb-w' . $width . '.' . $matches[2];
	
		//get resized image
		$resized = $cache_dir . $resized;
	
		//unlink the image
		if(file_exists($resized))
			unlink($resized);
	
		//get image path
		$image = __DIR__ . '/../../../../' . $image;
	
		// Images must be local files, so for convenience we strip the domain if it's there
		$image			= preg_replace('/^(s?f|ht)tps?:\/\/[^\/]+/i', '', $image);
	
		// If the image doesn't exist, or we haven't been told what it is, there's nothing
		// that we can do
		if (!file_exists($image))
		{
			$error = 'There is no image';
			return false;
		}
	
		// Strip the possible trailing slash off the document root
		//$docRoot	= preg_replace('/\/$/', '', JFactory::getApplication()->input->server->get('DOCUMENT_ROOT'));
		$docRoot = '';
	
		$size	= GetImageSize($image);
		$mime	= $size['mime'];
	
		if (substr($mime, 0, 6) != 'image/')
		{
			$error = 'Wrong filetype';
			return false;
		}
		$maxWidth		= $width;
		$maxHeight		= $height;
	
		$width			= $size[0];
		$height			= $size[1];
	
		if (!$maxWidth && $maxHeight)
		{
			$maxWidth	= 99999999999999;
		}
		elseif ($maxWidth && !$maxHeight)
		{
			$maxHeight	= 99999999999999;
		}
		if ((!$maxWidth && !$maxHeight) || ($maxWidth >= $width && $maxHeight >= $height))
		{
			copy($image,$resized);
			return false;
		}
	
		// Ratio cropping
		$offsetX	= 0;
		$offsetY	= 0;
	
		if ($crop)
		{
			if ($width != 0 && $height != 0)
			{
				$ratioComputed		= $width / $height;
				$cropRatioComputed	= $maxWidth / $maxHeight;
	
				if ($ratioComputed < $cropRatioComputed)
				{ // Image is too tall so we will crop the top and bottom
					$origHeight	= $height;
					$height		= $width / $cropRatioComputed;
					$offsetY	= ($origHeight - $height) / 2;
				}
				else if ($ratioComputed >= $cropRatioComputed)
				{ // Image is too wide so we will crop off the left and right sides
					$origWidth	= $width;
					$width		= $height * $cropRatioComputed;
					$offsetX	= ($origWidth - $width) / 2;
				}
			}
		}
	
		$xRatio		= $maxWidth / $width;
		$yRatio		= $maxHeight / $height;
	
		if ($xRatio * $height < $maxHeight)
		{ // Resize the image based on width
			$tnHeight	= ceil($xRatio * $height);
			$tnWidth	= $maxWidth;
		}
		else // Resize the image based on height
		{
			$tnWidth	= ceil($yRatio * $width);
			$tnHeight	= $maxHeight;
		}
	
		$quality = 100;
	
		// Set up a blank canvas for our resized image (destination)
		$dst	= imagecreatetruecolor($tnWidth, $tnHeight);
	
		switch ($size['mime'])
		{
			case 'image/gif':
				// We will be converting GIFs to PNGs to avoid transparency issues when resizing GIFs
				// This is maybe not the ideal solution, but IE6 can suck it
				$creationFunction	= 'ImageCreateFromGif';
				$outputFunction		= 'ImagePng';
				$mime				= 'image/png'; // We need to convert GIFs to PNGs
				$doSharpen			= FALSE;
				$quality			= round(10 - ($quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
				break;
	
			case 'image/x-png':
			case 'image/png':
				$creationFunction	= 'ImageCreateFromPng';
				$outputFunction		= 'ImagePng';
				$doSharpen			= FALSE;
				$quality			= round(10 - ($quality / 10)); // PNG needs a compression level of 0 (no compression) through 9
				break;
	
			default:
				$creationFunction	= 'ImageCreateFromJpeg';
				$outputFunction	 	= 'ImageJpeg';
				$doSharpen			= TRUE;
				break;
		}
		// Read in the original image
		$src	= $creationFunction($docRoot . $image);
	
		if (in_array($size['mime'], array('image/gif', 'image/png')))
		{
			imagealphablending($dst, false);
			imagesavealpha($dst, true);
		}
	
		// Resample the original image into the resized canvas we set up earlier
		ImageCopyResampled($dst, $src, 0, 0, $offsetX, $offsetY, $tnWidth, $tnHeight, $width, $height);
	
		if ($doSharpen)
		{
			// Sharpen the image based on two things:
			//	(1) the difference between the original size and the final size
			//	(2) the final size
			$sharpness	= $this->findSharp($width, $tnWidth);
	
			$sharpenMatrix	= array(
					array(-1, -2, -1),
					array(-2, $sharpness + 12, -2),
					array(-1, -2, -1)
			);
			$divisor		= $sharpness;
			$offset			= 0;
			imageconvolution($dst, $sharpenMatrix, $divisor, $offset);
		}
		// Write the resized image to the cache
		$outputFunction($dst, $docRoot.$resized, $quality);
	
		ImageDestroy($src);
		ImageDestroy($dst);
	}
	
	function findSharp($orig, $final)
	{
		$final	= $final * (750.0 / $orig);
		$a		= 52;
		$b		= -0.27810650887573124;
		$c		= .00047337278106508946;
	
		$result = $a + $b * $final + $c * $final * $final;
	
		return max(round($result), 0);
	}
}