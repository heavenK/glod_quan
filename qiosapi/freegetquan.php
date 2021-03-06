<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
if(isset($_REQUEST['type'])&&$_REQUEST['type']=='M'){
	$user_id=isset($_REQUEST['userId'])?trim(strip_tags($_REQUEST['userId'])):'';
	$user_name=isset($_REQUEST['userName'])?trim(strip_tags($_REQUEST['userName'])):'';
	$qid=isset($_REQUEST['quanId'])?trim(strip_tags($_REQUEST['quanId'])):'';
	$phone=isset($_REQUEST['phone'])?trim(strip_tags($_REQUEST['phone'])):'';
	$id = abs(intval($qid));
	$team = Table::Fetch('team', $id);
	if ( !$team || $team['begin_time']>time() ) {
		$back=array("message"=>"优惠券过期");
		echo(json_encode($back));
		exit();
	}

	if($INI['sms']['numbers'] =='' || $INI['sms']['numbers']=='0') {
		 $sms_number = 5;
	} else {	
	     $sms_number = $INI['sms']['numbers']; 
	}
	$data['user_id']=$user_id;
	$data['user_name']=$user_name;
	$data['partner_id']=$team['partner_id'];
	$data['team_id']=$team['id'];
	$data['mobile']=$phone;
	$data['content']='测试短信，优惠券代码test123456789,感谢参与测试。';
	$data['create_time']=time();
	$condition=array(
					'team_id'=>$team['id'],
					'mobile'=>$phone
	);
	$count = Table::Count('mobile_option', $condition);
	if ( $count>=$sms_number) {
		$back=array("message"=>'短信发送优惠券最多'.$sms_number.'次');
		echo(json_encode($back));
		exit();
	}
	$res=sms_send($phone,$data['content']);
	if($res===true){
		$data['state']="发送成功";
		$insertid=DB::Insert('mobile_option', $data);
		if($insertid<1){
			$back=array("message"=>"系统错误");
			echo(json_encode($back));
			exit();
		}
		$back=array("message"=>"发送成功");
		echo(json_encode($back));
	}else{
		$data['state']=$res;
		$insertid=DB::Insert('mobile_option', $data);
		if($insertid<1){
			$back=array("message"=>"系统错误");
			echo(json_encode($back));
			exit();
		}
		$back=array("message"=>$res);
		echo(json_encode($back));
	}

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
	$data['state']=1;
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