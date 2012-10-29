<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$group = DB::LimitQuery('category', array(
	'condition' => array('zone'=>'group'),
	'order' => 'ORDER BY display ASC, sort_order DESC, id DESC',
));
$partner = DB::LimitQuery('category', array(
	'condition' => array('zone'=>'partner'),
	'order' => 'ORDER BY display ASC, sort_order DESC, id DESC',
));
$sort=array('zhonglei'=>array(),'shangquan'=>array());
$a=1;
$b=1;
foreach($group as $key=>$value){
	$sort['zhonglei'][$a]['zhongleiID']=$value['id'];
	$sort['zhonglei'][$a]['zhongleiName']=$value['name'];
	$sort['zhonglei'][$a]['imgURL']='';
	$a++;
}
foreach($partner as $key=>$value){
	$sort['shangquan'][$b]['shangquanID']=$value['id'];
	$sort['shangquan'][$b]['shangquanName']=$value['name'];
	$b++;
}
echo(json_encode($sort));
?>