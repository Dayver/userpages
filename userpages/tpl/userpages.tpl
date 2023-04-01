<!-- BEGIN: USERPAGES -->

	<!-- BEGIN: YES -->
	{UP_AJAX_BEGIN}
		{PHP.L.plu_sort_by} <a href="users.php?m=details&amp;id={UP_USER_ID}&amp;ps=date&amp;dp={UP_PAGE_ID}"{UP_ORDER_SET_DAT}>{PHP.L.plu_date}</a> | <a href="users.php?m=details&amp;id={UP_USER_ID}&amp;ps=cat&amp;dp={UP_PAGE_ID}"{UP_ORDER_SET_CAT}>{PHP.L.plu_category}</a><br />
		<!-- BEGIN: PAGES -->
		{UP_DATE} : {UP_TITLE}<br />
		<!-- END: PAGES -->
		<div class="pagnav">{UP_PAGENAV_PREV}&nbsp;{UP_PAGENAV}&nbsp;{UP_PAGENAV_NEXT}</div>
		{PHP.L.Total} : {UP_TOTALITEMS}, {PHP.L.Onpage} : {UP_COUNT_ON_PAGE}
	{UP_AJAX_END}
	<!-- END: YES -->

	<!-- BEGIN: NONE -->
	{PHP.L.None}
	<!-- END: NONE -->

<!-- END: USERPAGES -->