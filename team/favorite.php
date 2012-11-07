<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$id = abs(intval($_GET['id']));
$team = Table::Fetch('team', $id);
if ( !$team || $team['begin_time']>time() ) {
	Session::Set('error', '团购项目不存在');
	redirect( WEB_ROOT . '/index.php' );
}
echo($login_user_id);
print_r($login_user);
?>