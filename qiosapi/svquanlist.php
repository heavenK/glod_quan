<?php
if(empty($_REQUEST['certificateID'])&&empty($_REQUEST['certificateType'])){
	$quan=array('code'=>4);
	echo(json_encode($quan));
	exit();
}
require_once(dirname(dirname(__FILE__)) . '/app.php');
if(trim($_GET['certificateID'])>-1){
	$qid=trim($_GET['certificateID']);
}
$imgtype=trim($_GET['certificateType']);

/*$teams = DB::LimitQuery('team', array(
	'order' => 'ORDER BY begin_time DESC, sort_order DESC, id DESC',
));
$quan=array('certificates'=>array(),'hasmore'=1);
$a=1;
foreach($teams as $key=>$value){
	if(!empty($qid)&&$qid==$value['id']){
		$quan['certificates'][$a]['certificateID']=$value['id'];
		if($imgtype==2){
		//	$quan['certificates'][$a]['imgURL']=team_image($value['image'], true);
		}else{
			$quan['certificates'][$a]['imgURL']=$value['image'];
			$quan['certificates'][$a]['imgURL1']=$value['image1'];
			$quan['certificates'][$a]['imgURL2']=$value['image2'];
		}
		
		$quan['certificates'][$a]['title']=$value['title'];
		$quan['certificates'][$a]['type']=$value['group_id'];
		$quan['certificates'][$a]['likeCnt']=$value['now_number'];
		$quan['certificates'][$a]['content']=$value['summary'];
	}else{
		$quan['certificates'][$a]['certificateID']=$value['id'];
		if($imgtype==2){
		//	$quan['certificates'][$a]['imgURL']=team_image($value['image'], true);
		}else{
			$quan['certificates'][$a]['imgURL']=$value['image'];
			$quan['certificates'][$a]['imgURL1']=$value['image1'];
			$quan['certificates'][$a]['imgURL2']=$value['image2'];
		}
		
		$quan['certificates'][$a]['title']=$value['title'];
		$quan['certificates'][$a]['type']=$value['group_id'];
		$quan['certificates'][$a]['likeCnt']=$value['now_number'];
		$quan['certificates'][$a]['content']=$value['summary'];
		$a++;
	}
}*/
//echo(json_encode($quan));
?>