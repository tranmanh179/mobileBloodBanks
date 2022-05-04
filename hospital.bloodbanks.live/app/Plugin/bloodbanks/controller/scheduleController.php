<?php 
function bloodDonationSchedule($input)
{
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	global $urlNow;
	global $metaTitleMantan;

	$metaTitleMantan= 'Blood Donation Schedule';

	if(!empty($_SESSION['infoManager'])){
		$modelSchedule = new Schedule();
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

		$listData = $modelSchedule->getPage($page, $limit, $conditions);

		if(!empty($listData)){
			foreach ($listData as $key => $value) {
				$listData[$key]['Schedule']['registration']= $modelDonation->find('count', array('conditions'=>array('idSchedule'=>$listData[$key]['Schedule']['id'])));
			}
		}

		$totalData = $modelSchedule->find('count', array('conditions' => $conditions));

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

function addBloodDonationSchedule($input)
{
	global $modelOption;
	global $isRequestPost;
	global $urlHomes;
	global $metaTitleMantan;

	$metaTitleMantan= 'Add Blood Donation Schedule';

	if(!empty($_SESSION['infoManager'])){
		$modelSchedule = new Schedule();
		$mess= '';
		$save= array();

		if(!empty($_GET['id'])){
			$save= $modelSchedule->getData($_GET['id']);
		}

		if ($isRequestPost) {
			$dataSend = $input['request']->data;

        	$save['Schedule']['time'] = $dataSend['time'];
        	$save['Schedule']['timestamp'] = strtotime(str_replace("/", "-", $dataSend['time']) . ' 7:0');
        	$save['Schedule']['title'] = $dataSend['title'];
        	$save['Schedule']['slug'] = createSlugMantan($dataSend['title']);
        	$save['Schedule']['image'] = $dataSend['image'];
        	$save['Schedule']['description'] = $dataSend['description'];
        	$save['Schedule']['content'] = $dataSend['content'];
        	$save['Schedule']['idHospital'] = $_SESSION['infoManager']['Hospital']['id'];

        	if(empty($_GET['id'])){
	        	$save['Schedule']['listReg'] = array();
	        	$save['Schedule']['numberReg'] = 0;
	        }

            if ($modelSchedule->save($save)) {
				$mess= '<p class="color_green">Successfully saved information</p>';
			} else {
				$mess= '<p class="color_red">Save data error</p>';
			}
		}

		setVariable('save', $save);
		setVariable('mess', $mess);

	}else {
        $modelOption->redirect('/login');
    }
}

function deleteBloodDonationSchedule($input)
{
	$modelSchedule = new Schedule();

	global $urlHomes;
	if(!empty($_SESSION['infoManager'])){
		if(!empty($_GET['id']) && MongoId::isValid($_GET['id'])){
			$id= new MongoId($_GET['id']);
			$modelSchedule->delete($id);

			$modelSchedule->redirect($urlHomes.'bloodDonationSchedule?status=2');
		}
	}else{
		$modelSchedule->redirect($urlHomes);
	}
}

?>