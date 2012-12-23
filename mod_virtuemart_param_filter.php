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

require_once('helper.php');
vmJsApi::jQuery();
vmJsApi::cssSite();

$customfieldsModel = new VirtueMartModelCustomfields();
$cache = JFactory::getCache('com_virtuemart','callback');

$doc = JFactory::getDocument();
$multiple = $chosen = $slider = false;

/* ===== + Params ===== */
$class_sfx = $params->get('class_sfx', '');
$moduleclass_sfx = $params->get('moduleclass_sfx','');

$method = $params->get('method','get');
$layout = $params->get('layout','default');
$limit = $params->get('limit','10');
$stock = $params->get('stock',false);

$parent_id = $params->get('Parent_Category_id',null);
$parent_auto = $params->get('parent_auto',false);
$categories_show = $params->get('categories_show',true);
$categories_layout = $params->get('categories_layout','checkbox');

$manufacturers_show = $params->get('manufacturers_show',true);
$manufacturers_layout = $params->get('manufacturers_layout','checkbox');

$price_show = $params->get('price_show',true);
$price_discount = $params->get('price_discount',0);
$price_layout = $params->get('price_layout','input');

$customfields_show = $params->get('customfields_show',true);
$customfields_layout = $params->get('customfields_layout','auto');
$castom_fields_filter = $params->get('castom_fields_filter','');
/* ===== - Params ===== */

$active_category_id = JRequest::getInt('virtuemart_category_id', 0);
$cids = JRequest::getVar('cids',array($active_category_id));
$show_filter = false;
//var_dump($active_category_id);
/* ===== + Categories load -> tmpl ===== */
$categories='';
if($categories_show){
	$show_filter = true;
	$categories = getCategories();
	$html = '';
	require(JModuleHelper::getLayoutPath('mod_virtuemart_param_filter','categories'.DS.$categories_layout.DS.'default')); // Generate html
	$categories_html = $html;
}elseif($parent_auto && $active_category_id > 0){
	$categories_html = '<input type="hidden" name="virtuemart_category_id" value="'.$active_category_id.'" />';
}
/* ===== - Categories load -> tmpl ===== */

/* ===== + Manufacturer load -> tmpl ===== */
$manufacturers='';
if($manufacturers_show){
	$show_filter = true;
	$manufacturers = getManufacturers();
	$mids = JRequest::getVar('mids');
	$html = '';
	require(JModuleHelper::getLayoutPath('mod_virtuemart_param_filter','manufacturers'.DS.$manufacturers_layout)); // Generate html
	$manufacturers_html = $html;
}
/* ===== - Manufacturer load -> tmpl ===== */

/* ===== + Price load -> tmpl ===== */
$price_html='';
if($price_show){
	$show_filter = true;
	$price_left = JRequest::getVar('pl','');
	$price_right = JRequest::getVar('pr','');
	if($parent_auto){
		$price_limits = getPriceLimits($price_discount,$cids);
	}else{
		$price_limits = getPriceLimits($price_discount);
	}
	$html = '';
	require(JModuleHelper::getLayoutPath('mod_virtuemart_param_filter','price'.DS.$price_layout)); // Generate html
	if($price_discount){
		$html .= '<input type="hidden" name="d" value="1" />';
	}
	$price_html = $html;
}
/* ===== - Price load -> tmpl ===== */

/* ===== Customfields load -> preload ===== */
$types = array();
if($customfields_show){
	$show_filter = true;
	$custom_ids = JRequest::getVar('cpi', array());
	if($parent_auto && $active_category_id > 0){
		// $profiler = new JProfiler();
		$types = $cache->call('getCategoryCustomfields',$active_category_id,$custom_ids);
		// $types = getCategoryCustomfields($active_category_id,$custom_ids);
		// echo $profiler->mark( ' with caching' ).'<br/>';
	}elseif($parent_id != null){
		$types = getCustomfields($parent_id,array());
	}elseif(count($custom_ids) > 0){
		$types = getCustomfields($parent_id,$custom_ids);
	}
	if(count($types) > 0){
		$pre_int_values = $cache->call('getCustomIntValues');
		$pre_text_values = $cache->call('getCustomTextValues');
	}
	$type_req = $types[0];
}elseif($castom_fields_filter){
        $show_filter = true;
        $castom_fields_filter = explode(',', $castom_fields_filter);
	$type_req = getCustomfields('', $castom_fields_filter,0);
	$type_req = $type_req[0];
}else{
	$type_req = getCustomfields('',array(),1);
	$type_req = $type_req[0];
}

/* ===== Module tmpl ===== */
require(JModuleHelper::getLayoutPath('mod_virtuemart_param_filter',$layout));
if($chosen){
	$doc->addStyleSheet(JURI::base()."components/com_virtuemart/assets/css/chosen.css");
	$doc->addScript(JURI::base()."components/com_virtuemart/assets/js/chosen.jquery.min.js");
}
if($slider){
	// load jQuery ui script
}
$doc->addScript(JURI::base()."modules/mod_virtuemart_param_filter/assets/jquery-ui-1.9.2.custom.min.js");
$doc->addScript(JURI::base()."modules/mod_virtuemart_param_filter/assets/js.js");
$doc->addStyleSheet(JURI::base()."modules/mod_virtuemart_param_filter/assets/style.css");