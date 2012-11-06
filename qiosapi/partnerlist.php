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
foreach($teams as $key=>$value){
	$partner_id=$value['partner_id'];
}
$p_condition=array('id'=>$partner_id);
$partner=DB::LimitQuery('partner', array(
	'condition' => $p_condition,
));

print_r($teams);
echo("<br>");
print_r($partner);
?>