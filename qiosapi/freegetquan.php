<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
if(isset($_REQUEST['type'])&&$_REQUEST['type']=='M'){

}else if(isset($_REQUEST['type'])&&$_REQUEST['type']=='P'){
	$user_id=isset($_REQUEST['userId'])?trim(strip_tags($_REQUEST['userId'])):'';
	$user_name=isset($_REQUEST['userName'])?trim(strip_tags($_REQUEST['userName'])):'';
	$qid=isset($_REQUEST['quanId'])?trim(strip_tags($_REQUEST['quanId'])):'';
	$id = abs(intval($qid));
	$team = Table::Fetch('team', $id);
	if ( !$team || $team['begin_time']>time() ) {
		$back=array("err"=>1);
		echo(json_encode($back));
		exit();
	}
	$data['user_id']=$user_id;
	$data['user_name']=$user_name;
	$data['partner_id']=$team['partner_id'];
	$data['team_id']=$team['id'];
	$data['create_time']=time();
	if(empty($team['qimage'])){
		$back=array('err'=>2);
		echo(json_encode($back));
		exit();
	}
	$image=team_image($team['qimage']);
	$insertid=DB::Insert('mobile_option', $data);
	if($insertid>0){
		$back=array('image'=>$image);
		echo(json_encode($back));
	}else{
		$back=array("err"=>0);
		echo(json_encode($back));
	}
}
?>