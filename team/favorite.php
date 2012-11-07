<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$id = abs(intval($_GET['id']));
$team = Table::Fetch('team', $id);
if ( !$team || $team['begin_time']>time() ) {
	Session::Set('error', '团购项目不存在');
	redirect( WEB_ROOT . '/index.php' );
}
$data['user_id']=$login_user_id;
$data['user_name']=$login_user['username'];
$data['partner_id']='';
print_r($team);
?>