<?php
session_start();

$pageTitle='members';
if(isset($_SESSION['username'])){
    include 'init.php';

    
  // print_r($_SESSION);
    
    $action=isset($_GET['action']) ? $_GET['action']:'mange';
    
   
  if($action=='mange'){
      
        $query='';
        if(isset($_GET['page'])&&$_GET['page']=='pending'){
            $query='AND RegStatus=0';

        }





        $stmt=$link->prepare("SELECT * FROM users WHERE GroupID !=1 $query");
        $stmt->execute();
        $row=$stmt->fetchAll();
        ?>
    <h1  class="text-center" style="color:#666">Mange Member Page</h1>
    <div class="container">
        <div class="table-responsive">
            <table   class="table table-bordered">
                <tr style="background-color:#333;color:#fff;text-align:center" >
                    <td>#ID</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Fullname</td>
                    <td>Registerd Date</td>
                    <td>Control</td>
                </tr>
                <?php
                foreach($row as $info){
                    echo "<tr style='background-color:white;text-align:center'>";
                     echo "<td>".$info['userID']."</td>";
                     echo "<td>".$info['username']."</td>";
                     echo "<td>".$info['Email']."</td>";
                     echo "<td>".$info['fullname']."</td>";
                     echo "<td>".$info['date']."</td>";
                    echo  "<td class='text-center'>
                       <a href='members.php?action=edit&userid=".$info['userID']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>

                        <a href='members.php?action=delete&userid=".$info['userID']."' class='btn btn-danger confirm '> Delete  </a>";
                        if($info['RegStatus']==0){
                            echo "<a href='members.php?action=activate&userid=".$info['userID']."' class='btn btn-info ' >Activate</a>";

                        }
                   echo "</td>";





                    echo "</tr>";

                }




                ?>
                
                    
                <tr>    
            </table>
        </div>    
        <a href="members.php?action=add" class="btn btn-primary">+Add New Member</a>


    </div>
   
           
            <?php

            }
            
            
            
            
            elseif($action=='activate'){
               echo " <h1 class='text-center' style='color:#666'>Activate User<h1>";
               echo "<div class='container'>";
               if(isset($_GET['userid'])&&is_numeric($_GET['userid'])){

                $userID=intval($_GET['userid']);
                $count=checkName("userID","users",$userID);
                if($count>0){
                    $stmt=$link->prepare("UPDATE users SET RegStatus=1 WHERE userID=?");
                    $stmt->execute(array($userID));
                    
                $success= 'This User Is Activate';
                $page="members.php?action=mange";
                redirectMessage($success,10,$page,true);

                }
                


               }
               else
               {

                $error= 'you cant browse this page';
                $page="index.php";
                redirectMessage($error,10,$page,false);
               }
               echo "</div>";
               
                    

                

            }
  

























elseif($action=='edit'){
    
        if(isset($_GET['userid'])&&is_numeric($_GET['userid'])){
        $userID=intval($_GET['userid']);  
        $stmt=$link->prepare("SELECT * FROM users WHERE userID =? LIMIT 1");
        $stmt->execute(array($userID));
        $res=$stmt->fetch();
        $count=$stmt->rowCount();
        if($count>0){   ?>
        <h1 class="text-center " style="color:#666">Edit Member<h1>
        <div class="container">
            <form class="form-horizontal" action="?action=update" method="post">
                <input type="hidden" name="ID" value="<?php  echo $userID ?>" />
                <div class="form-group">
                <label class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo $res['username'];?>" name="username" class="form-control" required="required" autocomplete="off"/>

                 </div>    
                </div>  
                <div class="form-group">
                <label class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                <input type="password"value="<?php echo $res['password'];?>"placeholder="leave blank if you dont want change it"  name="pass" class="form-control" autocomplete="new-password"/>

                 </div>    
                </div> 
                <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="email"value="<?php echo $res['Email'];?>" required="required"  name="email" class="form-control"/>
                    
                 </div>    
                </div> 
                <div class="form-group">
                <label class="col-sm-2 control-label" style="font-size:34px">Full Name</label>
                <div class="col-sm-10">
                    <input type="text"value="<?php echo $res['fullname'];?>" required="required"   name="full" class="form-control"/>
                    
                 </div>    
                </div> 
                <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="save" class="btn btn-primary btn-lg"/>
                    
                 </div>    
                </div> 


            </form>
        </div>   









       
       <?php }
        
        
       else{
           $error='There no such id';
           $page="index.php";
           redirectMessage($error,10,$page,false);
       }
       
       
    
    }
    else{
       
        $error= 'you cant browse this page';
        $page="index.php";
        redirectMessage($error,10,$page,false);
        }
    

}










   elseif($action=='update'){
   echo " <h1 class='text-center' style='color:#666'>Update Member<h1>"; 
   echo "<div class='container'>";
   if($_SERVER['REQUEST_METHOD']=='POST'){

      $user=$_POST['username'];
      $pass=$_POST['pass'];
      $fullname=$_POST['full'];
      $email=$_POST['email'];
      $userID=$_POST['ID'];
      
      $formError=array();
      if(empty($user)){
          $formError[]='user cant be empty';
      }
      if(empty($fullname)){
        $formError[]='fullname cant be empty';
    }
    if(empty($email)){
        $formError[]='email cant be empty';
    }
    foreach($formError as $error){
        echo '<div class="alert alert-danger">$error</div>';

    }
    if(empty($formError))
    {
        
        $stmt=$link->prepare("UPDATE users SET username = ?,password = ?,Email = ?,fullname = ? WHERE userID=?");
        $stmt->execute(array($user,$pass,$email,$fullname,$userID));
        $count=$stmt->rowCount();
        //echo "<div class='alert alert-success'>". $count." ".'Record Updated'."</div>";
        $success=$count." "."Record Updated";
        $page="members.php?action=mange";
        redirectMessage($success,10,$page,true);


    }

     
      
      



   }
   
   else{
       $error= 'you cant browse this page';
       $page="index.php";
       redirectMessage($error,10,$page,false);
   }
   echo "</div>";








  
}  







 




elseif($action=='add'){ ?>
    <h1 class="text-center " style="color:#666">Add New Member<h1>
    <div class="container">
        <form class="form-horizontal" action="?action=insert" method="post">
            <div class="form-group">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10">
                <input type="text" name="username" class="form-control" autocomplete="off"/>

             </div>    
            </div>  
            <div class="form-group">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
            <input type="password"placeholder="leave blank if you dont want change it"  name="pass" class="form-control" autocomplete="new-password"/>

             </div>    
            </div> 
            <div class="form-group">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <input type="email"  name="email" class="form-control"/>
                
             </div>    
            </div> 
            <div class="form-group">
            <label class="col-sm-2 control-label" style="font-size:34px">Full Name</label>
            <div class="col-sm-10">
                <input type="text"   name="full" class="form-control"/>
                
             </div>    
            </div> 
            <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Add" class="btn btn-primary btn-lg"/>
                
             </div>    
            </div> 


        </form>
    </div>   
  

<?php

}


 
elseif($action=='insert'){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        
    echo " <h1 class='text-center' style='color:#666'>Insert Member<h1>"; 

    echo "<div class='container'>";
 
       $user=$_POST['username'];
       $pass=$_POST['pass'];
       $fullname=$_POST['full'];
       $email=$_POST['email'];
       
       $formErrors=array();
       if(empty($user)){
           $formErrors[]='user cant be empty';
       }
       if(empty($fullname)){
         $formErrors[]='fullname cant be empty';
     }
     if(empty($email)){
         $formErrors[]='email cant be empty';
     }
     foreach($formErrors as $error){
         echo '<div class="alert alert-danger">'.$error.'</div>';
 
     }
     if(empty($formErrors))
     {
            $count= checkName("username","users",$user);
            if($count==0){           
            $stmt=$link->prepare("INSERT INTO users (username,password,Email,fullname,date) VALUES(:zuser,:zpass,:zemail,:zfull,now())");
            $stmt->execute(array('zuser'=>$user,
                                'zpass'=>$pass,
                                'zemail'=>$email,
                                'zfull'=> $fullname));
            $count=$stmt->rowCount();
            $success= $count." ".'Record Insert';
            $page='members.php?action=mange';
            redirectMessage($success,10,$page,true);

            }
            else{
                $error='username cant valid';
                $page='members.php?action=add';
                redirectMessage($error,10,$page,false);

            }
 
 
     }
 
      
       
       
 
 
 
    }

    

    echo "</div>";




}

















   

        
        
        
        
        
        
    
    





      
        

    




}


else{
    header('location:index.php');
}



?>