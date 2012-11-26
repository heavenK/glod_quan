<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

if ( $_POST ) {
	$table = new Table('partner', $_POST);
	$table->SetStrip('location', 'other');
	$table->create_time = time();
	$table->user_id = $login_user_id;
	$table->password = ZPartner::GenPassword($table->password);
	$table->group_id = abs(intval($table->group_id));
	$table->city_id = abs(intval($table->city_id));
	$table->open = (strtoupper($table->open)=='Y') ? 'Y' : 'N';
	$table->display = (strtoupper($table->display)=='Y') ? 'Y' : 'N';
	$table->image = upload_image('upload_image', null, 'team', true);
	$table->image1 = upload_image('upload_image1', null, 'team');
	$table->image2 = upload_image('upload_image2', null, 'team');
	$table->image3 = upload_image('upload_image3', null, 'team');
	$table->image4 = upload_image('upload_image4', null, 'team');
	$table->image5 = upload_image('upload_image5', null, 'team');
	$table->image6 = upload_image('upload_image6', null, 'team');
	$table->image7 = upload_image('upload_image7', null, 'team');
	$table->image8 = upload_image('upload_image8', null, 'team');
	$table->image9 = upload_image('upload_image9', null, 'team');
	$table->image10 = upload_image('upload_image10', null, 'team');
	$table->image11 = upload_image('upload_image11', null, 'team');
	$table->image12 = upload_image('upload_image12', null, 'team');
	$table->insert(array(
		'username', 'user_id', 'city_id', 'title', 'group_id',
		'bank_name', 'bank_user', 'bank_no', 'create_time',
		'location', 'other', 'homepage', 'contact', 'mobile', 'phone',
		'password', 'address', 'open', 'display',
		'image', 'image1', 'image2', 'image3', 'image4', 'image5', 'image6',
		 'image7', 'image8', 'image9', 'image10', 'image11', 'image12', 'averagecost',
		'longlat',
	));
	redirect( WEB_ROOT . '/manage/partner/index.php');
}

include template('manage_partner_create');
