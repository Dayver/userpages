<?php
/* ====================
[BEGIN_COT_EXT]
Name=Userpages
Category=misc-ext
Description=Will display all the pages created by the user in his profile
Version=0.9.6
Date=2023-04-01
Author=Cotonti Team, esclkm, Alex, Dayver
Copyright=copyright (c) 2008 - 2022 Cotonti Team
Notes=BSD License
Auth_guests=R
Lock_guests=W12345A
Auth_members=R
Lock_members=W12345A
Requires_modules=page
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
countonpage=01:select:3,5,10,15,20,25,30,35,40:5:Displayed pages on page
ajax=02:radio::1:Turn on AJAX navigation
timeback=03:select:2,3,5,7,10,15,30:7:Period for stats count (in days)
[END_COT_EXT_CONFIG]
==================== */
defined('COT_CODE') or die('Wrong URL.');
