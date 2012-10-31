<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$searchName = isset($_GET['searchName'])?trim(strip_tags($_GET['searchName'])):'';
$condition[] = "( title like '%".mysql_escape_string($searchName)."%' )";
$city_id = abs(intval($city['id']));
$condition[] = "((city_ids like '%@{$city_id}@%' or city_ids like '%@0@%') or city_id in(0,{$city_id}))";
?>