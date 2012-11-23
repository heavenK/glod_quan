<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$searchName = isset($_REQUEST['searchTxt'])?trim(strip_tags($_REQUEST['searchTxt'])):'';
$condition[] = "( title like '%".mysql_escape_string($searchName)."%' )";
$city_id = abs(intval($city['id']));
$condition[] = "((city_ids like '%@{$city_id}@%' or city_ids like '%@0@%') or city_id in(0,{$city_id}))";

$count = Table::Count('team', $condition);
$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY begin_time DESC, sort_order DESC, id DESC',
//	'offset' => $offset,
));
$quan=array('code'=>2,'certificates'=>array());
$a=1;
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
	$str['typeName']=$str['typeName']=empty($type[$value['group_id']]['name'])?0:$type[$value['group_id']]['name'];
	$lcondition=array('team_id'=>$value['id']);
	$count = Table::Count('likecoupon', $lcondition);
	$str['likeCnt']=empty($count)?0:$count;
	$str['content']=empty($value['summary'])?0:$value['summary'];
	array_push($quan['certificates'],$str);
}

echo(json_encode($quan));
?>