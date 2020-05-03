<?php
session_start();
$pageTitle='dashboard';
if(isset($_SESSION['username'])){
    include 'init.php';
    








    ?>
    <div class="container" style="text-align:center">
    <h1 class='text-center' style='color:#666'>Dashboard<h1>
        <div class="row" style="background-color:#EEE;border:1px solid #CCC;">
            <div class="col-md-3"style="background-color:#3498db;border-radius:10px" >
                <div class="stat" >Total Members</div>
                <span ><a href="members.php" style="color:white;text-decoration:none"><?php echo countUser("userID","users");  ?></a></span>
            </div>
            <div class="col-md-3" style="background-color:#c0392b;border-radius:10px" >
                <div class="stat" style="font-size:30px;margin-top:7px">Pending Members</div>
                <span ><a href="members.php?page=pending" style="color:white;text-decoration:none">
                <?php echo checkName("RegStatus","users","0"); ?>
                </a></span>

            </div>
            <div class="col-md-3"style="background-color:#d35400;border-radius:10px" >
                <div class="stat">Total Catagories</div>
                <span ><a href="catagory.php?page=mange" style="color:white;text-decoration:none">
                <?php echo countUser("ID","catagory");  ?>               
               </a></span>

            </div>
            <div class="col-md-3"style="background-color:#8e44ad;border-radius:10px" >
                <div class="stat">Total Comments</div>
                <span ><a href="comments.php?page=mange" style="color:white;text-decoration:none">
                <?php echo countUser("cID","comment");  ?>               
               </a></span>
            </div>
        </div>

    </div>
    <div class="container" style="margin-top:30px;margin-left:90px">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users">*~*Latest Registerd User</i>

                   </div>
                   <div class="panel-body">
                       <ul>
                       <?php

                   $res=getLatest("*","users","userID","5");
                   foreach($res as $r){
                       echo '<li style="overflow:hidden;margin-left:-30px;margin-top:9px">'.                   
                        $r['username']."<span class='btn btn-success pull-right'>
                         <a href='members.php?action=edit&userid=".$r['userID']."' style='color:white;text-decoration:none'>Edit</a>
                         </span>"
                       .'</li>';
                     

                   }
                   ?>
                   </ul>
                   </div>
                 </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users">*~*Latest Catagories</i>

                   </div>
                   <div class="panel-body">
                   <ul>
                       <?php

                   $res=getLatest("*","catagory","ID","5");
                   foreach($res as $r){
                       echo '<li style="overflow:hidden;margin-left:-30px;margin-top:9px">'.                   
                        $r['Name']."<span class='btn btn-success pull-right'>
                         <a href='catagory.php?action=edit&catid=".$r['ID']."' style='color:white;text-decoration:none'>Edit</a>
                         </span>"
                       .'</li>';
                     

                   }
                   ?>
                   </ul>

                   </div>
                 </div>
            </div>
        </div>
    </div>






    <div class="container" style="margin-top:30px;margin-left:90px">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users">*~*Latest Comment</i>

                   </div>
                   <div class="panel-body">
                       <?php
                       $stmt1=$link->prepare("SELECT comment.*,users.username AS member from comment INNER JOIN 
                       users ON users.userID=comment.userID");
                       $stmt1->execute();
                       $res=$stmt1->fetchAll();
                       
                       foreach($res as $roro){
                           echo '<div class="comment-box">';
                          echo  '<span style="display:inline-block;color:red">'.$roro['member']."::".'</span>';
                          echo '<p style="display:inline-block;background-color:#EEE;height:20px;border-raduis:10px" >'.$roro['comment'].'</p>';

                           echo '</div>';
                       }
                       ?>
                
                   </div>
                 </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users">*~*Latest Items</i>

                   </div>
                   <div class="panel-body">
                   <ul>
                       <?php

                   $res=getLatest("*","items","itemID","5");
                   foreach($res as $r){
                       echo '<li style="overflow:hidden;margin-left:-30px;margin-top:9px">'.                   
                        $r['Name']."<span class='btn btn-success pull-right'>
                         <a href='items.php?action=edit&itemID=".$r['itemID']."' style='color:white;text-decoration:none'>Edit</a>
                         </span>"
                       .'</li>';
                     

                   }
                   ?>
                   </ul>

                   </div>
                 </div>
            </div>
        </div>
    </div>





















    <?php
    
}
else{
    header('location:index.php');
}



?>