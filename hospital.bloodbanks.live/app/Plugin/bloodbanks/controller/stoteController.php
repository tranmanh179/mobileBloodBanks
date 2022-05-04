<?php 
function bloodStore($input)
{
	global $modelOption;
	global $metaTitleMantan;

	$metaTitleMantan= 'Blood Store';

	if(!empty($_SESSION['infoManager'])){
		$modelHospital = new Hospital();

		$infoManager= $modelHospital->getData($_SESSION['infoManager']['Hospital']['id']);
		//$listData= array('A+'=>100,'A-'=>124,'B+'=>136,'B-'=>217,'O+'=>123,'O-'=>183,'AB+'=>152,'AB+'=>173);
		$listData= @$infoManager['Hospital']['staticBlood'];

		setVariable('listData', $listData);
	}else {
        $modelOption->redirect('/login');
    }
}

function bloodSearch($input)
{
	global $modelOption;
	global $metaTitleMantan;
	global $isRequestPost;
	global $modelUser;

	$metaTitleMantan= 'Blood Search';

	if(!empty($_SESSION['infoManager'])){
		$modelHospital = new Hospital();
		$modelDonation = new Donation();

		$mess= '';
		$messStore= '';
		$messHospital= '';
		$messUser= '';

		$listHospital= array();
		$listUser= array();

		if(!empty($_GET)){
			$dataSend = arrayMap($input['request']->query);
			if(empty($dataSend['distance'])) $dataSend['distance']= 10;
			$distanceShow= 10*$dataSend['distance'];

			if(!empty($dataSend['typeBlood']) && !empty($dataSend['bloodCount'])){
				// kiểm tra máu trong kho
				$infoManager= $modelHospital->getData($_SESSION['infoManager']['Hospital']['id']);
				$staticBlood= @$infoManager['Hospital']['staticBlood'];

				if(empty($staticBlood[$dataSend['typeBlood']])) $staticBlood[$dataSend['typeBlood']]=0;
				if($staticBlood[$dataSend['typeBlood']]<$dataSend['bloodCount']){
					$messStore= '<p class="color_red">The amount of '.$dataSend['typeBlood'].' blood in stock is only '.number_format($staticBlood[$dataSend['typeBlood']]).'ml, not enough as requested</p>';
				}else{
					$messStore= '<p class="color_green">The amount of '.$dataSend['typeBlood'].' blood in stock is '.number_format($staticBlood[$dataSend['typeBlood']]).'ml, enough for request</p>';
				}

				// kiểm tra máu ở bệnh viện khác trong bán kính 30km
				$lat= $_SESSION['infoManager']['Hospital']['gps']['x'];
				$long= $_SESSION['infoManager']['Hospital']['gps']['y'];
				if(!empty($lat) && !empty($long)){
					$distance= 0.081*$dataSend['distance']; // 100km
			        $latMin= $lat-$distance;
			        $latMax= $lat+$distance;

			        $longMin= $long-$distance;
			        $longMax= $long+$distance;

			        $conditions= array();
			        $conditions['gps.x']= array('$gte' => $latMin,'$lte' => $latMax);
			        $conditions['gps.y']= array('$gte' => $longMin,'$lte' => $longMax);
			        $conditions['staticBlood.'.$dataSend['typeBlood']]= array('$gte' => (int) $dataSend['bloodCount']);

			        $listHospital= $modelHospital->find('all', array('conditions'=>$conditions));

			        if(!empty($listHospital)){
				        $messHospital= '<p class="color_green">List of hospitals within a radius of '.$distanceShow.'km with enough '.$dataSend['bloodCount'].'ml of blood '.$dataSend['typeBlood'].'</p>';
				    }else{
				    	$messHospital= '<p class="color_red">There is no hospital within a radius of '.$distanceShow.'km that has enough '.$dataSend['bloodCount'].'ml of blood group '.$dataSend['typeBlood'].'</p>';
				    }
			    }else{
			    	$messHospital= '<p class="color_red">No data about your hospital GPS coordinates</p>';
			    }

			    // kiểm tra danh sách người hiến máu thuộc nhóm máu cần tìm
			    $listDonationNew= $modelDonation->find('all', array('conditions'=>array('typeBlood'=>$dataSend['typeBlood'],'idUser'=>array('$ne'=>''))));
			    if(!empty($listDonationNew)){
			    	

			    	foreach ($listDonationNew as $key => $value) {
			    		if(empty($listUser[$value['Donation']['idUser']])){
			    			$infoUser= $modelUser->getUser($value['Donation']['idUser']);
			    			if(!empty($infoUser['User']['gps'])){
			    				$x= $infoUser['User']['gps']['x'];
			    				$y= $infoUser['User']['gps']['y'];

			    				$x1= $_SESSION['infoManager']['Hospital']['gps']['x'];
			    				$y1= $_SESSION['infoManager']['Hospital']['gps']['y'];

			    				$distance= 100*round(sqrt(($x-$x1)*($x-$x1)+($y-$y1)*($y-$y1)),3);
			    			}else{
			    				$distance= 1000000000;
			    			}

			    			if($distance<=$distanceShow){
				    			$listUser[$value['Donation']['idUser']]= array(	'infoUser'=> $infoUser,
				    															'lastDonation'=>$value['Donation']['timestampDateBloodDonation'],
				    															'distance'=>$distance,
				    															'numberDonation'=>1,
				    															'evaluate'=>rand(1,3)
				    													 );
				    		}
			    		}else{
			    			$listUser[$value['Donation']['idUser']]['numberDonation']++;
			    			if($listUser[$value['Donation']['idUser']]['lastDonation']<$value['Donation']['timestampDateBloodDonation']){
			    				$listUser[$value['Donation']['idUser']]['lastDonation']= $value['Donation']['timestampDateBloodDonation'];
			    			}
			    		}
			    	}

			    	if(!empty($listUser)){
			    		$messUser= '<p class="color_green">List of suitable users within a radius of '.$distanceShow.'km</p>';

			    		if(count($listUser)>=2){
			    			//usort($listUser, "distance_sort");
			    			usort($listUser, "evaluate_sort");
			    		}
			    	}else{
			    		$messUser= '<p class="color_red">No matching users</p>';
			    	}
			    }else{
			    	$messUser= '<p class="color_red">No matching users</p>';
			    }

			}else{
				$mess= '<p class="color_red">Required fields cannot be left blank</p>';
			}

			setVariable('mess', $mess);
			setVariable('messStore', $messStore);
			setVariable('messUser', $messUser);

			setVariable('listHospital', $listHospital);
			setVariable('messHospital', $messHospital);
			setVariable('listUser', $listUser);
		}
	}else {
        $modelOption->redirect('/login');
    }
}

function sendNotification($input)
{
	global $urlNow;
    global $urlHomes;
    global $modelOption;
    global $isRequestPost;
    global $modelUser;

    if(!empty($_SESSION['infoManager'])){
        $mess= '';
        if($isRequestPost){
            $dataSend=$input['request']->data;
            if(!empty($dataSend['idUser']) && !empty($dataSend['typeBlood']) && !empty($dataSend['bloodCount'])){
                $user= $modelUser->getUser($dataSend['idUser']);
                if(!empty($user['User']['tokenDevice'])){

	                $data = array('title'=>'Emergency support','body'=>$_SESSION['infoManager']['Hospital']['name'].' needs your support to donate blood.Contact: '.$_SESSION['infoManager']['Hospital']['phone'],'type'=>'requestBloodDonation','idHospital'=>$_SESSION['infoManager']['Hospital']['id'],'typeBlood'=>$dataSend['typeBlood'],'bloodCount'=>$dataSend['bloodCount']);
	                
	                $conditions['tokenDevice']= array('$exists'=>true,'$ne'=>'');
	                
	                $return= sendMessageNotifi($data,$user['User']['tokenDevice']);
	                
	                echo $return;

                    $return= json_decode($return, true);

                    if(!empty($return['failure']) && !empty($return['results'])){
                        foreach($return['results'] as $key=>$results){
                            if(!empty($results['error']) && $results['error']=='NotRegistered'){
                                // xóa token user
                                $updateUser['$unset']['tokenDevice']= '';
                                $conditionsUser['tokenDevice']= $user['User']['tokenDevice'];
                                $modelUser->create();
                                $modelUser->updateAll($updateUser, $conditionsUser);
                            }
                        }
                    }
                }else{
                	// người dùng chưa có token
                	echo 2;
                }
            }else{
            	// gửi thiếu dữ liệu
                echo 1;
            }
        }
    }else{
        $modelOption->redirect($urlHomes);
    }
}

function sendNotificationAllUser($input)
{
	global $urlNow;
    global $urlHomes;
    global $modelOption;
    global $isRequestPost;
    global $modelUser;

    if(!empty($_SESSION['infoManager'])){
        $mess= '';
        if($isRequestPost){
            $dataSend=$input['request']->data;
            if(!empty($dataSend['listUser']) && !empty($dataSend['typeBlood']) && !empty($dataSend['bloodCount'])){
            	$listUser= json_decode($dataSend['listUser']);

            	foreach($listUser as $idUser){
	                $user= $modelUser->getUser($idUser);
	                if(!empty($user['User']['tokenDevice'])){
		                $data = array('title'=>'Emergency support','body'=>$_SESSION['infoManager']['Hospital']['name'].' needs your support to donate blood.Contact: '.$_SESSION['infoManager']['Hospital']['phone'],'type'=>'requestBloodDonation','idHospital'=>$_SESSION['infoManager']['Hospital']['id'],'typeBlood'=>$dataSend['typeBlood'],'bloodCount'=>$dataSend['bloodCount']);
		                
		                $conditions['tokenDevice']= array('$exists'=>true,'$ne'=>'');
		                
		                $return= sendMessageNotifi($data,$user['User']['tokenDevice']);
		                
		                echo $return;
		                 
	                    $return= json_decode($return, true);

	                    if(!empty($return['failure']) && !empty($return['results'])){
	                        foreach($return['results'] as $key=>$results){
	                            if(!empty($results['error']) && $results['error']=='NotRegistered'){
	                                // xóa token user
	                                $updateUser['$unset']['tokenDevice']= '';
	                                $conditionsUser['tokenDevice']= $user['User']['tokenDevice'];
	                                $modelUser->create();
	                                $modelUser->updateAll($updateUser, $conditionsUser);
	                            }
	                        }
	                    }
	                }else{
	                	// người dùng chưa có token
	                	echo 2;
	                }
	            }
            }else{
            	// gửi thiếu dữ liệu
                echo 1;
            }
        }
    }else{
        $modelOption->redirect($urlHomes);
    }
}

?>