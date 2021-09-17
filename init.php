<?php
ini_set('display_errors','on');
error_reporting(E_ALL);
include "admin/connect.php";
$lang="includes/langs/";
$fun="includes/functions/";
$tmp="includes/templates";
$css="layout/css";
$js="layout/js";
// include the  navbar but not in the first page and include the header and the footer
// include $fun."function.php";
include $fun.'function.php';
include $tmp."/header.php";
include $lang."English.php";
