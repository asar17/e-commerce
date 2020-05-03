

<?php
session_start();

$pageTitle="comments";
if(isset($_SESSION['username'])){
    include 'init.php';

    $action=isset($_GET['action']) ? $_GET['action']:'mange';
    if($action=='mange'){
       



        $stmt=$link->prepare("SELECT comment.*,items.Name AS itemName,users.username FROM comment inner join
                                items ON items.itemID=comment.itemID
                              INNER JOIN users  ON users.userID=comment.userID ");
                                 
        $stmt->execute();
        $row=$stmt->fetchAll();
        ?>
    <h1  class="text-center" style="color:#666">Mange Comments</h1>
    <div class="container">
        <div class="table-responsive">
            <table   class="table table-bordered">
                <tr style="background-color:#333;color:#fff;text-align:center" >
                    <td>cID</td>
                    <td>comment</td>
                    <td>comment_Date</td>
                    <td>Items Name</td>
                    <td> User Name</td>
                    <td>Control</td>
                </tr>
                <?php
                foreach($row as $info){
                    echo "<tr style='background-color:white;text-align:center'>";
                     echo "<td>".$info['cID']."</td>";
                     echo "<td>".$info['comment']."</td>";
                     echo "<td>".$info['comment_Date']."</td>";
                     echo "<td>".$info['itemName']."</td>";
                     echo "<td>".$info['username']."</td>";
                    echo  "<td class='text-center'>
                       <a href='comments.php?action=edit&cID=".$info['cID']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>

                        <a href='comments.php?action=delete&cID=".$info['cID']."' class='btn btn-danger confirm '> Delete  </a>";
                        if($info['status']==0){
                            echo "<a href='comments.php?action=approve&cID=".$info['cID']."' class='btn btn-info ' >Approve</a>";

                        }
                   echo "</td>";





                    echo "</tr>";

                }
                    
                




                ?>
                
                    
                <tr>    
            </table>
        </div>    
        <a href="comments.php?action=add" class="btn btn-primary">+Add New Comment</a>


    </div>
   
           
            <?php
      

        }
        elseif($action=='add'){?>
            
    <h1 class="text-center " style="color:#666">Add Comment<h1>
    <div class="container">
        <form class="form-horizontal" action="?action=insert" method="post">
            <div class="form-group">
            <label class="col-sm-2 control-label">Comment</label>
            <div class="col-sm-10">
            <textarea " name="comment" class="form-control"/>
                       </textarea>
             </div>    
            </div>  
            
            <div class="form-group">
             <label class="col-sm-2 control-label">Item</label>
             <div class="col-sm-10">
                 <select name="item" class="form-control">
                     <option value="0">..</option>
                     <?php           
                     $stmt=$link->prepare("SELECT * FROM items");
                     $stmt->execute();
                     $res=$stmt->fetchAll();

                     foreach($res as $cat){
                         echo "<option value='".$cat['itemID']."'>".$cat['Name']."</option>";
                     }
                     
                     
                     
                     ?>


                 </select>
 
              </div>    
             </div>
            
             <div class="form-group">
             <label class="col-sm-2 control-label">Member </label>
             <div class="col-sm-10">
                 <select name="member" class="form-control">
                     <option value="0">..</option>
                     <?php
                     $stmt=$link->prepare("SELECT * FROM users");
                     $stmt->execute();
                     $res=$stmt->fetchAll();

                     foreach($res as $user){
                         echo "<option value='".$user['userID']."'>".$user['username']."</option>";
                     }
                     
                     
                     
                     ?>


                 </select>
 
              </div>    
             </div>
           
                    
            
            
            <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Add Comment" class="btn btn-primary btn-lg"/>
                
             </div>    
            </div> 


        </form>
    </div>   
  

<?php

        }
   
    elseif($action=='edit'){
        
    
        if(isset($_GET['cID'])&&is_numeric($_GET['cID'])){
            $cID=intval($_GET['cID']);  
            $stmt=$link->prepare("SELECT * FROM comment WHERE cID =? LIMIT 1");
            $stmt->execute(array($cID));
            $res=$stmt->fetch();
            $count=$stmt->rowCount();
            if($count>0){   ?>
            <h1 class="text-center " style="color:#666">Edit Comment<h1>
            <div class="container">
                <form class="form-horizontal" action="?action=update" method="post">
                    <input type="hidden" name="cID" value="<?php  echo $cID ?>" />
                    <div class="form-group">
                    <label class="col-sm-2 control-label">Comment</label>
                    <div class="col-sm-10">
                        <textarea " name="comment" class="form-control"/>
                        <?php echo $res['comment'];?>
                       </textarea>
                     </div>    
                    </div>  
                    <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Update Comment" class="btn btn-primary btn-lg"/>
                    
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
        
   echo " <h1 class='text-center' style='color:#666'>Update Comment<h1>"; 
   echo "<div class='container'>";
   if($_SERVER['REQUEST_METHOD']=='POST'){

      $comment=$_POST['comment'];
      $cID=$_POST['cID'];
    
      
      $formError=array();
      if(empty($comment)){
        $formError[]='comment cant be empty';
    }
     
    if(empty($formError))
    {
        
        $stmt=$link->prepare("UPDATE comment SET comment = ? WHERE cID=?");
        $stmt->execute(array($comment,$cID));
        $count=$stmt->rowCount();
        //echo "<div class='alert alert-success'>". $count." ".'Record Updated'."</div>";
        $success=$count." "."Record Updated";
        $page="comments.php?action=mange";
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
    elseif($action=='insert'){


    if($_SERVER['REQUEST_METHOD']=='POST'){
        
        echo " <h1 class='text-center' style='color:#666'>Insert Comment<h1>"; 
    
        echo "<div class='container'>";
     
           $c=$_POST['comment'];
           $item=$_POST['item'];
           $member=$_POST['member'];
           
           $formErrors=array();
           if(empty($c)){
               $formErrors[]='Comment cant be empty';
           }
           if($item===0){
             $formErrors[]='Items cant be empty';
         }
    
                           
                $stmt4=$link->prepare("INSERT INTO comment (comment,comment_Date,itemID,userID) VALUES(:zc,now(),:zitemID,:zuser)");
                $stmt4->execute(array('zc'=>$c,
                                      'zitemID'=>$item,
                                    'zuser'=>$member ));
                $count=$stmt4->rowCount();
                $success= $count." ".'Comment Insert';
                $page='comments.php?action=mange';
                redirectMessage($success,10,$page,true);
    
                
            }
        }




        
    elseif($action=='approve'){
            
        echo " <h1 class='text-center' style='color:#666'>Approve Comment<h1>";
        echo "<div class='container'>";
        if(isset($_GET['cID'])&&is_numeric($_GET['cID'])){

         $cID=intval($_GET['cID']);
         $count=checkName("cID","comment",$cID);
         if($count>0){
             $stmt=$link->prepare("UPDATE comment SET Status=1 WHERE cID=?");
             $stmt->execute(array($cID));
             
         $success= 'This Comment Is Approve';
         $page="comments.php?action=mange";
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



    } 
   
       

    



else
{
    header('location:index.php');

}




?>