<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$group = DB::LimitQuery('category', array(
	'condition' => array('zone'=>'group'),
	'order' => 'ORDER BY display ASC, sort_order DESC, id DESC',
));
if(!$group){
	$sort['code']=4;
	echo(json_encode($sort));
	exit();
}
$partner = DB::LimitQuery('category', array(
	'condition' => array('zone'=>'partner'),
	'order' => 'ORDER BY display ASC, sort_order DESC, id DESC',
));
$sort=array('code'=>2,'zhonglei'=>array(),'shangquan'=>array());

foreach($group as $key=>$value){
	$str=array();
	$str['zhongleiID']=empty($value['id'])?0:$value['id'];
	$str['zhongleiName']=empty($value['name'])?0:$value['name'];
	$str['imgURL']='';
	array_push($sort['zhonglei'],$str);
}
foreach($partner as $key=>$value){
	$pstr=array();
	$pstr['shangquanID']=empty($value['id'])?0:$value['id'];
	$pstr['shangquanName']=empty($value['name'])?0:$value['name'];
	array_push($sort['shangquan'],$pstr);
}
echo(json_encode($sort));
?>