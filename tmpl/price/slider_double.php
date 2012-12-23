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
$slider = true;
$html .= '<div class="values sliderbox slider-double-handle">';
$html .= '<input type="text" class="slider-range-gt" name="pl" rel="'.floor($price_limits[0]->min).'" value="'.$price_left.'" size="4" />';
$html .= '<input type="text" class="slider-range-lt" name="pr" rel="'.ceil($price_limits[0]->max + 1).'" value="'.$price_right.'" size="4" />';
$html .= '<div style="clear:both;"></div>';
$html .= '<div class="slider-line"></div>';
$html .= '</div>';
$html .= '</div>';