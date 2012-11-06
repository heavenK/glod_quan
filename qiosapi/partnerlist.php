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
$partner_ids = Utility::GetColumn($teams, 'partner_id');
print_r($teams);
?>