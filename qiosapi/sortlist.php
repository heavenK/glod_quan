<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$teams = DB::LimitQuery('team', array(
	'condition' => array('zone'=>'group'),
	'order' => 'ORDER BY begin_time DESC, sort_order DESC, id DESC',
));
$categories = DB::LimitQuery('category', array(

	'order' => 'ORDER BY display ASC, sort_order DESC, id DESC',
));
print_r($categories);
echo("<br>");
print_r($teams);
?>