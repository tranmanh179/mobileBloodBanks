<?php 
function listBloodDonation($input)
{
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;

	$metaTitleMantan= 'Blood Donation List';

	if(!empty($_SESSION['infoManager'])){
		$modelDonation = new Donation();
		$mess = '';
		if (isset($_GET['status'])) {
			switch ($_GET['status']) {
				case 2: $mess = '<p class="color_green">Delete data successfully</p>';
				break;
			}
		}

		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		if ($page <= 0)
			$page = 1;
		$limit = 15;
		$conditions= array();
		$conditions['idHospital'] = $_SESSION['infoManager']['Hospital']['id'];

		if(!empty($_GET['idSchedule'])){
			$conditions['idSchedule'] = $_GET['idSchedule'];
		}

		$listData = $modelDonation->getPage($page, $limit, $conditions);

		$totalData = $modelDonation->find('count', array('conditions' => $conditions));

		$balance = $totalData % $limit;
		$totalPage = ($totalData - $balance) / $limit;
		if ($balance > 0)
			$totalPage+=1;

		$back = $page - 1;
		$next = $page + 1;
		if ($back <= 0)
			$back = 1;
		if ($next >= $totalPage)
			$next = $totalPage;

		if (isset($_GET['page'])) {
			$urlPage = str_replace('&page=' . $_GET['page'], '', $urlNow);
			$urlPage = str_replace('page=' . $_GET['page'], '', $urlPage);
		} else {
			$urlPage = $urlNow;
		}
		if (strpos($urlPage, '?') !== false) {
			if (count($_GET) >= 1) {
				$urlPage = $urlPage . '&page=';
			} else {
				$urlPage = $urlPage . 'page=';
			}
		} else {
			$urlPage = $urlPage . '?page=';
		}

		setVariable('listData', $listData);
		setVariable('page', $page);
		setVariable('totalPage', $totalPage);
		setVariable('back', $back);
		setVariable('next', $next);
		setVariable('urlPage', $urlPage);
		setVariable('mess', $mess);
	} else {
		$modelOption->redirect($urlHomes);
	}
}

function addBloodDonation($input)
{
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	global $metaTitleMantan;
	global $modelUser;

	$metaTitleMantan= 'Add Blood Donation';

	if(!empty($_SESSION['infoManager'])){
		$modelDonation = new Donation();
		$modelSchedule = new Schedule();
		$modelHospital = new Hospital();

		$mess= '';
		$save= array();
		$bloodCount= 0;
		if(!empty($_GET['id'])){
			$save= $modelDonation->getData($_GET['id']);
			$bloodCount= (int) $save['Donation']['bloodCount'];
		}

		if ($isRequestPost) {
			$dataSend = $input['request']->data;

        	$save['Donation']['image'] = $dataSend['image'];
        	$save['Donation']['fullname'] = $dataSend['fullname'];
        	$save['Donation']['phone'] = str_replace(array(' ','.','-'),'', $dataSend['phone']);
        	$save['Donation']['birthday'] = $dataSend['birthday'];
        	$save['Donation']['timestampBirthday'] = strtotime(str_replace("/", "-", $dataSend['birthday']) . ' 0:0:0');
        	$save['Donation']['identifyCard'] = $dataSend['identifyCard'];
        	$save['Donation']['address'] = $dataSend['address'];
        	$save['Donation']['bloodCount'] = (int) $dataSend['bloodCount'];
        	$save['Donation']['typeBlood'] = $dataSend['typeBlood'];
        	$save['Donation']['dateBloodDonation'] = $dataSend['dateBloodDonation'];
        	$save['Donation']['timestampDateBloodDonation'] = strtotime(str_replace("/", "-", $dataSend['dateBloodDonation']) . ' 8:0:0');

        	$save['Donation']['idHospital'] = $_SESSION['infoManager']['Hospital']['id'];
        	$save['Donation']['idSchedule'] = $dataSend['idSchedule'];

        	// lưu thông tin người dùng
        	if(!empty($dataSend['idUser'])){
        		$saveUser= $modelUser->getUser($dataSend['idUser']);
        	}

        	if(empty($saveUser)){
				$saveUser= $modelUser->find('first', array('conditions'=>array('identifyCard'=>$dataSend['identifyCard'])));
			}

			if(empty($saveUser)){
				$saveUser= $modelUser->find('first', array('conditions'=>array('phone'=>$dataSend['phone'])));
			}

			$saveUser['User']['fullname']= $dataSend['fullname'];
			$saveUser['User']['birthday']= $dataSend['birthday'];
			$saveUser['User']['timestampBirthday'] = strtotime(str_replace("/", "-", $dataSend['birthday']) . ' 0:0:0');
			$saveUser['User']['identifyCard']= $dataSend['identifyCard'];
			$saveUser['User']['address']= $dataSend['address'];
			$saveUser['User']['typeBlood']= $dataSend['typeBlood'];

			if(empty($saveUser['User']['status'])) $saveUser['User']['status']= 'active';
			if(empty($saveUser['User']['email'])) $saveUser['User']['email']= '';
			if(empty($saveUser['User']['avatar'])) $saveUser['User']['avatar']= 'http://hospital.bloodbanks.live/app/Plugin/bloodbanks/view/image/no-avatar.png';
			if(empty($saveUser['User']['phone'])) $saveUser['User']['phone']= $dataSend['phone'];
			
			if($modelUser->save($saveUser)){
				if(empty($saveUser['User']['id'])){
					$save['Donation']['idUser']= $modelUser->getLastInsertId();
				}else{
					$save['Donation']['idUser']= $saveUser['User']['id'];
				}
			}
			
            if ($modelDonation->save($save)) {
				$mess= '<p class="color_green">Successfully saved information</p>';

				$_SESSION['idScheduleChoice']= $dataSend['idSchedule'];

				// thống kê kho máu
				$static['$inc']['staticBlood.'.$dataSend['typeBlood']]= (int) $dataSend['bloodCount']-$bloodCount;
				$conditionsUpdate= array('_id'=> new MongoId($_SESSION['infoManager']['Hospital']['id']));
				$modelHospital->updateAll($static, $conditionsUpdate);
			} else {
				$mess= '<p class="color_red">Save data error</p>';
			}
		}

		$listAllSchedule= $modelSchedule->find('all', array('order'=>array('timestamp'=>'desc')));

		setVariable('save', $save);
		setVariable('mess', $mess);
		setVariable('listAllSchedule', $listAllSchedule);

	}else {
        $modelOption->redirect('/login');
    }
}

function deleteBloodDonation($input)
{
	$modelDonation = new Donation();

	global $urlHomes;
	if(!empty($_SESSION['infoManager'])){
		if(!empty($_GET['id']) && MongoId::isValid($_GET['id'])){
			$id= new MongoId($_GET['id']);
			$modelDonation->delete($id);

			$modelDonation->redirect($urlHomes.'listBloodDonation?status=2');
		}
	}else{
		$modelDonation->redirect($urlHomes);
	}
}

function viewBloodDonation($input)
{
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	global $metaTitleMantan;

	$metaTitleMantan= 'View Blood Donation';

	if(!empty($_SESSION['infoManager'])){
		$modelDonation = new Donation();
		$modelSchedule = new Schedule();

		if(!empty($_GET['id'])){
			$data= $modelDonation->getData($_GET['id']);
			if(!empty($data['Donation']['idSchedule'])){
				$schedule= $modelSchedule->getData($data['Donation']['idSchedule']);
				$data['Donation']['nameSchedule']= @$schedule['Schedule']['title'];
			}
			setVariable('data', $data);
		}else{
			$modelDonation->redirect($urlHomes);
		}
	}else {
        $modelOption->redirect('/login');
    }
}

?>