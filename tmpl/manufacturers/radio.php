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

$html .= '<div class="heading">'.JText::_('MOD_VMCUSTOM_PARAM_FILTER_MANUFACTURER').'</div>';
if(count($manufacturers) > 0){
	$html .= '<div class="values">';
	foreach($manufacturers as $v){
		$checked = isset($mids) && in_array($v->virtuemart_manufacturer_id,$mids)? ' checked="checked"' : '';
		$html .= '<label><input type="radio" name="mids[]" value="'.$v->virtuemart_manufacturer_id.'"'.$checked.' />'.$v->mf_name.'</label><br/>';
	}
	$html .= '</div>';
}