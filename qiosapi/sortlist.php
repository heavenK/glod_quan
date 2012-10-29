<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$group = DB::LimitQuery('category', array(
	'condition' => array('zone'=>'group'),
	'order' => 'ORDER BY display ASC, sort_order DESC, id DESC',
));
$partner = DB::LimitQuery('category', array(
	'condition' => array('zone'=>'partner'),
	'order' => 'ORDER BY display ASC, sort_order DESC, id DESC',
));
print_r($group);
echo("<br>");
print_r($partner);
?>