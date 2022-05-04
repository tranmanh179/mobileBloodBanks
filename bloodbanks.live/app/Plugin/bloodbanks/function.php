<?php
	$menus= array();
	$menus[0]['title']= 'Live Blood Bank';
	$menus[0]['sub'][0]= array('name'=>'Hospitals',
							   'classIcon'=>'fa-hospital-o',
		 					   'url'=>$urlPlugins.'admin/bloodbanks-view-admin-hospital-listHospital.php',
		 					   'permission'=>'listHospital'
		 					   );
	$menus[0]['sub'][1]= array('name'=>'Users',
							   'classIcon'=>'fa-users',
		 					   'url'=>$urlPlugins.'admin/bloodbanks-view-admin-user-listUser.php',
		 					   'permission'=>'listUser'
		 					   );
    
    addMenuAdminMantan($menus);
    
    
?>