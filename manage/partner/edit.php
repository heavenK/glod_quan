<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

need_manager();
need_auth('market');

$id = abs(intval($_GET['id']));
$partner = Table::Fetch('partner', $id);

if ( $_POST && $id==$_POST['id'] && $partner) {
	$table = new Table('partner', $_POST);
	$table->SetStrip('location', 'other');
	$table->group_id = abs(intval($table->group_id));
	$table->city_id = abs(intval($table->city_id));
	$table->open = (strtoupper($table->open)=='Y') ? 'Y' : 'N';
	$table->display = (strtoupper($table->display)=='Y') ? 'Y' : 'N';
	$table->image = upload_image('upload_image', $partner['image'], 'team', true);
	$table->image1 = upload_image('upload_image1', $partner['image1'], 'team');
	$table->image2 = upload_image('upload_image2', $partner['image2'], 'team');
	$table->image3 = upload_image('upload_image3', $partner['image3'], 'team');
	$table->image4 = upload_image('upload_image4', $partner['image4'], 'team');
	$table->image5 = upload_image('upload_image5', $partner['image5'], 'team');
	$table->image6 = upload_image('upload_image6', $partner['image6'], 'team');
	$table->image7 = upload_image('upload_image7', $partner['image7'], 'team');
	$table->image8 = upload_image('upload_image8', $partner['image8'], 'team');
	$table->image9 = upload_image('upload_image9', $partner['image9'], 'team');
	$table->image10 = upload_image('upload_image10', $partner['image10'], 'team');
	$table->image11 = upload_image('upload_image11', $partner['image11'], 'team');
	$table->image12 = upload_image('upload_image12', $partner['image12'], 'team');

	$up_array = array(
			'username', 'title', 'bank_name', 'bank_user', 'bank_no',
			'location', 'other', 'homepage', 'contact', 'mobile', 'phone',
			'address', 'group_id', 'open', 'city_id', 'display',
			'image', 'image1', 'image2', 'image3', 'image4', 'image5', 'image6',
			'image7', 'image8', 'image9', 'image10', 'image11', 'image12', 'averagecost',
			'longlat', 'head',
			);

	if ($table->password ) {
		$table->password = ZPartner::GenPassword($table->password);
		$up_array[] = 'password';
	}
	$flag = $table->update( $up_array );
	if ( $flag ) {
		Session::Set('notice', '修改商户信息成功');
		redirect( WEB_ROOT . "/manage/partner/edit.php?id={$id}");
	}
	Session::Set('error', '修改商户信息失败');
	$partner = $_POST;
}

include template('manage_partner_edit');
