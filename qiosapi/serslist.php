<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$searchName = isset($_GET['searchTxt'])?trim(strip_tags($_GET['searchTxt'])):'';
$condition[] = "( title like '%".mysql_escape_string($searchName)."%' )";
$city_id = abs(intval($city['id']));
$condition[] = "((city_ids like '%@{$city_id}@%' or city_ids like '%@0@%') or city_id in(0,{$city_id}))";
$limit=2;
$count = Table::Count('team', $condition);
$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY begin_time DESC, sort_order DESC, id DESC',
	'size' => $limit,
//	'offset' => $offset,
));
$quan=array('code'=>2,'certificates'=>array());
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
	}else if($sort==2){
		$str['type']=$value['partner_id'];
	}
	
	$str['likeCnt']=$value['now_number'];
	$str['content']=$value['summary'];
	array_push($quan['certificates'],$str);
}

echo(json_encode($quan));
?>