<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$sorts = DB::LimitQuery('category', array(
	'order' => 'ORDER BY display ASC, sort_order DESC, id DESC',
));
$sort=array('zhonglei'=>array(),'shangquan'=>array());
$a=1;
$b=1;
foreach($sorts as $key=>$value){
	if($value['zone']=='group'){
		$sort['zhonglei'][$a]['zhongleiID']=$value['id'];
		$sort['zhonglei'][$a]['zhongleiName']=$value['name'];
		$sort['zhonglei'][$a]['imgURL']='';
		$a++;
	}else if($value['zone']=='partner'){
		$sort['shangquan'][$a]['shangquanID']=$value['id'];
		$sort['shangquan'][$a]['shangquanName']=$value['name'];
		$b++;
	}
}
echo(json_encode($sort));
?>