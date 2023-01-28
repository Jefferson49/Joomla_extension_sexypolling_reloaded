<?php 
/**
 * Joomla! component sexypolling
 *
 * @version $Id: form.php 2012-04-05 14:30:25 svn $
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

$document = JFactory::getApplication()->getDocument();
$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/colorpicker.css';
$document->addStyleSheet($cssFile, array('type' => 'text/css'), array());

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/layout.css';
$document->addStyleSheet($cssFile, array('type' => 'text/css'), array());

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/temp_'.JV.'.css';
$document->addStyleSheet($cssFile, array('type' => 'text/css'), array());

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/jquery-ui-1.7.1.custom.css';
$document->addStyleSheet($cssFile, array('type' => 'text/css'), array());

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/ui.slider.extras.css';
$document->addStyleSheet($cssFile, array('type' => 'text/css'), array());

$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/main.css';
$document->addStyleSheet($cssFile, array('type' => 'text/css'), array());

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/sexylib.js';
$document->addScript($jsFile);

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/colorpicker.js';
$document->addScript($jsFile);

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/eye.js';
$document->addScript($jsFile);

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/utils.js';
$document->addScript($jsFile);

$jsFile = JURI::base(true).'/components/com_sexypolling/assets/js/layout.js?ver=1.0.2';
//$document->addScript($jsFile);
?>

<?php 
if(JV == 'j2') {
	echo '<style>
	
	</style>';
}
else {
	echo '<style>
			.colorpicker input {
				background-color: transparent !important;
				border: 1px solid transparent !important;
				position: absolute !important;
				font-size: 10px !important;
				font-family: Arial, Helvetica, sans-serif !important;
				color: #898989 !important;
				top: 4px !important;
				right: 11px !important;
				text-align: right !important;
				margin: 0 !important;
				padding: 0 !important;
				height: 11px !important;
				outline: none !important;
				box-shadow: none !important;
				width: 32px !important;
				height: 12px !important;
				top: 2px !important;
			}
			.colorpicker_hex input {
				width: 38px !important;
				right: 6px !important;
			}
	</style>';
}
?>


<script type="text/javascript">
<?php if(version_compare( JVERSION, '1.6.0', '<' )) { ?>
function submitbutton(task) {
<?php } else { ?>
Joomla.submitbutton = function(task) {
<?php } ?>
	var form = document.adminForm;
	if (task == 'cancel') {
		Joomla.submitform(task);   
	} else if (form.name.value == ""){
		form.name.style.border = "1px solid red";
		form.name.focus();
	} else {
		Joomla.submitform(task);   
	}
}

//admin forever
var req = false;
function refreshSession() {
    req = false;
    if(window.XMLHttpRequest && !(window.ActiveXObject)) {
        try {
            req = new XMLHttpRequest();
        } catch(e) {
            req = false;
        }
    // branch for IE/Windows ActiveX version
    } else if(window.ActiveXObject) {
        try {
            req = new ActiveXObject("Msxml2.XMLHTTP");
        } catch(e) {
            try {
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch(e) {
                req = false;
            }
        }
    }

    if(req) {
        req.onreadystatechange = processReqChange;
        req.open("HEAD", "<?php echo JURI::base();?>", true);
        req.send();
    }
}

function processReqChange() {
    // only if req shows "loaded"
    if(req.readyState == 4) {
        // only if "OK"
        if(req.status == 200) {
            // TODO: think what can be done here
        } else {
            // TODO: think what can be done here
            //alert("There was a problem retrieving the XML data: " + req.statusText);
        }
    }
}
setInterval("refreshSession()", <?php echo $timeout = intval(JFactory::getApplication()->getCfg('lifetime') * 60 / 3 * 1000);?>);
</script>
<script>
(function($) {
	$(document).ready(function() {


		var active_element;
		$('.colorSelector').click(function() {
			active_element = $(this);
		})
		
		$('.colorSelector').ColorPicker({
			onBeforeShow: function () {
				$color = $(active_element).next('input').val();
				$(this).ColorPickerSetColor($color);
			},
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {

				$(active_element).children('div').css('backgroundColor', '#' + hex);
				$(active_element).next('input').val('#' + hex);
				roll = $(active_element).next('input').attr('roll');
				if(roll == 0) {
					$(".polling_container").css('backgroundColor' , '#' + hex);

				}
				else if(roll == 1) {
					$(".polling_container").css('borderColor' , '#' + hex);
				}
				else if(roll == 84) {
					$(".polling_container .grad").css('borderColor' , '#' + hex);
				}
				else if(roll == 3) {
					var boxShadow = $("#elem-55").val() + ' ' + $("#elem-56").val() + 'px '  + $("#elem-57").val() + 'px '  + $("#elem-58").val() + 'px ' + $("#elem-59").val() + 'px ' + $("#elem-5").val();
					var boxShadow_ = $("#elem-50").val() + ' ' + $("#elem-46").val() + 'px '  + $("#elem-47").val() + 'px '  + $("#elem-48").val() + 'px ' + $("#elem-49").val() + 'px  ' + $("#elem-3").val();
					
					$(".polling_container").css('boxShadow' , boxShadow_);
					$(".polling_container").hover(function() {
						$(this).css('boxShadow' , boxShadow);
					},function() {
						$(this).css('boxShadow' , boxShadow_);
					});

				}
				else if(roll == 5) {
					var boxShadow = $("#elem-55").val() + ' ' + $("#elem-56").val() + 'px '  + $("#elem-57").val() + 'px '  + $("#elem-58").val() + 'px ' + $("#elem-59").val() + 'px  #' + hex;
					var boxShadow_ = $("#elem-50").val() + ' ' + $("#elem-46").val() + 'px '  + $("#elem-47").val() + 'px '  + $("#elem-48").val() + 'px ' + $("#elem-49").val() + 'px  ' + $("#elem-3").val();
					
					$(".polling_container").hover(function() {
						$(this).css('boxShadow' , boxShadow);
					},function() {
						$(this).css('boxShadow' , boxShadow_);
					});
				}
				else if(roll == 7) {//poll name color
					$(".polling_container .polling_name").css('color' , '#' + hex);
				}
				else if(roll == 9) {//poll name color
					$(".polling_container .answer_name").css('color' , '#' + hex);
				}
				else if(roll == 11) {//answer animation shadow
					var boxShadow = $("#elem-68").val() + ' ' + $("#elem-69").val() + 'px '  + $("#elem-70").val() + 'px '  + $("#elem-71").val() + 'px ' + $("#elem-72").val() + 'px  #' + hex;
					$(".polling_container .active_li").css('boxShadow' , boxShadow);
				}
				else if(roll == 12) {//answer animation backgroundColor
					$(".polling_container .active_li").css('backgroundColor' , '#' + hex);
				}

				else if(roll == 63) { //poll name text shadow
					textShadow = $("#elem-60").val() + 'px '  + $("#elem-61").val() + 'px '  + $("#elem-62").val() + 'px #' + hex;
					$(".polling_container .polling_name").css('textShadow' , textShadow);
				}
				else if(roll == 67) { //poll answer name text shadow
					textShadow = $("#elem-64").val() + 'px '  + $("#elem-65").val() + 'px '  + $("#elem-66").val() + 'px #' + hex;
					$(".polling_container .answer_name").css('textShadow' , textShadow);
				}
				else if(roll == 73) {
					$(".polling_container .active_li").css('borderColor' , '#' + hex);
				}
				else if(roll == 78) {
					var boxShadow = $("#elem-79").val() + ' ' + $("#elem-80").val() + 'px '  + $("#elem-81").val() + 'px '  + $("#elem-82").val() + 'px ' + $("#elem-83").val() + 'px  #' + hex;
					$(".polling_container .grad").css('boxShadow' , boxShadow);
				}
				
				//polling Submit////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				else if(roll == 91) {//answer animation backgroundColor
					var backColor = $("#elem-123").val();
					var backColor_ = $("#elem-91").val();
					$(".polling_container .polling_submit").css('backgroundColor' , backColor_);
					
					$(".polling_container .polling_submit").hover(function() {
						$(".polling_container .polling_submit").css('backgroundColor' , backColor);
					},function() {
						$(".polling_container .polling_submit").css('backgroundColor' , backColor_);
					});
				}
				else if(roll == 100) {//answer animation backgroundColor
					var borderColor = $("#elem-126").val();
					var borderColor_ = $("#elem-100").val();
					$(".polling_container .polling_submit").css('borderColor' , borderColor_);
					
					$(".polling_container .polling_submit").hover(function() {
						$(this).css('borderColor' , borderColor);
					},function() {
						$(this).css('borderColor' , borderColor_);
					});
				}
				else if(roll == 94) { //poll answer name text shadow

					var boxShadow = $("#elem-118").val() + ' ' + $("#elem-119").val() + 'px '  + $("#elem-120").val() + 'px '  + $("#elem-121").val() + 'px ' + $("#elem-122").val() + 'px ' +  $("#elem-117").val();
					var boxShadow_ = $("#elem-95").val() + ' ' + $("#elem-96").val() + 'px '  + $("#elem-97").val() + 'px '  + $("#elem-98").val() + 'px ' + $("#elem-99").val() + 'px ' + $("#elem-94").val();
					$(".polling_container .polling_submit").css('boxShadow' , boxShadow_);
					
					$(".polling_container .polling_submit").hover(function() {
						$(this).css('boxShadow' , boxShadow);
					},function() {
						$(this).css('boxShadow' , boxShadow_);
					});
				}
				else if(roll == 106) {
					var textColor = $("#elem-124").val();
					var textColor_ = $("#elem-106").val();
					$(".polling_container .polling_submit").css('color' , textColor_);
					
					$(".polling_container .polling_submit").hover(function() {
						$(this).css('color' , textColor);
					},function() {
						$(this).css('color' , textColor_);
					});
				}
				else if(roll == 113) { //poll name text shadow
					var textShadow = $("#elem-114").val() + 'px '  + $("#elem-115").val() + 'px '  + $("#elem-116").val() + 'px ' + $("#elem-125").val();
					var textShadow_ = $("#elem-114").val() + 'px '  + $("#elem-115").val() + 'px '  + $("#elem-116").val() + 'px ' + $("#elem-113").val();
					$(".polling_container .polling_submit").css('textShadow' , textShadow_);
					
					$(".polling_container .polling_submit").hover(function() {
						$(this).css('textShadow' , textShadow);
					},function() {
						$(this).css('textShadow' , textShadow_);
					});
				}
				else if(roll == 123) {
					var backColor = '#' + hex;
					var backColor_ = $("#elem-91").val();
					
					$(".polling_container .polling_submit").hover(function() {
						$(".polling_container .polling_submit").css('backgroundColor' , backColor);
					},function() {
						$(".polling_container .polling_submit").css('backgroundColor' , backColor_);
					});
				}
				else if(roll == 124) {
					var textColor = '#' + hex;
					var textColor_ = $("#elem-106").val();
					
					$(".polling_container .polling_submit").hover(function() {
						$(this).css('color' , textColor);
					},function() {
						$(this).css('color' , textColor_);
					});
				}
				else if(roll == 125) {
					var textShadow = $("#elem-114").val() + 'px '  + $("#elem-115").val() + 'px '  + $("#elem-116").val() + 'px #' + hex;
					var textShadow_ = $("#elem-114").val() + 'px '  + $("#elem-115").val() + 'px '  + $("#elem-116").val() + 'px #' + $("#elem-113").val();
					
					$(".polling_container .polling_submit").hover(function() {
						$(this).css('textShadow' , textShadow);
					},function() {
						$(this).css('textShadow' , textShadow_);
					});
				}
				else if(roll == 126) {
					var borderColor = '#' + hex;
					var borderColor_ = $("#elem-100").val();
					
					$(".polling_container .polling_submit").hover(function() {
						$(this).css('borderColor' , borderColor);
					},function() {
						$(this).css('borderColor' , borderColor_);
					});
				}
				else if(roll == 117) {
					var boxShadow = $("#elem-118").val() + ' ' + $("#elem-119").val() + 'px '  + $("#elem-120").val() + 'px '  + $("#elem-121").val() + 'px ' + $("#elem-122").val() + 'px  #' + hex;
					var boxShadow_ = $("#elem-95").val() + ' ' + $("#elem-96").val() + 'px '  + $("#elem-97").val() + 'px '  + $("#elem-98").val() + 'px ' + $("#elem-99").val() + 'px ' + $("#elem-94").val();
					
					$(".polling_container .polling_submit").hover(function() {
						$(this).css('boxShadow' , boxShadow);
					},function() {
						$(this).css('boxShadow' , boxShadow_);
					});
				}
				
				//polling Result////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				else if(roll == 128) {//answer animation backgroundColor
					var backColor = $("#elem-160").val();
					var backColor_ = $("#elem-128").val();
					$(".polling_container .polling_result").css('backgroundColor' , backColor_);
					
					$(".polling_container .polling_result").hover(function() {
						$(".polling_container .polling_result").css('backgroundColor' , backColor);
					},function() {
						$(".polling_container .polling_result").css('backgroundColor' , backColor_);
					});
				}
				else if(roll == 137) {//answer animation backgroundColor
					var borderColor = $("#elem-163").val();
					var borderColor_ = $("#elem-137").val();
					$(".polling_container .polling_result").css('borderColor' , borderColor_);
					
					$(".polling_container .polling_result").hover(function() {
						$(this).css('borderColor' , borderColor);
					},function() {
						$(this).css('borderColor' , borderColor_);
					});
				}
				else if(roll == 131) { //poll answer name text shadow

					var boxShadow = $("#elem-155").val() + ' ' + $("#elem-156").val() + 'px '  + $("#elem-157").val() + 'px '  + $("#elem-158").val() + 'px ' + $("#elem-159").val() + 'px ' +  $("#elem-154").val();
					var boxShadow_ = $("#elem-132").val() + ' ' + $("#elem-133").val() + 'px '  + $("#elem-134").val() + 'px '  + $("#elem-135").val() + 'px ' + $("#elem-136").val() + 'px ' + $("#elem-131").val();
					$(".polling_container .polling_result").css('boxShadow' , boxShadow_);
					
					$(".polling_container .polling_result").hover(function() {
						$(this).css('boxShadow' , boxShadow);
					},function() {
						$(this).css('boxShadow' , boxShadow_);
					});
				}
				else if(roll == 143) {
					var textColor = $("#elem-161").val();
					var textColor_ = $("#elem-143").val();
					$(".polling_container .polling_result").css('color' , textColor_);
					
					$(".polling_container .polling_result").hover(function() {
						$(this).css('color' , textColor);
					},function() {
						$(this).css('color' , textColor_);
					});
				}
				else if(roll == 150) { //poll name text shadow
					var textShadow = $("#elem-151").val() + 'px '  + $("#elem-152").val() + 'px '  + $("#elem-153").val() + 'px ' + $("#elem-162").val();
					var textShadow_ = $("#elem-151").val() + 'px '  + $("#elem-152").val() + 'px '  + $("#elem-153").val() + 'px ' + $("#elem-150").val();
					$(".polling_container .polling_result").css('textShadow' , textShadow_);
					
					$(".polling_container .polling_result").hover(function() {
						$(this).css('textShadow' , textShadow);
					},function() {
						$(this).css('textShadow' , textShadow_);
					});
				}
				else if(roll == 160) {
					var backColor = '#' + hex;
					var backColor_ = $("#elem-128").val();
					
					$(".polling_container .polling_result").hover(function() {
						$(".polling_container .polling_result").css('backgroundColor' , backColor);
					},function() {
						$(".polling_container .polling_result").css('backgroundColor' , backColor_);
					});
				}
				else if(roll == 161) {
					var textColor = '#' + hex;
					var textColor_ = $("#elem-143").val();
					
					$(".polling_container .polling_result").hover(function() {
						$(this).css('color' , textColor);
					},function() {
						$(this).css('color' , textColor_);
					});
				}
				else if(roll == 162) {
					var textShadow = $("#elem-151").val() + 'px '  + $("#elem-152").val() + 'px '  + $("#elem-153").val() + 'px #' + hex;
					var textShadow_ = $("#elem-151").val() + 'px '  + $("#elem-152").val() + 'px '  + $("#elem-153").val() + 'px #' + $("#elem-150").val();
					
					$(".polling_container .polling_result").hover(function() {
						$(this).css('textShadow' , textShadow);
					},function() {
						$(this).css('textShadow' , textShadow_);
					});
				}
				else if(roll == 163) {
					var borderColor = '#' + hex;
					var borderColor_ = $("#elem-137").val();
					
					$(".polling_container .polling_result").hover(function() {
						$(this).css('borderColor' , borderColor);
					},function() {
						$(this).css('borderColor' , borderColor_);
					});
				}
				else if(roll == 154) {
					var boxShadow = $("#elem-155").val() + ' ' + $("#elem-156").val() + 'px '  + $("#elem-157").val() + 'px '  + $("#elem-158").val() + 'px ' + $("#elem-159").val() + 'px  #' + hex;
					var boxShadow_ = $("#elem-132").val() + ' ' + $("#elem-133").val() + 'px '  + $("#elem-134").val() + 'px '  + $("#elem-135").val() + 'px ' + $("#elem-136").val() + 'px ' + $("#elem-131").val();
					
					$(".polling_container .polling_result").hover(function() {
						$(this).css('boxShadow' , boxShadow);
					},function() {
						$(this).css('boxShadow' , boxShadow_);
					});
				}
				//select tags////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				else if(roll == 206) {
					var backColor = $("#elem-206").val();
					var backColor_ = $("#elem-226").val();
					$(".polling_select1,.polling_select2").css('backgroundColor' , backColor);
					
					$(".polling_select1,.polling_select2").hover(function() {
						$(".polling_select1,.polling_select2").css('backgroundColor' , backColor_);
					},function() {
						$(".polling_select1,.polling_select2").css('backgroundColor' , backColor);
					});
				}
				else if(roll == 209) {
					var textColor = $("#elem-209").val();
					var textColor_ = $("#elem-228").val();
					$(".polling_select1,.polling_select2").css('color' , textColor);
					
					$(".polling_select1,.polling_select2").hover(function() {
						$(this).css('color' , textColor_);
					},function() {
						$(this).css('color' , textColor);
					});
				}
				else if(roll == 215) { //poll name text shadow
					var textShadow = $("#elem-216").val() + 'px '  + $("#elem-217").val() + 'px '  + $("#elem-218").val() + 'px ' + $("#elem-215").val();
					var textShadow_ = $("#elem-216").val() + 'px '  + $("#elem-217").val() + 'px '  + $("#elem-218").val() + 'px ' + $("#elem-229").val();
					$(".polling_select1,.polling_select2").css('textShadow' , textShadow);
					
					$(".polling_select1,.polling_select2").hover(function() {
						$(this).css('textShadow' , textShadow_);
					},function() {
						$(this).css('textShadow' , textShadow);
					});
				}
				else if(roll == 219) {
					var borderColor = '#' + hex;
					var borderColor_ = $("#elem-227").val();
					
					$('.polling_select1,.polling_select2').css('borderColor' , borderColor);
					$(".polling_select1,.polling_select2").hover(function() {
						$(this).css('borderColor' , borderColor_);
					},function() {
						$(this).css('borderColor' , borderColor);
					});
				}
				else if(roll == 226) {//answer animation backgroundColor
					var backColor = $("#elem-206").val();
					var backColor_ = $("#elem-226").val();
					
					$(".polling_select1,.polling_select2").hover(function() {
						$(".polling_select1,.polling_select2").css('backgroundColor' , backColor_);
					},function() {
						$(".polling_select1,.polling_select2").css('backgroundColor' , backColor);
					});
				}
				else if(roll == 229) { //poll name text shadow
					var textShadow = $("#elem-216").val() + 'px '  + $("#elem-217").val() + 'px '  + $("#elem-218").val() + 'px ' + $("#elem-215").val();
					var textShadow_ = $("#elem-216").val() + 'px '  + $("#elem-217").val() + 'px '  + $("#elem-218").val() + 'px ' + $("#elem-229").val();
					
					$(".polling_select1,.polling_select2").hover(function() {
						$(this).css('textShadow' , textShadow_);
					},function() {
						$(this).css('textShadow' , textShadow);
					});
				}
				else if(roll == 228) {
					var textColor = $("#elem-209").val();
					var textColor_ = $("#elem-228").val();
					
					$(".polling_select1,.polling_select2").hover(function() {
						$(this).css('color' , textColor_);
					},function() {
						$(this).css('color' , textColor);
					});
				}
				else if(roll == 227) {
					var borderColor = $("#elem-219").val();
					var borderColor_ = $("#elem-227").val();
					
					$(".polling_select1,.polling_select2").hover(function() {
						$(this).css('borderColor' , borderColor_);
					},function() {
						$(this).css('borderColor' , borderColor);
					});
				}
				// votes data
				else if(roll == 166) {
					var textColor = $("#elem-166").val();
					$(".answer_votes_data").css('color',textColor);
				}
				else if(roll == 172) {
					var textShadow = $("#elem-173").val() + 'px '  + $("#elem-174").val() + 'px '  + $("#elem-175").val() + 'px ' + $("#elem-172").val();
					$(".answer_votes_data").css('textShadow' , textShadow);
				}
				// votes data
				else if(roll == 176) {
					var textColor = $("#elem-176").val();
					$(".answer_votes_data span").css('color',textColor);
				}
				else if(roll == 182) {
					var textShadow = $("#elem-183").val() + 'px '  + $("#elem-184").val() + 'px '  + $("#elem-185").val() + 'px ' + $("#elem-182").val();
					$(".answer_votes_data span").css('textShadow' , textShadow);
				}
				//total votes data 
				else if(roll == 186) {
					var textColor = $("#elem-186").val();
					$(".left_col").css('color',textColor);
				}
				else if(roll == 192) {
					var textShadow = $("#elem-193").val() + 'px '  + $("#elem-194").val() + 'px '  + $("#elem-195").val() + 'px ' + $("#elem-192").val();
					$(".left_col").css('textShadow' , textShadow);
				}
				//right colomn
				else if(roll == 196) {
					var textColor = $("#elem-196").val();
					$(".right_col").css('color',textColor);
				}
				else if(roll == 202) {
					var textShadow = $("#elem-203").val() + 'px '  + $("#elem-204").val() + 'px '  + $("#elem-205").val() + 'px ' + $("#elem-202").val();
					$(".right_col").css('textShadow' , textShadow);
				}

				//add answer
				else if(roll == 273) {
					var backColor = $("#elem-273").val();
					$(".add_answer").css('backgroundColor' , backColor);
				}
				else if(roll == 251) {
					var backColor = $("#elem-251").val();
					$(".add_ans_name").css('color' , backColor);
				}
				else if(roll == 271) {
					var backColor = $("#elem-271").val();
					$(".add_ans_submit").css('color' , backColor);
				}
				else if(roll == 274) {
					var textShadow = $("#elem-275").val() + 'px '  + $("#elem-276").val() + 'px '  + $("#elem-277").val() + 'px ' + $("#elem-274").val();
					$(".add_ans_name,.add_ans_submit").css('textShadow' , textShadow);
				}
				else if(roll == 257) {
					var boxShadow = $("#elem-258").val() + ' ' + $("#elem-259").val() + 'px '  + $("#elem-260").val() + 'px '  + $("#elem-261").val() + 'px ' + $("#elem-262").val() + 'px ' + $("#elem-257").val() ;
					$(".add_answer").css('boxShadow' , boxShadow);
				}
				else if(roll == 263) {
					var border = $("#elem-264").val() + 'px '  + $("#elem-265").val() + $("#elem-263").val() ;
					$(".add_answer").css('border' , border);
					$(".add_ans_submit").css('borderLeft' , border);
				}

				//slider
				else if(roll == 230) {
					var back = $("#elem-230").val();
					$(".ui-widget-content").css('backgroundColor' , back);
				}
				else if(roll == 231) {
					var bord = $("#elem-231").val();
					$(".ui-widget-content").css('borderColor' , bord);
				}
				else if(roll == 235) {
					var backColor = $("#elem-235").val();
					var backColor_ = $("#elem-237").val();
					
					$(".ui-widget-content .ui-state-default").css('backgroundColor' , backColor);
					$(".ui-widget-content .ui-state-default").hover(function() {
						$(this).css('backgroundColor' , backColor_);
					},function() {
						$(this).css('backgroundColor' , backColor);
					});
				}
				else if(roll == 236) {
					var bord = '1px solid ' + $("#elem-236").val();
					var bord_ = '1px solid ' + $("#elem-238").val();
					
					$(".ui-widget-content .ui-state-default").css('border' , bord);
					$(".ui-widget-content .ui-state-default").hover(function() {
						$(this).css('border' , bord_);
					},function() {
						$(this).css('border' , bord);
					});
				}
				else if(roll == 237) {
					var backColor = $("#elem-235").val();
					var backColor_ = $("#elem-237").val();
					
					$(".ui-widget-content .ui-state-default").hover(function() {
						$(this).css('backgroundColor' , backColor_);
					},function() {
						$(this).css('backgroundColor' , backColor);
					});
				}
				else if(roll == 238) {
					var bord = '1px solid ' + $("#elem-236").val();
					var bord_ = '1px solid ' + $("#elem-238").val();
					
					$(".ui-widget-content .ui-state-default").hover(function() {
						$(this).css('border' , bord_);
					},function() {
						$(this).css('border' , bord);
					});
				}
				else if(roll == 239) {
					var col = $("#elem-239").val();
					$(".ui-slider dt").css('color' , col);
				}
				else if(roll == 249) {
					var bord = '1px dotted ' + $("#elem-249").val();
					$(".ui-slider dt").css('borderBottom' , bord);
				}
				else if(roll == 244) {
					var textShadow = $("#elem-245").val() + 'px '  + $("#elem-246").val() + 'px '  + $("#elem-247").val() + 'px ' + $("#elem-244").val();
					$(".ui-slider dt").css('textShadow' , textShadow);
				}
				else if(roll == 233) {
					var back = '-webkit-linear-gradient(top, ' + $("#elem-233").val() + ', '  + $("#elem-234").val() + ')';
					$(".ui-widget-header").css('background' , back);
					back = '-webkit-gradient(linear, 0% 0%, 0% 100%, from(' + $("#elem-233").val() + '), to('  + $("#elem-234").val() + '))';
					$(".ui-widget-header").css('background' , back);
					back = '-moz-linear-gradient(top, ' + $("#elem-233").val() + ', '  + $("#elem-234").val() + ')';
					$(".ui-widget-header").css('background' , back);
					back = '-ms-linear-gradient(top, ' + $("#elem-233").val() + ', '  + $("#elem-234").val() + ')';
					$(".ui-widget-header").css('background' , back);
					back = '-o-linear-gradient(top, ' + $("#elem-233").val() + ', '  + $("#elem-234").val() + ')';
					$(".ui-widget-header").css('background' , back);
					fil = ' progid:DXImageTransform.Microsoft.gradient(startColorstr=' + $("#elem-233").val() + ', endColorstr='  + $("#elem-234").val() + ')';
					$(".ui-widget-header").css('filter' , fil);
				}
				else if(roll == 234) {
					var back = '-webkit-linear-gradient(top, ' + $("#elem-233").val() + ', '  + $("#elem-234").val() + ')';
					$(".ui-widget-header").css('background' , back);
					back = '-webkit-gradient(linear, 0% 0%, 0% 100%, from(' + $("#elem-233").val() + '), to('  + $("#elem-234").val() + '))';
					$(".ui-widget-header").css('background' , back);
					back = '-moz-linear-gradient(top, ' + $("#elem-233").val() + ', '  + $("#elem-234").val() + ')';
					$(".ui-widget-header").css('background' , back);
					back = '-ms-linear-gradient(top, ' + $("#elem-233").val() + ', '  + $("#elem-234").val() + ')';
					$(".ui-widget-header").css('background' , back);
					back = '-o-linear-gradient(top, ' + $("#elem-233").val() + ', '  + $("#elem-234").val() + ')';
					$(".ui-widget-header").css('background' , back);
					fil = ' progid:DXImageTransform.Microsoft.gradient(startColorstr=' + $("#elem-233").val() + ', endColorstr='  + $("#elem-234").val() + ')';
					$(".ui-widget-header").css('filter' , fil);
				}
				//answers
				else if(roll == 500 || roll == 501 || roll == 502 || roll == 503 || roll == 504 || roll == 505 || roll == 506 || roll == 507 || roll == 508 || roll == 509 || roll == 510 || roll == 511 || roll == 512 || roll == 513 || roll == 514 || roll == 515 || roll == 516 || roll == 517 || roll == 518 || roll == 519 || roll == 520 || roll == 521 || roll == 522 || roll == 523 || roll == 524 || roll == 525 || roll == 526 || roll == 527 || roll == 528 || roll == 529 || roll == 530 || roll == 531 || roll == 532 || roll == 533 || roll == 534 || roll == 535 || roll == 536 || roll == 537 || roll == 538 || roll == 539) {

					if(roll%2 == 0) {
						ind = roll;
						ind1 = roll*1 + 1;
					}
					else {
						ind = roll - 1;
						ind1 = roll;
					}
					elem_index = Math.ceil((roll - 499)/2);
					
					var back = '-webkit-linear-gradient(top, ' + $("#elem-" + ind).val() + ', '  + $("#elem-" + ind1).val() + ')';
					$("#answer_navigation_" + elem_index + " .grad").css('background' , back);
					back = '-webkit-gradient(linear, 0% 0%, 0% 100%, from(' + $("#elem-" + ind).val() + '), to('  + $("#elem-" + ind1).val() + '))';
					$("#answer_navigation_" + elem_index + " .grad").css('background' , back);
					back = '-moz-linear-gradient(top, ' + $("#elem-" + ind).val() + ', '  + $("#elem-" + ind1).val() + ')';
					$("#answer_navigation_" + elem_index + " .grad").css('background' , back);
					back = '-ms-linear-gradient(top, ' + $("#elem-" + ind).val() + ', '  + $("#elem-" + ind1).val() + ')';
					$("#answer_navigation_" + elem_index + " .grad").css('background' , back);
					back = '-o-linear-gradient(top, ' + $("#elem-" + ind).val() + ', '  + $("#elem-" + ind1).val() + ')';
					$("#answer_navigation_" + elem_index + " .grad").css('background' , back);
					fil = ' progid:DXImageTransform.Microsoft.gradient(startColorstr=' + $("#elem-" + ind).val() + ', endColorstr='  + $("#elem-" + ind1).val() + ')';
					$("#answer_navigation_" + elem_index + " .grad").css('filter' , fil);
				}

				
			}
		});


		//size up
		var up_int,down_int,curr_up,curr_down;
		$('.size_up').mousedown(function() {
			
			var $this = $(this);
			curr_up = parseInt($this.parent('div').prev('input').val());
			up_int = setInterval(function() {
				max_val = parseInt($this.attr("maxval"));
				val = parseInt($this.parent('div').prev('input').val());
				if(val < max_val) {
					$this.parent('div').prev('input').val(val*1 + 1);
					roll = $this.parent('div').prev('input').attr('roll');
					move_up(roll,val);
				}
			},100);
		})
		
		$('.size_up').mouseup(function() {
			clearInterval(up_int);
			var $this = $(this);
			max_val = parseInt($this.attr("maxval"));
			val = parseInt($this.parent('div').prev('input').val());
			if((val < max_val) && (curr_up == val)) {
				$this.parent('div').prev('input').val(val*1 + 1);
				roll = $this.parent('div').prev('input').attr('roll');
				move_up(roll,val);
			}
		});

		$('.size_up').mouseleave(function() {
			clearInterval(up_int);
		});

		function move_up(roll,val) {
			if(roll == 2) { //box border width
				$(".polling_container").css({
					borderLeftWidth : val*1 + 1,
					borderRightWidth : val*1 + 1,
					borderBottomWidth : val*1 + 1,
					borderTopWidth : val*1 + 1
				});
			}
			else if(roll == 89) { //box border width
				$(".polling_container .grad").css({
					borderLeftWidth : val*1 + 1,
					borderRightWidth : val*1 + 1,
					borderBottomWidth : val*1 + 1,
					borderTopWidth : val*1 + 1
				});
			}
			else if(roll == 51) {
				$(".polling_container").css('border-top-left-radius' , val*1 + 1);
			}
			else if(roll == 52) {
				$(".polling_container").css('border-top-right-radius' , val*1 + 1);
			}
			else if(roll == 53) {
				$(".polling_container").css('border-bottom-left-radius' , val*1 + 1);
			}
			else if(roll == 54) {
				$(".polling_container").css('border-bottom-right-radius' , val*1 + 1);
			}
			
			//add answer
			else if(roll == 266) {
				$(".add_answer").css('border-top-left-radius' , val*1 + 1);
			}
			else if(roll == 267) {
				$(".add_answer").css('border-top-right-radius' , val*1 + 1);
			}
			else if(roll == 268) {
				$(".add_answer").css('border-bottom-left-radius' , val*1 + 1);
			}
			else if(roll == 269) {
				$(".add_answer").css('border-bottom-right-radius' , val*1 + 1);
			}
			else if(roll == 252) {
				$(".add_ans_name,.add_ans_submit").css('fontSize' , val*1 + 1);
			}
			else if(roll == 264) {
				var size = val*1 + 1;
				var border = size + 'px '  + $("#elem-265").val() + $("#elem-263").val() ;
				$(".add_answer").css('border' , border);
				$(".add_ans_submit").css('borderLeft' , border);
			}
			else if(roll == 259 || roll == 260 || roll == 261 || roll == 262) {
				var boxShadow = $("#elem-258").val() + ' ' + $("#elem-259").val() + 'px '  + $("#elem-260").val() + 'px '  + $("#elem-261").val() + 'px ' + $("#elem-262").val() + 'px ' + $("#elem-257").val();
				$(".add_answer").css('boxShadow' , boxShadow);
			}
			else if(roll == 275 || roll == 276 || roll == 277 ) { 
				textShadow = $("#elem-275").val() + 'px '  + $("#elem-276").val() + 'px '  + $("#elem-277").val() + 'px ' +  $("#elem-274").val() ;
				$(".add_ans_name,.add_ans_submit").css('textShadow' , textShadow);
			}
			else if(roll == 272) {
				$(".add_answer").css('height' , val*1 + 1);
			}

        	//grad
			else if(roll == 85) {
				$(".polling_container .grad").css('border-top-left-radius' , val*1 + 1);
				$(".polling_container .answer_navigation").css('border-top-left-radius' , val*1 + 1);
			}
			else if(roll == 86) {
				$(".polling_container .grad").css('border-top-right-radius' , val*1 + 1);
				$(".polling_container .answer_navigation").css('border-top-right-radius' , val*1 + 1);
			}
			else if(roll == 87) {
				$(".polling_container .grad").css('border-bottom-left-radius' , val*1 + 1);
				$(".polling_container .answer_navigation").css('border-bottom-left-radius' , val*1 + 1);
			}
			else if(roll == 88) {
				$(".polling_container .grad").css('border-bottom-right-radius' , val*1 + 1);
				$(".polling_container .answer_navigation").css('border-bottom-right-radius' , val*1 + 1);
			}
			else if(roll == 8) { //box border radius
				$(".polling_container .polling_name").css('fontSize' , val*1 + 1);
			}
			else if(roll == 10) { //answer name font size
				$(".polling_container .answer_name label").css('fontSize' , val*1 + 1);
			}
			else if(roll == 46 || roll == 47 || roll == 48 || roll == 49) {
				var boxShadow = $("#elem-55").val() + ' ' + $("#elem-56").val() + 'px '  + $("#elem-57").val() + 'px '  + $("#elem-58").val() + 'px ' + $("#elem-59").val() + 'px ' + $("#elem-5").val();
				var boxShadow_ = $("#elem-50").val() + ' ' + $("#elem-46").val() + 'px '  + $("#elem-47").val() + 'px '  + $("#elem-48").val() + 'px ' + $("#elem-49").val() + 'px  ' + $("#elem-3").val();
				
				$(".polling_container").css('boxShadow' , boxShadow_);
				$(".polling_container").hover(function() {
					$(this).css('boxShadow' , boxShadow);
				},function() {
					$(this).css('boxShadow' , boxShadow_);
				});
			}
			else if(roll == 56 || roll == 57 || roll == 58 || roll == 59) {//box hover state
				var boxShadow = $("#elem-55").val() + ' ' + $("#elem-56").val() + 'px '  + $("#elem-57").val() + 'px '  + $("#elem-58").val() + 'px ' + $("#elem-59").val() + 'px ' + $("#elem-5").val();
				var boxShadow_ = $("#elem-50").val() + ' ' + $("#elem-46").val() + 'px '  + $("#elem-47").val() + 'px '  + $("#elem-48").val() + 'px ' + $("#elem-49").val() + 'px  ' + $("#elem-3").val();
				
				$(".polling_container").hover(function() {
					$(this).css('boxShadow' , boxShadow);
				},function() {
					$(this).css('boxShadow' , boxShadow_);
				});
			}
			else if(roll == 60 || roll == 61 || roll == 62 ) { //poll name text shadow
				textShadow = $("#elem-60").val() + 'px '  + $("#elem-61").val() + 'px '  + $("#elem-62").val() + 'px ' +  $("#elem-63").val() ;
				$(".polling_container .polling_name").css('textShadow' , textShadow);
			}
			else if(roll == 64 || roll == 65 || roll == 66 ) { //poll answer name text shadow
				textShadow = $("#elem-64").val() + 'px '  + $("#elem-65").val() + 'px '  + $("#elem-66").val() + 'px ' +  $("#elem-67").val() ;
				$(".polling_container .answer_name").css('textShadow' , textShadow);
			}
			else if(roll == 72 || roll == 69 || roll == 70 || roll == 71) { //active animation
				var boxShadow = $("#elem-68").val() + ' ' + $("#elem-69").val() + 'px '  + $("#elem-70").val() + 'px '  + $("#elem-71").val() + 'px ' + $("#elem-72").val() + 'px ' + $("#elem-11").val();
				$(".polling_container .active_li").css('boxShadow' , boxShadow);
			}
			else if(roll == 80 || roll == 81 || roll == 82 || roll == 83) { //answer_navigation
				var boxShadow = $("#elem-79").val() + ' ' + $("#elem-80").val() + 'px '  + $("#elem-81").val() + 'px '  + $("#elem-82").val() + 'px ' + $("#elem-83").val() + 'px ' + $("#elem-78").val();
				$(".polling_container .grad").css('boxShadow' , boxShadow);
			}
			//animation border radius
			else if(roll == 74) {
				$(".polling_container .active_li").css('border-top-left-radius' , val*1 + 1);
			}
			else if(roll == 75) {
				$(".polling_container .active_li").css('border-top-right-radius' , val*1 + 1);
			}
			else if(roll == 76) {
				$(".polling_container .active_li").css('border-bottom-left-radius' , val*1 + 1);
			}
			else if(roll == 77) {
				$(".polling_container .active_li").css('border-bottom-right-radius' , val*1 + 1);
			}
			else if(roll == 90) {
				$(".polling_container .answer_navigation").css('height' , val*1 + 1);
			}
			
			// poll submit ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			else if(roll == 92) {
				$(".polling_container .polling_submit").css('paddingTop' , val*1 + 1);
				$(".polling_container .polling_submit").css('paddingBottom' , val*1 + 1);
			}
			else if(roll == 93) {
				$(".polling_container .polling_submit").css('paddingLeft' , val*1 + 1);
				$(".polling_container .polling_submit").css('paddingRight' , val*1 + 1);
			}
			else if(roll == 101) { //box border width
				$(".polling_container .polling_submit").css({
					borderLeftWidth : val*1 + 1,
					borderRightWidth : val*1 + 1,
					borderBottomWidth : val*1 + 1,
					borderTopWidth : val*1 + 1
				});
			}
			else if(roll == 102) {
				$(".polling_container .polling_submit").css('border-top-left-radius' , val*1 + 1);
			}
			else if(roll == 103) {
				$(".polling_container .polling_submit").css('border-top-right-radius' , val*1 + 1);
			}
			else if(roll == 104) {
				$(".polling_container .polling_submit").css('border-bottom-left-radius' , val*1 + 1);
			}
			else if(roll == 105) {
				$(".polling_container .polling_submit").css('border-bottom-right-radius' , val*1 + 1);
			}
			else if(roll == 96 || roll == 97 || roll == 98 || roll == 99) {
				var boxShadow = $("#elem-118").val() + ' ' + $("#elem-119").val() + 'px '  + $("#elem-120").val() + 'px '  + $("#elem-121").val() + 'px ' + $("#elem-122").val() + 'px ' +  $("#elem-117").val();
				var boxShadow_ = $("#elem-95").val() + ' ' + $("#elem-96").val() + 'px '  + $("#elem-97").val() + 'px '  + $("#elem-98").val() + 'px ' + $("#elem-99").val() + 'px ' + $("#elem-94").val();
				$(".polling_container .polling_submit").css('boxShadow' , boxShadow_);
				
				$(".polling_container .polling_submit").hover(function() {
					$(this).css('boxShadow' , boxShadow);
				},function() {
					$(this).css('boxShadow' , boxShadow_);
				});
			}
			else if(roll == 107) {
				$(".polling_container .polling_submit").css('fontSize' , val*1 + 1);
			}
			else if(roll == 114 || roll == 115 || roll == 116 ) {
				var textShadow = $("#elem-114").val() + 'px '  + $("#elem-115").val() + 'px '  + $("#elem-116").val() + 'px ' + $("#elem-125").val();
				var textShadow_ = $("#elem-114").val() + 'px '  + $("#elem-115").val() + 'px '  + $("#elem-116").val() + 'px ' + $("#elem-113").val();
				$(".polling_container .polling_submit").css('textShadow' , textShadow_);
				
				$(".polling_container .polling_submit").hover(function() {
					$(this).css('textShadow' , textShadow);
				},function() {
					$(this).css('textShadow' , textShadow_);
				});
			}
			else if(roll == 119 || roll == 120 || roll == 121 || roll == 122) {
				var boxShadow = $("#elem-118").val() + ' ' + $("#elem-119").val() + 'px '  + $("#elem-120").val() + 'px '  + $("#elem-121").val() + 'px ' + $("#elem-122").val() + 'px ' + $("#elem-117").val();
				var boxShadow_ = $("#elem-95").val() + ' ' + $("#elem-96").val() + 'px '  + $("#elem-97").val() + 'px '  + $("#elem-98").val() + 'px ' + $("#elem-99").val() + 'px ' + $("#elem-94").val();
				
				$(".polling_container .polling_submit").hover(function() {
					$(this).css('boxShadow' , boxShadow);
				},function() {
					$(this).css('boxShadow' , boxShadow_);
				});
			}

			// poll Result ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			else if(roll == 129) {
				$(".polling_container .polling_result").css('paddingTop' , val*1 + 1);
				$(".polling_container .polling_result").css('paddingBottom' , val*1 + 1);
			}
			else if(roll == 130) {
				$(".polling_container .polling_result").css('paddingLeft' , val*1 + 1);
				$(".polling_container .polling_result").css('paddingRight' , val*1 + 1);
			}
			else if(roll == 138) { //box border width
				$(".polling_container .polling_result").css({
					borderLeftWidth : val*1 + 1,
					borderRightWidth : val*1 + 1,
					borderBottomWidth : val*1 + 1,
					borderTopWidth : val*1 + 1
				});
			}
			else if(roll == 139) {
				$(".polling_container .polling_result").css('border-top-left-radius' , val*1 + 1);
			}
			else if(roll == 140) {
				$(".polling_container .polling_result").css('border-top-right-radius' , val*1 + 1);
			}
			else if(roll == 141) {
				$(".polling_container .polling_result").css('border-bottom-left-radius' , val*1 + 1);
			}
			else if(roll == 142) {
				$(".polling_container .polling_result").css('border-bottom-right-radius' , val*1 + 1);
			}
			else if(roll == 133 || roll == 134 || roll == 135 || roll == 136) {
				var boxShadow = $("#elem-155").val() + ' ' + $("#elem-156").val() + 'px '  + $("#elem-157").val() + 'px '  + $("#elem-158").val() + 'px ' + $("#elem-159").val() + 'px ' +  $("#elem-154").val();
				var boxShadow_ = $("#elem-132").val() + ' ' + $("#elem-133").val() + 'px '  + $("#elem-134").val() + 'px '  + $("#elem-135").val() + 'px ' + $("#elem-136").val() + 'px ' + $("#elem-131").val();
				$(".polling_container .polling_result").css('boxShadow' , boxShadow_);
				
				$(".polling_container .polling_result").hover(function() {
					$(this).css('boxShadow' , boxShadow);
				},function() {
					$(this).css('boxShadow' , boxShadow_);
				});
			}
			else if(roll == 144) {
				$(".polling_container .polling_result").css('fontSize' , val*1 + 1);
			}
			else if(roll == 151 || roll == 152 || roll == 153 ) {
				var textShadow = $("#elem-151").val() + 'px '  + $("#elem-152").val() + 'px '  + $("#elem-153").val() + 'px ' + $("#elem-162").val();
				var textShadow_ = $("#elem-151").val() + 'px '  + $("#elem-152").val() + 'px '  + $("#elem-153").val() + 'px ' + $("#elem-150").val();
				$(".polling_container .polling_result").css('textShadow' , textShadow_);
				
				$(".polling_container .polling_result").hover(function() {
					$(this).css('textShadow' , textShadow);
				},function() {
					$(this).css('textShadow' , textShadow_);
				});
			}
			else if(roll == 156 || roll == 157 || roll == 158 || roll == 159) {
				var boxShadow = $("#elem-155").val() + ' ' + $("#elem-156").val() + 'px '  + $("#elem-157").val() + 'px '  + $("#elem-158").val() + 'px ' + $("#elem-159").val() + 'px ' + $("#elem-154").val();
				var boxShadow_ = $("#elem-132").val() + ' ' + $("#elem-133").val() + 'px '  + $("#elem-134").val() + 'px '  + $("#elem-135").val() + 'px ' + $("#elem-136").val() + 'px ' + $("#elem-131").val();
				
				$(".polling_container .polling_result").hover(function() {
					$(this).css('boxShadow' , boxShadow);
				},function() {
					$(this).css('boxShadow' , boxShadow_);
				});
			}
			//votes data
			else if(roll == 207) {
				$(".polling_select1,.polling_select2").css('paddingTop' , val*1 + 1);
				$(".polling_select1,.polling_select2").css('paddingBottom' , val*1 + 1);
			}
			else if(roll == 208) {
				$(".polling_select1,.polling_select2").css('paddingLeft' , val*1 + 1);
				$(".polling_select1,.polling_select2").css('paddingRight' , val*1 + 1);
			}
			else if(roll == 210) { //box border radius
				$(".polling_select1,.polling_select2").css('fontSize' , val*1 + 1);
			}
			else if(roll == 216 || roll == 217 || roll == 218 ) {
				var textShadow = $("#elem-216").val() + 'px '  + $("#elem-217").val() + 'px '  + $("#elem-218").val() + 'px ' + $("#elem-215").val();
				var textShadow_ = $("#elem-216").val() + 'px '  + $("#elem-217").val() + 'px '  + $("#elem-218").val() + 'px ' + $("#elem-229").val();
				$(".polling_select1,.polling_select2").css('textShadow' , textShadow);
				
				$(".polling_select1,.polling_select2").hover(function() {
					$(this).css('textShadow' , textShadow_);
				},function() {
					$(this).css('textShadow' , textShadow);
				});
			}
			else if(roll == 220) { 
				$(".polling_select1,.polling_select2").css({
					borderLeftWidth : val*1 + 1,
					borderRightWidth : val*1 + 1,
					borderBottomWidth : val*1 + 1,
					borderTopWidth : val*1 + 1
				});
			}
			else if(roll == 222) {
				$(".polling_select1,.polling_select2").css('border-top-left-radius' , val*1 + 1);
			}
			else if(roll == 223) {
				$(".polling_select1,.polling_select2").css('border-top-right-radius' , val*1 + 1);
			}
			else if(roll == 224) {
				$(".polling_select1,.polling_select2").css('border-bottom-left-radius' , val*1 + 1);
			}
			else if(roll == 225) {
				$(".polling_select1,.polling_select2").css('border-bottom-right-radius' , val*1 + 1);
			}
			//vote data
			else if(roll == 167) {
				$(".answer_votes_data").css('fontSize',val*1 + 1);
			}
			else if(roll == 173 || roll == 174 || roll == 175 ) {
				var textShadow = $("#elem-173").val() + 'px '  + $("#elem-174").val() + 'px '  + $("#elem-175").val() + 'px ' + $("#elem-172").val();
				$(".answer_votes_data").css('textShadow' , textShadow);
			}
			//vote  digit data
			else if(roll == 177) {
				$(".answer_votes_data span").css('fontSize',val*1 + 1);
			}
			else if(roll == 183 || roll == 184 || roll == 185 ) {
				var textShadow = $("#elem-183").val() + 'px '  + $("#elem-184").val() + 'px '  + $("#elem-185").val() + 'px ' + $("#elem-182").val();
				$(".answer_votes_data span").css('textShadow' , textShadow);
			}
			//total vote  data
			else if(roll == 187) {
				$(".left_col").css('fontSize',val*1 + 1);
			}
			else if(roll == 197) {
				$(".right_col").css('fontSize',val*1 + 1);
			}
			else if(roll == 193 || roll == 194 || roll == 195 ) {
				var textShadow = $("#elem-193").val() + 'px '  + $("#elem-194").val() + 'px '  + $("#elem-195").val() + 'px ' + $("#elem-192").val();
				$(".left_col").css('textShadow' , textShadow);
			}
			else if(roll == 203 || roll == 204 || roll == 205 ) {
				var textShadow = $("#elem-203").val() + 'px '  + $("#elem-204").val() + 'px '  + $("#elem-205").val() + 'px ' + $("#elem-202").val();
				$(".right_col").css('textShadow' , textShadow);
			}
			//slider
			else if (roll == 232) {
				$(".ui-corner-all").css('borderRadius',val*1 + 1);
			}
			else if (roll == 248) {
				$(".ui-slider dt").css('fontSize',val*1 + 1);
			}
			else if (roll == 250) {
				$(".ui-slider dt").css('height',val*1 + 1);
			}
			else if(roll == 245 || roll == 246 || roll == 247 ) {
				var textShadow = $("#elem-245").val() + 'px '  + $("#elem-246").val() + 'px '  + $("#elem-247").val() + 'px ' + $("#elem-244").val();
				$(".ui-slider dt").css('textShadow' , textShadow);
			}

			
		}


		$('.size_down').mousedown(function() {
			var $this = $(this);
			curr_down = parseInt($this.parent('div').prev('input').val());
			down_int = setInterval(function() {
				min_val = parseInt($this.attr("minval"));
				val = parseInt($this.parent('div').prev('input').val());
				if(val > min_val) {
					$this.parent('div').prev('input').val(val*1 - 1);
					roll = $this.parent('div').prev('input').attr('roll');
					move_down(roll,val);
				}
			},100);
		})
		
		$('.size_down').mouseup(function() {
			clearInterval(down_int);
			var $this = $(this);
			min_val = parseInt($this.attr("minval"));
			val = parseInt($this.parent('div').prev('input').val());
			if((val > min_val) && (curr_down == val)) {
				$this.parent('div').prev('input').val(val*1 - 1);
				roll = $this.parent('div').prev('input').attr('roll');
				move_down(roll,val);
			}
		})
		
		$('.size_down').mouseleave(function() {
			clearInterval(down_int);
		});

		function move_down(roll,val) {
			if(roll == 2) {
				$(".polling_container").css({
					borderLeftWidth : val*1 - 1,
					borderRightWidth : val*1 - 1,
					borderBottomWidth : val*1 - 1,
					borderTopWidth : val*1 - 1
				});
			}
			else if(roll == 89) { //box border width
				$(".polling_container .grad").css({
					borderLeftWidth : val*1 - 1,
					borderRightWidth : val*1 - 1,
					borderBottomWidth : val*1 - 1,
					borderTopWidth : val*1 - 1
				});
			}
			else if(roll == 51) {
				$(".polling_container").css('border-top-left-radius' , val*1 - 1);
			}
			else if(roll == 52) {
				$(".polling_container").css('border-top-right-radius' , val*1 - 1);
			}
			else if(roll == 53) {
				$(".polling_container").css('border-bottom-left-radius' , val*1 - 1);
			}
			else if(roll == 54) {
				$(".polling_container").css('border-bottom-right-radius' , val*1 - 1);
			}
			else if(roll == 85) {
				$(".polling_container .grad").css('border-top-left-radius' , val*1 + 1);
				$(".polling_container .answer_navigation").css('border-top-left-radius' , val*1 + 1);
			}
			else if(roll == 86) {
				$(".polling_container .grad").css('border-top-right-radius' , val*1 + 1);
				$(".polling_container .answer_navigation").css('border-top-right-radius' , val*1 + 1);
			}
			else if(roll == 87) {
				$(".polling_container .grad").css('border-bottom-left-radius' , val*1 + 1);
				$(".polling_container .answer_navigation").css('border-bottom-left-radius' , val*1 + 1);
			}
			else if(roll == 88) {
				$(".polling_container .grad").css('border-bottom-right-radius' , val*1 + 1);
				$(".polling_container .answer_navigation").css('border-bottom-right-radius' , val*1 + 1);
			}
			else if(roll == 8) { //box border radius
				$(".polling_container .polling_name").css('fontSize' , val*1 - 1);
			}
			else if(roll == 10) { //answer name font size
				$(".polling_container .answer_name label").css('fontSize' , val*1 - 1);
			}
			else if(roll == 46 || roll == 47 || roll == 48 || roll == 49) {
				var boxShadow = $("#elem-55").val() + ' ' + $("#elem-56").val() + 'px '  + $("#elem-57").val() + 'px '  + $("#elem-58").val() + 'px ' + $("#elem-59").val() + 'px ' + $("#elem-5").val();
				var boxShadow_ = $("#elem-50").val() + ' ' + $("#elem-46").val() + 'px '  + $("#elem-47").val() + 'px '  + $("#elem-48").val() + 'px ' + $("#elem-49").val() + 'px  ' + $("#elem-3").val();
				
				$(".polling_container").css('boxShadow' , boxShadow_);
				$(".polling_container").hover(function() {
					$(this).css('boxShadow' , boxShadow);
				},function() {
					$(this).css('boxShadow' , boxShadow_);
				});
			}
			else if(roll == 56 || roll == 57 || roll == 58 || roll == 59) {//box hover state
				var boxShadow = $("#elem-55").val() + ' ' + $("#elem-56").val() + 'px '  + $("#elem-57").val() + 'px '  + $("#elem-58").val() + 'px ' + $("#elem-59").val() + 'px ' + $("#elem-5").val();
				var boxShadow_ = $("#elem-50").val() + ' ' + $("#elem-46").val() + 'px '  + $("#elem-47").val() + 'px '  + $("#elem-48").val() + 'px ' + $("#elem-49").val() + 'px  ' + $("#elem-3").val();
				
				$(".polling_container").hover(function() {
					$(this).css('boxShadow' , boxShadow);
				},function() {
					$(this).css('boxShadow' , boxShadow_);
				});
			}
			else if(roll == 60 || roll == 61 || roll == 62 ) { //poll name text shadow
				textShadow = $("#elem-60").val() + 'px '  + $("#elem-61").val() + 'px '  + $("#elem-62").val() + 'px ' +  $("#elem-63").val() ;
				$(".polling_container .polling_name").css('textShadow' , textShadow);
			}
			else if(roll == 64 || roll == 65 || roll == 66 ) { //poll answer name text shadow
				textShadow = $("#elem-64").val() + 'px '  + $("#elem-65").val() + 'px '  + $("#elem-66").val() + 'px ' +  $("#elem-67").val() ;
				$(".polling_container .answer_name").css('textShadow' , textShadow);
			}
			else if(roll == 72 || roll == 69 || roll == 70 || roll == 71) { //active animation
				var boxShadow = $("#elem-68").val() + ' ' + $("#elem-69").val() + 'px '  + $("#elem-70").val() + 'px '  + $("#elem-71").val() + 'px ' + $("#elem-72").val() + 'px ' + $("#elem-11").val();
				$(".polling_container .active_li").css('boxShadow' , boxShadow);
			}
			else if(roll == 80 || roll == 81 || roll == 82 || roll == 83) { //active animation
				var boxShadow = $("#elem-79").val() + ' ' + $("#elem-80").val() + 'px '  + $("#elem-81").val() + 'px '  + $("#elem-82").val() + 'px ' + $("#elem-83").val() + 'px ' + $("#elem-78").val();
				$(".polling_container .grad").css('boxShadow' , boxShadow);
			}
			//animation border radius
			else if(roll == 74) {
				$(".polling_container .active_li").css('border-top-left-radius' , val*1 - 1);
			}
			else if(roll == 75) {
				$(".polling_container .active_li").css('border-top-right-radius' , val*1 - 1);
			}
			else if(roll == 76) {
				$(".polling_container .active_li").css('border-bottom-left-radius' , val*1 - 1);
			}
			else if(roll == 77) {
				$(".polling_container .active_li").css('border-bottom-right-radius' , val*1 - 1);
			}
			else if(roll == 90) {
				$(".polling_container .answer_navigation").css('height' , val*1 - 1);
			}
			//poll submit//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			else if(roll == 92) {
				$(".polling_container .polling_submit").css('paddingTop' , val*1 - 1);
				$(".polling_container .polling_submit").css('paddingBottom' , val*1 - 1);
			}
			else if(roll == 93) {
				$(".polling_container .polling_submit").css('paddingLeft' , val*1 - 1);
				$(".polling_container .polling_submit").css('paddingRight' , val*1 - 1);
			}
			else if(roll == 101) { //box border width
				$(".polling_container .polling_submit").css({
					borderLeftWidth : val*1 - 1,
					borderRightWidth : val*1 - 1,
					borderBottomWidth : val*1 - 1,
					borderTopWidth : val*1 - 1
				});
			}
			else if(roll == 102) {
				$(".polling_container .polling_submit").css('border-top-left-radius' , val*1 - 1);
			}
			else if(roll == 103) {
				$(".polling_container .polling_submit").css('border-top-right-radius' , val*1 - 1);
			}
			else if(roll == 104) {
				$(".polling_container .polling_submit").css('border-bottom-left-radius' , val*1 - 1);
			}
			else if(roll == 105) {
				$(".polling_container .polling_submit").css('border-bottom-right-radius' , val*1 - 1);
			}
			else if(roll == 96 || roll == 97 || roll == 98 || roll == 99) {
				var boxShadow = $("#elem-118").val() + ' ' + $("#elem-119").val() + 'px '  + $("#elem-120").val() + 'px '  + $("#elem-121").val() + 'px ' + $("#elem-122").val() + 'px ' +  $("#elem-117").val();
				var boxShadow_ = $("#elem-95").val() + ' ' + $("#elem-96").val() + 'px '  + $("#elem-97").val() + 'px '  + $("#elem-98").val() + 'px ' + $("#elem-99").val() + 'px ' + $("#elem-94").val();
				$(".polling_container .polling_submit").css('boxShadow' , boxShadow_);
				
				$(".polling_container .polling_submit").hover(function() {
					$(this).css('boxShadow' , boxShadow);
				},function() {
					$(this).css('boxShadow' , boxShadow_);
				});
			}
			else if(roll == 107) {
				$(".polling_container .polling_submit").css('fontSize' , val*1 - 1);
			}
			else if(roll == 114 || roll == 115 || roll == 116 ) {
				var textShadow = $("#elem-114").val() + 'px '  + $("#elem-115").val() + 'px '  + $("#elem-116").val() + 'px ' + $("#elem-125").val();
				var textShadow_ = $("#elem-114").val() + 'px '  + $("#elem-115").val() + 'px '  + $("#elem-116").val() + 'px ' + $("#elem-113").val();
				$(".polling_container .polling_submit").css('textShadow' , textShadow_);
				
				$(".polling_container .polling_submit").hover(function() {
					$(this).css('textShadow' , textShadow);
				},function() {
					$(this).css('textShadow' , textShadow_);
				});
			}
			else if(roll == 119 || roll == 120 || roll == 121 || roll == 122) {
				var boxShadow = $("#elem-118").val() + ' ' + $("#elem-119").val() + 'px '  + $("#elem-120").val() + 'px '  + $("#elem-121").val() + 'px ' + $("#elem-122").val() + 'px ' + $("#elem-117").val();
				var boxShadow_ = $("#elem-95").val() + ' ' + $("#elem-96").val() + 'px '  + $("#elem-97").val() + 'px '  + $("#elem-98").val() + 'px ' + $("#elem-99").val() + 'px ' + $("#elem-94").val();
				
				$(".polling_container .polling_submit").hover(function() {
					$(this).css('boxShadow' , boxShadow);
				},function() {
					$(this).css('boxShadow' , boxShadow_);
				});
			}
			// poll Result ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			else if(roll == 129) {
				$(".polling_container .polling_result").css('paddingTop' , val*1 - 1);
				$(".polling_container .polling_result").css('paddingBottom' , val*1 - 1);
			}
			else if(roll == 130) {
				$(".polling_container .polling_result").css('paddingLeft' , val*1 - 1);
				$(".polling_container .polling_result").css('paddingRight' , val*1 - 1);
			}
			else if(roll == 138) { //box border width
				$(".polling_container .polling_result").css({
					borderLeftWidth : val*1 - 1,
					borderRightWidth : val*1 - 1,
					borderBottomWidth : val*1 - 1,
					borderTopWidth : val*1 - 1
				});
			}
			else if(roll == 139) {
				$(".polling_container .polling_result").css('border-top-left-radius' , val*1 - 1);
			}
			else if(roll == 140) {
				$(".polling_container .polling_result").css('border-top-right-radius' , val*1 - 1);
			}
			else if(roll == 141) {
				$(".polling_container .polling_result").css('border-bottom-left-radius' , val*1 - 1);
			}
			else if(roll == 142) {
				$(".polling_container .polling_result").css('border-bottom-right-radius' , val*1 - 1);
			}
			else if(roll == 133 || roll == 134 || roll == 135 || roll == 136) {
				var boxShadow = $("#elem-155").val() + ' ' + $("#elem-156").val() + 'px '  + $("#elem-157").val() + 'px '  + $("#elem-158").val() + 'px ' + $("#elem-159").val() + 'px ' +  $("#elem-154").val();
				var boxShadow_ = $("#elem-132").val() + ' ' + $("#elem-133").val() + 'px '  + $("#elem-134").val() + 'px '  + $("#elem-135").val() + 'px ' + $("#elem-136").val() + 'px ' + $("#elem-131").val();
				$(".polling_container .polling_result").css('boxShadow' , boxShadow_);
				
				$(".polling_container .polling_result").hover(function() {
					$(this).css('boxShadow' , boxShadow);
				},function() {
					$(this).css('boxShadow' , boxShadow_);
				});
			}
			else if(roll == 144) {
				$(".polling_container .polling_result").css('fontSize' , val*1 - 1);
			}
			else if(roll == 151 || roll == 152 || roll == 153 ) {
				var textShadow = $("#elem-151").val() + 'px '  + $("#elem-152").val() + 'px '  + $("#elem-153").val() + 'px ' + $("#elem-162").val();
				var textShadow_ = $("#elem-151").val() + 'px '  + $("#elem-152").val() + 'px '  + $("#elem-153").val() + 'px ' + $("#elem-150").val();
				$(".polling_container .polling_result").css('textShadow' , textShadow_);
				
				$(".polling_container .polling_result").hover(function() {
					$(this).css('textShadow' , textShadow);
				},function() {
					$(this).css('textShadow' , textShadow_);
				});
			}
			else if(roll == 156 || roll == 157 || roll == 158 || roll == 159) {
				var boxShadow = $("#elem-155").val() + ' ' + $("#elem-156").val() + 'px '  + $("#elem-157").val() + 'px '  + $("#elem-158").val() + 'px ' + $("#elem-159").val() + 'px ' + $("#elem-154").val();
				var boxShadow_ = $("#elem-132").val() + ' ' + $("#elem-133").val() + 'px '  + $("#elem-134").val() + 'px '  + $("#elem-135").val() + 'px ' + $("#elem-136").val() + 'px ' + $("#elem-131").val();
				
				$(".polling_container .polling_result").hover(function() {
					$(this).css('boxShadow' , boxShadow);
				},function() {
					$(this).css('boxShadow' , boxShadow_);
				});
			}
			//votes data
			else if(roll == 207) {
				$(".polling_select1,.polling_select2").css('paddingTop' , val*1 - 1);
				$(".polling_select1,.polling_select2").css('paddingBottom' , val*1 - 1);
			}
			else if(roll == 208) {
				$(".polling_select1,.polling_select2").css('paddingLeft' , val*1 - 1);
				$(".polling_select1,.polling_select2").css('paddingRight' , val*1 - 1);
			}
			else if(roll == 210) { //box border radius
				$(".polling_select1,.polling_select2").css('fontSize' , val*1 - 1);
			}
			else if(roll == 216 || roll == 217 || roll == 218 ) {
				var textShadow = $("#elem-216").val() + 'px '  + $("#elem-217").val() + 'px '  + $("#elem-218").val() + 'px ' + $("#elem-215").val();
				var textShadow_ = $("#elem-216").val() + 'px '  + $("#elem-217").val() + 'px '  + $("#elem-218").val() + 'px ' + $("#elem-229").val();
				$(".polling_select1,.polling_select2").css('textShadow' , textShadow);
				
				$(".polling_select1,.polling_select2").hover(function() {
					$(this).css('textShadow' , textShadow_);
				},function() {
					$(this).css('textShadow' , textShadow);
				});
			}
			else if(roll == 220) { 
				$(".polling_select1,.polling_select2").css({
					borderLeftWidth : val*1 - 1,
					borderRightWidth : val*1 - 1,
					borderBottomWidth : val*1 - 1,
					borderTopWidth : val*1 - 1
				});
			}
			else if(roll == 222) {
				$(".polling_select1,.polling_select2").css('border-top-left-radius' , val*1 - 1);
			}
			else if(roll == 223) {
				$(".polling_select1,.polling_select2").css('border-top-right-radius' , val*1 - 1);
			}
			else if(roll == 224) {
				$(".polling_select1,.polling_select2").css('border-bottom-left-radius' , val*1 - 1);
			}
			else if(roll == 225) {
				$(".polling_select1,.polling_select2").css('border-bottom-right-radius' , val*1 - 1);
			}
			//vote data
			else if(roll == 167) {
				$(".answer_votes_data").css('fontSize',val*1 - 1);
			}
			else if(roll == 173 || roll == 174 || roll == 175 ) {
				var textShadow = $("#elem-173").val() + 'px '  + $("#elem-174").val() + 'px '  + $("#elem-175").val() + 'px ' + $("#elem-172").val();
				$(".answer_votes_data").css('textShadow' , textShadow);
			}
			//vote  digit data
			else if(roll == 177) {
				$(".answer_votes_data span").css('fontSize',val*1 - 1);
			}
			else if(roll == 183 || roll == 184 || roll == 185 ) {
				var textShadow = $("#elem-183").val() + 'px '  + $("#elem-184").val() + 'px '  + $("#elem-185").val() + 'px ' + $("#elem-182").val();
				$(".answer_votes_data span").css('textShadow' , textShadow);
			}
			//total vote  data
			else if(roll == 187) {
				$(".left_col").css('fontSize',val*1 - 1);
			}
			else if(roll == 197) {
				$(".right_col").css('fontSize',val*1 - 1);
			}
			else if(roll == 193 || roll == 194 || roll == 195 ) {
				var textShadow = $("#elem-193").val() + 'px '  + $("#elem-194").val() + 'px '  + $("#elem-195").val() + 'px ' + $("#elem-192").val();
				$(".left_col").css('textShadow' , textShadow);
			}
			else if(roll == 203 || roll == 204 || roll == 205 ) {
				var textShadow = $("#elem-203").val() + 'px '  + $("#elem-204").val() + 'px '  + $("#elem-205").val() + 'px ' + $("#elem-202").val();
				$(".right_col").css('textShadow' , textShadow);
			}
			else if (roll == 232) {
				$(".ui-corner-all").css('borderRadius',val*1 - 1);
			}
			else if (roll == 248) {
				$(".ui-slider dt").css('fontSize',val*1 - 1);
			}
			else if (roll == 250) {
				$(".ui-slider dt").css('height',val*1 - 1);
			}
			else if(roll == 245 || roll == 246 || roll == 247 ) {
				var textShadow = $("#elem-245").val() + 'px '  + $("#elem-246").val() + 'px '  + $("#elem-247").val() + 'px ' + $("#elem-244").val();
				$(".ui-slider dt").css('textShadow' , textShadow);
			}

			//add answer
			else if(roll == 266) {
				$(".add_answer").css('border-top-left-radius' , val*1 - 1);
			}
			else if(roll == 267) {
				$(".add_answer").css('border-top-right-radius' , val*1 - 1);
			}
			else if(roll == 268) {
				$(".add_answer").css('border-bottom-left-radius' , val*1 - 1);
			}
			else if(roll == 269) {
				$(".add_answer").css('border-bottom-right-radius' , val*1 - 1);
			}
			else if(roll == 252) {
				$(".add_ans_name,.add_ans_submit").css('fontSize' , val*1 - 1);
			}
			else if(roll == 264) {
				var size = val*1 - 1;
				var border = size + 'px '  + $("#elem-265").val() + $("#elem-263").val() ;
				$(".add_answer").css('border' , border);
				$(".add_ans_submit").css('borderLeft' , border);
			}
			else if(roll == 259 || roll == 260 || roll == 261 || roll == 262) {
				var boxShadow = $("#elem-258").val() + ' ' + $("#elem-259").val() + 'px '  + $("#elem-260").val() + 'px '  + $("#elem-261").val() + 'px ' + $("#elem-262").val() + 'px ' + $("#elem-257").val();
				$(".add_answer").css('boxShadow' , boxShadow);
			}
			else if(roll == 275 || roll == 276 || roll == 277 ) { 
				textShadow = $("#elem-275").val() + 'px '  + $("#elem-276").val() + 'px '  + $("#elem-277").val() + 'px ' +  $("#elem-274").val() ;
				$(".add_ans_name,.add_ans_submit").css('textShadow' , textShadow);
			}
			else if(roll == 272) {
				$(".add_answer").css('height' , val*1 - 1);
			}
		}
			
			
		$('.temp_family').blur(function() {
			var val = $(this).val().replace('|','');
			val = val.replace('~','');
			$(this).val(val);
		})
		
		$("#elem-165").change(function() {
			var borderStyle = $(this).val();
			$(".polling_container").css('borderStyle' , borderStyle);
		})
		$("#elem-36").change(function() {
			$(".polling_container .polling_name").css('fontWeight' , $(this).val());
		})
		$("#elem-37").change(function() {
			$(".polling_container .polling_name").css('fontStyle' , $(this).val());
		})
		$("#elem-38").change(function() {
			$(".polling_container .polling_name").css('textDecoration' , $(this).val());
		})
		$("#elem-39").change(function() {
			$(".polling_container .polling_name").css('textAlign' , $(this).val());
		})
		$("#elem-40").blur(function() {
			$(".polling_container .polling_name").css('fontFamily' , $(this).val());
		})

		$("#elem-41").change(function() {
			$(".polling_container .answer_name").css('fontWeight' , $(this).val());
		})
		$("#elem-42").change(function() {
			$(".polling_container .answer_name").css('fontStyle' , $(this).val());
		})
		$("#elem-43").change(function() {
			$(".polling_container .answer_name").css('textDecoration' , $(this).val());
		})
		$("#elem-44").change(function() {
			$(".polling_container .answer_name").css('textAlign' , $(this).val());
		})
		$("#elem-45").blur(function() {
			$(".polling_container .answer_name").css('fontFamily' , $(this).val());
		})
		$("#elem-50").change(function() {
			var boxShadow = $("#elem-55").val() + ' ' + $("#elem-56").val() + 'px '  + $("#elem-57").val() + 'px '  + $("#elem-58").val() + 'px ' + $("#elem-59").val() + 'px ' + $("#elem-5").val();
			var boxShadow_ = $("#elem-50").val() + ' ' + $("#elem-46").val() + 'px '  + $("#elem-47").val() + 'px '  + $("#elem-48").val() + 'px ' + $("#elem-49").val() + 'px  ' + $("#elem-3").val();
			
			$(".polling_container").css('boxShadow' , boxShadow_);
			$(".polling_container").hover(function() {
				$(this).css('boxShadow' , boxShadow);
			},function() {
				$(this).css('boxShadow' , boxShadow_);
			});
		})
		$("#elem-79").change(function() {
			var boxShadow = $(this).val() + ' ' + $("#elem-80").val() + 'px '  + $("#elem-81").val() + 'px '  + $("#elem-82").val() + 'px ' + $("#elem-83").val() + 'px ' + $("#elem-78").val();
			$(".polling_container .grad").css('boxShadow' , boxShadow);
		})
		$("#elem-55").change(function() {
			var boxShadow = $(this).val() + ' ' + $("#elem-56").val() + 'px '  + $("#elem-57").val() + 'px '  + $("#elem-58").val() + 'px ' + $("#elem-59").val() + 'px ' + $("#elem-5").val();
			var boxShadow_ = $("#elem-50").val() + ' ' + $("#elem-46").val() + 'px '  + $("#elem-47").val() + 'px '  + $("#elem-48").val() + 'px ' + $("#elem-49").val() + 'px  ' + $("#elem-3").val();
			
			$(".polling_container").hover(function() {
				$(this).css('boxShadow' , boxShadow);
			},function() {
				$(this).css('boxShadow' , boxShadow_);
			});
		})
		//poll submit/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$("#elem-127").change(function() {
			var borderStyle = $(this).val();
			$(".polling_container .polling_submit").css('border' , $("#elem-101").val() + 'px ' +  borderStyle + $("#elem-100").val());
		})
		$("#elem-112").blur(function() {
			$(".polling_container .polling_submit").css('fontFamily' , $(this).val());
		})
		$("#elem-108").change(function() {
			$(".polling_container .polling_submit").css('fontWeight' , $(this).val());
		})
		$("#elem-109").change(function() {
			$(".polling_container .polling_submit").css('fontStyle' , $(this).val());
		})
		$("#elem-110").change(function() {
			$(".polling_container .polling_submit").css('textDecoration' , $(this).val());
		})
		$("#elem-95").change(function() {
			var boxShadow = $("#elem-118").val() + ' ' + $("#elem-119").val() + 'px '  + $("#elem-120").val() + 'px '  + $("#elem-121").val() + 'px ' + $("#elem-122").val() + 'px ' + $("#elem-117").val();
			var boxShadow_ = $("#elem-95").val() + ' ' + $("#elem-96").val() + 'px '  + $("#elem-97").val() + 'px '  + $("#elem-98").val() + 'px ' + $("#elem-99").val() + 'px ' + $("#elem-94").val();
			$(".polling_container .polling_submit").css('boxShadow' , boxShadow_);
			$(".polling_container .polling_submit").hover(function() {
				$(this).css('boxShadow' , boxShadow);
			},function() {
				$(this).css('boxShadow' , boxShadow_);
			});

		})
		$("#elem-118").change(function() {
			var boxShadow = $("#elem-118").val() + ' ' + $("#elem-119").val() + 'px '  + $("#elem-120").val() + 'px '  + $("#elem-121").val() + 'px ' + $("#elem-122").val() + 'px ' + $("#elem-117").val();
			var boxShadow_ = $("#elem-95").val() + ' ' + $("#elem-96").val() + 'px '  + $("#elem-97").val() + 'px '  + $("#elem-98").val() + 'px ' + $("#elem-99").val() + 'px ' + $("#elem-94").val();
			
			$(".polling_container .polling_submit").hover(function() {
				$(this).css('boxShadow' , boxShadow);
			},function() {
				$(this).css('boxShadow' , boxShadow_);
			});
		})
		//poll Result/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$("#elem-164").change(function() {
			var borderStyle = $(this).val();
			$(".polling_container .polling_result").css('border' , $("#elem-138").val() + 'px ' +  borderStyle + $("#elem-137").val());
		})
		$("#elem-149").blur(function() {
			$(".polling_container .polling_result").css('fontFamily' , $(this).val());
		})
		$("#elem-145").change(function() {
			$(".polling_container .polling_result").css('fontWeight' , $(this).val());
		})
		$("#elem-146").change(function() {
			$(".polling_container .polling_result").css('fontStyle' , $(this).val());
		})
		$("#elem-147").change(function() {
			$(".polling_container .polling_result").css('textDecoration' , $(this).val());
		})
		$("#elem-132").change(function() {
			var boxShadow = $("#elem-155").val() + ' ' + $("#elem-156").val() + 'px '  + $("#elem-157").val() + 'px '  + $("#elem-158").val() + 'px ' + $("#elem-159").val() + 'px ' + $("#elem-154").val();
			var boxShadow_ = $("#elem-132").val() + ' ' + $("#elem-133").val() + 'px '  + $("#elem-134").val() + 'px '  + $("#elem-135").val() + 'px ' + $("#elem-136").val() + 'px ' + $("#elem-131").val();
			$(".polling_container .polling_result").css('boxShadow' , boxShadow_);
			$(".polling_container .polling_result").hover(function() {
				$(this).css('boxShadow' , boxShadow);
			},function() {
				$(this).css('boxShadow' , boxShadow_);
			});

		})
		$("#elem-155").change(function() {
			var boxShadow = $("#elem-155").val() + ' ' + $("#elem-156").val() + 'px '  + $("#elem-157").val() + 'px '  + $("#elem-158").val() + 'px ' + $("#elem-159").val() + 'px ' + $("#elem-154").val();
			var boxShadow_ = $("#elem-132").val() + ' ' + $("#elem-133").val() + 'px '  + $("#elem-134").val() + 'px '  + $("#elem-135").val() + 'px ' + $("#elem-136").val() + 'px ' + $("#elem-131").val();
			
			$(".polling_container .polling_result").hover(function() {
				$(this).css('boxShadow' , boxShadow);
			},function() {
				$(this).css('boxShadow' , boxShadow_);
			});
		})
		//select tags
		$("#elem-214").blur(function() {
			$(".polling_select1,.polling_select2").css('fontFamily' , $(this).val());
		})
		$("#elem-211").change(function() {
			$(".polling_select1,.polling_select2").css('fontWeight' , $(this).val());
		})
		$("#elem-212").change(function() {
			$(".polling_select1,.polling_select2").css('fontStyle' , $(this).val());
		})
		$("#elem-213").change(function() {
			$(".polling_select1,.polling_select2").css('textDecoration' , $(this).val());
		})
		$("#elem-221").change(function() {
			var borderStyle = $(this).val();
			$(".polling_select1,.polling_select2").css('border' , $("#elem-220").val() + 'px ' +  borderStyle + $("#elem-219").val());
		})
		//votes data
		$("#elem-171").blur(function() {
			$(".answer_votes_data").css('fontFamily' , $(this).val());
		})
		$("#elem-168").change(function() {
			$(".answer_votes_data").css('fontWeight' , $(this).val());
		})
		$("#elem-169").change(function() {
			$(".answer_votes_data").css('fontStyle' , $(this).val());
		})
		$("#elem-170").change(function() {
			$(".answer_votes_data").css('textDecoration' , $(this).val());
		})
		//votes digit data
		$("#elem-181").blur(function() {
			$(".answer_votes_data span").css('fontFamily' , $(this).val());
		})
		$("#elem-178").change(function() {
			$(".answer_votes_data span").css('fontWeight' , $(this).val());
		})
		$("#elem-179").change(function() {
			$(".answer_votes_data span").css('fontStyle' , $(this).val());
		})
		$("#elem-180").change(function() {
			$(".answer_votes_data span").css('textDecoration' , $(this).val());
		})
		//votes total left
		$("#elem-191").blur(function() {
			$(".left_col").css('fontFamily' , $(this).val());
		})
		$("#elem-188").change(function() {
			$(".left_col").css('fontWeight' , $(this).val());
		})
		$("#elem-189").change(function() {
			$(".left_col").css('fontStyle' , $(this).val());
		})
		$("#elem-190").change(function() {
			$(".left_col").css('textDecoration' , $(this).val());
		})
		//votes total right
		$("#elem-201").blur(function() {
			$(".right_col").css('fontFamily' , $(this).val());
		})
		$("#elem-198").change(function() {
			$(".right_col").css('fontWeight' , $(this).val());
		})
		$("#elem-199").change(function() {
			$(".right_col").css('fontStyle' , $(this).val());
		})
		$("#elem-200").change(function() {
			$(".right_col").css('textDecoration' , $(this).val());
		})
		//slider
		$("#elem-243").blur(function() {
			$(".ui-slider dt").css('fontFamily' , $(this).val());
		})
		$("#elem-240").change(function() {
			$(".ui-slider dt").css('fontWeight' , $(this).val());
		})
		$("#elem-241").change(function() {
			$(".ui-slider dt").css('fontStyle' , $(this).val());
		})
		$("#elem-242").change(function() {
			$(".ui-slider dt").css('textDecoration' , $(this).val());
		})
		//add answer///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$("#elem-256").blur(function() {
			$(".add_ans_name,.add_ans_submit").css('fontFamily' , $(this).val());
		})
		$("#elem-253").change(function() {
			$(".add_ans_name,.add_ans_submit").css('fontWeight' , $(this).val());
		})
		$("#elem-254").change(function() {
			$(".add_ans_name,.add_ans_submit").css('fontStyle' , $(this).val());
		})
		$("#elem-255").change(function() {
			$(".add_ans_name,.add_ans_submit").css('textDecoration' , $(this).val());
		})
		$("#elem-265").change(function() {
			var border = $("#elem-264").val() + 'px '  + $("#elem-265").val() + $("#elem-263").val() ;
			$(".add_answer").css('border' , border);
			$(".add_ans_submit").css('borderLeft' , border);
		})
		$("#elem-258").change(function() {
			var boxShadow = $("#elem-258").val() + ' ' + $("#elem-259").val() + 'px '  + $("#elem-260").val() + 'px '  + $("#elem-261").val() + 'px ' + $("#elem-262").val() + 'px ' + $("#elem-257").val() ;
			$(".add_answer").css('boxShadow' , boxShadow);
		})
		

		var top_offset = parseInt($(".preview_box").css('top'));
		top_offset_moove = top_offset == 26 ? 26 : 100;
		//animate preview
		$(window).scroll(function() {
			var off = $("#preview_dummy").offset().top;

			var off_0 = $("#c_div").offset().top;
			if(off > off_0 && !($('.answers_switcher').hasClass('active')) ) {
				delta = off - off_0 + top_offset_moove*1;
				$(".preview_box").stop(true).animate( {
					top: delta
				},500);
			}
			else {
				$(".preview_box").stop(true).animate( {
					top: top_offset
				},500);
			}
			
		})

		$('.temp_block.opened').live('click',function() {
			$(this).removeClass('opened');
			$(this).addClass('closed');
			$(this).next('div').slideUp(600);
		})
		$('.temp_block.closed').live('click',function() {
			$(this).removeClass('closed');
			$(this).addClass('opened');
			$(this).next('div').slideDown(600);
		})


		//answers switcher
		$('.answers_switcher').click(function() {
			if($(this).hasClass('active')) {
				$("#answers_styles_table").height("");
				$(this).removeClass('active');
				$(this).html('Switch to Answers');

				$('.main_view').slideDown(600);
				$('.answers_view').slideUp(600);
				$('#main_styles_table').slideDown(600);
				$('#answers_styles_table').slideUp(600);
			}
			else {
				setTimeout(function() {
					var h = $("#answers_styles_table").height();
					var h1 = $('.preview_box').height();
					if(parseInt(h1) > parseInt(h))
						$("#answers_styles_table").height(h1 + 50*1);
				},650)
				
				$('.preview_box').animate({'top':'26px'},600);
				$('html, body').animate({scrollTop:0}, 600);
				$(this).addClass('active');
				$(this).html('Switch to Main View');

				$('.main_view').slideUp(600);
				$('.answers_view').slideDown(600);
				$('#main_styles_table').slideUp(600);
				$('#answers_styles_table').slideDown(600);

			}
				
		})

	})
})(sexyJ);
</script>

<?php 
function create_accordion($txt,$state,$title='') {
	$dis = $state == 'opened' ? '' : 'display:none;';
	echo '<tr>
			<td colspan="2">
				<div class="temp_data_container">
				<div class="temp_block '.$state.'" title="'.$title.'">'.JText::_($txt).'</div><div style="'.$dis.'margin-bottom:6px;">
					<table>';
}
function close_accordion() {
	echo '</table></div></div></td></tr>';
}
function echo_font_tr($txt,$i,$value) {
	echo '
			<tr>
            <td width="180" align="right" class="key">
                <label for="name">';
                    echo JText::_($txt);
                echo '</label>
            </td>
            <td class="st_td">
	               <input class="temp_family" value="'.$value.'" name="styles['.$i.']" roll="'.$i.'"  id="elem-'.$i.'"/>	               
            </td>
        </tr>
	';
}
function echo_select_tr($txt,$i,$values,$value) {
	echo '
			<tr>
            <td width="180" align="right" class="key">
                <label for="name">';
                    echo JText::_($txt);
                echo '</label>
            </td>
            <td class="st_td">
	               <select name="styles['.$i.']"  id="elem-'.$i.'" class="temp_select">';
                	foreach($values as $k => $val) {
                		$selected = $value == $k ? 'selected="selected"' : '';
                		echo '<option value="'.$k.'" '.$selected.'>'.$val.'</option>';
                	}
			echo '</select>	               
            </td>
        </tr>
	';
}
function echo_color_tr($txt,$i,$color) {
	echo '
			<tr>
            <td width="180" align="right" class="key">
                <label for="name">';
                    echo JText::_($txt);
                echo '</label>
            </td>
            <td class="st_td">
	               <div id="colorSelector" class="colorSelector" style="float: left;"><div style="background-color: '.$color.'"></div></div>
	               <input type="hidden" value="'.$color.'" name="styles['.$i.']" roll="'.$i.'"  id="elem-'.$i.'" />
            </td>
        </tr>
	';
}
function echo_size_tr($txt,$i,$size,$min,$max) {
	echo '
			<tr>
            <td width="180" align="right" class="key">
                <label for="name">';
                    echo JText::_($txt);
                echo '</label>
            </td>
             <td class="st_td">
            	<div class="size_container">
	            	<input class="size_input" type="text" value="'. $size .'" name="styles['.$i.']" readonly="readonly" roll="'.$i.'" id="elem-'.$i.'" />
	            	<div class="size_arrows">
	            		<div class="size_up" maxval="'.$max.'" title="'; echo JText::_( 'Up' ); echo '"></div>
	            		<div class="size_down" minval="'.$min.'" title="'; echo JText::_( 'Down' );echo '"></div>
	            	</div>
	            	<div class="pix_info">px</div>
	            </div>
            </td>
        </tr>
	';
}

function seperate_tr($txt,$title='') {
	echo '<tr><td colspan="2"><div class="sep_td" title="'.$title.'">'.$txt.'</div></td></tr>';
}

?>
<div class="col100" style="position: relative;" id="c_div">
	 <div id="preview_dummy"></div>
	 
	 <div class="preview_box">
	 
	 	
	 	<div class="answers_switcher">Switch to Answers</div>
	 	
	 	<div class="main_view">
	 		<div class="preview_name">Main view</div>
		 	<div class="polling_container_wrapper">
				<div class="polling_container">
		 			<div class="polling_name">Do You like template customization?</div>
			 		<ul class="polling_ul">
			 			<li id="answer_94" class="polling_li">
			 				<div class="answer_name">
			 					<label for="94">Yes, it is very flexible</label>
			 				</div>
			 				<div class="answer_input"><input  id="94" type="radio" class="poll_answer 94" value="94" name="ans_2" /></div>
			 			</li>
			 			<li id="answer_95" class="polling_li">
			 				<div class="answer_name">
			 					<label for="95">Great, i like this</label>
			 				</div>
			 				<div class="answer_input"><input  id="95" type="radio" class="poll_answer 94" value="95" name="ans_2" /></div>
			 			</li>
			 			<li id="answer_96" class="polling_li">
			 				<div class="answer_name">
			 					<label for="96">No, this is not usefull</label>
			 				</div>
			 				<div class="answer_input"><input  id="96" type="radio" class="poll_answer 96" value="96" name="ans_2" /></div>
			 			</li>
			 		</ul>
			 		
			 		<div class="answer_wrapper opened" ><div style="padding:6px">
					<div class="add_answer"><input name="answer_name" class="add_ans_name" value="Add an answer ..." />
					<input type="button" value="Add" class="add_ans_submit" /><input type="hidden" value="" class="poll_id" /></div>
					</div></div>
					
			 		<span class="polling_bottom_wrapper1">
			 			<div class="polling_submit" />Vote</div>
			 			<div class="polling_result" />Results</div>
			 		</span>
					
				</div>
		 	</div>
		 	
		 	<div class="preview_name">Result view</div>
		 	<div class="polling_container_wrapper">
				<div class="polling_container">
		 			<div class="polling_name">Do You like template customization?</div>
			 		<ul class="polling_ul">
			 			<li id="answer_95" class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Yes, it is very flexible</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_1" id="answer_navigation_1" style=" opacity: 1; width: 375px; "><div class="grad"></div></div>
								<div class="answer_votes_data" id="answer_votes_data_94" style="height: 17px; ">Votes: <span id="answer_votes_data_count_94">148</span> 
								(<span id="answer_votes_data_percent_94">56.4</span>%)
							</div>
			 				
			 			</li>
			 			<li id="answer_95" class="polling_li active_li">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Great, i like this</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_2" id="answer_navigation_2" style=" opacity: 1; width: 135px; "><div class="grad"></div></div>
								<div class="answer_votes_data" id="answer_votes_data_94" style="height: 17px; ">Votes: <span id="answer_votes_data_count_94">55</span> 
								(<span id="answer_votes_data_percent_94">17.8</span>%)
							</div>
			 				
			 			</li>
			 			<li id="answer_95" class="polling_li " style="margin-top: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">No, this is not usefull</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_3" id="answer_navigation_3" style=" opacity: 1; width: 47px; "><div class="grad"></div></div>
								<div class="answer_votes_data" id="answer_votes_data_94" style="height: 17px; ">Votes: <span id="answer_votes_data_count_94">8</span> 
								(<span id="answer_votes_data_percent_94">4.7</span>%)
							</div>
			 				
			 			</li>
			 			
			 		</ul>
			 		<div class="polling_info" style="height: 65px;">
			 			<table cellpadding="0" cellspacing="0" border="0">
			 				<tr>
			 					<td class="left_col">Total Votes: </td>
			 					<td class="total_votes right_col">300</td>
			 				</tr>
			 				<tr>
			 					<td class="left_col">First Vote: </td>
			 					<td class="first_vote right_col" >May 1, 2012</td>
			 				</tr>
			 				<tr>
			 					<td class="left_col">Last Vote: </td>
			 					<td class="last_vote right_col">May 3, 2012</td>
			 				</tr>
			 			</table>
			 		</div>
					<div class="timeline_select_wrapper" style="height: 95px; overflow-x: visible; overflow-y: visible; ">
						<div style="padding:0">
							<select class="polling_select1" id="polling_select_2_1" name="polling_select_2_1">
								<optgroup label="May 2012">
									<option selected="selected" value="2012-05-03">May 3, 2012</option>
								</optgroup>
							</select>
							<select class="polling_select2" id="polling_select_2_2" name="polling_select_2_2">
								<optgroup label="May 2012">
									<option selected="selected" value="2012-05-03">May 3, 2012</option>
								</optgroup>
							</select>
						</div>
						<div class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" role="application">
							<a id="handle_polling_select_2_1" class="ui-slider-handle ui-state-default ui-corner-all" aria-valuetext="May 7, 2012" aria-valuenow="4" aria-valuemax="24" aria-valuemin="0" aria-labelledby="undefined" role="slider" tabindex="0" href="#" style="left: 16.6667%;"><span class="screenReaderContext"></span><span class="ui-slider-tooltip ui-widget-content ui-corner-all"><span class="ttContent">May 7, 2012</span><span class="ui-tooltip-pointer-down ui-widget-content"><span class="ui-tooltip-pointer-down-inner" style="border-top: 7px solid rgb(252, 253, 253);"></span></span></span></a><a id="handle_polling_select_2_2" class="ui-slider-handle ui-state-default ui-corner-all" aria-valuetext="May 23, 2012" aria-valuenow="20" aria-valuemax="24" aria-valuemin="0" aria-labelledby="undefined" role="slider" tabindex="0" href="#" style="left: 83.3333%;"><span class="screenReaderContext"></span><span class="ui-slider-tooltip ui-widget-content ui-corner-all"><span class="ttContent">May 23, 2012</span><span class="ui-tooltip-pointer-down ui-widget-content"><span class="ui-tooltip-pointer-down-inner" style="border-top: 7px solid rgb(252, 253, 253);"></span></span></span></a><dl class="ui-slider-scale ui-helper-reset" role="presentation"><dt style="width: 100%; left: 0%;"><span>May 2012</span></dt><dd style="left: 0%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-03</span><span class="ui-slider-tic ui-widget-content" style="display: none;"></span></dd><dd style="left: 4.17%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-04</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 8.33%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-05</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 12.5%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-06</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 16.67%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-07</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 20.83%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-08</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 25%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-09</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 29.17%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-10</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 33.33%;"><span class="ui-slider-label" style="margin-left: -26.5px;">2012-05-11</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 37.5%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-12</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 41.67%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-13</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 45.83%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-14</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 50%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-15</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 54.17%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-16</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 58.33%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-17</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 62.5%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-18</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 66.67%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-19</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 70.83%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-20</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 75%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-21</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 79.17%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-22</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 83.33%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-23</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 87.5%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-24</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 91.67%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-25</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 95.83%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-26</span><span class="ui-slider-tic ui-widget-content"></span></dd><dd style="left: 100%;"><span class="ui-slider-label" style="margin-left: -27px;">2012-05-27</span><span class="ui-slider-tic ui-widget-content" style="display: none;"></span></dd></dl><div class="ui-slider-range ui-widget-header" style="left: 16.6667%; width: 66.6667%;"></div>
						</div>
					</div>
				</div>
		 	</div>
		 </div>
		 
		 <!-- answers -->
	 	<div class="answers_view" style="display: none;">
		 	<div class="preview_name">Answers Styles</div>
		 	<div class="polling_container_wrapper">
				<div class="polling_container">
		 			<div class="polling_name">Do You like template customization?</div>
			 		<ul class="polling_ul">
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer1</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_1" id="answer_navigation_1" style=" opacity: 1; width: 450px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer2</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_2" id="answer_navigation_2" style=" opacity: 1; width: 460px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer3</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_3" id="answer_navigation_3" style=" opacity: 1; width: 470px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer4</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_4" id="answer_navigation_4" style=" opacity: 1; width: 480px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer5</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_5" id="answer_navigation_5" style=" opacity: 1; width: 490px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer6</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_6" id="answer_navigation_6" style=" opacity: 1; width: 500px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer7</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_7" id="answer_navigation_7" style=" opacity: 1; width: 510px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer8</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_8" id="answer_navigation_8" style=" opacity: 1; width: 520px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer9</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_9" id="answer_navigation_9" style=" opacity: 1; width: 530px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer10</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_10" id="answer_navigation_10" style=" opacity: 1; width: 540px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer11</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_11" id="answer_navigation_11" style=" opacity: 1; width: 530px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer12</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_12" id="answer_navigation_12" style=" opacity: 1; width: 520px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer13</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_13" id="answer_navigation_13" style=" opacity: 1; width: 510px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer14</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_14" id="answer_navigation_14" style=" opacity: 1; width: 500px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer15</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_15" id="answer_navigation_15" style=" opacity: 1; width: 490px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer16</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_16" id="answer_navigation_16" style=" opacity: 1; width: 480px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer17</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_17" id="answer_navigation_17" style=" opacity: 1; width: 470px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer18</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_18" id="answer_navigation_18" style=" opacity: 1; width: 460px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer19</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_19" id="answer_navigation_19" style=" opacity: 1; width: 450px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 			<li class="polling_li" style="margin-bottom: 2px;">
			 				<div class="answer_name">
			 					<label for="95" style="margin-left: 0">Answer20</label>
			 				</div>
			 				<div class="answer_result">
								<div class="answer_navigation polling_bar_20" id="answer_navigation_20" style=" opacity: 1; width: 430px; "><div class="grad"></div></div>
							</div>
			 			</li>
			 		</ul>
				</div>
		 	</div>
		 </div>
	 	
	 </div>
<form action="<?php echo JRoute::_('index.php?option=com_sexypolling&layout=form&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm">
    <fieldset class="adminform" style="position: relative;">
        <legend><?php echo JText::_( 'Custom Styles' ); ?></legend>
        <div id="main_styles_table">
	        <table class="temp_table">
	        <?php seperate_tr("Template Name");
	        	create_accordion('Name','closed');?>
	        <tr>
	            <td width="180" align="right" class="key" style="width: 230px;">
	                <label for="name">
	                    <?php echo JText::_( 'Name' ); ?>:
	                </label>
	            </td>
	            <td class="st_td">
	                <input class="text_area" type="text" name="name" id="name" size="60" maxlength="250" value="<?php echo $this->item->name;?>" />
	            </td>
	            <?php close_accordion();?>
	        </tr>
	        <?php 
	        	$styles_array = explode('|',$this->styles);
	        	$max = 0;
	        	foreach ($styles_array as $val) {
	        		$arr = explode('~',$val);
	        		$styles[$arr[0]] = $arr[1];
	        		$max = $arr[0]> $max ? $arr[0] : $max;
	        	}
	        	
	        	/*
	        	$keys = array_keys($styles);
	        	sort($keys);
	        	print_r($keys);
	        	*/
	        	
	        	//Main Box//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        	seperate_tr("Main Box");
	        	create_accordion('Background','closed');
		        	echo_color_tr('Backround Color:','0',$styles[0]);
	        	close_accordion();
	        	
	        	create_accordion('Border','closed');
		        	echo_color_tr('Border Color:','1',$styles[1]);
		        	echo_size_tr('Border Size:','2',$styles[2],'0','3');
		        	echo_select_tr('Border Style','165',array("solid" => "Solid", "dotted" => "Dotted","dashed" => "Dashed", "double" => "Double", "groove" => "Groove", "ridge" => "Ridge", "inset" => "Inset", "outset" => "Outset"),$styles[165]);
		        	echo_size_tr('Border Top Left Radius:','51',$styles[51],'0','80');
		        	echo_size_tr('Border Top Right Radius:','52',$styles[52],'0','80');
		        	echo_size_tr('Border Bottom Left Radius:','53',$styles[53],'0','80');
		        	echo_size_tr('Border Bottom Right Radius:','54',$styles[54],'0','80');
	        	close_accordion();
	        	
	        	create_accordion('Shadow Effects','closed');
		        	echo_color_tr('Box Shadow Color:','3',$styles[3]);
		        	echo_select_tr('Box Shadow Type','50',array("" => "Default","inset" => "Inset"),$styles[50]);
		        	echo_size_tr('Box Shadow Horizontal Offset:','46',$styles[46],'-80','80');
		        	echo_size_tr('Box Shadow Vertical Offset:','47',$styles[47],'-80','80');
		        	echo_size_tr('Box Shadow Blur Radius:','48',$styles[48],'-120','120');
		        	echo_size_tr('Box Shadow Spread Radius:','49',$styles[49],'-120','120');
	        	close_accordion();
	        	
	        	create_accordion('Hover State','closed','Change values and hover over container');
		        	echo_color_tr('Box Shadow Hover Color:','5',$styles[5]);
		        	echo_select_tr('Box Shadow Hover Type','55',array("" => "Default","inset" => "Inset"),$styles[55]);
		        	echo_size_tr('Box Shadow Hover Horizontal Offset:','56',$styles[56],'-80','80');
		        	echo_size_tr('Box Shadow Hover Vertical Offset:','57',$styles[57],'-80','80');
		        	echo_size_tr('Box Shadow Hover Blur Radius:','58',$styles[58],'-120','120');
		        	echo_size_tr('Box Shadow Hover Spread Radius:','59',$styles[59],'-120','120');
	        	close_accordion();
	        	
	        	//poll name////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        	seperate_tr("Poll Name");
	        	create_accordion('Font Styles','closed');
	        		echo_color_tr('Poll Name Font Color:','7',$styles[7]);
	        		echo_size_tr('Poll Name Font Size:','8',$styles[8],'8','26');
	        		echo_select_tr('Poll Name Font Weight','36',array("normal" => "Normal","bold" => "Bold"),$styles[36]);
	        		echo_select_tr('Poll Name Font Style','37',array("normal" => "Normal","italic" => "Italic"),$styles[37]);
	        		echo_select_tr('Poll Name Text Decoration','38',array("none" => "None","underline" => "Underline","overline" => "Overline","line-through"=>"Line Through"),$styles[38]);
	        		echo_select_tr('Poll Name Text Align','39',array("left" => "Left","right" => "Right","center" => "Center"),$styles[39]);
	        		echo_font_tr('Poll Name Font Family','40',$styles[40]);
	        	close_accordion();
	        	create_accordion('Text Shadow','closed');
	        		echo_color_tr('Text Shadow Color:','63',$styles[63]);
	        		echo_size_tr('Text Shadow Horizontal Offset:','60',$styles[60],'-50','50');
	        		echo_size_tr('Text Shadow Vertical Offset:','61',$styles[61],'-50','50');
	        		echo_size_tr('Text Shadow Blur Radius:','62',$styles[62],'0','50');
	        	close_accordion();
	        	
	        	//answer text////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        	seperate_tr("Poll Answers Text");
	        	create_accordion('Font Styles','closed');
		        	echo_color_tr('Answer Font Color:','9',$styles[9]);
		        	echo_size_tr('Answer Font Size:','10',$styles[10],'8','22');
		        	echo_select_tr('Answers Font Weight','41',array("normal" => "Normal","bold" => "Bold"),$styles[41]);
		        	echo_select_tr('Answers Font Style','42',array("normal" => "Normal","italic" => "Italic"),$styles[42]);
		        	echo_select_tr('Answers Text Decoration','43',array("none" => "None","underline" => "Underline","overline" => "Overline","line-through"=>"Line Through"),$styles[43]);
		        	echo_select_tr('Answers Text Align','44',array("left" => "Left","right" => "Right","center" => "Center"),$styles[44]);
		        	echo_font_tr('Answers Font Family','45',$styles[45]);
	        	close_accordion();
	        	create_accordion('Text Shadow','closed');
		        	echo_color_tr('Text Shadow Color:','67',$styles[67]);
		        	echo_size_tr('Text Shadow Horizontal Offset:','64',$styles[64],'-50','50');
		        	echo_size_tr('Text Shadow Vertical Offset:','65',$styles[65],'-50','50');
		        	echo_size_tr('Text Shadow Blur Radius:','66',$styles[66],'0','50');
	        	close_accordion();
	        	
	        	//answer animation////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        	seperate_tr("Poll Answers Animation","Animation which happens during answers reordering");
	        	create_accordion('Background','closed');
		        	echo_color_tr('Answer Active Background Color:','12',$styles[12]);
	        	close_accordion();
	        	create_accordion('Shadow Effects','closed');
		        	echo_color_tr('Box Shadow Color:','11',$styles[11]);
		        	echo_select_tr('Box Shadow Type','68',array("" => "Default","inset" => "Inset"),$styles[68]);
		        	echo_size_tr('Box Shadow Horizontal Offset:','69',$styles[69],'-80','80');
		        	echo_size_tr('Box Shadow Vertical Offset:','70',$styles[70],'-80','80');
		        	echo_size_tr('Box Shadow Blur Radius:','71',$styles[71],'-120','120');
		        	echo_size_tr('Box Shadow Spread Radius:','72',$styles[72],'-120','120');
	        	close_accordion();
	        	create_accordion('Border','closed');
		        	echo_color_tr('Border Color:','73',$styles[73]);
		        	echo_size_tr('Border Top Left Radius:','74',$styles[74],'0','80');
		        	echo_size_tr('Border Top Right Radius:','75',$styles[75],'0','80');
		        	echo_size_tr('Border Bottom Left Radius:','76',$styles[76],'0','80');
		        	echo_size_tr('Border Bottom Right Radius:','77',$styles[77],'0','80');
	        	close_accordion();
	        	
	        	
	        	//answer navigation///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        	seperate_tr("Answer Bars Styles","");
	        	create_accordion('Height','closed');
		        	echo_size_tr('Bar Height:','90',$styles[90],'13','25');
	        	close_accordion();
	        	create_accordion('Shadow Effects','closed');
		        	echo_color_tr('Box Shadow Color:','78',$styles[78]);
		        	echo_select_tr('Box Shadow Type','79',array("" => "Default","inset" => "Inset"),$styles[79]);
		        	echo_size_tr('Box Shadow Horizontal Offset:','80',$styles[80],'-80','80');
		        	echo_size_tr('Box Shadow Vertical Offset:','81',$styles[81],'-80','80');
		        	echo_size_tr('Box Shadow Blur Radius:','82',$styles[82],'-120','120');
		        	echo_size_tr('Box Shadow Spread Radius:','83',$styles[83],'-120','120');
	        	close_accordion();
	        	create_accordion('Border','closed');
		        	echo_color_tr('Border Color:','84',$styles[84]);
		        	echo_size_tr('Border Size:','89',$styles[89],'0','3');
		        	echo_size_tr('Border Top Left Radius:','85',$styles[85],'0','80');
		        	echo_size_tr('Border Top Right Radius:','86',$styles[86],'0','80');
		        	echo_size_tr('Border Bottom Left Radius:','87',$styles[87],'0','80');
		        	echo_size_tr('Border Bottom Right Radius:','88',$styles[88],'0','80');
	        	close_accordion();
	        	
	        	//add answer///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        	seperate_tr("Add Answer Styles","");
	        	create_accordion('Styles','closed');
	        		echo_size_tr('Height:','272',$styles[272],'13','40');
	        		echo_color_tr('Background Color:','273',$styles[273]);
	        	close_accordion();
	        	create_accordion('Font Styles','closed');
		        	echo_color_tr('Answer Color Inactive:','251',$styles[251]);
		        	echo_color_tr('Answer Color Active:','270',$styles[270]);
		        	echo_color_tr('Add Button Color:','271',$styles[271]);
		        	echo_size_tr('Font Size:','252',$styles[252],'8','22');
		        	echo_select_tr('Font Weight','253',array("normal" => "Normal","bold" => "Bold"),$styles[253]);
		        	echo_select_tr('Font Style','254',array("normal" => "Normal","italic" => "Italic"),$styles[254]);
		        	echo_select_tr('Text Decoration','255',array("none" => "None","underline" => "Underline","overline" => "Overline","line-through"=>"Line Through"),$styles[255]);
		        	echo_font_tr('Font Family','256',$styles[256]);
	        	close_accordion();
	        	create_accordion('Text Shadow','closed');
		        	echo_color_tr('Text Shadow Color:','274',$styles[274]);
		        	echo_size_tr('Text Shadow Horizontal Offset:','275',$styles[275],'-50','50');
		        	echo_size_tr('Text Shadow Vertical Offset:','276',$styles[276],'-50','50');
		        	echo_size_tr('Text Shadow Blur Radius:','277',$styles[277],'0','50');
	        	close_accordion();
	        	create_accordion('Box Shadow','closed');
		        	echo_color_tr('Box Shadow Color:','257',$styles[257]);
		        	echo_select_tr('Box Shadow Type','258',array("" => "Default","inset" => "Inset"),$styles[258]);
		        	echo_size_tr('Box Shadow Horizontal Offset:','259',$styles[259],'-80','80');
		        	echo_size_tr('Box Shadow Vertical Offset:','260',$styles[260],'-80','80');
		        	echo_size_tr('Box Shadow Blur Radius:','261',$styles[261],'-120','120');
		        	echo_size_tr('Box Shadow Spread Radius:','262',$styles[262],'-120','120');
	        	close_accordion();
	        	create_accordion('Border','closed');
		        	echo_color_tr('Border Color:','263',$styles[263]);
		        	echo_size_tr('Border Size:','264',$styles[264],'0','3');
		        	echo_select_tr('Border Style','265',array("solid" => "Solid", "dotted" => "Dotted","dashed" => "Dashed", "double" => "Double", "groove" => "Groove", "ridge" => "Ridge", "inset" => "Inset", "outset" => "Outset"),$styles[265]);
		        	echo_size_tr('Border Top Left Radius:','266',$styles[266],'0','80');
		        	echo_size_tr('Border Top Right Radius:','267',$styles[267],'0','80');
		        	echo_size_tr('Border Bottom Left Radius:','268',$styles[268],'0','80');
		        	echo_size_tr('Border Bottom Right Radius:','269',$styles[269],'0','80');
	        	close_accordion();
	        	
	        	//Vote button/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        	seperate_tr("Vote Button");
	        	create_accordion('Styles','closed','Background Color, Paddings');
		        	echo_color_tr('Background Color:','91',$styles[91]);
		        	echo_size_tr('Padding Top,Bottom:','92',$styles[92],'0','30');
		        	echo_size_tr('Padding Left,Right:','93',$styles[93],'0','30');
	        	close_accordion();
	        	
	        	create_accordion('Border','closed');
		        	echo_color_tr('Border Color:','100',$styles[100]);
		        	echo_size_tr('Border Size:','101',$styles[101],'0','3');
		        	echo_select_tr('Border Style','127',array("solid" => "Solid", "dotted" => "Dotted","dashed" => "Dashed", "double" => "Double", "groove" => "Groove", "ridge" => "Ridge", "inset" => "Inset", "outset" => "Outset"),$styles[127]);
		        	echo_size_tr('Border Top Left Radius:','102',$styles[102],'0','80');
		        	echo_size_tr('Border Top Right Radius:','103',$styles[103],'0','80');
		        	echo_size_tr('Border Bottom Left Radius:','104',$styles[104],'0','80');
		        	echo_size_tr('Border Bottom Right Radius:','105',$styles[105],'0','80');
	        	close_accordion();
	        	
	        	create_accordion('Shadow Effects','closed');
		        	echo_color_tr('Box Shadow Color:','94',$styles[94]);
		        	echo_select_tr('Box Shadow Type','95',array("" => "Default","inset" => "Inset"),$styles[95]);
		        	echo_size_tr('Box Shadow Horizontal Offset:','96',$styles[96],'-80','80');
		        	echo_size_tr('Box Shadow Vertical Offset:','97',$styles[97],'-80','80');
		        	echo_size_tr('Box Shadow Blur Radius:','98',$styles[98],'-120','120');
		        	echo_size_tr('Box Shadow Spread Radius:','99',$styles[99],'-120','120');
	        	close_accordion();
	        	
	        	create_accordion('Font Styles','closed');
		        	echo_color_tr('Font Color:','106',$styles[106]);
		        	echo_size_tr('Font Size:','107',$styles[107],'8','22');
		        	echo_select_tr('Font Weight','108',array("normal" => "Normal","bold" => "Bold"),$styles[108]);
		        	echo_select_tr('Font Style','109',array("normal" => "Normal","italic" => "Italic"),$styles[109]);
		        	echo_select_tr('Text Decoration','110',array("none" => "None","underline" => "Underline","overline" => "Overline","line-through"=>"Line Through"),$styles[110]);
		        	echo_font_tr('Font Family','112',$styles[112]);
	        	close_accordion();
	        	create_accordion('Text Shadow','closed');
		        	echo_color_tr('Text Shadow Color:','113',$styles[113]);
		        	echo_size_tr('Text Shadow Horizontal Offset:','114',$styles[114],'-50','50');
		        	echo_size_tr('Text Shadow Vertical Offset:','115',$styles[115],'-50','50');
		        	echo_size_tr('Text Shadow Blur Radius:','116',$styles[116],'0','50');
	        	close_accordion();
	        	create_accordion('Hover State','closed','Shadow, Background Color, Font Color');
	        		echo_color_tr('Background Color:','123',$styles[123]);
	        		echo_color_tr('Text Color:','124',$styles[124]);
	        		echo_color_tr('Text Shadow Color:','125',$styles[125]);
	        		echo_color_tr('Border Color:','126',$styles[126]);
		        	echo_color_tr('Box Shadow Color:','117',$styles[117]);
		        	echo_select_tr('Box Shadow Type','118',array("" => "Default","inset" => "Inset"),$styles[118]);
		        	echo_size_tr('Box Shadow Horizontal Offset:','119',$styles[119],'-80','80');
		        	echo_size_tr('Box Shadow Vertical Offset:','120',$styles[120],'-80','80');
		        	echo_size_tr('Box Shadow Blur Radius:','121',$styles[121],'-120','120');
		        	echo_size_tr('Box Shadow Spread Radius:','122',$styles[122],'-120','120');
	        	close_accordion();
	        	
	        	
	        	
	        	//Result button///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        	seperate_tr("Results Button");
	        	create_accordion('Styles','closed','Background Color, Paddings');
		        	echo_color_tr('Background Color:','128',$styles[128]);//91->128 == 37
		        	echo_size_tr('Padding Top,Bottom:','129',$styles[129],'0','30');
		        	echo_size_tr('Padding Left,Right:','130',$styles[130],'0','30');
	        	close_accordion();
	        	
	        	create_accordion('Border','closed');
		        	echo_color_tr('Border Color:','137',$styles[137]);
		        	echo_size_tr('Border Size:','138',$styles[138],'0','3');
		        	echo_select_tr('Border Style','164',array("solid" => "Solid", "dotted" => "Dotted","dashed" => "Dashed", "double" => "Double", "groove" => "Groove", "ridge" => "Ridge", "inset" => "Inset", "outset" => "Outset"),$styles[164]);
		        	echo_size_tr('Border Top Left Radius:','139',$styles[139],'0','80');
		        	echo_size_tr('Border Top Right Radius:','140',$styles[140],'0','80');
		        	echo_size_tr('Border Bottom Left Radius:','141',$styles[141],'0','80');
		        	echo_size_tr('Border Bottom Right Radius:','142',$styles[142],'0','80');
	        	close_accordion();
	        	
	        	create_accordion('Shadow Effects','closed');
		        	echo_color_tr('Box Shadow Color:','131',$styles[131]);
		        	echo_select_tr('Box Shadow Type','132',array("" => "Default","inset" => "Inset"),$styles[132]);
		        	echo_size_tr('Box Shadow Horizontal Offset:','133',$styles[133],'-80','80');
		        	echo_size_tr('Box Shadow Vertical Offset:','134',$styles[134],'-80','80');
		        	echo_size_tr('Box Shadow Blur Radius:','135',$styles[135],'-120','120');
		        	echo_size_tr('Box Shadow Spread Radius:','136',$styles[136],'-120','120');
	        	close_accordion();
	        	
	        	create_accordion('Font Styles','closed');
		        	echo_color_tr('Font Color:','143',$styles[143]);
		        	echo_size_tr('Font Size:','144',$styles[144],'8','22');
		        	echo_select_tr('Font Weight','145',array("normal" => "Normal","bold" => "Bold"),$styles[145]);
		        	echo_select_tr('Font Style','146',array("normal" => "Normal","italic" => "Italic"),$styles[146]);
		        	echo_select_tr('Text Decoration','147',array("none" => "None","underline" => "Underline","overline" => "Overline","line-through"=>"Line Through"),$styles[147]);
		        	echo_font_tr('Font Family','149',$styles[149]);
	        	close_accordion();
	        	create_accordion('Text Shadow','closed');
		        	echo_color_tr('Text Shadow Color:','150',$styles[150]);
		        	echo_size_tr('Text Shadow Horizontal Offset:','151',$styles[151],'-50','50');
		        	echo_size_tr('Text Shadow Vertical Offset:','152',$styles[152],'-50','50');
		        	echo_size_tr('Text Shadow Blur Radius:','153',$styles[153],'0','50');
	        	close_accordion();
	        	create_accordion('Hover State','closed','Shadow, Background Color, Font Color');
	        		echo_color_tr('Background Color:','160',$styles[160]);
	        		echo_color_tr('Text Color:','161',$styles[161]);
	        		echo_color_tr('Text Shadow Color:','162',$styles[162]);
	        		echo_color_tr('Border Color:','163',$styles[163]);
		        	echo_color_tr('Box Shadow Color:','154',$styles[154]);
		        	echo_select_tr('Box Shadow Type','155',array("" => "Default","inset" => "Inset"),$styles[155]);
		        	echo_size_tr('Box Shadow Horizontal Offset:','156',$styles[156],'-80','80');
		        	echo_size_tr('Box Shadow Vertical Offset:','157',$styles[157],'-80','80');
		        	echo_size_tr('Box Shadow Blur Radius:','158',$styles[158],'-120','120');
		        	echo_size_tr('Box Shadow Spread Radius:','159',$styles[159],'-120','120');
	        	close_accordion();
	        	
	        	//answer votes/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        	seperate_tr("Answers Votes Data");
	        	create_accordion('Text Font Styles','closed');
		        	echo_color_tr('Font Color:','166',$styles[166]);
		        	echo_size_tr('Font Size:','167',$styles[167],'8','18');
		        	echo_select_tr('Font Weight','168',array("normal" => "Normal","bold" => "Bold"),$styles[168]);
		        	echo_select_tr('Font Style','169',array("normal" => "Normal","italic" => "Italic"),$styles[169]);
		        	echo_select_tr('Text Decoration','170',array("none" => "None","underline" => "Underline","overline" => "Overline","line-through"=>"Line Through"),$styles[170]);
		        	echo_font_tr('Font Family','171',$styles[171]);
	        	close_accordion();
	        	create_accordion('Text Shadow','closed');
		        	echo_color_tr('Text Shadow Color:','172',$styles[172]);
		        	echo_size_tr('Text Shadow Horizontal Offset:','173',$styles[173],'-50','50');
		        	echo_size_tr('Text Shadow Vertical Offset:','174',$styles[174],'-50','50');
		        	echo_size_tr('Text Shadow Blur Radius:','175',$styles[175],'0','50');
	        	close_accordion();
	        	
	        	create_accordion('Digits Font Styles','closed');
		        	echo_color_tr('Font Color:','176',$styles[176]);
		        	echo_size_tr('Font Size:','177',$styles[177],'8','18');
		        	echo_select_tr('Font Weight','178',array("normal" => "Normal","bold" => "Bold"),$styles[178]);
		        	echo_select_tr('Font Style','179',array("normal" => "Normal","italic" => "Italic"),$styles[179]);
		        	echo_select_tr('Text Decoration','180',array("none" => "None","underline" => "Underline","overline" => "Overline","line-through"=>"Line Through"),$styles[180]);
		        	echo_font_tr('Font Family','181',$styles[181]);
	        	close_accordion();
	        	create_accordion('Digits Shadow','closed');
		        	echo_color_tr('Text Shadow Color:','182',$styles[182]);
		        	echo_size_tr('Text Shadow Horizontal Offset:','183',$styles[183],'-50','50');
		        	echo_size_tr('Text Shadow Vertical Offset:','184',$styles[184],'-50','50');
		        	echo_size_tr('Text Shadow Blur Radius:','185',$styles[185],'0','50');
	        	close_accordion();
	        	
	        	
	        	//Votes Info/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        	seperate_tr("Total Votes Data");
	        	create_accordion('Left Culomn Font Styles','closed');
		        	echo_color_tr('Font Color:','186',$styles[186]);
		        	echo_size_tr('Font Size:','187',$styles[187],'8','18');
		        	echo_select_tr('Font Weight','188',array("normal" => "Normal","bold" => "Bold"),$styles[188]);
		        	echo_select_tr('Font Style','189',array("normal" => "Normal","italic" => "Italic"),$styles[189]);
		        	echo_select_tr('Text Decoration','190',array("none" => "None","underline" => "Underline","overline" => "Overline","line-through"=>"Line Through"),$styles[190]);
		        	echo_font_tr('Font Family','191',$styles[191]);
	        	close_accordion();
	        	create_accordion('Left Culomn Text Shadow','closed');
		        	echo_color_tr('Text Shadow Color:','192',$styles[192]);
		        	echo_size_tr('Text Shadow Horizontal Offset:','193',$styles[193],'-50','50');
		        	echo_size_tr('Text Shadow Vertical Offset:','194',$styles[194],'-50','50');
		        	echo_size_tr('Text Shadow Blur Radius:','195',$styles[195],'0','50');
	        	close_accordion();
	        	
	        	create_accordion('Right Culomn Font Styles','closed');
		        	echo_color_tr('Font Color:','196',$styles[196]);
		        	echo_size_tr('Font Size:','197',$styles[197],'8','18');
		        	echo_select_tr('Font Weight','198',array("normal" => "Normal","bold" => "Bold"),$styles[198]);
		        	echo_select_tr('Font Style','199',array("normal" => "Normal","italic" => "Italic"),$styles[199]);
		        	echo_select_tr('Text Decoration','200',array("none" => "None","underline" => "Underline","overline" => "Overline","line-through"=>"Line Through"),$styles[200]);
		        	echo_font_tr('Font Family','201',$styles[201]);
	        	close_accordion();
	        	create_accordion('Right Culomn Text Shadow','closed');
		        	echo_color_tr('Text Shadow Color:','202',$styles[202]);
		        	echo_size_tr('Text Shadow Horizontal Offset:','203',$styles[203],'-50','50');
		        	echo_size_tr('Text Shadow Vertical Offset:','204',$styles[204],'-50','50');
		        	echo_size_tr('Text Shadow Blur Radius:','205',$styles[205],'0','50');
	        	close_accordion();
	        	
	        	//select tags ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        	seperate_tr("Timeline Select Tags");
	        	create_accordion('Styles','closed');
	        		echo_color_tr('Background Color:','206',$styles[206]);
	        		echo_size_tr('Padding Top,Bottom:','207',$styles[207],'0','15');
	        		echo_size_tr('Padding Left,Right:','208',$styles[208],'0','15');
	        	close_accordion();
	        	create_accordion('Font Styles','closed');
		        	echo_color_tr('Font Color:','209',$styles[209]);
		        	echo_size_tr('Font Size:','210',$styles[210],'8','18');
		        	echo_select_tr('Font Weight','211',array("normal" => "Normal","bold" => "Bold"),$styles[211]);
		        	echo_select_tr('Font Style','212',array("normal" => "Normal","italic" => "Italic"),$styles[212]);
		        	echo_select_tr('Text Decoration','213',array("none" => "None","underline" => "Underline","overline" => "Overline","line-through"=>"Line Through"),$styles[213]);
		        	echo_font_tr('Font Family','214',$styles[214]);
	        	close_accordion();
	        	create_accordion('Text Shadow','closed');
		        	echo_color_tr('Text Shadow Color:','215',$styles[215]);
		        	echo_size_tr('Text Shadow Horizontal Offset:','216',$styles[216],'-50','50');
		        	echo_size_tr('Text Shadow Vertical Offset:','217',$styles[217],'-50','50');
		        	echo_size_tr('Text Shadow Blur Radius:','218',$styles[218],'0','50');
	        	close_accordion();
	        	create_accordion('Border','closed');
		        	echo_color_tr('Border Color:','219',$styles[219]);
		        	echo_size_tr('Border Size:','220',$styles[220],'0','3');
		        	echo_select_tr('Border Style','221',array("solid" => "Solid", "dotted" => "Dotted","dashed" => "Dashed", "double" => "Double", "groove" => "Groove", "ridge" => "Ridge", "inset" => "Inset", "outset" => "Outset"),$styles[221]);
		        	echo_size_tr('Border Top Left Radius:','222',$styles[222],'0','80');
		        	echo_size_tr('Border Top Right Radius:','223',$styles[223],'0','80');
		        	echo_size_tr('Border Bottom Left Radius:','224',$styles[224],'0','80');
		        	echo_size_tr('Border Bottom Right Radius:','225',$styles[225],'0','80');
	        	close_accordion();
	        	create_accordion('Hover State','closed');
		        	echo_color_tr('Background Color:','226',$styles[226]);
		        	echo_color_tr('Border Color:','227',$styles[227]);
		        	echo_color_tr('Text Color:','228',$styles[228]);
		        	echo_color_tr('Text Shadow Color:','229',$styles[229]);
	        	close_accordion();
	        	
	        	//slider
	        	seperate_tr("Slider");
	        	create_accordion('Main Styles','closed');
	        		echo_color_tr('Background Color:','230',$styles[230]);
	        		echo_color_tr('Border Color:','231',$styles[231]);
	        		echo_size_tr('Border Radius:','232',$styles[232],'0','15');
	        	close_accordion();
	        	create_accordion('Slider Bar','closed');
	        		echo_color_tr('Background Color Start:','233',$styles[233]);
	        		echo_color_tr('Background Color End:','234',$styles[234]);
	        	close_accordion();
	        	create_accordion('Slider Butons','closed');
	        		echo_color_tr('Background Color:','235',$styles[235]);
	        		echo_color_tr('Border Color:','236',$styles[236]);
	        	close_accordion();
	        	create_accordion('Slider Butons Hover','closed');
	        		echo_color_tr('Background Color:','237',$styles[237]);
	        		echo_color_tr('Border Color:','238',$styles[238]);
	        	close_accordion();
	        	create_accordion('Font Styles','closed');
		        	echo_color_tr('Font Color:','239',$styles[239]);
		        	echo_color_tr('Dotted Line Color:','249',$styles[249]);
		        	echo_size_tr('Font Size:','248',$styles[248],'8','18');
		        	echo_size_tr('Line Vertical Align:','250',$styles[250],'2','22');
		        	echo_select_tr('Font Weight','240',array("normal" => "Normal","bold" => "Bold"),$styles[240]);
		        	echo_select_tr('Font Style','241',array("normal" => "Normal","italic" => "Italic"),$styles[241]);
		        	echo_select_tr('Text Decoration','242',array("none" => "None","underline" => "Underline","overline" => "Overline","line-through"=>"Line Through"),$styles[242]);
		        	echo_font_tr('Font Family','243',$styles[243]);
	        	close_accordion();
	        	create_accordion('Text Shadow','closed');
		        	echo_color_tr('Text Shadow Color:','244',$styles[244]);
		        	echo_size_tr('Text Shadow Horizontal Offset:','245',$styles[245],'-50','50');
		        	echo_size_tr('Text Shadow Vertical Offset:','246',$styles[246],'-50','50');
		        	echo_size_tr('Text Shadow Blur Radius:','247',$styles[247],'0','50');
	        	close_accordion();
	        	
	        ?>
	    </table>
	  </div>
	  <div id="answers_styles_table" style="display: none;">
	        <table class="temp_table">
	        <?php 
	        	//Main Box//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        	seperate_tr("Answers");
	        	create_accordion('Answer1','closed');
		        	echo_color_tr('background Color Start:','500',$styles[500]);
		        	echo_color_tr('background Color end:','501',$styles[501]);
	        	close_accordion();
	        	create_accordion('Answer2','closed');
		        	echo_color_tr('background Color Start:','502',$styles[502]);
		        	echo_color_tr('background Color end:','503',$styles[503]);
	        	close_accordion();
	        	create_accordion('Answer3','closed');
		        	echo_color_tr('background Color Start:','504',$styles[504]);
		        	echo_color_tr('background Color end:','505',$styles[505]);
	        	close_accordion();
	        	create_accordion('Answer4','closed');
		        	echo_color_tr('background Color Start:','506',$styles[506]);
		        	echo_color_tr('background Color end:','507',$styles[507]);
	        	close_accordion();
	        	create_accordion('Answer5','closed');
		        	echo_color_tr('background Color Start:','508',$styles[508]);
		        	echo_color_tr('background Color end:','509',$styles[509]);
	        	close_accordion();
	        	create_accordion('Answer6','closed');
		        	echo_color_tr('background Color Start:','510',$styles[510]);
		        	echo_color_tr('background Color end:','511',$styles[511]);
	        	close_accordion();
	        	create_accordion('Answer7','closed');
		        	echo_color_tr('background Color Start:','512',$styles[512]);
		        	echo_color_tr('background Color end:','513',$styles[513]);
	        	close_accordion();
	        	create_accordion('Answer8','closed');
		        	echo_color_tr('background Color Start:','514',$styles[514]);
		        	echo_color_tr('background Color end:','515',$styles[515]);
	        	close_accordion();
	        	create_accordion('Answer9','closed');
		        	echo_color_tr('background Color Start:','516',$styles[516]);
		        	echo_color_tr('background Color end:','517',$styles[517]);
	        	close_accordion();
	        	create_accordion('Answer10','closed');
		        	echo_color_tr('background Color Start:','518',$styles[518]);
		        	echo_color_tr('background Color end:','519',$styles[519]);
	        	close_accordion();
	        	create_accordion('Answer11','closed');
		        	echo_color_tr('background Color Start:','520',$styles[520]);
		        	echo_color_tr('background Color end:','521',$styles[521]);
	        	close_accordion();
	        	create_accordion('Answer12','closed');
		        	echo_color_tr('background Color Start:','522',$styles[522]);
		        	echo_color_tr('background Color end:','523',$styles[523]);
	        	close_accordion();
	        	create_accordion('Answer13','closed');
		        	echo_color_tr('background Color Start:','524',$styles[524]);
		        	echo_color_tr('background Color end:','525',$styles[525]);
	        	close_accordion();
	        	create_accordion('Answer14','closed');
		        	echo_color_tr('background Color Start:','526',$styles[526]);
		        	echo_color_tr('background Color end:','527',$styles[527]);
	        	close_accordion();
	        	create_accordion('Answer15','closed');
		        	echo_color_tr('background Color Start:','528',$styles[528]);
		        	echo_color_tr('background Color end:','529',$styles[529]);
	        	close_accordion();
	        	create_accordion('Answer16','closed');
		        	echo_color_tr('background Color Start:','530',$styles[530]);
		        	echo_color_tr('background Color end:','531',$styles[531]);
	        	close_accordion();
	        	create_accordion('Answer17','closed');
		        	echo_color_tr('background Color Start:','532',$styles[532]);
		        	echo_color_tr('background Color end:','533',$styles[533]);
	        	close_accordion();
	        	create_accordion('Answer18','closed');
		        	echo_color_tr('background Color Start:','534',$styles[534]);
		        	echo_color_tr('background Color end:','535',$styles[535]);
	        	close_accordion();
	        	create_accordion('Answer19','closed');
		        	echo_color_tr('background Color Start:','536',$styles[536]);
		        	echo_color_tr('background Color end:','537',$styles[537]);
	        	close_accordion();
	        	create_accordion('Answer20','closed');
		        	echo_color_tr('background Color Start:','538',$styles[538]);
		        	echo_color_tr('background Color end:','539',$styles[539]);
	        	close_accordion();
	        	
			?>
		</table>
	</div>
    
    
    </fieldset>
</div>
 
<div class="clr"></div>
 
<input type="hidden" name="option" value="com_sexypolling" />
<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
<input type="hidden" name="task" value="sexytemplate.edit" />
<?php echo JHtml::_('form.token'); ?>
</form>

<style>
.polling_container {
	border: <?php echo $styles[2];?>px <?php echo $styles[165];?> <?php echo $styles[1];?>;
	background-color: <?php echo $styles[0];?>;
	-moz-box-shadow: <?php echo $styles[50];?> <?php echo $styles[46];?>px <?php echo $styles[47];?>px <?php echo $styles[48];?>px <?php echo $styles[49];?>px  <?php echo $styles[3];?>;
	-webkit-box-shadow: <?php echo $styles[50];?> <?php echo $styles[46];?>px <?php echo $styles[47];?>px <?php echo $styles[48];?>px <?php echo $styles[49];?>px  <?php echo $styles[3];?>;
	box-shadow: <?php echo $styles[50];?> <?php echo $styles[46];?>px <?php echo $styles[47];?>px <?php echo $styles[48];?>px <?php echo $styles[49];?>px  <?php echo $styles[3];?>;
	
	-webkit-border-top-left-radius: <?php echo $styles[51];?>px;
	-moz-border-radius-topleft: <?php echo $styles[51];?>px;
	border-top-left-radius: <?php echo $styles[51];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[52];?>px;
	-moz-border-radius-topright: <?php echo $styles[52];?>px;
	border-top-right-radius: <?php echo $styles[52];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $styles[53];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[53];?>px;
	border-bottom-left-radius: <?php echo $styles[53];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[54];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[54];?>px;
	border-bottom-right-radius: <?php echo $styles[54];?>px;
}
.polling_container:hover {
	-moz-box-shadow: <?php echo $styles[55];?> <?php echo $styles[56];?>px <?php echo $styles[57];?>px <?php echo $styles[58];?>px <?php echo $styles[59];?>px  <?php echo $styles[5];?>;
	-webkit-box-shadow: <?php echo $styles[55];?> <?php echo $styles[56];?>px <?php echo $styles[57];?>px <?php echo $styles[58];?>px <?php echo $styles[59];?>px  <?php echo $styles[5];?>;
	box-shadow: <?php echo $styles[55];?> <?php echo $styles[56];?>px <?php echo $styles[57];?>px <?php echo $styles[58];?>px <?php echo $styles[59];?>px  <?php echo $styles[5];?>;
}
.polling_name {
	color: <?php echo $styles[7];?>;
	font-size: <?php echo $styles[8];?>px;
	font-style: <?php echo $styles[37];?>;
	font-weight: <?php echo $styles[36];?>;
	text-align: <?php echo $styles[39];?>;
	text-decoration: <?php echo $styles[38];?>;
	font-family: <?php echo $styles[40];?>;
	text-shadow: <?php echo $styles[60];?>px <?php echo $styles[61];?>px <?php echo $styles[62];?>px <?php echo $styles[63];?>;
	
}
.answer_name label{
	font-size: <?php echo $styles[10];?>px;
	color: <?php echo $styles[9];?>;
	font-style: <?php echo $styles[42];?>;
	font-weight: <?php echo $styles[41];?>;
	text-align: <?php echo $styles[44];?>;
	text-decoration: <?php echo $styles[43];?>;
	font-family: <?php echo $styles[45];?>;
	text-shadow: <?php echo $styles[64];?>px <?php echo $styles[65];?>px <?php echo $styles[66];?>px <?php echo $styles[67];?>;
}
.polling_container .polling_li {
	border: 1px solid transparent;
	-webkit-border-top-left-radius: <?php echo $styles[74];?>px;
	-moz-border-radius-topleft: <?php echo $styles[74];?>px;
	border-top-left-radius: <?php echo $styles[74];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[75];?>px;
	-moz-border-radius-topright: <?php echo $styles[75];?>px;
	border-top-right-radius: <?php echo $styles[75];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $styles[76];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[76];?>px;
	border-bottom-left-radius: <?php echo $styles[76];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[77];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[77];?>px;
	border-bottom-right-radius: <?php echo $styles[77];?>px;	
}
.polling_container .polling_li.active_li {
	-moz-box-shadow: <?php echo $styles[68];?> <?php echo $styles[69];?>px <?php echo $styles[70];?>px <?php echo $styles[71];?>px <?php echo $styles[72];?>px  <?php echo $styles[11];?>;
	-webkit-box-shadow: <?php echo $styles[68];?> <?php echo $styles[69];?>px <?php echo $styles[70];?>px <?php echo $styles[71];?>px <?php echo $styles[72];?>px  <?php echo $styles[11];?>;
	box-shadow: <?php echo $styles[68];?> <?php echo $styles[69];?>px <?php echo $styles[70];?>px <?php echo $styles[71];?>px <?php echo $styles[72];?>px  <?php echo $styles[11];?>;
	border: 1px solid <?php echo $styles[73];?>;
	background-color: <?php echo $styles[12];?>;
}

/* Polling Vote */
.polling_submit {
	background-color: <?php echo $styles[91];?>;
	padding: <?php echo $styles[92];?>px <?php echo $styles[93];?>px;
	-moz-box-shadow: <?php echo $styles[95];?> <?php echo $styles[96];?>px <?php echo $styles[97];?>px <?php echo $styles[98];?>px <?php echo $styles[99];?>px  <?php echo $styles[94];?>;	
	-webkit-box-shadow: <?php echo $styles[95];?> <?php echo $styles[96];?>px <?php echo $styles[97];?>px <?php echo $styles[98];?>px <?php echo $styles[99];?>px  <?php echo $styles[94];?>;	
	box-shadow: <?php echo $styles[95];?> <?php echo $styles[96];?>px <?php echo $styles[97];?>px <?php echo $styles[98];?>px <?php echo $styles[99];?>px  <?php echo $styles[94];?>;	
	border-style: <?php echo $styles[127];?>;
	border-width: <?php echo $styles[101];?>px;
	border-color: <?php echo $styles[100];?>;
	
	-webkit-border-top-left-radius: <?php echo $styles[102];?>px;
	-moz-border-radius-topleft: <?php echo $styles[102];?>px;
	border-top-left-radius: <?php echo $styles[102];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[103];?>px;
	-moz-border-radius-topright: <?php echo $styles[103];?>px;
	border-top-right-radius: <?php echo $styles[103];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $styles[104];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[104];?>px;
	border-bottom-left-radius: <?php echo $styles[104];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[105];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[105];?>px;
	border-bottom-right-radius: <?php echo $styles[105];?>px;

	font-size: <?php echo $styles[107];?>px;
	color: <?php echo $styles[106];?>;
	font-style: <?php echo $styles[109];?>;
	font-weight: <?php echo $styles[108];?>;
	text-decoration: <?php echo $styles[110];?>;
	font-family: <?php echo $styles[112];?>;
	text-shadow: <?php echo $styles[114];?>px <?php echo $styles[115];?>px <?php echo $styles[116];?>px <?php echo $styles[113];?>;
}
.polling_submit:hover {
	background-color:<?php echo $styles[123];?>;
	color: <?php echo $styles[124];?>;
	text-shadow: <?php echo $styles[114];?>px <?php echo $styles[115];?>px <?php echo $styles[116];?>px <?php echo $styles[125];?>;
	-moz-box-shadow: <?php echo $styles[118];?> <?php echo $styles[119];?>px <?php echo $styles[120];?>px <?php echo $styles[121];?>px <?php echo $styles[122];?>px  <?php echo $styles[117];?>;
	-webkit-box-shadow: <?php echo $styles[118];?> <?php echo $styles[119];?>px <?php echo $styles[120];?>px <?php echo $styles[121];?>px <?php echo $styles[122];?>px  <?php echo $styles[117];?>;
	box-shadow: <?php echo $styles[118];?> <?php echo $styles[119];?>px <?php echo $styles[120];?>px <?php echo $styles[121];?>px <?php echo $styles[122];?>px  <?php echo $styles[117];?>;
	border-style: <?php echo $styles[127];?>;
	border-width: <?php echo $styles[101];?>px;
	border-color: <?php echo $styles[126];?>;
}

/* Polling result */
.polling_result {
	background-color: <?php echo $styles[128];?>;
	padding: <?php echo $styles[129];?>px <?php echo $styles[130];?>px;
	-moz-box-shadow: <?php echo $styles[132];?> <?php echo $styles[133];?>px <?php echo $styles[134];?>px <?php echo $styles[135];?>px <?php echo $styles[136];?>px  <?php echo $styles[131];?>;	
	-webkit-box-shadow: <?php echo $styles[132];?> <?php echo $styles[133];?>px <?php echo $styles[134];?>px <?php echo $styles[135];?>px <?php echo $styles[136];?>px  <?php echo $styles[131];?>;	
	box-shadow: <?php echo $styles[132];?> <?php echo $styles[133];?>px <?php echo $styles[134];?>px <?php echo $styles[135];?>px <?php echo $styles[136];?>px  <?php echo $styles[131];?>;	
	border-style: <?php echo $styles[164];?>;
	border-width: <?php echo $styles[138];?>px;
	border-color: <?php echo $styles[137];?>;
	
	-webkit-border-top-left-radius: <?php echo $styles[139];?>px;
	-moz-border-radius-topleft: <?php echo $styles[139];?>px;
	border-top-left-radius: <?php echo $styles[139];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[140];?>px;
	-moz-border-radius-topright: <?php echo $styles[140];?>px;
	border-top-right-radius: <?php echo $styles[140];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $styles[141];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[141];?>px;
	border-bottom-left-radius: <?php echo $styles[141];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[142];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[142];?>px;
	border-bottom-right-radius: <?php echo $styles[142];?>px;

	font-size: <?php echo $styles[144];?>px;
	color: <?php echo $styles[143];?>;
	font-style: <?php echo $styles[146];?>;
	font-weight: <?php echo $styles[145];?>;
	text-decoration: <?php echo $styles[147];?>;
	font-family: <?php echo $styles[149];?>;
	text-shadow: <?php echo $styles[151];?>px <?php echo $styles[152];?>px <?php echo $styles[153];?>px <?php echo $styles[150];?>;
}
.polling_result:hover {
	background-color:<?php echo $styles[160];?>;
	color: <?php echo $styles[161];?>;
	text-shadow: <?php echo $styles[151];?>px <?php echo $styles[152];?>px <?php echo $styles[153];?>px <?php echo $styles[162];?>;
	-moz-box-shadow: <?php echo $styles[155];?> <?php echo $styles[156];?>px <?php echo $styles[157];?>px <?php echo $styles[158];?>px <?php echo $styles[159];?>px  <?php echo $styles[154];?>;
	-webkit-box-shadow: <?php echo $styles[155];?> <?php echo $styles[156];?>px <?php echo $styles[157];?>px <?php echo $styles[158];?>px <?php echo $styles[159];?>px  <?php echo $styles[154];?>;
	box-shadow: <?php echo $styles[155];?> <?php echo $styles[156];?>px <?php echo $styles[157];?>px <?php echo $styles[158];?>px <?php echo $styles[159];?>px  <?php echo $styles[154];?>;
	border-style: <?php echo $styles[164];?>;
	border-width: <?php echo $styles[138];?>px;
	border-color: <?php echo $styles[163];?>;
}

.answer_navigation {
	
	-webkit-border-top-left-radius: <?php echo $styles[85];?>px;
	-moz-border-radius-topleft: <?php echo $styles[85];?>px;
	border-top-left-radius: <?php echo $styles[85];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[86];?>px;
	-moz-border-radius-topright: <?php echo $styles[86];?>px;
	border-top-right-radius: <?php echo $styles[86];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $styles[87];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[87];?>px;
	border-bottom-left-radius: <?php echo $styles[87];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[88];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[88];?>px;
	border-bottom-right-radius: <?php echo $styles[88];?>px;
	
	height: <?php echo $styles[90];?>px;
}
.grad {
	-moz-box-shadow: <?php echo $styles[79];?> <?php echo $styles[80];?>px <?php echo $styles[81];?>px <?php echo $styles[82];?>px <?php echo $styles[83];?>px  <?php echo $styles[78];?>;
	-webkit-box-shadow: <?php echo $styles[79];?> <?php echo $styles[80];?>px <?php echo $styles[81];?>px <?php echo $styles[82];?>px <?php echo $styles[83];?>px  <?php echo $styles[78];?>;
	box-shadow: <?php echo $styles[79];?> <?php echo $styles[80];?>px <?php echo $styles[81];?>px <?php echo $styles[82];?>px <?php echo $styles[83];?>px  <?php echo $styles[78];?>;
	border: <?php echo $styles[89];?>px solid <?php echo $styles[84];?>;
	
	-webkit-border-top-left-radius: <?php echo $styles[85];?>px;
	-moz-border-radius-topleft: <?php echo $styles[85];?>px;
	border-top-left-radius: <?php echo $styles[85];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[86];?>px;
	-moz-border-radius-topright: <?php echo $styles[86];?>px;
	border-top-right-radius: <?php echo $styles[86];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $styles[87];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[87];?>px;
	border-bottom-left-radius: <?php echo $styles[87];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[88];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[88];?>px;
	border-bottom-right-radius: <?php echo $styles[88];?>px;
}
	        
.add_answer {
	border: <?php echo $styles[264];?>px <?php echo $styles[265];?> <?php echo $styles[263];?>;
	background-color:<?php echo $styles[273];?>;
	height:<?php echo $styles[272];?>px;
	
	-webkit-border-top-left-radius: <?php echo $styles[266];?>px;
	-moz-border-radius-topleft: <?php echo $styles[266];?>px;
	border-top-left-radius: <?php echo $styles[266];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[267];?>px;
	-moz-border-radius-topright: <?php echo $styles[267];?>px;
	border-top-right-radius: <?php echo $styles[267];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $styles[268];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[268];?>px;
	border-bottom-left-radius: <?php echo $styles[268];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[269];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[269];?>px;
	border-bottom-right-radius: <?php echo $styles[269];?>px;
	
	-moz-box-shadow: <?php echo $styles[258];?> <?php echo $styles[259];?>px <?php echo $styles[260];?>px <?php echo $styles[261];?>px <?php echo $styles[262];?>px  <?php echo $styles[257];?>;
	-webkit-box-shadow: <?php echo $styles[258];?> <?php echo $styles[259];?>px <?php echo $styles[260];?>px <?php echo $styles[261];?>px <?php echo $styles[262];?>px  <?php echo $styles[257];?>;
	box-shadow: <?php echo $styles[258];?> <?php echo $styles[259];?>px <?php echo $styles[260];?>px <?php echo $styles[261];?>px <?php echo $styles[262];?>px  <?php echo $styles[257];?>;
}
.add_ans_name {
	color: <?php echo $styles[251];?>;
	font-size: <?php echo $styles[252];?>px;
	
	font-style: <?php echo $styles[254];?>;
	font-weight: <?php echo $styles[253];?>;
	text-decoration: <?php echo $styles[255];?>;
	font-family: <?php echo $styles[256];?>;
	text-shadow: <?php echo $styles[275];?>px <?php echo $styles[276];?>px <?php echo $styles[277];?>px <?php echo $styles[274];?>;
	
	-webkit-border-top-left-radius: <?php echo $styles[266];?>px;
	-moz-border-radius-topleft: <?php echo $styles[266];?>px;
	border-top-left-radius: <?php echo $styles[266];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[267];?>px;
	-moz-border-radius-topright: <?php echo $styles[267];?>px;
	border-top-right-radius: <?php echo $styles[267];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $styles[268];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[268];?>px;
	border-bottom-left-radius: <?php echo $styles[268];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[269];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[269];?>px;
	border-bottom-right-radius: <?php echo $styles[269];?>px;
}
.add_ans_submit {
	border-left: <?php echo $styles[264];?>px <?php echo $styles[265];?> <?php echo $styles[263];?>;
	color: <?php echo $styles[271];?>;
	font-size: <?php echo $styles[252];?>px;
	
	font-style: <?php echo $styles[254];?>;
	font-weight: <?php echo $styles[253];?>;
	text-decoration: <?php echo $styles[255];?>;
	font-family: <?php echo $styles[256];?>;
	text-shadow: <?php echo $styles[275];?>px <?php echo $styles[276];?>px <?php echo $styles[277];?>px <?php echo $styles[274];?>;
	
	-webkit-border-top-left-radius: <?php echo $styles[266];?>px;
	-moz-border-radius-topleft: <?php echo $styles[266];?>px;
	border-top-left-radius: <?php echo $styles[266];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[267];?>px;
	-moz-border-radius-topright: <?php echo $styles[267];?>px;
	border-top-right-radius: <?php echo $styles[267];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $styles[268];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[268];?>px;
	border-bottom-left-radius: <?php echo $styles[268];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[269];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[269];?>px;
	border-bottom-right-radius: <?php echo $styles[269];?>px;
}




.answer_votes_data {
	font-size: <?php echo $styles[167];?>px;
	color: <?php echo $styles[166];?>;
	font-style: <?php echo $styles[169];?>;
	font-weight: <?php echo $styles[168];?>;
	text-decoration: <?php echo $styles[170];?>;
	font-family: <?php echo $styles[171];?>;
	text-shadow: <?php echo $styles[173];?>px <?php echo $styles[174];?>px <?php echo $styles[175];?>px <?php echo $styles[172];?>;
}
.answer_votes_data span {
	font-size: <?php echo $styles[177];?>px;
	color: <?php echo $styles[176];?>;
	font-style: <?php echo $styles[179];?>;
	font-weight: <?php echo $styles[178];?>;
	text-decoration: <?php echo $styles[180];?>;
	font-family: <?php echo $styles[181];?>;
	text-shadow: <?php echo $styles[183];?>px <?php echo $styles[184];?>px <?php echo $styles[185];?>px <?php echo $styles[182];?>;
}
.left_col {
	font-size: <?php echo $styles[187];?>px;
	color: <?php echo $styles[186];?>;
	font-style: <?php echo $styles[189];?>;
	font-weight: <?php echo $styles[188];?>;
	text-decoration: <?php echo $styles[190];?>;
	font-family: <?php echo $styles[191];?>;
	text-shadow: <?php echo $styles[193];?>px <?php echo $styles[194];?>px <?php echo $styles[195];?>px <?php echo $styles[192];?>;
}
.right_col {
	font-size: <?php echo $styles[197];?>px;
	color: <?php echo $styles[196];?>;
	font-style: <?php echo $styles[199];?>;
	font-weight: <?php echo $styles[198];?>;
	text-decoration: <?php echo $styles[200];?>;
	font-family: <?php echo $styles[201];?>;
	text-shadow: <?php echo $styles[203];?>px <?php echo $styles[204];?>px <?php echo $styles[205];?>px <?php echo $styles[202];?>;
}

.polling_select1,.polling_select2 {
	background-color: <?php echo $styles[206]?>;
	padding: <?php echo $styles[207]?>px <?php echo $styles[208]?>px;
	
	font-size: <?php echo $styles[210];?>px;
	color: <?php echo $styles[209];?>;
	font-style: <?php echo $styles[212];?>;
	font-weight: <?php echo $styles[211];?>;
	text-decoration: <?php echo $styles[213];?>;
	font-family: <?php echo $styles[214];?>;
	text-shadow: <?php echo $styles[216];?>px <?php echo $styles[217];?>px <?php echo $styles[218];?>px <?php echo $styles[215];?>;
	
	border: <?php echo $styles[220];?>px <?php echo $styles[221];?> <?php echo $styles[219];?>;
	
	-webkit-border-top-left-radius: <?php echo $styles[222];?>px;
	-moz-border-radius-topleft: <?php echo $styles[222];?>px;
	border-top-left-radius: <?php echo $styles[222];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[223];?>px;
	-moz-border-radius-topright: <?php echo $styles[223];?>px;
	border-top-right-radius: <?php echo $styles[223];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $styles[224];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[224];?>px;
	border-bottom-left-radius: <?php echo $styles[224];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[225];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[225];?>px;
	border-bottom-right-radius: <?php echo $styles[225];?>px;
}
.polling_select1:hover {
	background-color: <?php echo $styles[226]?>;
	color: <?php echo $styles[228];?>;
	border: <?php echo $styles[220];?>px <?php echo $styles[221];?> <?php echo $styles[227];?>;
	text-shadow: <?php echo $styles[216];?>px <?php echo $styles[217];?>px <?php echo $styles[218];?>px <?php echo $styles[229];?>;
}
.polling_select2:hover {
	background-color: <?php echo $styles[226]?>;
	color: <?php echo $styles[228];?>;
	border: <?php echo $styles[220];?>px <?php echo $styles[221];?> <?php echo $styles[227];?>;
	text-shadow: <?php echo $styles[216];?>px <?php echo $styles[217];?>px <?php echo $styles[218];?>px <?php echo $styles[229];?>;
}

/* slider */
.ui-corner-all {
	-webkit-border-radius: <?php echo $styles[232];?>px;
	-moz-border-radius: <?php echo $styles[232];?>px;
	border-radius: <?php echo $styles[232];?>px;
}
.ui-widget-content {
	background: none;
	background-color: <?php echo $styles[230];?>;
	border: 1px solid <?php echo $styles[231];?>;
	color: <?php echo $styles[231];?>;
}
.ui-widget-content .ui-state-default{
	background: none;
	background-color: <?php echo $styles[235];?>;
	border: 1px solid <?php echo $styles[236];?>;
}
.ui-widget-content .ui-state-default:hover {
	background: none;
	background-color: <?php echo $styles[237];?>;
	border: 1px solid <?php echo $styles[238];?>;
}
	/*keep this for js loaded file*/
.ui-widget-content .ui-state-hover,.ui-widget-content .ui-state-focus{
	background: none;
	background-color: <?php echo $styles[237];?>;
	border: 1px solid <?php echo $styles[238];?>;
}
	
.ui-slider dt {
	border-bottom: 1px dotted <?php echo $styles[249];?>;
	
	font-size: <?php echo $styles[248];?>px;
	color: <?php echo $styles[239];?>;
	font-style: <?php echo $styles[241];?>;
	font-weight: <?php echo $styles[240];?>;
	text-decoration: <?php echo $styles[242];?>;
	font-family: <?php echo $styles[243];?>;
	text-shadow: <?php echo $styles[245];?>px <?php echo $styles[246];?>px <?php echo $styles[247];?>px <?php echo $styles[244];?>;
	
	top: 12px;
	height: <?php echo $styles[250];?>px;
}

.ui-widget-header {
	background: none;
	background-color: <?php echo $styles[234];?>;
	
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[233];?>), to(<?php echo $styles[234];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[233];?>, <?php echo $styles[234];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[233];?>, <?php echo $styles[234];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[233];?>, <?php echo $styles[234];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[233];?>, <?php echo $styles[234];?>);/* Opera 11.10+ */
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[233];?>', endColorstr='<?php echo $styles[234];?>'); /* for IE */
}
.ui-slider dt span {
	background: <?php echo $styles[0];?>;
}
/* answers */
.polling_bar_1 .grad {
	background-color: <?php echo $styles[501];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[500];?>', endColorstr='<?php echo $styles[501];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[500];?>), to(<?php echo $styles[501];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[500];?>, <?php echo $styles[501];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[500];?>, <?php echo $styles[501];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[500];?>, <?php echo $styles[501];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[500];?>, <?php echo $styles[501];?>);/* Opera 11.10+ */
}
.polling_bar_2 .grad {
	background-color: <?php echo $styles[503];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[502];?>', endColorstr='<?php echo $styles[503];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[502];?>), to(<?php echo $styles[501];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[502];?>, <?php echo $styles[503];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[502];?>, <?php echo $styles[503];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[502];?>, <?php echo $styles[503];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[502];?>, <?php echo $styles[503];?>);/* Opera 11.10+ */
}
.polling_bar_3 .grad {
	background-color: <?php echo $styles[505];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[504];?>', endColorstr='<?php echo $styles[505];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[504];?>), to(<?php echo $styles[505];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[504];?>, <?php echo $styles[505];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[504];?>, <?php echo $styles[505];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[504];?>, <?php echo $styles[505];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[504];?>, <?php echo $styles[505];?>);/* Opera 11.10+ */
}
.polling_bar_4 .grad {
	background-color: <?php echo $styles[507];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[506];?>', endColorstr='<?php echo $styles[507];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[506];?>), to(<?php echo $styles[507];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[506];?>, <?php echo $styles[507];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[506];?>, <?php echo $styles[507];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[506];?>, <?php echo $styles[507];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[506];?>, <?php echo $styles[507];?>);/* Opera 11.10+ */
}
.polling_bar_5 .grad {
	background-color: <?php echo $styles[509];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[508];?>', endColorstr='<?php echo $styles[509];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[508];?>), to(<?php echo $styles[509];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[508];?>, <?php echo $styles[509];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[508];?>, <?php echo $styles[509];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[508];?>, <?php echo $styles[509];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[508];?>, <?php echo $styles[509];?>);/* Opera 11.10+ */
}
.polling_bar_6 .grad {
	background-color: <?php echo $styles[511];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[510];?>', endColorstr='<?php echo $styles[511];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[510];?>), to(<?php echo $styles[511];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[510];?>, <?php echo $styles[511];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[510];?>, <?php echo $styles[511];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[510];?>, <?php echo $styles[511];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[510];?>, <?php echo $styles[511];?>);/* Opera 11.10+ */
}
.polling_bar_7 .grad {
	background-color: <?php echo $styles[513];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[512];?>', endColorstr='<?php echo $styles[513];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[512];?>), to(<?php echo $styles[513];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[512];?>, <?php echo $styles[513];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[512];?>, <?php echo $styles[513];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[512];?>, <?php echo $styles[513];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[512];?>, <?php echo $styles[513];?>);/* Opera 11.10+ */
}
.polling_bar_8 .grad {
	background-color: <?php echo $styles[515];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[514];?>', endColorstr='<?php echo $styles[515];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[514];?>), to(<?php echo $styles[515];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[514];?>, <?php echo $styles[515];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[514];?>, <?php echo $styles[515];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[514];?>, <?php echo $styles[515];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[514];?>, <?php echo $styles[515];?>);/* Opera 11.10+ */
}
.polling_bar_9 .grad {
	background-color: <?php echo $styles[517];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[516];?>', endColorstr='<?php echo $styles[517];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[516];?>), to(<?php echo $styles[517];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[516];?>, <?php echo $styles[517];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[516];?>, <?php echo $styles[517];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[516];?>, <?php echo $styles[517];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[516];?>, <?php echo $styles[517];?>);/* Opera 11.10+ */
}
.polling_bar_10 .grad {
	background-color: <?php echo $styles[519];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[518];?>', endColorstr='<?php echo $styles[519];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[518];?>), to(<?php echo $styles[519];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[518];?>, <?php echo $styles[519];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[518];?>, <?php echo $styles[519];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[518];?>, <?php echo $styles[519];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[518];?>, <?php echo $styles[519];?>);/* Opera 11.10+ */
}
.polling_bar_11 .grad {
	background-color: <?php echo $styles[521];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[520];?>', endColorstr='<?php echo $styles[521];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[520];?>), to(<?php echo $styles[521];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[520];?>, <?php echo $styles[521];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[520];?>, <?php echo $styles[521];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[520];?>, <?php echo $styles[521];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[520];?>, <?php echo $styles[521];?>);/* Opera 11.10+ */
}
.polling_bar_12 .grad {
	background-color: <?php echo $styles[523];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[522];?>', endColorstr='<?php echo $styles[523];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[522];?>), to(<?php echo $styles[523];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[522];?>, <?php echo $styles[523];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[522];?>, <?php echo $styles[523];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[522];?>, <?php echo $styles[523];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[522];?>, <?php echo $styles[523];?>);/* Opera 11.10+ */
}
.polling_bar_13 .grad {
	background-color: <?php echo $styles[525];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[524];?>', endColorstr='<?php echo $styles[525];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[524];?>), to(<?php echo $styles[525];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[524];?>, <?php echo $styles[525];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[524];?>, <?php echo $styles[525];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[524];?>, <?php echo $styles[525];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[524];?>, <?php echo $styles[525];?>);/* Opera 11.10+ */
}
.polling_bar_14 .grad {
	background-color: <?php echo $styles[527];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[526];?>', endColorstr='<?php echo $styles[527];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[526];?>), to(<?php echo $styles[527];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[526];?>, <?php echo $styles[527];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[526];?>, <?php echo $styles[527];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[526];?>, <?php echo $styles[527];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[526];?>, <?php echo $styles[527];?>);/* Opera 11.10+ */
}
.polling_bar_15 .grad {
	background-color: <?php echo $styles[529];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[528];?>', endColorstr='<?php echo $styles[529];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[528];?>), to(<?php echo $styles[529];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[528];?>, <?php echo $styles[529];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[528];?>, <?php echo $styles[529];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[528];?>, <?php echo $styles[529];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[528];?>, <?php echo $styles[529];?>);/* Opera 11.10+ */
}
.polling_bar_16 .grad {
	background-color: <?php echo $styles[531];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[530];?>', endColorstr='<?php echo $styles[531];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[530];?>), to(<?php echo $styles[531];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[530];?>, <?php echo $styles[531];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[530];?>, <?php echo $styles[531];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[530];?>, <?php echo $styles[531];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[530];?>, <?php echo $styles[531];?>);/* Opera 11.10+ */
}
.polling_bar_17 .grad {
	background-color: <?php echo $styles[533];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[532];?>', endColorstr='<?php echo $styles[533];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[532];?>), to(<?php echo $styles[533];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[532];?>, <?php echo $styles[533];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[532];?>, <?php echo $styles[533];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[532];?>, <?php echo $styles[533];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[532];?>, <?php echo $styles[533];?>);/* Opera 11.10+ */
}
.polling_bar_18 .grad {
	background-color: <?php echo $styles[535];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[534];?>', endColorstr='<?php echo $styles[535];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[534];?>), to(<?php echo $styles[535];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[534];?>, <?php echo $styles[535];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[534];?>, <?php echo $styles[535];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[534];?>, <?php echo $styles[535];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[534];?>, <?php echo $styles[535];?>);/* Opera 11.10+ */
}
.polling_bar_19 .grad {
	background-color: <?php echo $styles[537];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[536];?>', endColorstr='<?php echo $styles[537];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[536];?>), to(<?php echo $styles[537];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[536];?>, <?php echo $styles[537];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[536];?>, <?php echo $styles[537];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[536];?>, <?php echo $styles[537];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[536];?>, <?php echo $styles[537];?>);/* Opera 11.10+ */
}
.polling_bar_20 .grad {
	background-color: <?php echo $styles[539];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[538];?>', endColorstr='<?php echo $styles[539];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[538];?>), to(<?php echo $styles[539];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[538];?>, <?php echo $styles[539];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[538];?>, <?php echo $styles[539];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[538];?>, <?php echo $styles[539];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[538];?>, <?php echo $styles[539];?>);/* Opera 11.10+ */
}
	
	
</style>

<?php include (JPATH_BASE.'/components/com_sexypolling/helpers/footer.php'); ?>