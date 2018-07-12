<?php
/**
 * Oneline Plugin, Functions
 *
 * @package oneline
 * @version 2.00
 * @author Dmitri Beliavski
 * @copyright (c) seditio.by 2017
 */
 
defined('COT_CODE') or die('Wrong URL');

function cot_oneline($tpl = 'oneline.list', $items = 0, $section = '', $order = 'oneline_id DESC', $extra = '') {
		global $db, $db_x;

	$tpl = (!$tpl) ? 'oneline.list' : $tpl;
	$t = new XTemplate(cot_tplfile($tpl, 'plug'));
	
	$db_oneline = !empty($db_oneline) ? $db_oneline : $db_x.'oneline';
	
	$where = empty($section) ? '' : "WHERE oneline_section = '".$section."'";
	$order = empty($order) ? "ORDER BY oneline_id DESC" : "ORDER BY $order";
	$extra = empty($extra) ? "" : "$extra";
	
	
	$limit = ($items > 0) ? "LIMIT $items" : '';
	
	$res = $db->query("SELECT * 
		FROM $db_oneline
		$where
		$extra
		$order
		$limit");
		
	$jj = 1;
	while ($row = $res->fetch()) {
		$t->assign(array(
			'PAGE_ROW_ID'		=> $row['oneline_id'],
			'PAGE_ROW_DATE'		=> $row['oneline_date'],
			'PAGE_ROW_PRICE1'	=> $row['oneline_price1'],
			'PAGE_ROW_PRICE1A'	=> $row['oneline_price1a'],
			'PAGE_ROW_PRICE2'	=> $row['oneline_price2'],
			'PAGE_ROW_PRICE2A'	=> $row['oneline_price2a'],
			'PAGE_ROW_TEXT'		=> $row['oneline_text'],
			'PAGE_ROW_EXTRA1'	=> $row['oneline_extra1'],
			'PAGE_ROW_EXTRA2'	=> $row['oneline_extra2'],
			'PAGE_ROW_LINK'		=> $row['oneline_link'],
			'PAGE_ROW_SECTION'	=> $row['oneline_text'],
			
			'PAGE_ROW_NUM'		=> $jj,
			'PAGE_ROW_ODDEVEN'	=> cot_build_oddeven($jj)
		));
		
		/* === Hook === */
		foreach (cot_getextplugins('oneline.loop') as $pl)
		{
			include $pl;
		}
		/* ===== */

		$t->parse("MAIN.PAGE_ROW");
		$jj++;
	}
	
	$t->parse();
	return $t->text();}

function cot_oneline_conv($code, $prefix, $type) {
	global $L, $R;
	$prefix = !$prefix ? 'theme' : $prefix;
	$codeout = (!$type OR $type == 'L') ? $L[$prefix.'-'.$code] : $R[$prefix.'-'.$code];
	return $codeout;
}