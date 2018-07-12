<?php
/* ====================
[BEGIN_COT_EXT]
Code=oneline
Name=One Line Info
Description=Short One-Line News and Promotions
Version=2.00
Date=2017-1-01
Category=
Author=Dmitri Beliavski
Copyright=&copy; Seditio.by 2017
Notes=
Auth_guests=R
Lock_guests=WA12345
Auth_members=R
Lock_members=WA12345
[END_COT_EXT]
[BEGIN_COT_EXT_CONFIG]
code=00:string::sample:Custom Code for Settings
pagination=01:select:0,5,10,15,20,50:0:News on page (0 viewall)
showopen=02:radio::1:Show open button
display_date=03:radio::1:Display date
display_price1=04:radio::1:Display price No.1
display_price1a=05:radio::1:Display price No.1a
display_price2=06:radio::1:Display price No.2
display_price2a=07:radio::1:Display price No.2a
display_text=08:radio::1:Display text
display_extra1=09:radio::1:Display extra text field No.1
display_extra2=10:radio::1:Display extra text field No.2
display_link=11:radio::1:Display link
[END_COT_EXT_CONFIG]
==================== */

/**
 * Oneline Plugin
 *
 * @package oneline
 * @version 2.00
 * @author Dmitri Beliavski
 * @copyright (c) seditio.by 2017
 */

defined('COT_CODE') or die('Wrong URL');
