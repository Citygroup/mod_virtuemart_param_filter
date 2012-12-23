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
	$selected = (isset($active_categories) && in_array($v->virtuemart_category_id,$active_categories)) ? ' selected="selected"' : '';
	$html .= '<option value="'.$v->virtuemart_category_id.'"'.$selected.'>';
	if($v->depth > 1){
		$html .= str_repeat('-',$v->depth - 1).'&nbsp;';
	}
	$html .= $v->category_name.'</option>';
	$child = recursiveList($categories,$active_categories,$v->category_child_id,$v->depth,$tmpl);
	if(!empty($child)){
		$html .= $child;
	}
}