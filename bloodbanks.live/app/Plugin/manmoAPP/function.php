<?php
$me = array();
$me[0]['title'] = 'ManMo APP';

$me[0]['sub'][0] = array('name' => 'Setting', 'url' => $urlPlugins . 'admin/manmoAPP-admin-setting.php','permission'=>'settingManMoAPP');


addMenuAdminMantan($me);

?>