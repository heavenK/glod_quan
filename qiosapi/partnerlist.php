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
	$partner_arr['sellerName']=empty($value['title'])?0:$value['title'];
	$partner_arr['sellerImgURL']=empty($value['image'])?0:team_image($value['image']);
	$sortid=array(0=>$value['group_id']);
	$type = Table::Fetch('category', $sortid);
	$partner_arr['typeName']=empty($type[$value['group_id']]['name'])?0:$type[$value['group_id']]['name'];
	$partner_arr['aveCost']=empty($value['averagecost'])?0:$value['averagecost'];
	$lcondition=array('team_id'=>$qid);
	$count = Table::Count('likecoupon', $lcondition);
	$partner_arr['likeCnt']=empty($count)?0:$count;
	$partner_arr['sellerAddress']=empty($value['address'])?0:$value['address'];
	list($longi,$lati) = preg_split('/[,\s]+/',$value['longlat'],-1,PREG_SPLIT_NO_EMPTY);
	$partner_arr['sellerLon']=empty($longi)?0:(float)$longi;
	$partner_arr['sellerLat']=empty($lati)?0:(float)$lati;
//	$partner_arr['sellerLon']=38.858822;
//	$partner_arr['sellerLat']=121.514753;
	$partner_arr['sellerTel']=empty($value['phone'])?0:$value['phone'];
	$partner_arr['cerContent']=empty($teams[0]['summary'])?0:strip_tags($teams[0]['summary']);
	$partner_arr['cerValidityDate']=empty($teams[0]['end_time'])?0:date("Y.m.d",$teams[0]['end_time']);
	if($teams[0]['delivery']=='voucher'){
		$partner_arr['cerDelivery']=1;
	}else if($teams[0]['delivery']=='express'){
		$partner_arr['cerDelivery']=2;
	}else{
		$partner_arr['cerDelivery']=0;
	}
	$partner_arr['sellerContent']=empty($value['location'])?0:strip_tags($value['location']);
	$image1=empty($value['image1'])?0:team_image($value['image1']);
	$image2=empty($value['image2'])?0:team_image($value['image2']);
	$image3=empty($value['image3'])?0:team_image($value['image3']);
	$image4=empty($value['image4'])?0:team_image($value['image4']);
	$image5=empty($value['image5'])?0:team_image($value['image5']);
	$image6=empty($value['image6'])?0:team_image($value['image6']);
	$image7=empty($value['image7'])?0:team_image($value['image7']);
	$image8=empty($value['image8'])?0:team_image($value['image8']);
	$image9=empty($value['image9'])?0:team_image($value['image9']);
	$image10=empty($value['image10'])?0:team_image($value['image10']);
	$image11=empty($value['image11'])?0:team_image($value['image11']);
	$image12=empty($value['image12'])?0:team_image($value['image12']);
	$partner_arr['imgURLs']=array(array('imgURL'=>$image1),array('imgURL'=>$image2),array('imgURL'=>$image3),array('imgURL'=>$image4),array('imgURL'=>$image5),array('imgURL'=>$image6),array('imgURL'=>$image7),array('imgURL'=>$image8),array('imgURL'=>$image9),array('imgURL'=>$image10),array('imgURL'=>$image11),array('imgURL'=>$image12));
}
$partner_arr['code']=2;
echo(json_encode($partner_arr));
?>