<?php
/*if(empty($_REQUEST['certificateID'])&&empty($_REQUEST['certificateType'])&&empty($_REQUEST['type'])&&empty($_REQUEST['uid'])){
	$quan=array('code'=>4);
	echo(json_encode($quan));
	exit();
}*/
require_once(dirname(dirname(__FILE__)) . '/app.php');
if(trim($_REQUEST['certificateID'])>-1){
	$qid=trim($_REQUEST['certificateID']);
}
$imgtype=trim($_REQUEST['certificateType']);
$type=trim($_REQUEST['type']);
$uid=trim($_REQUEST['uid']);
$daytime = strtotime(date('Y-m-d'));
$condition = array(
	'user_id' => $uid,
//	'consume' => 'N',
	"expire_time >= {$daytime}",
);
if($qid>0){
	$condition[]='`team_id` <='.$qid.'';
}
$limit=6;
$coupons = DB::LimitQuery('coupon', array(
	'condition' => $condition,
	'order' => 'ORDER BY team_id DESC, create_time DESC',
	'size' => $limit,
//	'offset' => $offset,
));
print_r($coupons); 
$team_ids = Utility::GetColumn($coupons, 'team_id');
$count = Table::Count('team', $condition);
$teams = Table::Fetch('team', $team_ids);

$quan=array('code'=>2,'certificates'=>array());

foreach($teams as $key=>$value){
	$str=array();
	$str['certificateID']=$value['id'];
	if($imgtype==2){
		$str['imgURL']=team_image($value['image'], true);
	}else{
		$str['imgURL']=$value['image'];
		$str['imgURL1']=$value['image1'];
		$str['imgURL2']=$value['image2'];
	}
	$str['title']=$value['title'];
	$str['type']=$value['group_id'];
	$sortid=array(0=>$value['group_id']);
	$type = Table::Fetch('category', $sortid);
	$str['typeName']=$type[$value['group_id']]['name'];
	$str['likeCnt']=$value['now_number'];
	$str['content']=$value['summary'];
	array_push($quan['certificates'],$str);
}
if($count>$limit){
	$quan['hasmore']=1;
}else{
	$quan['hasmore']=0;
}
echo(json_encode($quan));

?>