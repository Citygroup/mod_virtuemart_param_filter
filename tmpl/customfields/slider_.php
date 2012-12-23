<?php
defined('_JEXEC') or die('Restricted access');
/**
* Param Filter: Virtuemart 2 search module
* Version: 1.0.0 (2012.04.23)
* Author: Usov Dima
* Copyright: Copyright (C) 2012 usovdm
* License GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
* http://myext.eu
**/

$html .= '<div id="customfield-'.$type->virtuemart_custom_id.'">';
$html .= '<div class="heading">'.$custom_params['n'].'</div>';
if($custom_params['vd'] > 0){
	$slider = true;
	$list = $custom_params['l'] ? 'list' : 'handle';
	$html .= '<div class="values sliderbox slider-single-'.$list.'">';
	$html .= '<label class="slider-value" style="display:none;"><input type="checkbox" name="cv'.$type->virtuemart_custom_id.'[]" value="" /><span>Все</span></label>';
	foreach($custom_params['vd'] as $v){
		$custom_value = JRequest::getVar('cv'.$type->virtuemart_custom_id);
		$checked = isset($custom_value) && in_array($v,$custom_value)? ' checked="checked"' : '';
		$html .= '<label class="slider-value" style="display:none;"><input type="checkbox" name="cv'.$type->virtuemart_custom_id.'[]" value="'.$v.'"'.$checked.' /><span>'.$v.'</span></label>';
	}
	$html .= '<div class="slider-msg">Все</div>';
	$html .= '<div class="slider-line"></div>';
	$html .= '</div>';
}
$html .= '</div>';