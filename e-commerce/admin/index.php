<?php  
SESSION_START(); 
$notNav='';
$pageTitle='login';
if(isset($_SESSION['username'])){
    header('location:dashboard.php');

} 
include 'init.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $user=$_POST['user'];
    $pass=$_POST['pass'];
    
     $stmt=$link->prepare("SELECT userID, username,password FROM users WHERE username= ? AND password= ? AND GroupID=1 LIMIT 1");
     $stmt->execute(array($user,$pass));
     $res=$stmt->fetch();

     $count=$stmt->rowCount();
     if($count>0){
         $_SESSION['username']=$user;
         $_SESSION['userID']=$res['userID'];
         //prinr_r($_SESSION);
         header('location:dashboard.php');

     }
     

}




?>

<form class="login"action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" >
<h4 class="text-center">Admin Login<h4>
<input  class="form-control "  type="text" name="user" placeholder="Username" autocomplete="off"/>
<input class="form-control " type="password" name="pass" placeholder="Password" autocomplete="new-password"/>
<input class="btn  btn-primary btn-block" type="submit" value="login"/>
</form>






 
 
 


 
  

  




