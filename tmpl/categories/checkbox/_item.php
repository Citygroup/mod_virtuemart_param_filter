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

if($v->category_parent_id == $parent_category_id){
	$v->depth = $depth + 1;
	$html .= '<li>';
	$checked = (isset($active_categories) && in_array($v->virtuemart_category_id,$active_categories)) ? ' checked="checked"' : '';
	if($v->depth > 1){
		$html .= str_repeat('&nbsp;&nbsp;',$v->depth - 1).'<sup>L</sup>&nbsp;';
	}
	$html .= '<label><input type="checkbox" name="cids[]" value="'.$v->virtuemart_category_id.'"'.$checked.' /> '.$v->category_name.'</label>';
	$child = recursiveList($categories,$active_categories,$v->category_child_id,$v->depth,$tmpl);
	if(!empty($child)){
		$html .= '&nbsp;<a class="next_depth" href="#">&darr;&uarr;</a>';
		$html .= '<ul style="display:none;">'.$child.'</ul>';
	}
	$html .= '</li>';
}