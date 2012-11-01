<?php
/*if(empty($_REQUEST['certificateID'])&&empty($_REQUEST['certificateType'])&&empty($_REQUEST['type'])&&empty($_REQUEST['uid'])){
	$quan=array('code'=>4);
	echo(json_encode($quan));
	exit();
}*/
require_once(dirname(dirname(__FILE__)) . '/app.php');
if(trim($_GET['certificateID'])>-1){
	$qid=trim($_GET['certificateID']);
}
$imgtype=trim($_GET['certificateType']);
$type=trim($_GET['type']);
$uid=trim($_GET['uid']);

$condition = array(
	'user_id' => $uid,
//	'consume' => 'N',
//	"expire_time >= {$daytime}",
);
$coupons = DB::LimitQuery('coupon', array(
	'condition' => $condition,
	'order' => 'ORDER BY team_id DESC, create_time DESC',
//	'size' => $pagesize,
//	'offset' => $offset,
));
print_r($coupons);
?>