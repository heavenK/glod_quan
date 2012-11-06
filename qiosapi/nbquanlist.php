<?php
if(empty($_REQUEST['certificateID'])&&empty($_REQUEST['certificateType'])&&empty($_REQUEST['lon'])&&empty($_REQUEST['lat'])){
	$quan=array('code'=>4);
	echo(json_encode($quan));
	exit();
}
require_once(dirname(dirname(__FILE__)) . '/app.php');
$lon=trim($_REQUEST['lon']);
$lat=trim($_REQUEST['lat']);
$partners = DB::LimitQuery('partner', array(
//	'size' => $limit,
//	'offset' => $offset,
));
$pstr=array();
foreach($partners as $k=>$val){
	list($longi,$lati) = preg_split('/[,\s]+/',$val['longlat'],-1,PREG_SPLIT_NO_EMPTY);
	if(($longi>=($lon-0.01)&&$longi<($lon+0.05))&&($lati>=($lat-0.01)&&$lati<($lat+0.05))){
		$pstr[$val['id']]['lon']=$longi;
		$pstr[$val['id']]['lat']=$lati;
		$pstr[$val['id']]['addr']=$val['address'];
	}else{
		unset($partners[$k]);
	}
}
$partner_ids = Utility::GetColumn($partners, 'id');
//$teams = Table::Fetch('team', $partner_ids);
$partner_id=implode(',',$partner_ids);

$condition=array('partner_id in ('.$partner_id.')');

if($qid>0){
	$condition[]='`id`<='.$qid.'';
}
$limit=6;

$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY begin_time DESC, sort_order DESC, id DESC',
	'size' => $limit,
//	'offset' => $offset,
));

$quan=array('code'=>2,'certificates'=>array(),'hasmore'=>1);

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
	$lcondition=array('team_id'=>$value['id']);
	$count = Table::Count('likecoupon', $lcondition);
	$str['likeCnt']=$count;
	$str['address']=$pstr[$value['partner_id']]['addr'];
	$str['distance']=GetDistance($pstr[$value['partner_id']]['lat'],$pstr[$value['partner_id']]['lon'],$lat,$lon);
	array_push($quan['certificates'],$str);
}
if($count>$limit){
	$quan['hasmore']=1;
}else{
	$quan['hasmore']=0;
}

echo(json_encode($quan));

function rad($d)  
{  
    return $d * 3.1415926535898 / 180.0;  
}  
function GetDistance($lat1, $lng1, $lat2, $lng2)  
{  
    $EARTH_RADIUS = 6378.137;  
    $radLat1 = rad($lat1);  
    //echo $radLat1;  
   $radLat2 = rad($lat2);  
   $a = $radLat1 - $radLat2;  
   $b = rad($lng1) - rad($lng2);  
   $s = 2 * asin(sqrt(pow(sin($a/2),2) +  
    cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));  
   $s = $s *$EARTH_RADIUS;  
   $s = round($s * 10000) / 10000;  
   return $s;  
}  
?>