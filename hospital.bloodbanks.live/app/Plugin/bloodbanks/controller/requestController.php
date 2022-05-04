<?php 
function requestBloodToHospital($input)
{
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;

	$metaTitleMantan= 'Send Request Blood To Hospital';

	if(!empty($_SESSION['infoManager'])){
		$modelRequest = new Request();

		if(!empty($_GET['idHospital']) && !empty($_GET['typeBlood']) && !empty($_GET['bloodCount'])){
			$save['Request']['time']= time();
			$save['Request']['idHospitalTo']= $_GET['idHospital'];
			$save['Request']['idHospitalFrom']= $_SESSION['infoManager']['Hospital']['id'];
			$save['Request']['typeBlood']= $_GET['typeBlood'];
			$save['Request']['bloodCount']= $_GET['bloodCount'];
			$save['Request']['status']= 'new';

			if($modelRequest->save($save)){
				$modelOption->redirect($urlHomes.'listRequestBlood/?status=sendRequestDone');
			}else{
				$modelOption->redirect($urlHomes.'bloodSearch/?typeBlood='.$_GET['typeBlood'].'&bloodCount='.$_GET['bloodCount'].'&status=sendRequestFail');
			}
		}
	}else{
		$modelOption->redirect($urlHomes);
	}
}

function listRequestBlood($input)
{
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;

	$metaTitleMantan= 'Request Blood List';

	if(!empty($_SESSION['infoManager'])){
		$modelRequest = new Request();
		$modelHospital = new Hospital();

		$mess = '';
		if (isset($_GET['status'])) {
			switch ($_GET['status']) {
				case 'sendRequestDone': $mess = '<p class="color_green">Send request successfully</p>';break;
				case 'updateRequestDone': $mess = '<p class="color_green">Process request successfully</p>';break;
				case 'updateRequestFail': $mess = '<p class="color_red">Process request fail</p>';break;
			}
		}

		$page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
		if ($page <= 0)
			$page = 1;
		$limit = 15;
		$conditions= array();
		$conditions['$or'][0]['idHospitalTo']= $_SESSION['infoManager']['Hospital']['id'];
        $conditions['$or'][1]['idHospitalFrom']= $_SESSION['infoManager']['Hospital']['id'];

		$listData = $modelRequest->getPage($page, $limit, $conditions);
		$listHospital= array();

		if(!empty($listData)){
			foreach ($listData as $key => $value) {
				if(empty($listHospital[$value['Request']['idHospitalFrom']])){
					$listHospital[$value['Request']['idHospitalFrom']]= $modelHospital->getData($value['Request']['idHospitalFrom']);
				}

				if(empty($listHospital[$value['Request']['idHospitalTo']])){
					$listHospital[$value['Request']['idHospitalTo']]= $modelHospital->getData($value['Request']['idHospitalFrom']);
				}
			}
		}
		$totalData = $modelRequest->find('count', array('conditions' => $conditions));

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
		setVariable('listHospital', $listHospital);

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

function updateRequestBlood($input)
{
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;

	$metaTitleMantan= 'Update Request Blood';

	if(!empty($_SESSION['infoManager'])){
		$modelRequest = new Request();
		$modelHospital = new Hospital();

		if(!empty($_GET['id']) && !empty($_GET['status'])){
			$update['$set']['status']= $_GET['status'];
			$conditions= array('_id'=> new MongoId($_GET['id']));

			if($modelRequest->updateAll($update, $conditions)){
				if($_GET['status']=='agree'){
					$infoRequest= $modelRequest->getData($_GET['id']);

					// cộng máu cho bệnh viện xin
					$updateFrom['$inc']['typeBlood.'.$infoRequest['Request']['typeBlood']]= $infoRequest['Request']['bloodCount'];
					$conditionsFrom= array('_id'=> new MongoId($infoRequest['Request']['idHospitalFrom']));
					$modelHospital->create();
					$modelHospital->updateAll($updateFrom, $conditionsFrom);

					// trừ máu từ bệnh viện cho
					$updateTo['$inc']['typeBlood.'.$infoRequest['Request']['typeBlood']]= $infoRequest['Request']['bloodCount'];
					$conditionsTo= array('_id'=> new MongoId($infoRequest['Request']['idHospitalTo']));
					$modelHospital->create();
					$modelHospital->updateAll($updateTo, $conditionsTo);
				}

				$modelOption->redirect($urlHomes.'listRequestBlood/?status=updateRequestDone');
			}else{
				$modelOption->redirect($urlHomes.'listRequestBlood/?status=updateRequestFail');
			}
		}
	}else {
		$modelOption->redirect($urlHomes);
	}
}

?>