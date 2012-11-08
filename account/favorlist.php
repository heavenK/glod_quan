<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
need_login();
$condition = array(
	'user_id' => $login_user_id,
);
$count = Table::Count('coupon', $condition);
list($pagesize, $offset, $pagestring) = pagestring($count, 10);
$favors=DB::LimitQuery('likecoupon', array(
	'condition' => $condition,
	'order' => 'ORDER BY team_id DESC, create_time DESC',
	'size' => $pagesize,
	'offset' => $offset,
));
foreach($favors as $key=>$value){
	$teams=Table::Fetch('team', $value['team_id']);
	print_r($teams);
}
?>