<?php
if(empty($_REQUEST['certificateID'])&&empty($_REQUEST['certificateType'])&&empty($_REQUEST['type'])&&empty($_REQUEST['typeNum'])){
	$quan=array('code'=>4);
	echo(json_encode($quan));
	exit();
}
require_once(dirname(dirname(__FILE__)) . '/app.php');
$qid=trim($_GET['certificateID']);
$imgtype=trim($_GET['certificateType']);
$sort=trim($_GET['type']);
$sortid=trim($_GET['typeNum']);
if($qid>0){
	$condition=array('`id`<='.$qid.'');
}
if($sort==1){
	$condition['group_id']=$sortid;
}else if($sort==2){
	$partnerid=array(0=>$sortid);
	$partners = Table::Fetch('partner', $partnerid);
	$partner_ids = Utility::GetColumn($partners, 'id');
	$partner_id=implode(',',$partner_ids);
	$condition[]='partner_id in ('.$partner_id.')';
}
$city_id = abs(intval($city['id']));
$condition[] = "((city_ids like '%@{$city_id}@%' or city_ids like '%@0@%') or city_id in(0,{$city_id}))";
$limit=6;
$count = Table::Count('team', $condition);
$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY begin_time DESC, sort_order DESC, id DESC',
	'size' => $limit,
//	'offset' => $offset,
));
print_r($teams);
$quan=array('code'=>2,'certificates'=>array(),'hasmore'=>1);
$a=1;
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
		$sortid=array(0=>$value['group_id']);
		$type = Table::Fetch('category', $sortid);
		$str['typeName']=$type[$value['group_id']]['name'];
	}else if($sort==2){
		$str['type']=$partners['group_id'];
	}
	
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