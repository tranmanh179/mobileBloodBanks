<?php
class Schedule extends AppModel
{
   var $name = 'Schedule';
    
   function getPage($page=1,$limit=15,$conditions=array(),$order=array('created' => 'desc'))
   {
      $array= array(	'limit' => $limit,
                     'page' => $page,
                     'order' => $order,
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