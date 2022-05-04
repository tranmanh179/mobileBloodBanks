<?php 
function listHospital($input) {
    global $modelOption;
    global $urlHomes;
    global $urlNow;

    if (checkAdminLogin()) {
    	$mess= '';
    	if(!empty($_GET['status'])){
    		switch ($_GET['status']) {
    			case 1: $mess= 'Save data successfully';break;
    			case 4: $mess= 'Delete data successfully';break;
    		}
    	}

        $modelHospital = new Hospital();
        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0) {
            $page = 1;
        }
        $limit = 15;
        $conditions = array();
        
        $listData = $modelHospital->getPage($page, $limit, $conditions);

        $totalData= $modelHospital->find('count',array('conditions' => $conditions));
		
		$balance= $totalData%$limit;
		$totalPage= ($totalData-$balance)/$limit;
		if($balance>0)$totalPage+=1;
		
		$back=$page-1;$next=$page+1;
		if($back<=0) $back=1;
		if($next>=$totalPage) $next=$totalPage;
		
		if(isset($_GET['page'])){
			$urlPage= str_replace('&page='.$_GET['page'], '', $urlNow);
			$urlPage= str_replace('page='.$_GET['page'], '', $urlPage);
		}else{
			$urlPage= $urlNow;
		}

		if(strpos($urlPage,'?')!== false){
			if(count($_GET)>=1){
				$urlPage= $urlPage.'&page=';
			}else{
				$urlPage= $urlPage.'page=';
			}
		}else{
			$urlPage= $urlPage.'?page=';
		}

        setVariable('listData', $listData);
        setVariable('mess', $mess);

        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function addHospital($input) {
    global $modelOption;
    global $isRequestPost;
    global $urlHomes;
    global $urlPlugins;
    
    $contactSite = $modelOption->getOption('contact');
    $smtpSite = $modelOption->getOption('smtpSetting');
    $mess= '';

    if (checkAdminLogin()) {
    	$modelHospital = new Hospital();

    	$save= array();
    	if(!empty($_GET['id'])){
    		$save= $modelHospital->getData($_GET['id']);
    	}
        if ($isRequestPost) {
            $dataSend = arrayMap($input['request']->data);

            $checkAccount= $modelHospital->find('first', array('conditions'=> array('user'=>$dataSend['user'])));

            if ($checkAccount && (!empty($_GET['id']) && $_GET['id']!=$checkAccount['Hospital']['id'])) {
                $mess = 'Account already exists';
            } else {
                $save['Hospital']['user'] = $dataSend['user'];
                if(!empty($dataSend['password'])){
                	$save['Hospital']['password'] = md5($dataSend['password']);
                }
                
                $save['Hospital']['status'] = $dataSend['status'];
                $save['Hospital']['name'] = $dataSend['name'];
                $save['Hospital']['address'] = $dataSend['address'];

                if(!empty($dataSend['gps'])){
                	$gps= explode(',', $dataSend['gps']);
                	if(count($gps)==2){
                		$save['Hospital']['gps']['x']= (double) $gps[0];
                		$save['Hospital']['gps']['y']= (double) $gps[1];
                	}else{
                		$save['Hospital']['gps']= array('x'=>0,'y'=>0);
                	}
                }else{
                	$save['Hospital']['gps']= array('x'=>0,'y'=>0);
                }

                if(!empty($_GET['id'])){
                    $save['Hospital']['staticBlood']= array('A+'=>0,
                                                            'A-'=>0,
                                                            'B+'=>0,
                                                            'B-'=>0,
                                                            'O+'=>0,
                                                            'O-'=>0,
                                                            'AB+'=>0,
                                                            'AB-'=>0,
                                                        );
                }
                
                $save['Hospital']['email'] = $dataSend['email'];
                $save['Hospital']['phone'] = $dataSend['phone'];
                $save['Hospital']['avatar'] = (!empty($dataSend['avatar']))?$dataSend['avatar']:'http://bloodbanks.live/app/Plugin/bloodbanks/view/images/logo-Live-Blood-Bank.png';
                $save['Hospital']['address'] = $dataSend['address'];
                
                
                if ($modelHospital->save($save)) {
                    // send email for user and admin
                    $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                    $to = array(trim($dataSend['email']));
                    $cc = array();
                    $bcc = array();
                    $subject = 'Live Blood Bank software account information';

                    $content = '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <title>Document</title>
                        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">
                        <style>
                            .bao{background: #fafafa;margin: 40px;padding: 20px 20px 40px;}
                            .logo{

                            }
                            .logo img{height: 115px;margin:  0 auto;display:  block;margin-bottom: 15px;}
                            .nd{background: white;max-width: 680px;margin: 0 auto;border-radius: 12px;overflow:  hidden;border: 2px solid #e6e2e2;line-height: 2;}
                            .head{background: #01aac7; color:white;text-align: center;padding: 15px 10px;font-size: 17px;}
                            .main{padding: 10px 20px;}
                            .thong_tin{padding: 0 20px 20px;}
                            .line{position: relative;height: 2px;}
                            .line1{position: absolute;top: 0;left: 25%;width: 47%;height: 100%;background-image: linear-gradient(to right, transparent 50%, #737373 50%);background-size: 26px 100%;}
                            .cty{text-align:  center;margin: 20px 0 30px;}
                            @media screen and (max-width: 768px){
                                .bao{margin:0;}
                            }
                            @media screen and (max-width: 767px){
                                .bao{padding:6px; }
                                .nd{text-align: inherit;}
                            }
                        </style>
                    </head>
                    <body>
                        <div class="bao">
                            <div class="nd">
                                <div class="head">
                                    <span>Account information</span>
                                </div>
                                <div class="main">
                                    <em style="    margin: 10px 0 10px;display: inline-block;">Hi '.$save['Hospital']['name'].' !</em> <br>
                                    <p>The system has successfully activated your account. The login information is as follows: : <br>
                                    	- <strong>Link login</strong>: <a href="http://hospital.bloodbanks.live">http://hospital.bloodbanks.live</a> <br>
                                        - <strong>Account</strong>:'.$save['Hospital']['user'].' <br>
                                        - <strong>Passwork</strong>: '.$dataSend['password'].' <br>
                                        
                                        Thank you ./
                                    </p>
                                </div>
                            </div>
                        </div>
                    </body>
                    </html>';
                    
                    if(empty($_GET['id']) || !empty($dataSend['password']) ){
                        $modelHospital->sendMail($from, $to, $cc, $bcc, $subject, $content);
                    }
                    
                    $modelHospital->redirect($urlPlugins . 'admin/bloodbanks-view-admin-hospital-listHospital.php?status=1');
                } else {
                    $mess= 'System error';
                }
            }
        }

        setVariable('mess', $mess);
        setVariable('data', $save);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function deleteHospital($input) {
    global $modelOption;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        $modelHospital = new Hospital();
        if (isset($_GET['id']) && MongoId::isValid($_GET['id'])) {
            $idDelete = new MongoId($_GET['id']);
            $modelHospital->delete($idDelete);
        }

        $modelHospital->redirect($urlPlugins . 'admin/bloodbanks-view-admin-hospital-listHospital.php?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

// -------------------------------------
function listUser($input) {
    global $modelOption;
    global $modelUser;
    global $urlHomes;
    global $urlNow;

    if (checkAdminLogin()) {
    	$mess= '';
    	if(!empty($_GET['status'])){
    		switch ($_GET['status']) {
    			case 1: $mess= 'Change password successfully';break;
    			case 4: $mess= 'Change status successfully';break;
    		}
    	}

        $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
        if ($page <= 0) {
            $page = 1;
        }
        $limit = 15;
        $conditions = array();
        
        $listData = $modelUser->getPage($page, $limit, $conditions);

        $totalData= $modelUser->find('count',array('conditions' => $conditions));
		
		$balance= $totalData%$limit;
		$totalPage= ($totalData-$balance)/$limit;
		if($balance>0)$totalPage+=1;
		
		$back=$page-1;$next=$page+1;
		if($back<=0) $back=1;
		if($next>=$totalPage) $next=$totalPage;
		
		if(isset($_GET['page'])){
			$urlPage= str_replace('&page='.$_GET['page'], '', $urlNow);
			$urlPage= str_replace('page='.$_GET['page'], '', $urlPage);
		}else{
			$urlPage= $urlNow;
		}

		if(strpos($urlPage,'?')!== false){
			if(count($_GET)>=1){
				$urlPage= $urlPage.'&page=';
			}else{
				$urlPage= $urlPage.'page=';
			}
		}else{
			$urlPage= $urlPage.'?page=';
		}

        setVariable('listData', $listData);
        setVariable('mess', $mess);

        setVariable('page', $page);
        setVariable('totalPage', $totalPage);
        setVariable('back', $back);
        setVariable('next', $next);
        setVariable('urlPage', $urlPage);
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function changeStatusUser($input) {
    global $modelOption;
    global $modelUser;
    global $urlHomes;
    global $urlPlugins;

    if (checkAdminLogin()) {
        if (isset($_GET['id']) && MongoId::isValid($_GET['id']) && !empty($_GET['status'])) {
        	$update['$set']['status']= $_GET['status'];
        	$conditions= array('_id'=>new MongoId($_GET['id']));
           
            $modelUser->updateAll($update,$conditions);
        }

        $modelUser->redirect($urlPlugins . 'admin/bloodbanks-view-admin-user-listUser.php?status=4');
    } else {
        $modelOption->redirect($urlHomes);
    }
}

function changePassUser($input){
	global $modelOption;
    global $modelUser;
    global $urlHomes;
    global $urlPlugins;
    global $isRequestPost;

	if (checkAdminLogin()) {
		if (isset($_GET['id']) && MongoId::isValid($_GET['id']) && $isRequestPost) {
			$dataSend = arrayMap($input['request']->data);
			$user= $modelUser->getUser($_GET['id']);

			if($user){
				if($user['User']['password']==md5($dataSend['passOld'])){
					if($dataSend['passNew']==$dataSend['passNewAgain']){
						$update['$set']['password']= md5($dataSend['passNew']);
			        	$conditions= array('_id'=>new MongoId($_GET['id']));
			           
			            $modelUser->updateAll($update,conditions);
			            $modelUser->redirect($urlPlugins . 'admin/bloodbanks-view-admin-user-listUser.php?status=1');
					}else{
						$mess= 'Re-entered new password is not correct';
					}
				}else{
					$mess= 'Old password is not correct ';
				}
			}else{
				$modelUser->redirect($urlPlugins . 'admin/bloodbanks-view-admin-user-listUser.php?status=2');
			}
		}
	}else {
        $modelOption->redirect($urlHomes);
    }
}
?>