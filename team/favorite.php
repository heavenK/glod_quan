<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
need_login();
$id = abs(intval($_GET['id']));
$team = Table::Fetch('team', $id);
if ( !$team || $team['begin_time']>time() ) {
	Session::Set('error', '�Ź���Ŀ������');
	redirect( WEB_ROOT . '/index.php' );
}
$data['user_id']=$login_user_id;
$data['user_name']=$login_user['username'];
$data['partner_id']=$team['partner_id'];
$data['team_id']=$team['id'];
$data['create_time']=time();
$insertid=DB::Insert('likecoupon', $data);
print_r($insertid);
?>