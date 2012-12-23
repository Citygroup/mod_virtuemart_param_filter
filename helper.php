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

if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
$config= VmConfig::loadConfig();
if (!class_exists( 'VirtueMartModelCustomfields' )) require(JPATH_VM_ADMINISTRATOR.DS.'models'.DS.'customfields.php');

function getCategories(){
	$db = JFactory::getDBO();
	$q  = 'SELECT c.`virtuemart_category_id`, cl.`category_name`, cc.`category_parent_id`, cc.`category_child_id` FROM `#__virtuemart_categories` AS c';
	$q .= ' JOIN `#__virtuemart_categories_'.VMLANG.'` AS cl using (`virtuemart_category_id`)';
	$q .= ' JOIN `#__virtuemart_category_categories` AS cc ON cl.`virtuemart_category_id` = cc.`category_child_id`';
	$q .= ' WHERE c.published = "1" ORDER BY c.`ordering`';
	$db->setQuery($q);
	return $db->loadObjectList();
}

function getManufacturers(){
	$db = JFactory::getDBO();
	$q  = 'SELECT ml.`virtuemart_manufacturer_id`, ml.`mf_name` FROM `#__virtuemart_manufacturers` AS m';
	$q .= ' JOIN `#__virtuemart_manufacturers_'.VMLANG.'` AS ml using (`virtuemart_manufacturer_id`)';
	$q .= ' WHERE m.`published` = "1" ORDER BY ml.`mf_name`';
	$db->setQuery($q);
	return $db->loadObjectList();
}

function getPriceLimits($discount = 0,$cids = array()){
	$db = JFactory::getDBO();
	$q = '';
	if($discount){
		$q .= 'SELECT';
		$q .= ' MIN(CASE pd.`calc_value_mathop`
							WHEN "+%" THEN pp.`product_price` + pp.`product_price` * pd.`calc_value` / 100
							WHEN "-%" THEN pp.`product_price` - pp.`product_price` * pd.`calc_value` / 100
							WHEN "+" THEN pp.`product_price` + pd.`calc_value`
							WHEN "-" THEN pp.`product_price` - pd.`calc_value`
							ELSE pp.`product_price`
						END) as min';
		$q .= ',MAX(CASE pd.`calc_value_mathop`
							WHEN "+%" THEN pp.`product_price` + pp.`product_price` * pd.`calc_value` / 100
							WHEN "-%" THEN pp.`product_price` - pp.`product_price` * pd.`calc_value` / 100
							WHEN "+" THEN pp.`product_price` + pd.`calc_value`
							WHEN "-" THEN pp.`product_price` - pd.`calc_value`
							ELSE pp.`product_price`
						END) as max';
		$q .= ' FROM `#__virtuemart_product_prices` AS pp';
		$q .= ' LEFT JOIN `#__virtuemart_calcs` as pd ON pd.`virtuemart_calc_id` = pp.`product_discount_id`';
	}else{
		$q .= 'SELECT MIN(`product_price`) as min, MAX(`product_price`) as max FROM `#__virtuemart_product_prices` AS pp';
	}
	if(count($cids) > 0 && $cids[0] != 0){
		$q .= ' LEFT JOIN `#__virtuemart_product_categories` AS pc using (`virtuemart_product_id`)';
		$q .= ' WHERE pc.`virtuemart_category_id` IN ("'.implode('","',$cids).'")';
	}
	$db->setQuery($q);
	return $db->loadObjectList();
}

function getCategoryCustomfields($active_category_id, $custom_ids = array()){
	$db =&JFactory::getDBO();
	$q  = 'SELECT DISTINCT f.`virtuemart_custom_id`,f.custom_title,f.custom_tip,f.custom_params FROM `#__virtuemart_customs` AS f';
	$q .= ' INNER JOIN `#__virtuemart_product_custom_plg_param` AS pf ON f.`virtuemart_custom_id` = pf.`virtuemart_custom_id`';
	$q .= ' LEFT JOIN `#__virtuemart_product_categories` AS pc ON pf.`virtuemart_product_id` = pc.`virtuemart_product_id`';
	$q .= ' LEFT JOIN `#__virtuemart_products` AS p ON pf.`virtuemart_product_id` = p.`virtuemart_product_id`';
	$q .= ' LEFT JOIN `#__virtuemart_categories` AS c ON pc.`virtuemart_category_id` = c.`virtuemart_category_id`';
	$q .= ' WHERE p.published = "1" AND c.published = "1" AND f.custom_element="param" AND pc.virtuemart_category_id = "'.$active_category_id.'" AND f.custom_params LIKE "%s=\"1\"%"';
	if(count($custom_ids) > 0){
		$custom_ids = implode('","',$custom_ids);
		if(!empty($custom_ids))
			$q .= ' OR f.`virtuemart_custom_id` IN ("'.$custom_ids.'")';
	}
	$db->setQuery($q);
	return $db->loadObjectList();
}
/**
 *
 * @param type $parent_id
 * @param type $custom_ids
 * @param type $limit
 * @return type 
 */
function getCustomfields($parent_id = '',$custom_ids = array(),$limit = 0){
	$db =&JFactory::getDBO();
	$types_parent_id = explode(';',$parent_id);

	$q  = 'SELECT f.`virtuemart_custom_id`,f.`custom_title`,f.`custom_tip`,f.`custom_params` FROM `#__virtuemart_customs` AS f';
	$q .= ' WHERE f.`published` = "1" AND f.`custom_element`="param" AND f.`custom_params` LIKE "%s=\"1\"%"';

	if(!empty($parent_id) && count($types_parent_id) > 0){
		$types_parent_id = implode('","',$types_parent_id);
		$q .= 'AND f.`custom_parent_id` IN ("'.$types_parent_id.'") ';
	}
	if(count($custom_ids) > 0){
		$custom_ids = implode('","',$custom_ids);
		if(!empty($custom_ids))
			$q .= ' OR f.`virtuemart_custom_id` IN ("'.$custom_ids.'")';
	}
	$q .= ' ORDER BY f.`ordering`';
	if($limit > 0){
		$q .= ' LIMIT 0,'.$limit;
	}
	$db->setQuery($q);
	return $db->loadObjectList();
}

function getCustomIntValues(){
	$db = JFactory::getDBO(); 
	$q  = 'SELECT f.`virtuemart_custom_id`,GROUP_CONCAT(DISTINCT f.`intvalue`) as `values` FROM `#__virtuemart_product_custom_plg_param` as f';
	$q .= ' WHERE f.`intvalue` != "-13692"'; // -13692 is default
	$q .= ' GROUP BY f.`virtuemart_custom_id`';
	$q .= ' ORDER BY f.`virtuemart_custom_id`';
	$db->setQuery($q);
	return $db->loadObjectList('virtuemart_custom_id');
}

function getCustomTextValues(){
	$db = JFactory::getDBO(); 
	$q  = 'SELECT f.`virtuemart_custom_id`,GROUP_CONCAT(DISTINCT f.`value`) as `values` FROM `#__virtuemart_product_custom_plg_param` as f';
	$q .= ' LEFT JOIN `#__virtuemart_customs` as c using(`virtuemart_custom_id`)';
	$q .= ' WHERE c.`custom_params` LIKE \'%|l="0"|%\' AND f.`value` != \'||\'';
	// $q .= ' GROUP BY f.`virtuemart_custom_id`';
	$q .= ' ORDER BY f.`virtuemart_custom_id`';
	$db->setQuery($q);
	return $db->loadObjectList('virtuemart_custom_id');
}

function recursiveList($categories,$active_categories=array(),$parent_category_id,$depth,$tmpl){
	$html = '';
	foreach($categories as $v){
		require(JModuleHelper::getLayoutPath('mod_virtuemart_param_filter','categories'.DS.$tmpl.DS.'_item'));
	}
	return $html;
}