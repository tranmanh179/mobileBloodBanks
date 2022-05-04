<?php
	function setting($dataSend)
	{
		global $modelOption;
		global $urlPlugins;
		global $isRequestPost;
		global $urlHomes;
		global $languageMantan;
		global $modelAlbum;

		if(checkAdminLogin()){
			$data= $modelOption->getOption('settingManMoAPP');
			$mess= '';

			if($isRequestPost){

				$data['Option']['value']['idSlideDiscount']= (isset($dataSend['request']->data['idSlideDiscount']))? $dataSend['request']->data['idSlideDiscount']:'';
				$data['Option']['value']['idNoticeIntroduce']= (isset($dataSend['request']->data['idNoticeIntroduce']))? $dataSend['request']->data['idNoticeIntroduce']:'';
				$data['Option']['value']['idCategoryBlog']= (isset($dataSend['request']->data['idCategoryBlog']))? $dataSend['request']->data['idCategoryBlog']:'';
				$data['Option']['value']['idCategoryDiscount']= (isset($dataSend['request']->data['idCategoryDiscount']))? $dataSend['request']->data['idCategoryDiscount']:'';
				
				$modelOption->saveOption('settingManMoAPP', $data['Option']['value']);
				$mess= $languageMantan['saveSuccess'];
			}

			setVariable('mess',$mess);
			setVariable('data',$data);
		}else{
			$modelOption->redirect($urlHomes);
		}
	}

	function codeDiscount($input)
	{
		//Configure::write('debug', 2);
		$modelEvent = new Event();
	    
        $order = array('dateEnd.time'=>'desc');
        $conditions['dateEnd.time']['$gte']= time();
        $listData= $modelEvent->find('all', array('conditions'=>$conditions,'order'=>$order));
       
        setVariable('listData',$listData);
	}

	function minigame($input)
	{
		global $modelUser;

		if(!empty($_GET['accessToken'])){
			
		}
	}
?>