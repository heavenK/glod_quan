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
$daytime = strtotime(date('Y-m-d'));
$condition = array(
	'user_id' => $uid,
//	'consume' => 'N',
	"expire_time >= {$daytime}",
);
if($qid>0){
	$condition[]='`team_id` <='.$qid.'';
}

$coupons = DB::LimitQuery('coupon', array(
	'condition' => $condition,
	'order' => 'ORDER BY team_id DESC, create_time DESC',
//	'size' => $pagesize,
//	'offset' => $offset,
));

$team_ids = Utility::GetColumn($coupons, 'team_id');
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
	if($sort==1){
		$str['type']=$value['group_id'];
	}else if($sort==2){
		$str['type']=$value['partner_id'];
	}
	
	$str['likeCnt']=$value['now_number'];
	$str['content']=$value['summary'];
	array_push($quan['certificates'],$str);
}

echo(json_encode($quan));

?>