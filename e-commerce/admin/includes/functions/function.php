<?php
function getTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    }
    


}




function redirectMessage($stmt,$time,$page,$bool){
    global $success;
    global $error;
    if($bool==true){
        echo "<div class='alert alert-success'>$success</div>";
        header("refresh:$time;url=$page");

    }
    else{
    echo "<div class='alert alert-danger'>$error</div>";
    echo "<div class='alert alert-info'>You Will BE Direct TO HomePage After $time</div>";
    header("refresh:$time;url=$page");
    }
}





function checkName($attr,$table,$val){
    global $link;
    $stmt=$link->prepare("SELECT $attr FROM $table WHERE $attr= ?");
    $stmt->execute(array($val));
    $count=$stmt->rowCount();
    return $count;
}

function countUser($attr,$table){
    global $link;
    $stmt=$link->prepare("SELECT COUNT($attr) FROM $table");
    $stmt->execute();
   $count= $stmt->fetchColumn();
   return $count;
}

function getLatest($attr,$table,$con,$num){
    global $link;
    $stmt=$link->prepare("SELECT $attr FROM $table ORDER BY $con DESC LIMIT $num");
    $stmt->execute();
    $res=$stmt->fetchAll();
    
    return $res;


}
















?>
