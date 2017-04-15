<?php
/**
 * oneline functions
 *
 * @package oneline
 * @version 1.00
 * @author Dmitri Beliavski
 * @copyright (c) seditio.by 2017
 */
 
defined('COT_CODE') or die('Wrong URL');

function cot_oneline($tpl = 'oneline.list', $items = 0, $section = '', $order = 'oneline_id DESC')
{	global $db, $db_x;

	$tpl = (!$tpl) ? 'oneline.list' : $tpl;
	$t = new XTemplate(cot_tplfile($tpl, 'plug'));
	
	$db_oneline = !empty($db_oneline) ? $db_oneline : $db_x.'oneline';
	
	$where = empty($section) ? '' : "WHERE oneline_section = '".$section."'";
	$order = empty($order) ? "ORDER BY oneline_id DESC" : "ORDER BY $order";
	$limit = ($items > 0) ? "LIMIT $items" : '';
	
	$res = $db->query("SELECT * 
		FROM $db_oneline
		$where
		$order
		$limit");
		
	$jj = 1;
	while ($row = $res->fetch())
	{
		$t->assign(array(
			'PAGE_ROW_ID'      => $row['oneline_id'],
			'PAGE_ROW_DATE'    => $row['oneline_date'],
			'PAGE_ROW_PRICE1'   => $row['oneline_price1'],
			'PAGE_ROW_PRICE2'   => $row['oneline_price2'],
			'PAGE_ROW_TEXT'    => $row['oneline_text'],
			'PAGE_ROW_LINK'    => $row['oneline_link'],
			'PAGE_ROW_SECTION' => $row['oneline_text'],
			
			'PAGE_ROW_NUM'     => $jj,
			'PAGE_ROW_ODDEVEN' => cot_build_oddeven($jj)
		));

		$t->parse("MAIN.PAGE_ROW");
		$jj++;
	}
	
	$t->parse();
	return $t->text();
	}