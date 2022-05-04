<?php 
function getListScheduleAPI($input)
{
    global $modelUser;
    $modelSchedule = new Schedule();
    $modelHospital = new Hospital();

    $dataSend = $input['request']->data;
    $return = array('code'=>-1);

    $page = (!empty($dataSend['page']))?(int) $dataSend['page']:1;
    if ($page <= 0) $page = 1;
    $limit= 30;
    $conditions= array();
    $order= array('timestamp'=>'desc');

    $listData= $modelSchedule->getPage($page, $limit,$conditions,$order);

    if(!empty($listData)){
    	foreach($listData as $key=>$data){
            if(!empty($data['Schedule']['idHospital'])){
                $hospital= $modelHospital->getData($data['Schedule']['idHospital']);
                $listData[$key]['Schedule']['nameHospital']= @$hospital['Hospital']['name'];
            }
    	}
    }

    $return = array('code'=>0,'listData'=>$listData);
        
    
    echo json_encode($return);
}

function saveRegScheduleAPI($input)
{
	global $urlHomes;
    global $modelUser;

    $dataSend = $input['request']->data;
    $return = array('code'=>-2);
    $modelSchedule = new Schedule();

    if(!empty($dataSend['accessToken']) && !empty($dataSend['idSchedule'])){
        $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
        if(!empty($dataUser['User']['accessToken'])){
            $update['$push']['listReg']= $dataUser['User']['id'];
            $update['$inc']['numberReg']= 1;
            $conditions= array('_id'=> new MongoId($dataSend['idSchedule']) );

            if($modelSchedule->updateAll($update, $conditions)){
                $return = array('code'=>0);
            }else{
                $return = array('code'=>1);
            }
        }else{
            $return = array('code'=>-1);
        }
    }
    
    echo json_encode($return);
}

function getListScheduleUserAPI($input)
{
    global $modelUser;
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
            $conditions= array('listReg'=>$dataUser['User']['id']);
            $order= array('timestamp'=>'desc');

            $listData= $modelSchedule->getPage($page, $limit,$conditions,$order);

            if(!empty($listData)){
                foreach($listData as $key=>$data){
                    if(!empty($data['Schedule']['idHospital'])){
                        $hospital= $modelHospital->getData($data['Schedule']['idHospital']);
                        $listData[$key]['Schedule']['nameHospital']= @$hospital['Hospital']['name'];
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