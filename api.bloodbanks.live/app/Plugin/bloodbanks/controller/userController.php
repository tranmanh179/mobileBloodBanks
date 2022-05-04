<?php
function checkRegisterUserAPI($input)
{
    $listData = array();
    $dataSend= $input['request']->data; 

    global $contactSite;
    global $modelUser;

    if(!empty($dataSend['phone']) && strlen($dataSend['phone'])!=10){
        $return =array('code'=>5);
    }elseif( !empty($dataSend['fullname']) &&
        !empty($dataSend['phone']) &&
        !empty($dataSend['identifyCard']) &&
        !empty($dataSend['password']) &&
        !empty($dataSend['passwordAgain']) 
        
    ){
        $today= getdate();

        if($dataSend['password'] != $dataSend['passwordAgain']){
            $return= array('code'=>2);
        }else{
            if(empty($dataSend['email'])) $dataSend['email']= '';

            $data= $modelUser->find('first', array('conditions'=>array('identifyCard'=>$dataSend['identifyCard'])));
            if(empty($data)){
                $data= $modelUser->find('first', array('conditions'=>array('phone'=>$dataSend['phone'])));
            }
            
            if(empty($data['User']['password'])) {
                if(empty($data)){
                    $data['User']['fullname'] = $dataSend['fullname'];
                    $data['User']['birthday'] = '';
                    $data['User']['timestampBirthday'] = 0;
                    $data['User']['identifyCard'] = $dataSend['identifyCard'];
                    $data['User']['address'] = '';
                    $data['User']['typeBlood'] = '';
                    $data['User']['status'] = 'active';
                    $data['User']['avatar']= 'http://hospital.bloodbanks.live/app/Plugin/bloodbanks/view/image/no-avatar.png';
    	            $data['User']['phone'] = $dataSend['phone'];
                }else{
                    if(empty($data['User']['phone'])) $data['User']['phone'] = $dataSend['phone'];
                    if(empty($data['User']['identifyCard'])) $data['User']['identifyCard'] = $dataSend['identifyCard'];
                }

                $data['User']['email'] = $dataSend['email'];
	            $data['User']['password'] = md5($dataSend['password']);
                $data['User']['accessToken']= getGUID();

                $modelUser->save($data);
                $return= array('code'=>0);

                // Gửi email thông báo
                if(!empty($dataSend['email'])){
                    $from=array($contactSite['Option']['value']['email']);
                    $to=array($dataSend['email']);
                    $cc=array();
                    $bcc=array();
                    $subject='Successful account registration';
                    
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
                                                <span>User Account Information</span>
                                            </div>
                                            <div class="main">
                                                <em style="    margin: 10px 0 10px;display: inline-block;">Hello '.$data['User']['fullname'].' !</em> <br>
                                                <p>Bloodbanks system has successfully activated your account. Your login information:: <br>
                                                    - <strong>Account</strong>: '.$dataSend['phone'].'<br>
                                                    - <strong>Password</strong>: '.$dataSend['password'].'<br><br>
                                                    
                                                    Thank you ./


                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </body>
                                </html>';

                    $modelUser->sendMail($from,$to,$cc,$bcc,$subject,$content);
                }
            }else{
                $return= array('code'=>1);
            }
        }
    }else{
        $return= array('code'=>3);
    }

    echo json_encode($return);
}

function checkLoginUserAPI($input)
{
    global $modelUser;

    $listData = array();
    $dataSend= $input['request']->data;

    if(!empty($dataSend['phone']) && !empty($dataSend['pass'])){
        $conditions['phone']= $dataSend['phone'];
        $conditions['password']= md5($dataSend['pass']);
        
        $userByFone  = $modelUser->find('first', array('conditions'=>$conditions));
        $accessToken = getGUID();
        if($userByFone){
            $userByFone['User']['accessToken']= $accessToken;
            $return= array('code'=>0,'user'=>$userByFone['User']);
            $modelUser->save($userByFone);
        }else{
            $return= array('code'=>1,'user'=>array());
        }
    }else{
        $return= array('code'=>2,'user'=>array());
    }

    echo json_encode($return);
}

function changePassUserAPI($input){
    global $modelUser;
    $dataSend = $input['request']->data;
    if(!empty($dataSend['accessToken'])){
        $dataUser= $modelUser->checkLoginByToken($dataSend['accessToken']);
    }
 
    if(!empty($dataUser['User']['accessToken']) ){
        if($dataUser['User']['password'] == md5($dataSend['oldPass'])&& $dataSend['pass'] = $dataSend['RePass']){
            $dataUser['User']['password'] = md5($dataSend['pass']);
            if($modelUser->save($dataUser)){
                $return = array('code'=>0);
            }else{
                $return = array('code'=>1);
            }
        }else{
            $return = array('code'=>2);
        }
    }else{
        $return = array('code'=>-1);
    }
    
    echo json_encode($return);
}

function sendCodePassNewUserAPI($input)
{
    global $contactSite;
    global $modelUser;

    $dataSend= $input['request']->data;
    if(!empty($dataSend['phone'])){
        $data= $modelUser->find('first', array('conditions'=>array('phone'=>$dataSend['phone'])));
    }
    
    $return= array('code'=>1);

    if(!empty($data['User']['email'])){
        $data['User']['codeForgetPass']= rand(100000,999999);
        $modelUser->save($data);
        
        // Gửi email thông báo
        $from=array($contactSite['Option']['value']['email']);
        $to=array($data['User']['email']);
        $cc=array();
        $bcc=array();
        $subject='Password reset code';
        $content= ' <p>Hello '.$data['User']['fullname'].' !</p>

                    <p>Please enter the code to recover your password: <b>'.$data['User']['codeForgetPass'].'</b></p>
                    ';

        $modelUser->sendMail($from,$to,$cc,$bcc,$subject,$content);
        $return= array('code'=>0);
    }

    echo json_encode($return);
}

function sendPassNewUserAPI($input)
{
    global $contactSite;
    global $modelUser;

    $dataSend= $input['request']->data;

    if(!empty($dataSend['phone']) && !empty($dataSend['codeForgetPass'])){
        $data= $modelUser->find('first', array('conditions'=>array('phone'=>$dataSend['phone'])));
        $return= array('code'=>1);

        if(!empty($data['User']['email']) 
            && isset($data['User']['codeForgetPass']) 
            && $data['User']['codeForgetPass']==$dataSend['codeForgetPass'] 
            && !empty($dataSend['newPass']) 
            && !empty($dataSend['newPassAgain']) 
            && $dataSend['newPass']==$dataSend['newPassAgain']
        ){
            $newPass= $dataSend['newPass'];
            $save['$set']['password']= md5($newPass);
            $save['$unset']['codeForgetPass']= true;
            $dk= array('_id'=>new MongoId($data['User']['id']));
            if($modelUser->updateAll($save,$dk)){
                // Gửi email thông báo
                $from=array($contactSite['Option']['value']['email']);
                $to=array($data['User']['email']);
                $cc=array();
                $bcc=array();
                $subject='New password for you';
                $content= ' <p>Hello '.$data['User']['fullname'].' !</p>

                            <p>Your new password is: <b>'.$newPass.'</b></p>';

                $modelUser->sendMail($from,$to,$cc,$bcc,$subject,$content);
                $return= array('code'=>0);
            }else{
                $return= array('code'=>1);
            }
        }
    }else{
        $return= array('code'=>1);
    }

    echo json_encode($return);
}

function saveTokenDeviceUserAPI($input)
{
    global $modelUser;

    $modelTokenDevice= new TokenDevice();

    $dataSend = $input['request']->data;

    if(!empty($dataSend['accessToken'])){
        $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
    }
    $return = array('code'=>-1);
    if(!empty($dataSend['tokenDevice'])){
        // lưu vào bảng user
        if(!empty($dataUser['User']['accessToken'])){
            $save['$set']['tokenDevice']= $dataSend['tokenDevice'];
            $id= new MongoId($dataUser['User']['id']);
            $dk= array('_id'=>$id);

            if($modelUser->updateAll($save,$dk)){
                $return = array('code'=>0);
            }else{
                $return = array('code'=>1);
            }
        }else{
            $return = array('code'=>-1);
        }
    }  

    // lưu vào bảng token
    $tokenDevice= $modelTokenDevice->find('first', array('conditions'=>array('tokenDevice'=>$dataSend['tokenDevice'])));

    $tokenDevice['TokenDevice']['tokenDevice']= $dataSend['tokenDevice'];
    $tokenDevice['TokenDevice']['userId']= @$dataUser['User']['id'];
    $tokenDevice['TokenDevice']['lastUpdate']= time();
    
    if($modelTokenDevice->save($tokenDevice)){
        $return = array('code'=>0);
    }else{
        $return = array('code'=>1);
    }
    
    
    echo json_encode($return);
}

function saveGPSUserAPI($input)
{
    global $modelUser;
    $dataSend = $input['request']->data;
    $return = array('code'=>-1);
    
    if(!empty($dataSend['accessToken'])){
        $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
        if(!empty($dataUser['User']['accessToken']) && !empty($dataSend['lat']) && !empty($dataSend['long'])){
            $save['$set']['gps.x']= (double) $dataSend['lat'];
            $save['$set']['gps.y']= (double) $dataSend['long'];
            $id= new MongoId($dataUser['User']['id']);
            $dk= array('_id'=>$id);

            if($modelUser->updateAll($save,$dk)){
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

function uploadImageUserAPI($input)
{
    global $urlHomes;
    global $modelUser;

    $dataSend = $input['request']->data;
    $return = array('code'=>-2,'mess'=>'');

    if(!empty($dataSend['accessToken']) && isset($_FILES['image']) && empty($_FILES['image']["error"])){
        $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);

        if (!file_exists(__DIR__.'/../../../webroot/upload/' . $dataUser['User']['id'].'/files')) {
            mkdir(__DIR__.'/../../../webroot/upload/' . $dataUser['User']['id'].'/files', 0755, true);
        }

        if(!empty($dataUser['User']['accessToken'])){
            $checkImage= true;

            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $filename = $_FILES['image']["name"];
            $filetype = strtolower($_FILES['image']["type"]);
            $filesize = $_FILES['image']["size"];
            
            // Verify file extension
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists(strtolower($ext), $allowed)){
                $mess= 'Incorrect image format';
                $checkImage= false;
            }

            // Verify file size - 5MB maximum
            $maxsize = 1024 * 1024 * 5;
            if($filesize > $maxsize){
                $mess= 'Image size exceeds the allowed limit of 5Mb';
                $checkImage= false;
            }

            // Verify MYME type of the file
            if(in_array($filetype, $allowed)){
                // Check whether file exists before uploading it
                $locationImage= __DIR__.'/../../../webroot/upload/' . $dataUser['User']['id'].'/files/avatar.'.$ext;

                move_uploaded_file($_FILES['image']["tmp_name"], $locationImage);
                
                // nén ảnh
                //Tinify\fromFile($locationImage)->toFile($locationImage);

                $images= $urlHomes.'/app/webroot/upload/'.$dataUser['User']['id'].'/files/avatar.'.$ext;
                
            } else{
                $mess= 'Image upload error';
                $checkImage= false;
            }

            if($checkImage){
                $return = array('code'=>0,'urlImage'=>$images);
            }else{
                $return = array('code'=>-3,'mess'=>$mess);
            }
        }else{
            $return = array('code'=>-1, 'mess'=>'Wrong login token');
        }
    }
    
    echo json_encode($return);

}

function updateAvatarUserAPI($input)
{
    global $urlHomes;
    global $modelUser;

    $dataSend = $input['request']->data;
    $return = array('code'=>-2);

    if(!empty($dataSend['accessToken']) && !empty($dataSend['avatar'])){
        $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
        if(!empty($dataUser['User']['accessToken'])){
            $dataUser['User']['avatar'] = $dataSend['avatar'];

            if($modelUser->save($dataUser)){
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

function updateInfoUserAPI($input)
{
    global $urlHomes;
    global $modelUser;

    $dataSend = $input['request']->data;
    $return = array('code'=>-2);

    if(!empty($dataSend['accessToken'])){
        $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);
        if(!empty($dataUser['User']['accessToken'])){
            $dataUser['User']['fullname'] = $dataSend['fullname'];
            $dataUser['User']['email'] = $dataSend['email'];
            $dataUser['User']['sex'] = $dataSend['sex'];
            $dataUser['User']['address'] = @$dataSend['address'];
            $dataUser['User']['identifyCard'] = @$dataSend['identifyCard'];
            $dataUser['User']['typeBlood'] = @$dataSend['typeBlood'];

            if(!empty($dataSend['birthday'])){
                $dataUser['User']['birthday'] = @$dataSend['birthday'];
                $dataUser['User']['timestampBirthday'] = strtotime(str_replace("/", "-", $dataSend['birthday']) . ' 0:0:0');
            }

            if($modelUser->save($dataUser)){
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

function checkLogoutUserAPI($input)
{
    global $modelUser;

    $dataSend= $input['request']->data;
    $return= array('code'=>1);

    $dataUser['$unset']['accessToken']= true;
    $dataUser['$unset']['tokenDevice']= true;
    
    if(!empty($dataSend['accessToken'])){
        $dk= array('accessToken'=>$dataSend['accessToken']);
        if($modelUser->updateAll($dataUser,$dk)){
            $return= array('code'=>0);
        }else{
            $return= array('code'=>1);
        } 
    }

    echo json_encode($return);
}

function getInfoUserAPI($input){
    global $modelUser;
    $dataSend = $input['request']->data;
    $return = array('code'=>-1);

    if(!empty($dataSend['accessToken'])){
        $dataUser = $modelUser->checkLoginByToken($dataSend['accessToken']);

        if(!empty($dataUser['User']['accessToken'])){
            $return = array('code'=>1,'data'=>$dataUser);
        }else{
            $return = array('code'=>-1);
        }
    }
    
    echo json_encode($return);
}

function getSlideHomeAPI($input)
{
    global $modelAlbum;
    global $modelOption;
   
    $dataSend = arrayMap($input['request']->data);

    $return= array('code'=>1);
    
    $settingManMoAPP= $modelOption->getOption('settingManMoAPP');
    $album= array();
    if(!empty($settingManMoAPP['Option']['value']['idSlideDiscount'])){
        $album= $modelAlbum->getAlbum($settingManMoAPP['Option']['value']['idSlideDiscount']);
    }
    
    $return = array('code'=>0,'data'=>@$album['Album']['img']);
    
    echo json_encode($return);
}

/*

function getInfoUserManMoAPI($input)
{
    global $modelOption;
    global $typeHotelManmo;
    global $keyFirebase;
    global $keyGoogle;

    $modelKey = new Key();
    $modelUser= new Userhotel();
    $modelManager = new Manager();

    $dataSend = arrayMap($input['request']->data);
    //var_dump($dataSend);
    $checkKey= false;
    if(!empty($dataSend['key'])){
        $key= $modelKey->getKey($dataSend['key']);

        if($key){
            $checkKey= true;
        }
    }
    $return= array('code'=>1, 'info'=> array());
    $info= array();

    if($checkKey){
        if(!empty($dataSend['type'])){
            if($dataSend['type']=='user'){
                $info= $modelUser->getUser($dataSend['idUser']);
            }elseif($dataSend['type']=='manager'){
                $info= $modelManager->getManager($dataSend['idUser']);
            }
        }else{
            $info= $modelUser->getUser($dataSend['idUser']);
            if(empty($info)){
                $info= $modelManager->getManager($dataSend['idUser']);
            }
        }

        if(!empty($info)){
            $return= array('code'=>0, 'info'=> $info);
        }else{
            $return= array('code'=>2, 'info'=> array());
        }
    }
    echo json_encode($return);
}

function checkLoginGoogleAPI($input)
{
    $modelUser= new Userhotel();
    $modelHotel= new Hotel();
    $modelRoom = new Room();

    $listData = array();
    $dataSend= $input['request']->data;

    if(!empty($dataSend['idGoogle'])){
        $userByFone= $modelUser->getByGoogle($dataSend['idGoogle']);
        $accessToken = getGUID();
        if(!$userByFone){
            if(!empty($dataSend['email'])){
                $checkUserEmail= $modelUser->getByEmail($dataSend['email']);
            }
            
            if(!empty($checkUserEmail)){
                // ghép 1 tài khoản đã có với google
                $userByFone= $checkUserEmail;
            }else{
                // khởi tạo dữ liệu mới hoàn toàn
                $data['User']['password']= '';
                $data['User']['fullname']= $dataSend['name'];
                $data['User']['user']= 'GG'.$dataSend['idGoogle'];
                $data['User']['email']= $dataSend['email'];
                $data['User']['sex']= '';
                $data['User']['phone']= '';
                $data['User']['address']= '';
                $data['User']['actived']= 1;
                $data['User']['avatar']= (!empty($dataSend['avatar']))?$dataSend['avatar']:'https://manmo.vn/app/Theme/ver2/images/logo.png';
                $data['User']['accessTokenGoogle']= $dataSend['accessTokenGoogle'];
                $data['User']['idGoogle']= $dataSend['idGoogle'];
                $data['User']['linkGoogle']= '';

                $modelUser->create();
                $modelUser->save($data);

                $userByFone= $modelUser->getByGoogle($dataSend['idGoogle']);

                // tạo tài khoản ManMo Chat
                $data['User']['idUserManMo']= $userByFone['User']['id'];
                $return= sendDataConnectMantan('https://chat.manmo.vn/createUserAPI',$data['User']);
                
            }
        }

        if($userByFone){
        	if(!empty($userByFone['User']['favoriteHotel'])) $userByFone['User']['favoriteHotel']= array_values($userByFone['User']['favoriteHotel']);
        	
            $rooms= $modelRoom->getRoomByUser($userByFone['User']['user'],array('hotel','name') ); 
            if($rooms){
                foreach($rooms as $room){
                    $hotel= $modelHotel->getHotel($room['Room']['hotel'],array('name','phone','email'));
                    if($hotel){
                        $userByFone['User']['Hotel'][$hotel['Hotel']['id']]= array( 'nameHotel'=>$hotel['Hotel']['name'],
                                                                                    'idHotel'=>$hotel['Hotel']['id'],
                                                                                    'phoneHotel'=>$hotel['Hotel']['phone'],
                                                                                    'emailHotel'=>$hotel['Hotel']['email'],
                                                                                    'nameRoom'=>$room['Room']['name'],
                                                                                    'idRoom'=>$room['Room']['id']
                                                                                );
                    }
                }
            }

            $userByFone['User']['accessToken']= $accessToken;
            $userByFone['User']['accessTokenGoogle']= $dataSend['accessTokenGoogle'];
            $userByFone['User']['idGoogle']= $dataSend['idGoogle'];
            $modelUser->save($userByFone);

            $userByFone['User']['infoUserChat']= getInfoUserChat($userByFone);

            $return= array('code'=>0,'user'=>$userByFone['User']);
            
        }else{
            $return= array('code'=>1,'user'=>array());
        }
    }else{
        $return= array('code'=>2,'user'=>array());
    }

    echo json_encode($return);
}

*/
?>