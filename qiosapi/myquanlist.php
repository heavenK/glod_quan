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
$count = Table::Count('coupon', $condition);
$coupons = DB::LimitQuery('coupon', array(
	'condition' => $condition,
	'order' => 'ORDER BY team_id DESC, create_time DESC',
	'size' => $limit,
//	'offset' => $offset,
));

$team_ids = Utility::GetColumn($coupons, 'team_id');

$teams = Table::Fetch('team', $team_ids);

$quan=array('code'=>2,'certificates'=>array(),'hasmore'=>1);

foreach($teams as $key=>$value){
	$str=array();
	$str['certificateID']=empty($value['id'])?0:$value['id'];
	if($imgtype==2){
		$str['imgURL']=empty($value['image'])?0:team_image($value['image'], true);
	}else{
		$str['imgURL']=empty($value['image'])?0:team_image($value['image']);
		$str['imgURL1']=empty($value['image1'])?0:team_image($value['image1']);
		$str['imgURL2']=empty($value['image2'])?0:team_image($value['image2']);
	}
	$str['title']=empty($value['title'])?0:$value['title'];
	$str['type']=empty($value['group_id'])?0:$value['group_id'];
	$sortid=array(0=>$value['group_id']);
	$type = Table::Fetch('category', $sortid);
	$str['typeName']=empty($type[$value['group_id']]['name'])?0:$type[$value['group_id']]['name'];
	$lcondition=array('team_id'=>$value['id']);
	$count = Table::Count('likecoupon', $lcondition);
	$str['likeCnt']=empty($count)?0:$count;
	$str['content']=empty($value['summary'])?0:$value['summary'];
	array_push($quan['certificates'],$str);
}
if($count>$limit){
	$quan['hasmore']=1;
}else{
	$quan['hasmore']=0;
}
echo(json_encode($quan));

?>