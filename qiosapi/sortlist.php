<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY begin_time DESC, sort_order DESC, id DESC',
));
$categories = DB::LimitQuery('category', array(
	'condition' => $condition,
	'order' => 'ORDER BY display ASC, sort_order DESC, id DESC',
));
print_r($categories);
echo("/r/n");
print_r($teams);
?>