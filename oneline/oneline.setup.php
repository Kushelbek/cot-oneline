<?php
/**
[BEGIN_COT_EXT]
Code=oneline
Name=One Line Info
Description=Short One-Line News and Promotions
Version=1.02
Date=2017-04-15
Author=Dmitri Beliavski
Copyright=&copy; Seditio.by 2017
Auth_guests=R
Lock_guests=WA12345
Auth_members=R
Lock_members=WA12345
Requires_plugins=
[END_COT_EXT]
[BEGIN_COT_EXT_CONFIG]
code=00:string::sample:Custom Code for Settings
pagination=01:select:0,5,10,15,20,50:0:News on page (0 viewall)
showopen=02:radio::1:Show open button
display_date=03:radio::1:Display date
display_price1=04:radio::1:Display price No.1
display_price2=05:radio::1:Display price No.2
display_text=06:radio::1:Display text
display_link=07:radio::1:Display link
[END_COT_EXT_CONFIG]
*/

defined('COT_CODE') or die('Wrong URL');
