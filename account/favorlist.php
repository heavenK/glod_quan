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
$team_ids = Utility::GetColumn($favors, 'team_id');
$teams = Table::Fetch('team', $team_ids);
$partner_ids = Utility::GetColumn($favors, 'partner_id');
$partners = Table::Fetch('partner', $partner_ids);
foreach($favors as $key=>$value){
	$favorss[$key]['team_id']=$value['team_id'];
	$favorss[$key]['title']=$teams[$value['team_id']]['title'];
	$favorss[$key]['partner']=$partners[$value['partner_id']]['title'];
	$favorss[$key]['expire_time']=$teams[$value['team_id']]['expire_time'];
}
$pagetitle = '喜欢的优惠券';
include template('favorite_index');
?>