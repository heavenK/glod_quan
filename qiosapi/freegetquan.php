<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
if(isset($_REQUEST['type'])&&$_REQUEST['type']=='M'){
	$user_id=isset($_REQUEST['userId'])?trim(strip_tags($_REQUEST['userId'])):'';
	$user_name=isset($_REQUEST['userName'])?trim(strip_tags($_REQUEST['userName'])):'';
	$qid=isset($_REQUEST['quanId'])?trim(strip_tags($_REQUEST['quanId'])):'';
	$phone=isset($_REQUEST['phone'])?trim(strip_tags($_REQUEST['quanId'])):'';
	$id = abs(intval($qid));
	$team = Table::Fetch('team', $id);
	if ( !$team || $team['begin_time']>time() ) {
		$back=array("message"=>"优惠券过期");
		echo(json_encode($back));
		exit();
	}
	$data['user_id']=$user_id;
	$data['user_name']=$user_name;
	$data['partner_id']=$team['partner_id'];
	$data['team_id']=$team['id'];
	$data['mobile']=$phone;
	$data['content']='测试短信，优惠券代码test123456789,感谢参与测试。';
	$data['create_time']=time();
	$res=sms_send($phone,$data['content']);
	if($res===true){
		$data['content']=iconv("utf8","gb2312",'测试短信，优惠券代码test123456789,感谢参与测试。');
		$data['state']=iconv("utf8","gb2312","发送成功");
		$insertid=DB::Insert('mobile_option', $data);
		if($insertid<1){
			$back=array("message"=>"系统错误");
			echo(json_encode($back));
			exit();
		}
		$back=array("message"=>"发送成功");
		echo(json_encode($back));
	}else{
		$data['content']=iconv("utf8","gb2312",'测试短信，优惠券代码test123456789,感谢参与测试。');
		$data['state']=iconv("utf8","gb2312",$res);
		$insertid=DB::Insert('mobile_option', $data);
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