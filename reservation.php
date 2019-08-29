<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['gtlogin'])==0)
    {   
header('location:login.php');
}
else{
if(isset($_POST['apply']))
{
$uid=$_SESSION['uid'];
$roomtype=$_POST['roomtype'];
$fromdate=$_POST['fromdate'];  
$todate=$_POST['todate'];
$description=$_POST['description'];  
$status=0;
$isread=0;
if($fromdate > $todate){
    $error=" ToDate should be greater than FromDate ";
    }
$sql="INSERT INTO reservation(RoomType,ToDate,FromDate,Description,Status,IsRead,uid) VALUES(:roomtype,:fromdate,:todate,:description,:status,:isread,:uid)";
$query = $dbh->prepare($sql);
$query->bindParam(':roomtype',$roomtype,PDO::PARAM_STR);
$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
$query->bindParam(':todate',$todate,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':isread',$isread,PDO::PARAM_STR);
$query->bindParam(':uid',$uid,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Reservation Sent successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

}

?>
<?php include('includes/head.php');?>
<?php include('includes/header.php');?>
<?php include('includes/sidebar.php');?>
   <main class="mn-inner">
                <div class="row">
                    <div class="col s12">
                        <div class="page-title">Reservation</div>
                    </div>
                    <div class="col s12 m12 l8">
                        <div class="card">
                            <div class="card-content">
                                <form id="example-form" method="post" name="addemp">
                                    <div>
                                        <h3>Reservation</h3>
                                        <section>
                                            <div class="wizard-content">
                                                <div class="row">
                                                    <div class="col m12">
                                                        <div class="row">
                                                        <?php if($error){?><div class="errorWrap"><strong>ERROR </strong>:<?php echo htmlentities($error); ?> </div><?php }
                                                        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

                                                     <div class="input-field col  s12">
                                                        <select  name="roomtype" autocomplete="off">
                                                        <option value="">Select room type...</option>
                                                        <?php $sql = "SELECT  roomType from roomtype";
                                                        $query = $dbh -> prepare($sql);
                                                        $query->execute();
                                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt=1;
                                                        if($query->rowCount() > 0)
                                                        {
                                                        foreach($results as $result)
                                                        {   ?>
                                                        <option value="<?php echo htmlentities($result->roomType);?>"><?php echo htmlentities($result->roomType);?></option>
                                                        <?php }} ?>
                                                        </select>
                                                    </div>
                                                <div class="input-field col m6 s12">
                                                    <label for="fromdate">From  Date</label>
                                                    <input placeholder="" id="mask1" name="fromdate" class="masked" type="text" data-inputmask="'alias': 'date'" required>
                                                </div>
                                                <div class="input-field col m6 s12">
                                                    <label for="todate">To Date</label>
                                                    <input placeholder="" id="mask1" name="todate" class="masked" type="text" data-inputmask="'alias': 'date'" required>
                                                </div>
                                                <div class="input-field col m12 s12">
                                                    <label for="birthdate">Description</label>
                                                    <textarea id="textarea1" name="description" class="materialize-textarea" maxlength="500" ></textarea>
                                                </div>
                                            </div>
                                                <button type="submit" name="apply" id="apply" class="waves-effect waves-light btn indigo m-b-xs">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                         </div>
                    </div>
                </div>
            </div>
    </main>
<?php include ('includes/footer.php');?>
<?php } ?> 