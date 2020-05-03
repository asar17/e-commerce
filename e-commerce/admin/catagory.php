<?php
session_start();

$pageTitle='catagory';
if(isset($_SESSION['username'])){
    include 'init.php';
    $action=isset($_GET['action']) ? $_GET['action']:'mange';
    if($action=='mange'){
        $sort='';
        if(isset($_GET['sort'])){
            $sort=$_GET['sort'];

        }


        
        $stmt=$link->prepare("SELECT * FROM catagory ORDER BY Ordering $sort ");
        $stmt->execute();
        $row=$stmt->fetchAll(); ?>
      <h1  class="text-center" style="color:#666">Mange Catagory</h1>
      <div class="container c">
          <div class="panel panel-default">
              <div class="panel-heading">Mange Catagory</div>
                       <div class="order pull-right " style="margin-top:-30px">
                          <span style="color:red">ORDERING:</span>
                           <a href="?sort=DESC" style="text-decoration:none">DESC |</a>
                           <a href="?sort=ASC"style="text-decoration:none" >ASC</a>
                       </div>  

                    <div class="panel-body">
                        <?php
                        foreach($row as $row){
                         echo  '<div class="cat" >'?>
                         <div class="btn pull-right" style="visibility:hidden;transition:all .5s ease-in-out;" >
                                        
                                <a  href='catagory.php?action=edit&catid=<?php echo $row['ID'];?>' class='btn btn-info'>Edit</a>
                                <a href='' class='btn btn-danger confirm ' style=""> Delete  </a>

                        </div>


                         <?php
                            echo "<h3 >".$row['Name']."</h3>";
                            echo "<div class='view'>";
                            echo "<p>"; 

                                if($row['Describtion']==''){
                                    echo 'This Catagory Has No Description';

                                }
                                else{
                                    echo $row['Describtion'];

                                }

                            echo "</p>";
                            if($row['Visibilty']==1){
                                echo "<span style='background-color:#d35400;color:white;padding:5px;margin-right:10px;border-radius:10px'>Hidden</span>";

                            }
                            if($row['Allow_Comment']==1){
                                echo "<span style='background-color:#2c3e50;color:white;padding:5px;margin-right:10px;border-radius:10px'>Comment Disabled</span>";

                            }
                            if($row['Allow_Ads']==1){
                                echo "<span style='background-color:#c0392b;color:white;padding:5px;margin-right:10px;border-radius:10px'>Ads Disabled</span>";

                            }
                            
                            echo "<hr>";
                            echo "</div>";
                           echo '</div>';





                            
                        }


                         ?>
                        
                        
                    </div>
          </div>
          <a href="catagory.php?action=add" class="btn btn-primary">+Add New Catagory</a>

      </div>

      

       <?php }
        
    elseif($action=='add'){?>
     <h1 class="text-center " style="color:#666">Add New Catagory<h1>
    <div class="container">
        <form class="form-horizontal" action="?action=insert" method="post">
            <div class="form-group">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Name Of The Catagory"/>

             </div>    
            </div>  
            <div class="form-group">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
            <input type="text"placeholder="Description Of Catagory"  name="description" class="form-control" autocomplete="new-password"/>

             </div>    
            </div> 
            <div class="form-group">
            <label class="col-sm-2 control-label">Ordering</label>
            <div class="col-sm-10">
                <input type="number"  name="ordering" class="form-control" placeholder="Number  TO Arrange Catagories"/>
                
             </div>    
            </div> 
            <div class="form-group">
            <label class="col-sm-2 control-label" style="font-size:34px">Visible</label>
            <div class="col-sm-10" style="font-size:20px" >
                <div>
                    <input id="s" type="radio" name="vis" value="0" checked />
                    <label for="s">Yes</label>
                </div>
                <div>
                    <input id="s2" type="radio" name="vis" value="1" />
                    <label for="s2">No</label>
                </div>
             </div>    
            </div> 
            <div class="form-group">
            <label class="col-sm-2 control-label" style="font-size:34px">Allow Comment</label>
            <div class="col-sm-10" style="font-size:20px" >
                <div>
                    <input id="s1" type="radio" name="comment" value="0" checked />
                    <label for="s1">Yes</label>
                </div>
                <div>
                    <input id="s3" type="radio" name="comment" value="1" />
                    <label for="s3">No</label>
                </div>
             </div>    
            </div>
            <div class="form-group">
            <label class="col-sm-2 control-label" style="font-size:34px">Allow Ads</label>
            <div class="col-sm-10" style="font-size:20px" >
                <div>
                    <input id="s7" type="radio" name="ads" value="0" checked />
                    <label for="s7">Yes</label>
                </div>
                <div>
                    <input id="s8" type="radio" name="ads" value="1" />
                    <label for="s8">No</label>
                </div>
             </div>    
            </div> 
            







            <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Add Catagory" class="btn btn-primary btn-lg"/>
                
             </div>    
            </div> 


        </form>
    </div>   
  



     <?php 
        }
    elseif($action=='insert'){


        if($_SERVER['REQUEST_METHOD']=='POST'){
        
            echo " <h1 class='text-center' style='color:#666'>Insert Catagory<h1>"; 
        
            echo "<div class='container'>";
         
               $name=$_POST['name'];
               $desc=$_POST['description'];
               $order=$_POST['ordering'];
               $vis=$_POST['vis'];
               $comment=$_POST['comment'];
               $ads=$_POST['ads'];


               
               
             if(empty($formErrors))
             
                    $count= checkName("Name","catagory",$name);
                    if($count==0){           
                    $stmt=$link->prepare("INSERT INTO catagory (Name,Describtion,Ordering,Visibilty,Allow_Comment,Allow_Ads) VALUES(:zname,:zdesc,:zorder,:zvis,:zcomment,:zads)");
                    $stmt->execute(array('zname'=>$name,
                                        'zdesc'=>$desc,
                                        'zorder'=>$order,
                                        'zvis'=>$vis,
                                        'zcomment'=>$comment,
                                        'zads'=>$ads));
                    $count=$stmt->rowCount();
                    $success= $count." ".'Catagory Insert';
                    $page='catagory.php?action=mange';
                    redirectMessage($success,10,$page,true);
        
                    }
                    else{
                        $error='Sorry This Caatgory is Exits';
                        $page='catagory.php?action=add';
                        redirectMessage($error,10,$page,false);
        
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
        
        if(isset($_GET['catid'])&&is_numeric($_GET['catid'])){
            $catID=intval($_GET['catid']);  
            $stmt=$link->prepare("SELECT * FROM catagory WHERE ID =? ");
            $stmt->execute(array($catID));
            $res=$stmt->fetch();
            $count=$stmt->rowCount();
            if($count>0){   ?>
            <h1 class="text-center " style="color:#666">Edit Catagory<h1>
            <div class="container">
        <form class="form-horizontal" action="?action=update" method="post">
        <input type="hidden" name="ID" value="<?php  echo $catID ?>" />

            <div class="form-group">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" value="<?php echo $res['Name'] ?>"name="name" class="form-control" autocomplete="off" placeholder="Name Of The Catagory"/>

             </div>    
            </div>  
            <div class="form-group">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10">
            <input type="text"  value="<?php echo $res['Describtion']; ?>"   placeholder="Description Of Catagory"  name="description" class="form-control" autocomplete="new-password"/>

             </div>    
            </div> 
            <div class="form-group">
            <label class="col-sm-2 control-label">Ordering</label>
            <div class="col-sm-10">
                <input type="number" value="<?php echo $res['Ordering'] ?>"  name="ordering" class="form-control" placeholder="Number  TO Arrange Catagories"/>
                
             </div>    
            </div> 
            <div class="form-group">
            <label class="col-sm-2 control-label" style="font-size:34px">Visible</label>
            <div class="col-sm-10" style="font-size:20px" >
                <div>
                    <input id="s" type="radio" name="vis" value="0" <?php if($res['Visibilty']==0){ echo 'checked'; } ?> />
                    <label for="s">Yes</label>
                </div>
                <div>
                    <input id="s2" type="radio" name="vis" value="1" <?php if($res['Visibilty']==1){echo 'checked';} ?> />
                    <label for="s2">No</label>
                </div>
             </div>    
            </div> 
            <div class="form-group">
            <label class="col-sm-2 control-label" style="font-size:34px">Allow Comment</label>
            <div class="col-sm-10" style="font-size:20px" >
                <div>
                    <input id="s1" type="radio" name="comment" value="0" <?php if($res['Allow_Comment']==0){ echo 'checked'; } ?> />
                    <label for="s1">Yes</label>
                </div>
                <div>
                    <input id="s3" type="radio" name="comment" value="1" <?php if($res['Allow_Comment']==1){ echo 'checked'; } ?>/>
                    <label for="s3">No</label>
                </div>
             </div>    
            </div>
            <div class="form-group">
            <label class="col-sm-2 control-label" style="font-size:34px">Allow Ads</label>
            <div class="col-sm-10" style="font-size:20px" >
                <div>
                    <input id="s7" type="radio" name="ads" value="0" <?php if($res['Allow_Ads']==0){ echo 'checked'; } ?> />
                    <label for="s7">Yes</label>
                </div>
                <div>
                    <input id="s8" type="radio" name="ads" value="1" <?php if($res['Allow_Ads']==1){ echo 'checked'; } ?>/>
                    <label for="s8">No</label>
                </div>
             </div>    
            </div> 
            







            <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Update Catagory" class="btn btn-primary btn-lg"/>
                
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
      

        }
    elseif($action=='update'){
        echo " <h1 class='text-center' style='color:#666'>Update Gatagory<h1>"; 
        echo "<div class='container'>";
        if($_SERVER['REQUEST_METHOD']=='POST'){
     
           $ID=$_POST['ID'];
           $name=$_POST['name'];
           $desc=$_POST['description'];
           $order=$_POST['ordering'];

           $comment=$_POST['comment'];
           $vis=$_POST['vis'];

           $ads=$_POST['ads'];

         
             
         
             
             $stmt=$link->prepare("UPDATE catagory SET Name = ?,Describtion = ?,Ordering = ?,Visibilty = ?,Allow_Comment = ?,Allow_Ads = ? WHERE ID = ?");
             $stmt->execute(array($name,$desc,$order,$vis,$comment,$ads,$ID));
             $count=$stmt->rowCount();
             //echo "<div class='alert alert-success'>". $count." ".'Record Updated'."</div>";
             $success=$count." "."Catagory Updated";
             $page="catagory.php?action=mange";
             redirectMessage($success,10,$page,true);
     
     
         
     
          
           
           
     
     
     
        }
        
        else{
            $error= 'you cant browse this page';
            $page="catagory.php";
            redirectMessage($error,10,$page,false);
        }
        echo "</div>";
     
     
     
     
     
     
     
     
       
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