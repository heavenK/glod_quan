<?php
if(empty($_REQUEST['certificateID'])&&empty($_REQUEST['certificateType'])&&empty($_REQUEST['lon'])&&empty($_REQUEST['lat'])){
	$quan=array('code'=>4);
	echo(json_encode($quan));
	exit();
}
require_once(dirname(dirname(__FILE__)) . '/app.php');
$longlat=trim($_GET['lon']).','.trim($_GET['lat']);
$teams = DB::LimitQuery('partner', array(
//	'size' => $limit,
//	'offset' => $offset,
));
foreach($teams as $key=>$value){
	list($longi,$lati) = preg_split('/[,\s]+/',$value['longlat'],-1,PREG_SPLIT_NO_EMPTY);
	echo($longi."--".$lati."<br>");
}


$teamss = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY begin_time DESC, sort_order DESC, id DESC',
	'size' => $limit,
//	'offset' => $offset,
));
print_r($teams);
echo("<br>");
print_r($teamss); 
?>