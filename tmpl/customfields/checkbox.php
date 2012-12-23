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

$html .= '<div class="heading">'.$custom_params['n'].'</div>';
if($custom_params['vd'] > 0){
	$html .= '<div class="values">';
	foreach($custom_params['vd'] as $v){
		$custom_value = JRequest::getVar('cv'.$type->virtuemart_custom_id);
		$checked = isset($custom_value) && in_array($v,$custom_value)? ' checked="checked"' : '';
		$html .= '<label class="filter" ><input type="checkbox" name="cv'.$type->virtuemart_custom_id.'[]" value="'.$v.'"'.$checked.' />'.$v.'</label><br/>';
	}
	$html .= '</div>';
}