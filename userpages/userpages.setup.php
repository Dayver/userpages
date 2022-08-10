<?php
/* ====================
[BEGIN_COT_EXT]
Code=userpages
Name=Userpages
Description=Will display all the pages created by the user in his profile
Version=0.9.5
Date=2022-aug-09
Author=Cotonti Team, esclkm, Alex
Copyright=copyright (c) 2008 - 2022 Cotonti Team
Notes=BSD License
SQL=
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=W12345A
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
countonpage=01:select:3,5,10,15,20,25,30,35,40:5:Displayed pages on page
ajax=02:radio::1:Turn on AJAX navigation
[END_COT_EXT_CONFIG]
==================== */
defined('COT_CODE') or die('Wrong URL.');
