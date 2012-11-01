<?php
/*if(empty($_REQUEST['certificateID'])&&empty($_REQUEST['certificateType'])&&empty($_REQUEST['lon'])&&empty($_REQUEST['lat'])){
	$quan=array('code'=>4);
	echo(json_encode($quan));
	exit();
}*/
require_once(dirname(dirname(__FILE__)) . '/app.php');
$lon=trim($_GET['lon']);
$lat=trim($_GET['lat']);
$partners = DB::LimitQuery('partner', array(
//	'size' => $limit,
//	'offset' => $offset,
));
array_filter($partners,"psel");



$teams = DB::LimitQuery('team', array(
	'condition' => $condition,
	'order' => 'ORDER BY begin_time DESC, sort_order DESC, id DESC',
	'size' => $limit,
//	'offset' => $offset,
));

function psel($arr){
   foreach($arr as $key=>$value){
		$str=array();
		list($longi,$lati) = preg_split('/[,\s]+/',$value['longlat'],-1,PREG_SPLIT_NO_EMPTY);
		if(($longi>($lon-10)&&$longi<($lon+10))&&($lati>($lat-10)&&$lati<($lat+10))){
			return true;
		}
		return false; 
	} 
	
}
print_r($partners);
/*echo("<br>");
print_r($teams); */
?>