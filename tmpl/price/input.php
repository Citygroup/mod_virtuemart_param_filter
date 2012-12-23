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

$html .= '<div class="price"><div class="heading">'.JText::_('MOD_VMCUSTOM_PARAM_FILTER_PRICE').'</div>';
$html .= '<div class="values"><input type="text" name="pl" value="'.$price_left.'" size="4" /> - <input type="text" name="pr" value="'.$price_right.'" size="4" /></div></div>';