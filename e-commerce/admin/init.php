<?php
include 'connect.php';
$tpl='includes/templates/'; 
$css='layout/css/';
$js='layout/js/';
$lan='includes/lan/';
$fun='includes/functions/'; 



include $lan.'lan.php' ;
include $fun.'function.php';
include $tpl.'header.php';
if(! isset($notNav)){
include $tpl.'navbar.php';
}
include $tpl.'footer.php';





?>

