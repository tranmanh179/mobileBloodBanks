<?php 
global $google_key_api;

//$google_key_api= 'AIzaSyCArfV-5bW07DlvoTM2B99UkrY6U_rCCuU';
$google_key_api= 'AIzaSyD8Lo3pUlPzJUuT58ie2WP0WXq6YNMYHOg';

function randPass( $length ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		return substr(str_shuffle($chars),0,$length);

}

function getMenuSidebarLeftManager() {
    global $urlHomes;
    return array(

        array('icon' => 'fa-file-word-o', 'name' => 'Blood Donation File', 'link' => $urlHomes . 'listBloodDonation', 'permission' => 'listBloodDonation'),
        array('icon' => 'fa-flask', 'name' => 'Blood Store', 'link' => $urlHomes . 'bloodStore', 'permission' => 'bloodStore'),
        array('icon' => 'fa-exchange', 'name' => 'Exchange Blood', 'link' => $urlHomes . 'listRequestBlood', 'permission' => 'listRequestBlood'),
        array('icon' => 'fa-search', 'name' => 'Search Blood', 'link' => $urlHomes . 'bloodSearch', 'permission' => 'bloodSearch'),
        array('icon' => 'fa-calendar', 'name' => 'Blood Donation Schedule', 'link' => $urlHomes . 'bloodDonationSchedule', 'permission' => 'bloodDonationSchedule'),
    );
}

function distance_sort($user_a, $user_b) {
    return $user_a["distance"] - $user_b["distance"];
}

function evaluate_sort($user_a, $user_b) {
    return $user_a["evaluate"] - $user_b["evaluate"];
}

// đăng ký bằng mail tranmanhbk179@gmail.com
function sendMessageNotifi($data,$target,$id='',$type='manager')
{
    /*  
    Parameter Example
        $data = array('post_id'=>'12345','post_title'=>'A Blog post');
        $target = 'single tocken id or topic name';
        or
        $target = array('token1','token2','...'); // up to 1000 in one request
    */
    //FCM api URL
    $url = 'https://fcm.googleapis.com/fcm/send';
    
    //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
    $server_key = 'AAAAIKItras:APA91bFipFvDGtb3x6akxNmV-1s4Qp1fGEh0veAyfRYWVzuVmSZlJUPPrFvZ5q2LDOfQGTzsbuflK28lP0AwOn0kSR_OSRl7LrE6_xEN4e2NKdy3PjmcVqNTG_y7k01xI1IeFkvwPDny';

    $fields = array();
    $fields['data'] = $data;
    $fields['notification'] = $data;
    if(is_array($target)){
        $fields['registration_ids'] = $target;
    }else{
        $fields['to'] = $target;
    }

    //header with content_type api key
    $headers = array(
        'Content-Type:application/json',
        'Authorization:key='.$server_key
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
    //die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}
?>