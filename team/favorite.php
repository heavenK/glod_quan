<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
if(isset($_REQUEST['type'])&&$_REQUEST['type']=='M'){
	$user_id=isset($_REQUEST['userId'])?trim(strip_tags($_REQUEST['userId'])):'';
	$user_name=isset($_REQUEST['userName'])?trim(strip_tags($_REQUEST['userName'])):'';
	$qid=isset($_REQUEST['quanId'])?trim(strip_tags($_REQUEST['quanId'])):'';
	$id = abs(intval($qid));
	$team = Table::Fetch('team', $id);
	if ( !$team || $team['begin_time']>time() ) {
		$back=array("isFavor"=>3);
		echo(json_encode($back));
		exit();
	}
	$data['user_id']=$user_id;
	$data['user_name']=$user_name;
	$data['partner_id']=$team['partner_id'];
	$data['team_id']=$team['id'];
	$data['create_time']=time();
	$condition=array('user_id'=>$user_id,
					'user_name'=>$user_name,
					'team_id'=>$team['id']
					);
	$favor=DB::LimitQuery('likecoupon', array(
		'condition' => $condition,
	));
	if(!empty($favor)){
		$back=array("isFavor"=>4);
		echo(json_encode($back));
		exit();
	}
	$insertid=DB::Insert('likecoupon', $data);
	if($insertid>0){
		$back=array("isFavor"=>1);
		echo(json_encode($back));
		exit();
	}else{
		$back=array("isFavor"=>0);
		echo(json_encode($back));
		exit();
	}
}else{
	need_login();
	$id = abs(intval($_GET['id']));
	$team = Table::Fetch('team', $id);

	if ( !$team || $team['begin_time']>time() ) {
		Session::Set('error', '团购项目不存在');
		redirect( WEB_ROOT . '/index.php' );
	}
	$data['user_id']=$login_user_id;
	$data['user_name']=$login_user['username'];
	$data['partner_id']=$team['partner_id'];
	$data['team_id']=$team['id'];
	$data['create_time']=time();
	$condition=array('user_id'=>$login_user_id,
					'user_name'=>$login_user['username'],
					'team_id'=>$team['id']
					);
	$favor=DB::LimitQuery('likecoupon', array(
		'condition' => $condition,
	));
	if(!empty($favor)){
		Session::Set('error', '金券已收藏！');
		redirect( WEB_ROOT . "/team.php?id={$id}");
	}
	$insertid=DB::Insert('likecoupon', $data);
	Session::Set('notice', "收藏成功！");
	redirect( WEB_ROOT . "/team.php?id={$id}");
}

?>