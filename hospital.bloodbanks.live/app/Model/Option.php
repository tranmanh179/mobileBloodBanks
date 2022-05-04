<?php
   class Option extends AppModel
   {
       var $name = 'Option';

       function getOption($key,$typeFind='first')
       {
	       $dk = array ('key' => $key);
	       $return = $this -> find($typeFind, array('conditions' => $dk) );
	       
	       return $return;
       }
       
       function getOptionById($id)
       {
       		$return = array();
       	   if($id!='')
       	   {
	       	   $id= new MongoId($id);
		       $dk = array ('_id' => $id);
		       $return = $this -> find('first', array('conditions' => $dk) );
	       }
	       return $return;
       }
       
       function saveOption($key,$value)
       {
	       $dk = array ('key' => $key);
	       $return = $this -> find('first', array('conditions' => $dk) );
	       
	       $return['Option']['key']= $key;
	       $return['Option']['value']= $value;
	       $this->save($return);
       }


// Quan ly chuyen muc tin tuc
	   function getNumberSlugCategory($cats,$slug,$number=0)
	   {
		    foreach($cats as $cat)
			{
				if(strpos($cat['slug'],$slug)!== false)
				{
					$number++;
				}
				
				if($cat['sub'])
				{
					$number= $this->getNumberSlugCategory($cat['sub'],$slug,$number);
				}
			}
			return $number;
	   }
	   
       function sapXepCat($type,$idMenu,$cats)
       {
	       if($cats[$idMenu])
	       {
	       	   $valueArray= array_values( $cats );
	       	   $keyArray= array_keys( $cats );
	       	   $dem= count($valueArray);
	       	   
	       	   
	       	   for($i=0;$i<$dem;$i++)
	       	   {
		       		if($valueArray[$i]['id']==$idMenu)
		       		{
		       			$catNew= array();
			       		switch($type)
			       		{
				       		case 'top': if($i>0)
				       					{
					       					for($j=0;$j<($i-1);$j++)
					       					{
						       					$catNew[ $keyArray[$j] ]= $valueArray[$j];
					       					}
					       					$catNew[ $keyArray[$i] ]= $valueArray[$i];
					       					$catNew[ $keyArray[$i-1] ]= $valueArray[$i-1];
					       					for($j=($i+1);$j<$dem;$j++)
					       					{
						       					$catNew[ $keyArray[$j] ]= $valueArray[$j];
					       					}
				       					}
				       					break;
				       		case 'bottom':  if($i<($dem-1) )
				       						{
					       						for($j=0;$j<=($i-1);$j++)
						       					{
							       					$catNew[ $keyArray[$j] ]= $valueArray[$j];
						       					}
						       					$catNew[ $keyArray[$i+1] ]= $valueArray[$i+1];
						       					$catNew[ $keyArray[$i] ]= $valueArray[$i];
						       					
						       					for($j=($i+2);$j<$dem;$j++)
						       					{
							       					$catNew[ $keyArray[$j] ]= $valueArray[$j];
						       					}
				       						}
				       						break;
			       		}
			       		break;
		       		}	   
	       	   }
	       	   
	       	   if($catNew) $cats= $catNew;
	       	   
	       }
	       else
	       {
		       foreach($cats as $key=>$cat)
		       {
			       $cats[$key]['sub']= $this->sapXepCat($type,$idMenu,$cats[$key]['sub']);
		       }
	       }
	       return $cats;
       }
       
       function changeCategoryNotice($type,$idMenu)
	   {
		   $dk = array ('key' => 'categoryNotice');
	       $return = $this -> find('first', array('conditions' => $dk) );
           if($return)
           {
           		$return['Option']['value']['category']= $this->sapXepCat($type,$idMenu,$return['Option']['value']['category']);
           		$this->save($return, false, array("value"));	
           }
	   }
	   
	   function saveCategoryNotice($slug,$idCatEdit,$name,$parent,$key,$description,$image,$content)
	   {
	   		$dk = array ('key' => 'categoryNotice');
	   		$modelSlug= ClassRegistry::init('Slug');

            $groups= $this -> find('first', array('conditions' => $dk) );
	   		if(!$groups) 
            {
         	  $groups['Option']['key']= 'categoryNotice';
            }
	   		
			if($idCatEdit=='')
			{
				$groups['Option']['value']['tCategory']+= 1;
				$infoSlug= $modelSlug->saveSlug($slug,'','notices','cat');
				$save= array(
								'name'=>$name,
								'id'=>$groups['Option']['value']['tCategory'],
								'slug'=>$infoSlug['slug'],
								'idSlug'=>$infoSlug['idSlug'],
								'key'=>$key,
								'description'=>$description,
                                'image' => $image,						
                                'content' => $content					
							); 	 
				if($parent==0)
				{
					$groups['Option']['value']['category'][ $groups['Option']['value']['tCategory'] ]= $save;
				}  	
				else
				{
					$groups['Option']['value']['category']= $this->addCat($groups['Option']['value']['category'],$parent,$save);	
				}	
				
			}
			else
			{
				$idCatEdit= (int) $idCatEdit;
				
				$cats= $this->getcat($groups['Option']['value']['category'],$idCatEdit);
				if($cats)
				{
					$infoSlug= $modelSlug->saveSlug($slug,$cats['idSlug'],'notices','cat');
					//debug('da vao');
					$cats['slug']= $infoSlug['slug'];
					$cats['idSlug']= $infoSlug['idSlug'];
					$cats['name']= $name;
					$cats['key']= $key;
					$cats['description']= $description;
					$cats['image']= $image;
					$cats['content']= $content;
					
					$groups['Option']['value']['category']= $this->deleteCat($groups['Option']['value']['category'],$idCatEdit,$parent,0);
					//debug($groups['Manager']['category']);
					$groups['Option']['value']['category']= $this->addCat($groups['Option']['value']['category'],$parent,$cats);
					//debug($groups['Manager']['category']);
				}
				
			}
			$this->save($groups);
			return 1;	
	   		
	   }
	   function deleteCatageryNotice($idCat)
	   {
			
			$dk = array ('key' => 'categoryNotice');

            $groups= $this -> find('first', array('conditions' => $dk) );
	   		
			$cats= $this->getcat($groups['Option']['value']['category'],$idCat);
			if($cats)
			{
				$groups['Option']['value']['category']= $this->deleteCat($groups['Option']['value']['category'],$idCat,-1,0);
				$this->save($groups,  false,  array('value') );
				return 1;
			}
			
			return -1;
	   }
	   function getcat($cats,$idCat,$type='id',$parent=0)
	   	{
			foreach($cats as $cat)
			{
				if($cat[$type]==$idCat)
				{
					$cat['parent']= $parent;
					return $cat;
				}
				else
				{
					if(isset($cat['sub']) && count($cat['sub'])>0){
						$return= $this->getcat($cat['sub'],$idCat,$type,$cat['id']);
						if($return) return $return;
					}
				}
			}
			return null;
		}
	   
	   function searchIdParent($cats,$idCat)
	   {
		   foreach($cats as $cat)
		   {
				if($cat['id']==$idCat)
				{
					return $cats['id'];
				}
				else
				{
					$return= $this->searchIdParent($cat['sub'],$idCat);

					if($return) return $return;
				}
		   }
		   return null;
	   }
	   
	   function deleteCat($cats,$idCatEdit,$parentNew,$parentOld)
	   {
			$dem= -1;
			$ok= false;
			if(isset($cats) && count($cats)>0){
		   		foreach($cats as $key=>$cat)
		   		{
		   			$dem++;
		   			if($parentNew!=$parentOld && $cat['id']==$idCatEdit)
		   			{
		   				$ok=true;
		   				break;
		   			}
		   			else
		   			{
		   				$cats[ $key ]['sub']= $this->deleteCat($cat['sub'],$idCatEdit,$parentNew,$cat['id']);	   			
		   			}
		   		}
	   		}
	   		
			if($ok)
			{
				$tg= array();
				$dem2= -1;
				foreach($cats as $key2=>$cm)
				{
					$dem2++;
					if($cm['id'] != $cat['id'])
					{
						$tg[$key2]= $cm;
					}
				}
				$cats= $tg;
			}
	   		return $cats;
	   }
	   
	   
	   
	   function addCat($cats,$parent,$save,$number=0)
	   {
	   		
	   		$parent= (int) $parent;
	   		
	   		if($parent==0)
	   		{
	   			$check= true;
	   			foreach($cats as $key=>$cat)
		   		{
			   		if(  $cat['id']==$save['id'] )
			   		{
				   		$cats[ $key ]= $save;
				   		$check= false;
				   		break;
			   		}
		   		}
		   		if($check)
		   		{
		   			$cats[$save['id']]= $save;
	   			}
	   		}
	   		else
	   		{
	   			$dem= -1;
	   			foreach($cats as $key=>$cat)
	   			{
	   				$dem++;
	   				if(isset($cat['id']) && $cat['id']==$parent)
	   				{
	   					$check= true;
	   					$demSub= -1;
	   					foreach($cat['sub'] as $keySub=>$sub)
	   					{
	   						$demSub++;
		   					if($sub['id']==$save['id'])
		   					{
			   					$cats[ $key ]['sub'][ $keySub ]= $save;
			   					$check= false;
			   					break;
		   					}
	   					}
	   					if($check)
	   					{
		   					$cats[ $key ]['sub'][ $save['id'] ]= $save;
		   					break;
	   					}
	   				}
	   				else
	   				{
	   					$cats[ $key ]['sub']= $this->addCat($cat['sub'],$parent,$save,$number+1);	
	   				}
	   			}
	   		}
	   		return $cats;
	   }
// Quan ly trinh don
	   function saveInfoMenu($name,$id)
	   {
	   	   if($id)
	   	   {
		   	   $id= new MongoId($id);
		   	   $dk = array ('_id' => $id);
		   	   $data = $this -> find('first', array('conditions' => $dk) );
	   	   }
	   	   
	   	   $data['Option']['key']= 'menus';
	   	   $data['Option']['value']['name']= $name;
		   $this->save($data);
	   }   
	   
	   function saveMenus($idParent,$idTD,$name,$url,$description,$idMenu)
	   {
           
           $dk = array ('_id' => $idMenu,'key' => 'menus');
           $users= $this -> find('first', array('conditions' => $dk) );
           
           if($users) 
           {
	       	   if($idTD=='')
	       	   {
	           	   $tCategory= $users['Option']['value']['tCategory']+1;
	           	   $users['Option']['value']['tCategory']= $tCategory;
	           	   $save= array (   'id'=>$tCategory,
									'name'=>$name,
									'url'=>$url,
									'description'=>$description
								);
						
			       $users['Option']['value']['category']= $this->addCat($users['Option']['value']['category'],$idParent,$save);
		           
	           }
	           else
	           {
		            $idCatEdit= (int) $idTD;
				
					$cats= $this->getcat($users['Option']['value']['category'],$idCatEdit);
					if($cats)
					{
						//debug('da vao');
						$cats['name']= $name;
						$cats['url']= $url;
						$cats['description']= $description;
						
						$users['Option']['value']['category']= $this->deleteCat($users['Option']['value']['category'],$idCatEdit,$idParent,0);
						
						$users['Option']['value']['category']= $this->addCat($users['Option']['value']['category'],$idParent,$cats);
						
					}
	           }
	           $this->save($users);
           }
	   }
	   
	   	   
	   function processTrinhDon($allTrinhDon,$type,$idMenu)
	   {
		    switch($type)
       		{
           		case 'top': $dem= -1;
           					foreach($allTrinhDon as $trinhDon)
						    {
							    $dem++;
							    if($trinhDon['id']==$idMenu)
	           					{
		           					if($dem>0)
		           					{
			           					$tg= $allTrinhDon[$idTop];
			           					$allTrinhDon[$idTop]= $allTrinhDon[$idMenu];
			           					$allTrinhDon[$idMenu]= $tg;
			           					
			           					$allTrinhDon[$idMenu]['id']= $idMenu;
			           					$allTrinhDon[$idTop]['id']= $idTop;
		           					}
	           					}
	           					else
	           					{
		           					$idTop= $trinhDon['id'];
	           					}
						    }
						    break;
				case 'bottom':  $stop= false;
								debug($allTrinhDon);
	           					foreach($allTrinhDon as $trinhDon)
							    {
								    if($stop)
								    {
			           					$allTrinhDon[ $trinhDon['id'] ]= $allTrinhDon[$idMenu];
			           					
			           					$allTrinhDon[$idMenu]= $trinhDon;
			           					
			           					$allTrinhDon[$idMenu]['id']= $idMenu;
			           					$allTrinhDon[ $trinhDon['id'] ]['id']= $trinhDon['id'];
			           					
			           					break;
								    }
								    else if($trinhDon['id']==$idMenu)
		           					{
			           					$stop= true;
		           					}
							    }
							    debug($allTrinhDon);
							    break;
           		
				
       		}
       		return $allTrinhDon;
	   }
	   
	   function changeMenus($type,$idMenu,$idParent,$idMenuShow)
	   {
		   $dk = array ('_id'=>$idMenuShow,'key' => 'menus');
           $users= $this -> find('first', array('conditions' => $dk) );
            
           if($users)
           {
           		if($idParent!=0)
           		{
	           		$cats= $this->getcat($users['Option']['value']['category'],$idParent);
	           		if($cats)
	           		{
		           		$cats['sub']= $this->processTrinhDon($cats['sub'],$type,$idMenu);	
		           		$idParentBig= (int) $this->searchIdParent($users['Option']['value']['category'],$idParent);
		           		$users['Option']['value']['category']= $this->addCat($users['Option']['value']['category'],$idParentBig,$cats);
	           		}
           		}
           		else
           		{
	           		$users['Option']['value']['category']= $this->processTrinhDon($users['Option']['value']['category'],$type,$idMenu);	
           		}
           		$this->save($users, false, array("value"));
           }
	   }
	   
	   function deleteMenus($idMenu,$idMenuShow)
	   {
	   	    $dk = array ('_id'=>$idMenuShow,'key' => 'menus');
            $groups= $this -> find('first', array('conditions' => $dk) );
            
            if($groups)
            {
				$cats= $this->getcat($groups['Option']['value']['category'],$idMenu);
				//debug($cats);
				if($cats)
				{
					$groups['Option']['value']['category']= $this->deleteCat($groups['Option']['value']['category'],$idMenu,-1,0);
					//debug($groups['Manager']['trinhDon']);
					$this->save($groups,  false,  array('value') );
					return 1;
				}
			}
			
			return -1;
			
	   }	
// Quan ly thong tin chung

       function saveInfoSite($data)
       {
         $dk = array ('key' => 'infoSite');
         $groupsInfoSite= $this -> find('first', array('conditions' => $dk) );
         
         $groupsInfoSite['Option']['key']= 'infoSite';
         $groupsInfoSite['Option']['value']['title']= $data['title'];
     	 $groupsInfoSite['Option']['value']['domain']= $data['domain'];
     	 $groupsInfoSite['Option']['value']['key']= $data['key'];
     	 $groupsInfoSite['Option']['value']['description']= $data['description'];
		 $groupsInfoSite['Option']['value']['postsOnThePage']= (trim($data['postsOnThePage'])!='')? (int) $data['postsOnThePage']:10;
		 $groupsInfoSite['Option']['value']['seoURL']= $data['seoURL'];
		 $groupsInfoSite['Option']['value']['embedScript']= $data['embedScript'];
         
		 $this->create();
		 $this->save($groupsInfoSite);
		 
         $dk = array ('key' => 'contact');
         $groupsContact= $this -> find('first', array('conditions' => $dk) );
         
         $groupsContact['Option']['key']= 'contact';
         $groupsContact['Option']['value']['address']= $data['address'];
         $groupsContact['Option']['value']['fone']= $data['fone'];
         $groupsContact['Option']['value']['email']= $data['email'];
         $groupsContact['Option']['value']['fax']= $data['fax'];
         
         $this->create();
		 $this->save($groupsContact);
		 
		 $dk = array ('key' => 'smtpSetting');
         $groupsSMTP= $this -> find('first', array('conditions' => $dk) );
         
         $groupsSMTP['Option']['key']= 'smtpSetting';
         $groupsSMTP['Option']['value']['account']= $data['account'];
         $groupsSMTP['Option']['value']['show']= $data['show'];
         $groupsSMTP['Option']['value']['host']= $data['host'];
		 $groupsSMTP['Option']['value']['port']= $data['port'];
		 $groupsSMTP['Option']['value']['password']= '';

		 if(!empty($data['password'])){
		 	$numberChar= strlen($data['password']);
		 	for($i=1;$i<=$numberChar;$i++){
		 		$groupsSMTP['Option']['value']['password'] .= '*';
		 	}
		 }
         
         $this->create();
		 $this->save($groupsSMTP);
         
         return 1;

       }   
// Quan ly Plugin
	  function activePlugin($nameFile)
	  {
		  $dk = array ('key' => 'plugins');
          $groups= $this -> find('first', array('conditions' => $dk) );
          if(!$groups)
          {
         	 $groups['Option']['key']= 'plugins';
         	 $groups['Option']['value']= array();
          }
          if(!in_array($nameFile, $groups['Option']['value']))
          {
	          array_push($groups['Option']['value'], $nameFile);
          }
          $this->save($groups);
	  }
	  
	  function deactivePlugin($nameFile)
	  {
		  $dk = array ('key' => 'plugins');
          $groups= $this -> find('first', array('conditions' => $dk) );
          if(!$groups)
          {
         	 $groups['Option']['key']= 'plugins';
         	 $groups['Option']['value']= array();
          }
          if(in_array($nameFile, $groups['Option']['value']))
          {
          	  $listNew= array();
          	  foreach($groups['Option']['value'] as $value)
          	  {
	          	  if($value!=$nameFile)
	          	  {
		          	  array_push($listNew, $value);
	          	  }
          	  }
	          $groups['Option']['value']= $listNew;
          }
          $this->save($groups);
          //debug($groups);
	  }
	  
	  function deletePlugin($nameFile)
	  {
		  $dk = array ('key' => 'plugins');
          $groups= $this -> find('first', array('conditions' => $dk) );
          {
	          if( in_array($nameFile, $groups['Option']['value']) )
	          {
		          $groups['Option']['value'] = array_diff($groups['Option']['value'], array($nameFile));
		          $this->save($groups);
	          }
          }
	  }
   }
?>