<?php
global $routesPlugin;

$routesPlugin['login'] = 'bloodbanks/view/hospital/login.php';
$routesPlugin['logout'] = 'bloodbanks/view/hospital/logout.php';
$routesPlugin['forgetPassword'] = 'bloodbanks/view/hospital/forgetPassword.php';

// kho máu
$routesPlugin['bloodStore'] = 'bloodbanks/view/store/bloodStore.php';
$routesPlugin['bloodSearch'] = 'bloodbanks/view/store/bloodSearch.php';
$routesPlugin['sendNotification'] = 'bloodbanks/view/store/sendNotification.php';
$routesPlugin['sendNotificationAllUser'] = 'bloodbanks/view/store/sendNotificationAllUser.php';

// yêu cầu hỗ trợ máu từ bệnh viện khác
$routesPlugin['requestBloodToHospital'] = 'bloodbanks/view/request/requestBloodToHospital.php';
$routesPlugin['listRequestBlood'] = 'bloodbanks/view/request/listRequestBlood.php';
$routesPlugin['updateRequestBlood'] = 'bloodbanks/view/request/updateRequestBlood.php';


// danh sách hiến máu
$routesPlugin['listBloodDonation'] = 'bloodbanks/view/donation/listBloodDonation.php';
$routesPlugin['addBloodDonation'] = 'bloodbanks/view/donation/addBloodDonation.php';
$routesPlugin['deleteBloodDonation'] = 'bloodbanks/view/donation/deleteBloodDonation.php';
$routesPlugin['viewBloodDonation'] = 'bloodbanks/view/donation/viewBloodDonation.php';

// lịch hiến máu
$routesPlugin['bloodDonationSchedule'] = 'bloodbanks/view/schedule/bloodDonationSchedule.php';
$routesPlugin['addBloodDonationSchedule'] = 'bloodbanks/view/schedule/addBloodDonationSchedule.php';
$routesPlugin['deleteBloodDonationSchedule'] = 'bloodbanks/view/schedule/deleteBloodDonationSchedule.php';

// người dùng
$routesPlugin['getUserAPI'] = 'bloodbanks/view/user/getUserAPI.php';

