<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=tools
 * [END_COT_EXT]
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_langfile('oneline', 'plug');
require_once cot_incfile('oneline', 'plug', 'settings.'.$cfg['plugin']['oneline']['code'].'');
require_once cot_incfile('forms');

$db_oneline = !empty($db_oneline) ? $db_oneline : $db_x.'oneline';

$t = new XTemplate(cot_tplfile('oneline.tools', 'plug', true));
$adminhelp = $L['oneline_help'];

$mrp = (int)$cfg['plugin']['oneline']['pagination'];

if ($mrp > 0) {
	list($pg, $d, $durl) = cot_import_pagenav('d', $mrp);
	$sql_limit = "LIMIT $d, $mrp";
}

if ($a == 'delete') {
	cot_check_xg();
	$db->delete($db_oneline, "oneline_id=$id");
	cot_redirect(cot_url('admin', 'm=other&p=oneline', '', true));
}
elseif ($a == 'update') {
	$oneline_date = cot_import('oneline_date', 'P', 'ARR');
	$oneline_price1 = cot_import('oneline_price1', 'P', 'ARR');
	$oneline_price2 = cot_import('oneline_price2', 'P', 'ARR');
	$oneline_text = cot_import('oneline_text', 'P', 'ARR');
	$oneline_link = cot_import('oneline_link', 'P', 'ARR');
	$oneline_section = cot_import('oneline_section', 'P', 'ARR');
	
	foreach($oneline_text as $key => $val) {
		$db_ins = array();
		$db_ins['oneline_date'] = (int)cot_import_date($oneline_date[$key], true, false, 'D');
		$db_ins['oneline_price1'] = cot_import($oneline_price1[$key], 'D', 'NUM');
		$db_ins['oneline_price2'] = cot_import($oneline_price2[$key], 'D', 'NUM');
		$db_ins['oneline_text'] = cot_import($oneline_text[$key], 'D', 'TXT');
		$db_ins['oneline_link'] = cot_import($oneline_link[$key], 'D', 'TXT');
		$db_ins['oneline_section'] = cot_import($oneline_section[$key], 'D', 'TXT');
		$db->update($db_oneline, $db_ins, "oneline_id=$key");
	}

	$flt = cot_import('oneline_filter', 'P', 'TXT');
	($flt) ? $_SESSION['filter'] = $flt : $_SESSION['filter'] = '';
	
	cot_redirect(cot_url('admin', 'm=other&p=oneline', '', true));
}
elseif ($a == 'add') {
	
	$db_ins['oneline_date'] = (int)cot_import_date('oneline_date', true, false, 'P');
	$db_ins['oneline_price1'] = cot_import('oneline_price1', 'P', 'TXT');
	$db_ins['oneline_price2'] = cot_import('oneline_price2', 'P', 'TXT');
	$db_ins['oneline_text'] = cot_import('oneline_text', 'P', 'TXT');
	$db_ins['oneline_link'] = cot_import('oneline_link', 'P', 'TXT');
	$db_ins['oneline_section'] = cot_import('oneline_section', 'P', 'TXT');
	
	if(!empty($db_ins['oneline_text'])) {
		$db->insert($db_oneline, $db_ins);
		$_SESSION['filter'] = '';
	}
	else {
		cot_error('oneline_empty', 'oneline_disc');
	}
	cot_redirect(cot_url('admin', 'm=other&p=oneline', '', true));
}

($_SESSION['filter']) ? $where = 'WHERE oneline_section = "'.$_SESSION['filter'].'"' : $where = '';

$ttl = $db->query("SELECT COUNT(*) FROM $db_oneline $where")->fetchColumn();
($ttl > 0) ? $sql_order = 'ORDER BY oneline_id DESC' : '';

$sql = $db->query("SELECT * FROM $db_oneline $where $sql_order $sql_limit");
$ii = 0;

foreach ($sql->fetchAll() as $row) {
	$ii++;
	$t->assign(array(
		
		'ONELINE_FILTER_SELECT' => cot_selectbox($_SESSION['filter'], 'oneline_filter', $oneline_cats, $oneline_cats_titles, true, 'class="form-control" style="width:auto; float:left;"'),
		'ONELINE_FILTER_VALUE' => $_SESSION['filter'],
		
		'ONELINE_DATE' => cot_selectbox_date((int)$row['oneline_date'], 'short', 'oneline_date['.$row['oneline_id'].']', 2030, 2016, true, 'input_date_short'),
		
		'ONELINE_PRICE1' => cot_inputbox('text', 'oneline_price1['.$row['oneline_id'].']', $row['oneline_price1'], 'class="form-control"'),
		'ONELINE_PRICE1_RAW' => $row['oneline_price1'],
		
		'ONELINE_PRICE2' => cot_inputbox('text', 'oneline_price2['.$row['oneline_id'].']', $row['oneline_price2'], 'class="form-control"'),
		'ONELINE_PRICE2_RAW' => $row['oneline_price2'],
		
		'ONELINE_TEXT' => cot_inputbox('text', 'oneline_text['.$row['oneline_id'].']', $row['oneline_text'], 'class="form-control"'),
		'ONELINE_TEXT_RAW' => $row['oneline_text'],
		
		'ONELINE_LINK' => cot_inputbox('text', 'oneline_link['.$row['oneline_id'].']', $row['oneline_link'], 'class="form-control"'),
		'ONELINE_LINK_RAW' => $row['oneline_link'],
		
		'ONELINE_SECTION' => cot_selectbox($row['oneline_section'], 'oneline_section['.$row['oneline_id'].']', $oneline_cats, $oneline_cats_titles, true, 'class="form-control" style="width:100%;"'),
		'ONELINE_SECTION_RAW' => $row['oneline_section'],
		
		'ONELINE_DELURL' => cot_url('admin', 'm=other&p=oneline&a=delete&id='.$row['oneline_id'].'&'.cot_xg()),
		'ONELINE_ID' => $row['oneline_id'],
		'ONELINE_NUM' => $d + $ii,
		'ONELINE_ODDEVEN' => cot_build_oddeven($ii)
	));
	$t->parse('MAIN.ONELINE_ROW');
}

if ($ii == 0) {
	$t->parse('MAIN.ONELINE_NOROW');
}

$t->assign(array(
	'ONELINE_ADDURL' => cot_url('admin', 'm=other&p=oneline&a=add'),
	'ONELINE_ADDDATE' => cot_selectbox_date($sys['now'], 'long', 'oneline_date', 2030, 2016, true, ''),
	'ONELINE_ADDPRICE1' => cot_inputbox('text', 'oneline_price1', '', 'class="form-control"'),
	'ONELINE_ADDPRICE2' => cot_inputbox('text', 'oneline_price2', '', 'class="form-control"'),
	'ONELINE_ADDTEXT' => cot_inputbox('text', 'oneline_text', '', 'class="form-control"'),
	'ONELINE_ADDLINK' => cot_inputbox('text', 'oneline_link', '', 'class="form-control"'),
	'ONELINE_ADDSECTION' => cot_selectbox('', 'oneline_section', $oneline_cats, $oneline_cats_titles, true, 'class="form-control"')
));

$t->assign('ONELINE_UPDURL', cot_url('admin', 'm=other&p=oneline&a=update'));

$pagenav = cot_pagenav('admin', 'm=other&p=oneline', $d, $ttl, $mrp);
$t->assign(array(
	'ONELINE_PREV'			=> $pagenav['prev'],
	'ONELINE_PAGINATION'	=> $pagenav['main'],
	'ONELINE_NEXT'			=> $pagenav['next'],
	'ONELINE_TOTAL'			=> $pagenav['entries'],
	'ONELINE_ONPAGE'		=> $pagenav['onpage']
));

cot_display_messages($t);

$t->parse('MAIN');

if (COT_AJAX) {
	$t->out('MAIN');
}
else {
	$adminmain = $t->text('MAIN');
}
