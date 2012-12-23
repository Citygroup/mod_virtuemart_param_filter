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

$html .= '<div class="heading">'.JText::_('MOD_VMCUSTOM_PARAM_FILTER_CATEGORY').'</div>';
$html .= '<ul id="category_filter">'.recursiveList($categories,$cids,0,0,'checkbox').'</ul>';