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

$doc->addStyleSheet("/components/com_virtuemart/assets/css/chosen.css");
$doc->addScript("/components/com_virtuemart/assets/js/chosen.jquery.min.js");
$html .= '<div class="heading">'.JText::_('MOD_VMCUSTOM_PARAM_FILTER_CATEGORY').'</div>';
$html .= '<select id="category_filter" class="chosen" name="cids[]" style="width:200px;" data-placeholder="Choose a category"><option value=""></option>'.recursiveList($categories,$cids,0,0,'select').'</select>';