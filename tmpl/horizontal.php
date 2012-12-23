<?php
defined('_JEXEC') or die('Restricted access');
/**
* Param Filter: Virtuemart 2 search module
* Version: 1.0.0 (2012.05.22)
* Author: Usov Dima
* Copyright: Copyright (C) 2012 usovdm
* License GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
* http://myext.eu
**/

if($show_filter){
	echo '<div id="paramfilter">';
	echo   '<style type="text/css">
				.heading { font-size:120%; font-weight:bold; }
				label.filter input { margin:3px; }
				table.horizontbox { width:100%; border:0; }
				table.horizontbox td,table.horizontbox tr { vertical-align:middle; text-align:center; border:0; }
				div.horizontbox { float:left; width:24.4%; }
				.horizontbox select { width:90%; }
			</style>';
	echo '<form action="/index.php" method="'.$method.'">
		<input type="hidden" name="option" value="com_virtuemart" />
		<input type="hidden" name="search" value="true" />
		<input type="hidden" name="view" value="category" />';
	if($stock){
		echo '<input type="hidden" name="s" value="1" />'; // instock trigger
	}
	echo '<table class="horizontbox"><tr>';
	echo empty($categories_html) ? '' : '<td>'.$categories_html.'</td>';
	echo empty($manufacturers_html) ? '' : '<td>'.$manufacturers_html.'</td>';
	echo empty($price_html) ? '' : '<td>'.$price_html.'</td>';
	foreach($types as $type){
		$tmp_params = $type->custom_params;
		$tmp_params = explode('|',$tmp_params);
		$custom_params = array();
		foreach($tmp_params as $v){
			preg_match("/^([^=]*)=(.*)|/i",$v, $res);
			$custom_params[@$res[1]] = json_decode(@$res[2]);
		}
		if(isset($custom_params['l']) && !$custom_params['l']){ // Handle
			if(isset($custom_params['ft']) && $custom_params['ft'] == 'int'){
				if(!empty($pre_int_values[$type->virtuemart_custom_id]->values)){
					$custom_params['vd'] = explode(',',$pre_int_values[$type->virtuemart_custom_id]->values);
					sort($custom_params['vd']);
				}
			}else{
				if(!empty($pre_text_values[$type->virtuemart_custom_id]->values)){
					$custom_params['vd'] = explode('|,|',substr($pre_text_values[$type->virtuemart_custom_id]->values,1,-1));
					natcasesort($custom_params['vd']);
				}
			}
		}else{ // List
			$custom_params['vd'] = explode(';',$custom_params['vd']);
		}
		$html = '';
		$customfields_layout_tmp = $customfields_layout == 'auto' ? $custom_params['t'] : $customfields_layout;
		require(JModuleHelper::getLayoutPath('mod_virtuemart_param_filter','customfields'.DS.$customfields_layout_tmp)); // Generate customfields html
		echo '<td>';
		echo '<input type="hidden" name="cpi[]" value="'.$type->virtuemart_custom_id.'" />';
		echo $html;
		echo '</td>';
	}
	echo '<td><input type="hidden" name="custom_parent_id" value="'.$type_req->virtuemart_custom_id.'" />';
	echo '<input type="hidden" name="limitstart" value="0" />';
	echo '<input type="hidden" name="limit" value="'.$limit.'" />';
	echo '<input style="padding:5px;" type="submit" value="'.JText::_('MOD_VMCUSTOM_PARAM_FILTER_SEARCH').'" />';
	echo '</form>';
	echo '</td>';
	echo '</tr>';
	echo '</table>';
	echo '</div>';
}