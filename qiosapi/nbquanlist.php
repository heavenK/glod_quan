<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$teams = DB::LimitQuery('partner', array(
	
//	'offset' => $offset,
));

$teamss = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY begin_time DESC, sort_order DESC, id DESC',
	'size' => $limit,
//	'offset' => $offset,
));
print_r($teams);
echo("<br>");
print_r($teamss); 
?>