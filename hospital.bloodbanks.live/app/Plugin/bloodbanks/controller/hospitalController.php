<?php 
function login($input) {
    global $isRequestPost;
    global $urlHomes;
    global $urlHomeManager;

    $modelHospital = new Hospital();

    if ($isRequestPost && !isset($_SESSION['infoManager'])) {
        $dataSend= arrayMap($input['request']->data);
        
        $conditions= array('user'=>$dataSend['user'],'password'=>md5($dataSend['password']));
        $infoManager = $modelHospital->find('first', array('conditions'=>$conditions));
       
        if($infoManager){
            if($infoManager['Hospital']['status']=='active'){
                $_SESSION['infoManager']= $infoManager;
                $_SESSION['CheckAuthentication'] = true;
                $_SESSION['urlBaseUpload'] = '/app/webroot/upload/'. $infoManager['Hospital']['user'] . '/';

                $modelHospital->redirect($urlHomes . 'bloodStore');
            }else{
                // tài khoản bị khóa
                $modelHospital->redirect($urlHomes . 'login?status=-2');
            }
        }else{
            // sai user hoặc pass
            $modelHospital->redirect($urlHomes . 'login?status=-1');
        }
    } elseif (isset($_SESSION['infoManager'])) {
        $modelHospital->redirect($urlHomes . 'bloodStore');
    }
}

function logout() {
    global $urlHomes;
    $modelHospital = new Hospital();

    session_destroy();

    $modelHospital->redirect($urlHomes . 'login');
}

function forgetPassword($input) {
    global $isRequestPost;
    global $urlHomes;
    global $contactSite;
    global $smtpSite;
    global $gmpThemeSettings;
    global $urlManagerLogin;

    if ($isRequestPost && !isset($_SESSION['infoManager'])) {
        $modelHospital = new Hospital();
        $infoManager = $modelHospital->find('first', array('conditions'=>array('user'=>$_POST['user'])));

        if (empty($infoManager)) {
            // không tồn tại tài khoản
            $modelHospital->redirect($urlHomes . 'forgetPassword?status=-4');
        } elseif ($infoManager['Hospital']['status'] == 'lock') {
            // tài khoản đang bị khóa
            $modelHospital->redirect($urlHomes . 'forgetPassword?status=-2');
        } elseif ($infoManager['Hospital']['status'] == 'active') {
            $newPass = randPass(8);
            $infoManager['Hospital']['password'] = md5($newPass);

            $id = new MongoId($infoManager['Hospital']['id']);

            if ($modelHospital->updateAll($infoManager, array('_id' => $id))) {

                // send email for user and admin
                $from = array($contactSite['Option']['value']['email'] => $smtpSite['Option']['value']['show']);
                $to = array();
                if(!empty($infoManager['Hospital']['email'])) $to[]= $infoManager['Hospital']['email'];
                $cc = array();
                $bcc = array();
                $subject = '[' . $smtpSite['Option']['value']['show'] . '] New password';

                $content= '<!DOCTYPE html>
                <html lang="en">
                <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <title>Document</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css">
                <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
                <style>
                .bao{background: #fafafa;margin: 40px;padding: 20px 20px 40px;}
                .logo{

                }
                .logo img{height: 115px;margin:  0 auto;display:  block;margin-bottom: 15px;}
                .nd{background: white;max-width: 500px;margin: 0 auto;border-radius: 12px;border: 2px solid #e6e2e2;line-height: 2;position: relative; margin-top: 50px;}
                .head{background: #3fb901; color:white;text-align: center;padding: 15px 10px;font-size: 17px;text-transform: uppercase;}
                .main{padding: 10px 20px;}
                .thong_tin{padding: 0 20px 20px;}
                .line{position: relative;height: 2px;}
                .line1{position: absolute;top: 0;left: 0;width: 100%;height: 100%;background-image: linear-gradient(to right, transparent 50%, #737373 50%);background-size: 26px 100%;}
                .cty{text-align:  center;margin: 20px 0 30px;}
                .main .fa{color:green;}
                table{margin:auto;}
                .icon{
                    width: 80px;
                    height: 80px;
                    display: inline-block;
                    padding: 20px;
                    background: #00BCD4;
                    text-align: center;
                    color: white;
                    font-size: 40px;
                    line-height: 34px;
                    position: absolute;
                    top: -40px;
                    left: 202px;
                    border-radius: 50%;
                    border: 2px solid #e0e0e0;
                }
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
                <!-- Tiêu đề: Thay đổi mật khẩu thành công trên Phần mềm quản lý lưu trú ManMo3H -->
                <div class="bao">
                
                <div class="nd">
                <!-- <div class="head">
                <span>New password</span>
                </div> -->
                <div class="icon">
                <i class="fa fa-lock"></i>
                </div>
                <div class="main"> <br>
                <em style="    margin: 10px 0 10px;display: inline-block;">Hi ' . $infoManager['Hospital']['name'] . ' !</em> <br>
                
                Your password on Live Blood Bank system has been successfully changed at '.date('H:i m/d/Y').'. The new login information is as follows: <br><br>
                <i class="fa fa-globe"></i> Link login: <a href="http://hospital.bloodbanks.live">http://hospital.bloodbanks.live</a> <br>
                <i class="fa fa-user"></i> Account: <strong>' . $infoManager['Hospital']['user'] . '</strong> <br>
                <i class="fa fa-lock"></i> New password: <strong>' . $newPass . '</strong> <br><br>
                <br><br>
                Thank you ./

                </p>
                </div>
                

                </div>
                </div>
                </body>
                </html>';

                if ($modelHospital->sendMail($from, $to, $cc, $bcc, $subject, $content)) {
                    $modelHospital->redirect($urlHomes . 'forgetPassword?status=1');
                }
            }
        }
    } elseif (isset($_SESSION['infoManager'])) {
        $modelHospital->redirect('/bloodStore');
    }
}
?>