<?php
require_once(dirname(dirname(__FILE__)) . '/app.php');
$teams = DB::LimitQuery('partner', array(
	
//	'offset' => $offset,
));
print_r($teams);
?>