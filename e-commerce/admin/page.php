<?php

$action='';
if(isset($_GET['action'])){
    $action=$_GET['action'];

}
else{
    $action='mange';
}

if($action=='mange'){
    echo 'welcome to catagories';
    echo '<a  href="?action=add">Add catagories</a>';

}
elseif($action=='add'){
    echo 'add page';

}
elseif($action=='edit'){
    echo 'edit page';

}
elseif($action=='update'){
    echo 'update page';

}
elseif($action=='delete'){
    echo 'delete page';

}
else{
    echo 'not respond';
}



?>






























<?php
session_start();
include 'init.php';

$pageTitle='catagory';
if(isset($_SESSION['username'])){
    $action=isset($_GET['action']) ? $_GET['action']:'mange';
    if($action=='mange'){
        echo "mange";
      

        }
    elseif($action=='add'){
      echo "add";

        }
    elseif($action=='insert'){
      

        }
    elseif($action=='edit'){
      

        }
    elseif($action=='update'){
      

        }  
    elseif($action=='delete'){
      

        } 
        else{
            echo "not respond";
        }




}
else
{
    header('location:index.php');

}




?>










