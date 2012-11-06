<?php
if(empty($_REQUEST['certificateID'])){
	$quan=array('code'=>4);
	echo(json_encode($quan));
	exit();
}
require_once(dirname(dirname(__FILE__)) . '/app.php');
$qid=isset($_REQUEST['certificateID'])?trim(strip_tags($_REQUEST['certificateID'])):'';
$condition=array('id'=>$qid);
$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
));
foreach($teams as $key=>$value){
	$partner_id=$value['partner_id'];
}
$p_condition=array('id'=>$partner_id);
$partner=DB::LimitQuery('partner', array(
	'condition' => $p_condition,
));
$partner_ids = Utility::GetColumn($partners, 'id');
$teamss = Table::Fetch('team', $partner_ids);

$partner_arr=array('code'=>2,'certificates'=>array());
foreach($partner as $key=>$value){
	$str=array();
	$str['sellerName']=$value['title'];
	$str['sellerImgURL']=$value['image'];
	$sortid=array(0=>$value['group_id']);
	$type = Table::Fetch('category', $sortid);
	$str['typeName']=$type[$value['group_id']]['name'];
	$str['aveCost']=$value['title'];

	

	$str['likeCnt']=$value['title'];
	$str['sellerAddress']=$value['address'];
	list($longi,$lati) = preg_split('/[,\s]+/',$value['longlat'],-1,PREG_SPLIT_NO_EMPTY);
	$str['sellerLon']=$longi;
	$str['sellerLat']=$lati;
	$str['sellerTel']=$value['phone'];
	$str['cerContent']=$teams[0]['summary'];
	$str['cerValidityDate']=date("Y.m.d",$teams[0]['end_time']);
	$str['sellerContent']=$value['location'];
	$str['imgURLs']=array($value['image1'],$value['image2']);
}
print_r($teamss);
echo("<br>");
print_r($partner);
?>