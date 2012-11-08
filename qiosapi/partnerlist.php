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
$teamss = DB::LimitQuery('team', array(
	'condition' => array('partner_id'=>$partner_id),
));


foreach($partner as $key=>$value){
	$partner_arr=array();
	$partner_arr['sellerName']=$value['title'];
	$partner_arr['sellerImgURL']=$value['image'];
	$sortid=array(0=>$value['group_id']);
	$type = Table::Fetch('category', $sortid);
	$partner_arr['typeName']=$type[$value['group_id']]['name'];
	$partner_arr['aveCost']=$value['averagecost'];
	$lcondition=array('team_id'=>$qid);
	$count = Table::Count('likecoupon', $lcondition);
	$partner_arr['likeCnt']=$count;
	$partner_arr['sellerAddress']=$value['address'];
	list($longi,$lati) = preg_split('/[,\s]+/',$value['longlat'],-1,PREG_SPLIT_NO_EMPTY);
	$partner_arr['sellerLon']=$longi;
	$partner_arr['sellerLat']=$lati;
	$partner_arr['sellerTel']=$value['phone'];
	$partner_arr['cerContent']=$teams[0]['summary'];
	$partner_arr['cerValidityDate']=date("Y.m.d",$teams[0]['end_time']);
	$partner_arr['sellerContent']=$value['location'];
	$partner_arr['imgURLs']=array(array('imgURL'=>$value['image1']),array('imgURL'=>$value['image2']));
}
$partner_arr['code']=2;
echo(json_encode($partner_arr));
?>