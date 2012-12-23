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
$html .= '<div class="heading"><a href="#" class="reset">&nbsp;[x]&nbsp;</a>'.$custom_params['n'].'</div>';
if(count($custom_params['vd']) > 0){
	$slider = true;
	$custom_value = JRequest::getVar('cv'.$type->virtuemart_custom_id);
	if((isset($custom_params['l']) && !$custom_params['l']) && (isset($custom_params['ft']) && $custom_params['ft'] == 'int')){ 
		$custom_params['vd'] = array('gt' => $custom_params['vd'][0],'lt' => $custom_params['vd'][count($custom_params['vd'])-1]);
		// Handle int only
		$html .= '<div class="values sliderbox slider-double-handle">';
		$value = isset($custom_value['gt']) ? $custom_value['gt'] : '';
		$html .= '<input class="slider-range-gt" rel="'.$custom_params['vd']['gt'].'" type="text" name="cv'.$type->virtuemart_custom_id.'[gt]" value="'.$value.'" size="5" />';
		$value = isset($custom_value['lt']) ? $custom_value['lt'] : '';
		$html .= '<input class="slider-range-lt" rel="'.$custom_params['vd']['lt'].'" type="text" name="cv'.$type->virtuemart_custom_id.'[lt]" value="'.$value.'" size="5" />';
		$html .= '<div style="clear:both;"></div>';
		$html .= '<div class="slider-line"></div>';
		$html .= '</div>';
	}else{
		// Handle text or list
		$html .= '<div class="values sliderbox slider-double-list">';
		$html .= '<div class="slider-range-gt"></div>';
		foreach($custom_params['vd'] as $k=>$v){
			$checked = isset($custom_value) && in_array($v,$custom_value)? ' checked="checked"' : '';
			$html .= '<label class="slider-value" style="display:none;"><input type="checkbox" name="cv'.$type->virtuemart_custom_id.'[]" value="'.$v.'"'.$checked.' /><span>'.$v.'</span></label>';
		}
		$html .= '<div class="slider-line"></div>';
		$html .= '<div class="slider-range-lt"></div>';
		$html .= '</div>';
	}
}
$html .= '</div>';