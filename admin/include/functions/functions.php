<?php
/*
    this function her role checkItem is found in dtabase ?
*/
function checkitem($filed,$nameTable,$where=null,$condition1=null){
   global $con;

   $stmt = $con->prepare("SELECT $filed FROM $nameTable $where $condition1");
   $stmt->execute();
   $count = $stmt->rowCount();
   return $count;

}

/*
   this function her role get anything in dtabase ?
   function v2.0
*/

function getdb($filed,$table,$NameWhere=null,$where=null,$valueWhere=null){
   global $con;

   $stmt = $con->prepare("SELECT $filed FROM $table $NameWhere $where $valueWhere");
   $stmt->execute();
   $data = $stmt->fetchAll();
   return $data;
}
/*

*/

 function deleteItem($nameTable,$id,$value){
    global $con;
    $stmt = $con->prepare("DELETE FROM  $nameTable WHERE $id = '$value'");
    $stmt->execute();
    $count = $stmt->rowCount();
    return $count;
 }

 /*
 
 */

 function CountItem($item,$nameTable,$condition=null){
       global $con;
       $stmt = $con->prepare("SELECT COUNT($item) FROM $nameTable $condition");
       $stmt->execute();
       return $stmt->fetchColumn();
 }

/*

*/

function getTitle(){
   global $title;
     if(isset($title)){
         echo $title;
     }else{
        echo "default";
     }
}



?>