<?php 
function getListHospitalAPI($input)
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
    $order= array();

    $listData= $modelHospital->getPage($page, $limit,$conditions,$order);

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

function getInfoHospitalAPI($input)
{
	global $modelUser;
    $modelHospital = new Hospital();

    $dataSend = $input['request']->data;
    $return = array('code'=>-1);

    if(!empty($dataSend['accessToken']) && !empty($dataSend['idHospital'])){
        $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
        if(!empty($dataUser['User']['accessToken'])){
            $hospital= $modelHospital->getData($dataSend['idHospital']);

            $return = array('code'=>0,'data'=>$hospital);
        }else{
            $return = array('code'=>-1);
        }
    }
    echo json_encode($return);
}

function agreeRequestBloodDonationAPI($input)
{
	global $modelUser;
	global $contactSite;
    $modelHospital = new Hospital();

    $dataSend = $input['request']->data;
    $return = array('code'=>-1);

    if(!empty($dataSend['accessToken']) && !empty($dataSend['idHospital'])){
        $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
        if(!empty($dataUser['User']['accessToken'])){
            $hospital= $modelHospital->getData($dataSend['idHospital']);

            if(!empty($hospital['Hospital']['email'])){
            	$from=array($contactSite['Option']['value']['email']);
                $to=array($hospital['Hospital']['email']);
                $cc=array();
                $bcc=array();
                $subject='User AGREE to donate blood';
                
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
                                            <span>User agrees to donate blood</span>
                                        </div>
                                        <div class="main">
                                            <em style="    margin: 10px 0 10px;display: inline-block;">Hello '.$hospital['Hospital']['name'].' !</em> <br><br>
                                            
                                            User '.$dataUser['User']['fullname'].', phone number '.$dataUser['User']['phone'].', <b>AGREED</b> to donate blood at the request of the hospital.
                                            <br><br>
                                                
                                                Thank you ./
                                        </div>
                                    </div>
                                </div>
                            </body>
                            </html>';

                $modelUser->sendMail($from,$to,$cc,$bcc,$subject,$content);
            }

            $return = array('code'=>0);
        }else{
            $return = array('code'=>-1);
        }
    }
    echo json_encode($return);
}

function cancelRequestBloodDonationAPI($input)
{
	global $modelUser;
	global $contactSite;
    $modelHospital = new Hospital();

    $dataSend = $input['request']->data;
    $return = array('code'=>-1);

    if(!empty($dataSend['accessToken']) && !empty($dataSend['idHospital'])){
        $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
        if(!empty($dataUser['User']['accessToken'])){
            $hospital= $modelHospital->getData($dataSend['idHospital']);

            if(!empty($hospital['Hospital']['email'])){
            	$from=array($contactSite['Option']['value']['email']);
                $to=array($hospital['Hospital']['email']);
                $cc=array();
                $bcc=array();
                $subject='User CANCEL to donate blood';
                
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
                                            <span>User agrees to donate blood</span>
                                        </div>
                                        <div class="main">
                                            <em style="    margin: 10px 0 10px;display: inline-block;">Hello '.$hospital['Hospital']['name'].' !</em> <br><br>
                                            
                                            User '.$dataUser['User']['fullname'].', phone number '.$dataUser['User']['phone'].', <b>CANCELED</b> to donate blood at the request of the hospital.
                                            <br><br>
                                                
                                                Thank you ./
                                        </div>
                                    </div>
                                </div>
                            </body>
                            </html>';

                $modelUser->sendMail($from,$to,$cc,$bcc,$subject,$content);
            }

            $return = array('code'=>0);
        }else{
            $return = array('code'=>-1);
        }
    }
    echo json_encode($return);
}

?>