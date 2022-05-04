<?php 
function getUserAPI($input)
{
	global $modelUser;
	$return= array();

	if(!empty($_SESSION['infoManager'])){
		$dataSend= arrayMap($input['request']->query);
       
        if(!empty($dataSend['term'])){
            if(empty($dataSend['value'])) $dataSend['value']= 'id';
            if(empty($dataSend['field'])) $dataSend['field']= 'phone';
            
            $fields= array();
            $conditions= array();
            $page= null;
            $limit= null;
            $order = array('fullname' => 'asc');

            $conditions[$dataSend['field']] = $dataSend['term'];

            $listData= $modelUser->getPage($page,$limit,$conditions,$order,$fields);
            
            if($listData){
                foreach($listData as $data){
                    $return[]= array(	'id'=>$data['User']['id'],
                    					'label'=>$data['User']['fullname'].' '.$data['User']['phone'],
                    					'value'=>$data['User'][$dataSend['value']],
                    					'fullname'=>$data['User']['fullname'],
                    					'phone'=>$data['User']['phone'],
                    					'birthday'=>$data['User']['birthday'],
                    					'identifyCard'=>@$data['User']['identifyCard'],
                    					'address'=>@$data['User']['address'],
                    					'typeBlood'=>@$data['User']['typeBlood'],
                    				);
                }
            }
        }
	}

	echo json_encode($return);
}
?>