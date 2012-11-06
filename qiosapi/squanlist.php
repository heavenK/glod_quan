<?php
if(empty($_REQUEST['certificateID'])&&empty($_REQUEST['certificateType'])&&empty($_REQUEST['type'])&&empty($_REQUEST['typeNum'])){
	$quan=array('code'=>4);
	echo(json_encode($quan));
	exit();
}
require_once(dirname(dirname(__FILE__)) . '/app.php');
$qid=trim($_REQUEST['certificateID']);
$imgtype=trim($_REQUEST['certificateType']);
$sort=trim($_REQUEST['type']);
$sortid=trim($_REQUEST['typeNum']);

if($qid>0){
	$condition=array('`id`<='.$qid.'');
}
if($sort==1){
	$condition['group_id']=$sortid;
}else if($sort==2){
	$partners = DB::LimitQuery('partner', array(
		'condition' => array('group_id'=>$sortid),
		'order' => 'ORDER BY head DESC, id DESC',
	));
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
		foreach($partners as $pkey=>$pvalue){
			if($value['partner_id']==$pvalue['id']){
				$str['type']=$pvalue['group_id'];
			}
		}
	}
	$lcondition=array('team_id'=>$value['id']);
	$count = Table::Count('likecoupon', $lcondition);
	$str['likeCnt']=$count;
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