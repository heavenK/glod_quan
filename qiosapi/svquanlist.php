<?php
if(empty($_REQUEST['certificateID'])&&empty($_REQUEST['certificateType'])){
	$quan=array('code'=>4);
	echo(json_encode($quan));
	exit();
}
require_once(dirname(dirname(__FILE__)) . '/app.php');
echo($_GET['certificateID']."--".$_GET['certificateType']);
if(trim($_GET['certificateID'])>0){
	$qid=trim($_GET['certificateID']);
}
$imgtype=trim($_GET['certificateType']);
if(!empty($qid)){
	$condition=array('id'=>$qid);
}else{
	$condition='';
}
$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY begin_time DESC, sort_order DESC, id DESC',
));
print_r($teams);
?>