<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=users.details.tags, ajax
Tags=users.details.tpl:{USERS_DETAILS_USERPAGES}
[END_COT_EXT]
==================== */
defined('COT_CODE') or die('Wrong URL.');

require_once cot_langfile('userpages');

$user_pages = new XTemplate(cot_tplfile('userpages', 'plug'));

$ownerId = null;
if (cot_module_active('page')) {
    if (isset($urr) && !empty($urr['user_id'])) {
        // In user details page
        $ownerId = (int) $urr['user_id'];

    } elseif (COT_AJAX) {
        // Ajax
        $id = cot_import('id', 'G', 'INT');
        if ($id) {
            $sql = cot::$db->query('SELECT user_id FROM ' . cot::$db->users . " WHERE user_id='$id' LIMIT 1");
            if ($sql->rowCount() > 0) {
                $ownerId = $id;
            }
        }
    }
}

if (cot_module_active('page') && !empty($ownerId)) {
	require_once cot_incfile('page', 'module');
	$ps = cot_import('ps', 'G', 'ALP');
	$ps = empty($ps) ? 'date' : $ps;
	$dp = cot_import('dp', 'G', 'INT');
	$dp = empty($dp) ? 0 : (int) $dp;
	list($pnp, $dp, $dp_url) = cot_import_pagenav('dp', cot::$cfg['plugin']['userpages']['countonpage']);

	$totalitems = cot::$db->query("SELECT COUNT(*) FROM " . cot::$db->pages .
        " WHERE page_state=0 AND page_cat NOT LIKE 'system' AND page_ownerid='$ownerId'")->fetchColumn();

    $up_ajax_begin = '';
    $up_ajax_end = '';
	if (cot::$cfg['plugin']['userpages']['ajax'] && !COT_AJAX) {
		$up_ajax_begin = "<div id='reloadp'>";
		$up_ajax_end = "</div>";
	}

    $pageNavParams = ['m' => 'details', 'id' => $ownerId, 'ps' => $ps];
	$pagenav = cot_pagenav(
        'users',
        ['m' => 'details', 'id' => $ownerId, 'ps' => $ps],
        $dp,
        $totalitems,
        cot::$cfg['plugin']['userpages']['countonpage'],
        'dp',
        '',
        cot::$cfg['plugin']['userpages']['ajax'],
        "reloadp",
        'plug',
        ['r' => 'userpages', 'id' => $ownerId, 'ps' => $ps]
    );

	$stlcat = 'normal';
	$stldat = 'normal';
    $order = 'page_date DESC';

	if ($ps == 'cat') {
		$order = 'page_cat ASC';
		$stlcat = 'bold';
	} elseif ($ps == 'date') {
		$order = 'page_date DESC';
		$stldat = 'bold';
	}

	$sqluserpages = cot::$db->query('SELECT * FROM ' . cot::$db->pages .
        " WHERE page_state=0 AND page_cat <> 'system' AND page_ownerid='" . $ownerId .
        "' ORDER BY $order LIMIT " . cot::$cfg['plugin']['userpages']['countonpage']. " OFFSET $dp");

	if ($sqluserpages->rowCount() == 0) {
		$user_pages->parse("USERPAGES.NONE");

	} else {
		$jj = 0;
		while ($row = $sqluserpages->fetch()) {
			if (cot_auth('page', $row['page_cat'], 'R')) {
				$jj++;
				$user_pages->assign(cot_generate_pagetags($row, 'UP_'));
				$user_pages->assign(array(
					'UP_ODDEVEN' => cot_build_oddeven($jj),
					'UP_NUM' => $jj
				));
				$user_pages->parse("USERPAGES.YES.PAGES");
			}
		}

        $setDat = ' style="font-weight:' . $stldat . '"';
        $setCat = ' style="font-weight:' . $stlcat . '"';
        if (cot::$cfg['plugin']['userpages']['ajax']) {
            $setDat = " OnClick=\"return ajaxSend({url: '" . cot_url('plug', ['r' => 'userpages', 'id' => $ownerId, 'ps' => 'date']) .
                "', data: '&dp=" . $dp_url . "', divId: 'reloadp', errMsg: '" . cot::$L['plu_msg500'] . "'});\" " .
                'style="font-weight:' . $stldat . '"';

            $setCat = " OnClick=\"return ajaxSend({url: '" . cot_url('plug', ['r' => 'userpages', 'id' => $ownerId, 'ps' => 'cat']) .
                "', data: '&dp=" . $dp_url . "', divId: 'reloadp', errMsg: '" . cot::$L['plu_msg500'] . "'});\" " .
                'style="font-weight:' . $stlcat . '"';
        }

		$user_pages->assign(array(
			"UP_AJAX_BEGIN" => $up_ajax_begin,
			"UP_AJAX_END" => $up_ajax_end,
			"UP_PAGENAV" => $pagenav['main'],
			"UP_PAGENAV_PREV" => $pagenav['prev'],
			"UP_PAGENAV_NEXT" => $pagenav['next'],
			"UP_TOTALITEMS" => $totalitems,
			"UP_COUNT_ON_PAGE" => $jj,
			"UP_USER_ID" => $ownerId,
			"UP_PAGE_ID" => $dp,
			"UP_ORDER_SET_DAT" => $setDat,
			"UP_ORDER_SET_CAT" => $setCat,
		));
		$user_pages->parse("USERPAGES.YES");
	}
} else {
	$user_pages->parse("USERPAGES.NONE");
}

$user_pages->parse("USERPAGES");
$user_pag = $user_pages->text("USERPAGES");

if(!defined('COT_PLUG')) {
	$t->assign(array("USERS_DETAILS_USERPAGES" => $user_pag));
} else {
	cot_sendheaders();
	echo $user_pag;
}
