<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=admin.home.sidepanel
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL');

global $Ls;

require_once cot_langfile('userpages', 'plug');
require_once cot_incfile('userpages', 'plug');

$timeback_interval = isset(cot::$cfg['plugin']['userpages']['timeback']) ? cot::$cfg['plugin']['userpages']['timeback'] : 7;
$timeback_interval_str = cot_declension($timeback_interval, $Ls['Days']);

$tt = new XTemplate(cot_tplfile('userpages.admin.home', 'plug', true));

	// $tt->assign(array(
	// 	'ADMIN_HOME_URL' => cot_url('admin', 'm=page'),
	// 	'ADMIN_HOME_PAGESQUEUED' => $pagesqueued
	// ));

$tt->parse('MAIN');
$line = $tt->text('MAIN');
