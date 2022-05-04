<?php
class TokenDevice extends AppModel
{
   var $name = 'TokenDevice';
    
   function getPage($page=1,$limit=15,$conditions=array())
   {
      $array= array(	'limit' => $limit,
                     'page' => $page,
                     'order' => array('created' => 'desc'),
                     'conditions' => $conditions
                   );
      
      return $this -> find('all', $array);             
   }
    
   function getData($id)
   {
 		$id= new MongoId($id);
      $dk = array ('_id' => $id);
      $data = $this -> find('first', array('conditions' => $dk) );
      return $data;
   }
}
?>