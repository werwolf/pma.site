<?php
if (!defined("PROPER_INCLUDE"))die;

recurs_menu(get_dbdb($db,i18n::getLanguage()),0,&$static_pagess,0);

$View->site_map = $static_pagess."<li><a href=/".i18n::getLanguage()."/news>".i18n::get("news")."</a></li>";
$View->image_bottom = "main";
?>
