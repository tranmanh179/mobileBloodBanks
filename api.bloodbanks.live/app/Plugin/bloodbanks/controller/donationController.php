<?php 

function getHistoryDonationUserAPI($input)
{
    global $modelUser;
    $modelDonation = new Donation();
    $modelSchedule = new Schedule();
    $modelHospital = new Hospital();

    $dataSend = $input['request']->data;
    $return = array('code'=>-1);

    if(!empty($dataSend['accessToken'])){
        $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
        if(!empty($dataUser['User']['accessToken'])){
            $page = (!empty($dataSend['page']))?(int) $dataSend['page']:1;
            if ($page <= 0) $page = 1;
            $limit= 30;
            $conditions['idUser'] = $dataUser['User']['id'];

            $listData= $modelDonation->getPage($page, $limit,$conditions);

            if(!empty($listData)){
            	foreach($listData as $key=>$data){
                    if(!empty($data['Donation']['idSchedule'])){
                        $schedule= $modelSchedule->getData($data['Donation']['idSchedule']);
                        $listData[$key]['Donation']['nameSchedule']= @$schedule['Schedule']['title'];

                        $hospital= $modelHospital->getData($data['Donation']['idHospital']);
                        $listData[$key]['Donation']['nameHospital']= @$hospital['Hospital']['name'];
                    }
            	}
            }

            $return = array('code'=>0,'listData'=>$listData);
        }else{
            $return = array('code'=>-1);
        }
    }
    echo json_encode($return);
}
?>