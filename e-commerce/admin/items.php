
<?php
session_start();

$pageTitle='Items';
if(isset($_SESSION['username'])){
    include 'init.php';

    $action=isset($_GET['action']) ? $_GET['action']:'mange';
    if($action=='mange'){
        $query='';
        





        $stmt=$link->prepare("SELECT items.*,catagory.Name AS catName,users.username FROM 
                              items INNER JOIN catagory ON catagory.ID=items.catID
                               INNER JOIN users ON users.userID=items.memberID ");
        $stmt->execute();
        $row=$stmt->fetchAll();
        ?>
    <h1  class="text-center" style="color:#666">Mange Items</h1>
    <div class="container">
        <div class="table-responsive">
            <table   class="table table-bordered">
                <tr style="background-color:#333;color:#fff;text-align:center" >
                    <td>#ID</td>
                    <td>Name</td>
                    <td>Description</td>
                    <td>Price</td>
                    <td>Adding Date</td>
                    <td>Catagory</td>
                    <td>Member</td>
                    <td>Control</td>
                </tr>
                <?php
                foreach($row as $info){
                    echo "<tr style='background-color:white;text-align:center'>";
                     echo "<td>".$info['itemID']."</td>";
                     echo "<td>".$info['Name']."</td>";
                     echo "<td>".$info['Description']."</td>";
                     echo "<td>".$info['Price']."</td>";
                     echo "<td>".$info['Add_Date']."</td>";
                     echo "<td>".$info['catName']."</td>";
                     echo "<td>".$info['username']."</td>";
                    echo  "<td class='text-center'>
                       <a href='items.php?action=edit&itemID=".$info['itemID']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>

                        <a href='items.php?action=delete&itemID=".$info['itemID']."' class='btn btn-danger confirm '> Delete  </a>";
                    if($info['Approve']==0){
                        echo "<a href='items.php?action=approve&itemID=".$info['itemID']."' class='btn btn-info ' >Approve</a>";

                    }
                        
                   echo "</td>";





                    echo "</tr>";

                }




                ?>
                
                    
                <tr>    
            </table>
        </div>    
        <a href="items.php?action=add" class="btn btn-primary">+Add New Item</a>


    </div>
   
           
            <?php


        }
    elseif($action=='add'){?>
        
     <h1 class="text-center " style="color:#666">Add New Item<h1>
     <div class="container">
         <form class="form-horizontal" action="?action=insert" method="post">
             <div class="form-group">
             <label class="col-sm-2 control-label">Name</label>
             <div class="col-sm-10">
                 <input type="text" name="nameItem" class="form-control" autocomplete="off"  placeholder="Name Of The Item"/>
 
              </div>    
             </div>  
             <div class="form-group">
             <label class="col-sm-2 control-label">Description</label>
             <div class="col-sm-10">
                 <input type="text" name="description" class="form-control" autocomplete="off"  placeholder="Description Of The Item"/>
 
              </div>    
             </div>
             <div class="form-group">
             <label class="col-sm-2 control-label">Price</label>
             <div class="col-sm-10">
                 <input type="text" name="price" class="form-control" autocomplete="off"  placeholder="price Of The Item"/>
 
              </div>    
             </div>
             <div class="form-group">
             <label class="col-sm-2 control-label">Country</label>
             <div class="col-sm-10">
                 <input type="text" name="country" class="form-control" autocomplete="off"  placeholder="country Of The Item"/>
 
              </div>    
             </div>
             <div class="form-group">
             <label class="col-sm-2 control-label">Status</label>
             <div class="col-sm-10">
                 <select name="status" class="form-control">
                     <option value="0">...</option>
                     <option value="1">New</option>
                     <option value="2">Like New</option>
                     <option value="3">Used</option>
                     <option value="4">Old</option>


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
             <label class="col-sm-2 control-label">Catagory </label>
             <div class="col-sm-10">
                 <select name="catagory" class="form-control">
                     <option value="0">..</option>
                     <?php
                     $stmt=$link->prepare("SELECT * FROM catagory");
                     $stmt->execute();
                     $res=$stmt->fetchAll();

                     foreach($res as $cat){
                         echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
                     }
                     
                     
                     
                     ?>


                 </select>
 
              </div>    
             </div>
             
            
             
 
 
 
 
 
 
 
             <div class="form-group">
             <div class="col-sm-offset-2 col-sm-10">
                 <input type="submit" value="Add Items" class="btn btn-primary btn-lg"/>
                 
              </div>    
             </div> 
 
 
         </form>
     </div> 

      <?php  }
    elseif($action=='insert'){

      if($_SERVER['REQUEST_METHOD']=='POST'){
        
    echo " <h1 class='text-center' style='color:#666'>Insert Items<h1>"; 

    echo "<div class='container'>";
 
       $name=$_POST['nameItem'];
       $des=$_POST['description'];
       $price=$_POST['price'];
       $country=$_POST['country'];
       $status=$_POST['status'];
       $member=$_POST['member'];
       $catagory=$_POST['catagory'];


       
       $formErrors=array();
       if(empty($name)){
           $formErrors[]='NameItem cant be empty';
       }
       if(empty($des)){
         $formErrors[]='Description cant be empty';
     }
     if(empty($price)){
         $formErrors[]='price cant be empty';
     }
     if(empty($country)){
        $formErrors[]='Country cant be empty';
    }
    if($status===0){
        $formErrors[]='Status cant be empty';
    }
    if($member===0){
        $formErrors[]='You Must Choose Member';
    }
    if($catagory===0){
        $formErrors[]='You Must Choose Catagory';
    }
     foreach($formErrors as $error){
         echo '<div class="alert alert-danger">'.$error.'</div>';
 
     }
     if(empty($formErrors))
     {
                       
            $stmt=$link->prepare("INSERT INTO items (Name,Description,Price,Add_Date,Country_Make,Satatus,catID,memberID) VALUES(:zname,:zdes,:zprice,now(),:zcountry,:zstatus,:zcatagory,:zmember)");
            $stmt->execute(array('zname'=>$name,
                                'zdes'=>$des,
                                'zprice'=>$price,
                                'zcountry'=> $country,
                                'zstatus'=> $status,
                                'zcatagory'=> $catagory,
                                'zmember'=> $member
                            ));
            $count=$stmt->rowCount();
            $success= $count." ".'Items Insert';
            $page='items.php?action=mange';
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

    elseif($action=='edit'){
        if(isset($_GET['itemID'])&&is_numeric($_GET['itemID'])){
            $itemID=intval($_GET['itemID']);  
            $stmt=$link->prepare("SELECT * FROM items WHERE itemID=? ");
            $stmt->execute(array($itemID));
            $res=$stmt->fetch();
            $count=$stmt->rowCount();
            if($count>0){   ?>
            
        
     <h1 class="text-center " style="color:#666">Edit Item<h1>
     <div class="container">
         <form class="form-horizontal" action="?action=update" method="post">
         <input type="hidden" name="ID" value="<?php  echo $itemID ?>" />

            <div class="form-group">
             <label class="col-sm-2 control-label">Name</label>
             <div class="col-sm-10">
                 <input type="text" name="nameItem" class="form-control" autocomplete="off" 
                  placeholder="Name Of The Item" value="<?php echo $res['Name'] ?>"/>
 
              </div>    
             </div>  
             <div class="form-group">
             <label class="col-sm-2 control-label">Description</label>
             <div class="col-sm-10">
                 <input type="text" name="description" class="form-control" autocomplete="off"
                   placeholder="Description Of The Item"value="<?php echo $res['Description'] ?>" />
 
              </div>    
             </div>
             <div class="form-group">
             <label class="col-sm-2 control-label">Price</label>
             <div class="col-sm-10">
                 <input type="text" name="price" class="form-control" autocomplete="off" 
                  placeholder="price Of The Item"value="<?php echo $res['Price'] ?>" />
 
              </div>    
             </div>
             <div class="form-group">
             <label class="col-sm-2 control-label">Country</label>
             <div class="col-sm-10">
                 <input type="text" name="country" class="form-control"
                  autocomplete="off"  placeholder="country Of The Item"value="<?php echo $res['Country_Make'] ?>" />
 
              </div>    
             </div>
             <div class="form-group">
             <label class="col-sm-2 control-label">Status</label>
             <div class="col-sm-10">
                 <select name="status" class="form-control" >
                     <option value="0">...</option>
                     <option value="1" <?php if($res['Satatus']==1){echo 'selected';} ?> >New</option>
                     <option value="2" <?php if($res['Satatus']==2){echo 'selected';} ?> >Like New</option>
                     <option value="3" <?php if($res['Satatus']==3){echo 'selected';} ?> >Used</option>
                     <option value="4" <?php if($res['Satatus']==4){echo 'selected';} ?> >Old</option>


                 </select>
 
              </div>    
             </div>
             <div class="form-group">
             <label class="col-sm-2 control-label">Member </label>
             <div class="col-sm-10">
                 <select name="member" class="form-control"value="<?php echo $res['username'] ?>" >
                     <option value="0">..</option>
                     <?php
                     $stmt=$link->prepare("SELECT * FROM users");
                     $stmt->execute();
                     $res2=$stmt->fetchAll();

                     foreach($res2 as $user){
                         echo "<option value='".$user['userID']."'";
                         if($res['memberID']==$user['userID'] ){echo 'selected';}
                         echo ">"
                         .$user['username']."</option>";
                     }
                     
                     
                     
                     ?>


                 </select>
 
              </div>    
             </div>
             <div class="form-group">
             <label class="col-sm-2 control-label">Catagory </label>
             <div class="col-sm-10">
                 <select name="catagory" class="form-control"value="<?php echo $res['catName'] ?>" >
                     <option value="0">..</option>
                     <?php
                     $stmt=$link->prepare("SELECT * FROM catagory");
                     $stmt->execute();
                     $res3=$stmt->fetchAll();

                     foreach($res3 as $r){
                        // echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
                         echo "<option value='".$r['ID']."'";
                         if($res['catID']==$r['ID'] ){echo 'selected';}
                         echo ">"
                         .$r['Name']."</option>";
                     }
                     
                     
                     
                     ?>


                 </select>
 
              </div>    
             </div>
             
            
             
 
 
 
 
 
 
 
             <div class="form-group">
             <div class="col-sm-offset-2 col-sm-10">
                 <input type="submit" value="Update Items" class="btn btn-primary btn-lg"/>
                 
              </div>    
             </div> 
 
 
         </form>
         


<?php
        $stmt2=$link->prepare("SELECT comment.*,users.username FROM comment 
                               
                              INNER JOIN users  ON users.userID=comment.userID WHERE itemID=?  ");
                                 
        $stmt2->execute(array($itemID));
        $row=$stmt2->fetchAll();
        ?>
    <h1  class="text-center" style="color:#666">Mange[ <?php echo $res['Name'] ?> ]Comments</h1>
        <div class="table-responsive">
            <table   class="table table-bordered">
                <tr style="background-color:#333;color:#fff;text-align:center">
                    <td>comment</td>
                    <td>comment_Date</td>
                    <td> User Name</td>
                    <td>Control</td>
                </tr>
                <?php
                foreach($row as $info){
                    echo "<tr style='background-color:white;text-align:center'>";
                     echo "<td>".$info['comment']."</td>";
                     echo "<td>".$info['comment_Date']."</td>";
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

    $itemID=$_POST['ID']; 
    $name=$_POST['nameItem'];
    $des=$_POST['description'];
    $price=$_POST['price'];
    $country=$_POST['country'];
    $status=$_POST['status'];
    $member=$_POST['member'];
    $catagory=$_POST['catagory'];
      
    $formErrors=array();
    if(empty($name)){
        $formErrors[]='NameItem cant be empty';
    }
    if(empty($des)){
      $formErrors[]='Description cant be empty';
  }
  if(empty($price)){
      $formErrors[]='price cant be empty';
  }
  if(empty($country)){
     $formErrors[]='Country cant be empty';
 }
 if($status===0){
     $formErrors[]='Status cant be empty';
 }
 if($member===0){
     $formErrors[]='You Must Choose Member';
 }
 if($catagory===0){
     $formErrors[]='You Must Choose Catagory';
 }
  foreach($formErrors as $error){
      echo '<div class="alert alert-danger">'.$error.'</div>';

  }
    
    if(empty($formErrors))
     {
        
        $stmt=$link->prepare("UPDATE items SET Name = ?,Description = ?,Price = ?,Country_Make= ?,Satatus=?,catID=?,memberID=? WHERE itemID=?");
        $stmt->execute(array($name,$des,$price,$country,$status,$catagory,$member,$itemID));
            $count=$stmt->rowCount();
            $success= $count." ".'Items Insert';
            $page='items.php?action=mange';
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
    elseif($action=='delete'){
      

        } 
     
        elseif($action=='approve'){
            echo " <h1 class='text-center' style='color:#666'>Approve Item<h1>";
            echo "<div class='container'>";
            if(isset($_GET['itemID'])&&is_numeric($_GET['itemID'])){

             $itemID=intval($_GET['itemID']);
             $count=checkName("itemID","items",$itemID);
             if($count>0){
                 $stmt=$link->prepare("UPDATE items SET Approve=1 WHERE itemID=?");
                 $stmt->execute(array($itemID));
                 
             $success= 'This User Is Activate';
             $page="items.php?action=mange";
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