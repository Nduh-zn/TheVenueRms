<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['stlogin'])==0)
{
    header('location:login.php');
}
else{

// code for update the read notification status
    $isread=1;
    $did=intval($_GET['resid']);
    date_default_timezone_set('Asia/Kolkata');
    $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
    $sql="update reservation set IsRead=:isread where id=:did";
    $query = $dbh->prepare($sql);
    $query->bindParam(':isread',$isread,PDO::PARAM_STR);
    $query->bindParam(':did',$did,PDO::PARAM_STR);
    $query->execute();

// code for action taken on leave
    if(isset($_POST['update']))
    {
        $did=intval($_GET['resid']);
        $description=$_POST['description'];
        $status=$_POST['status'];
        date_default_timezone_set('Asia/Kolkata');
        $admremarkdate=date('Y-m-d G:i:s ', strtotime("now"));
        $sql="update reservation set AdminRemark=:description,Status=:status,AdminRemarkDate=:admremarkdate where id=:did";
        $query = $dbh->prepare($sql);
        $query->bindParam(':description',$description,PDO::PARAM_STR);
        $query->bindParam(':status',$status,PDO::PARAM_STR);
        $query->bindParam(':admremarkdate',$admremarkdate,PDO::PARAM_STR);
        $query->bindParam(':did',$did,PDO::PARAM_STR);
        $query->execute();
        $msg="reservation updated Successfully";
    }



    ?>

<?php include('partials/head.php');?>
<?php include('partials/header.php');?>
<?php include('partials/sidebar.php');?>
<main class="mn-inner">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Reservation Details</span>
                    <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                    <table id="example" class="display responsive-table ">
                        <tbody>
                        <?php
                        $rid=intval($_GET['resid']);
                        $sql = "SELECT reservation.id as rid,users.FirstName,users.LastName,users.username,users.id,users.Gender,users.Phonenumber,users.EmailId,reservation.roomType,reservation.ToDate,reservation.FromDate,reservation.Description,reservation.PostingDate,reservation.Status,reservation.AdminRemark,reservation.AdminRemarkDate from reservation join users on reservation.uid=users.id where reservation.id=:rid";
                        $query = $dbh -> prepare($sql);
                        $query->bindParam(':rid',$rid,PDO::PARAM_STR);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                            foreach($results as $result)
                            {
                                ?>

                                <tr>
                                    <td style="font-size:16px;"> <b>Name :</b></td>
                                    <td><?php echo htmlentities($result->FirstName." ".$result->LastName);?></a></td>
                                    <td style="font-size:16px;"><b>Username :</b></td>
                                    <td><?php echo htmlentities($result->username);?></td>
                                    <td style="font-size:16px;"><b>Gender :</b></td>
                                    <td><?php echo htmlentities($result->Gender);?></td>
                                </tr>

                                <tr>
                                    <td style="font-size:16px;"><b>Email id :</b></td>
                                    <td><?php echo htmlentities($result->EmailId);?></td>
                                    <td style="font-size:16px;"><b>Contact No. :</b></td>
                                    <td><?php echo htmlentities($result->Phonenumber);?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="font-size:16px;"><b>Reservation Type :</b></td>
                                    <td><?php echo htmlentities($result->roomType);?></td>
                                    <td style="font-size:16px;"><b>Reservation Dates :</b></td>
                                    <td>From <?php echo htmlentities($result->FromDate);?> to <?php echo htmlentities($result->ToDate);?></td>
                                    <td style="font-size:16px;"><b>Posting Date</b></td>
                                    <td><?php echo htmlentities($result->PostingDate);?></td>
                                </tr>
                                <tr>
                                    <td style="font-size:16px;"><b>Reservation Note : </b></td>
                                    <td colspan="5"><?php echo htmlentities($result->Description);?></td>

                                </tr>
                                <tr>
                                    <td style="font-size:16px;"><b>Reservation Status:</b></td>
                                    <td colspan="5"><?php $stats=$result->Status;
                                        if($stats==1){
                                            ?>
                                            <span style="color: green">Approved</span>
                                        <?php } if($stats==2)  { ?>
                                            <span style="color: red">Declined</span>
                                        <?php } if($stats==0)  { ?>
                                            <span style="color: blue">waiting for approval</span>
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="font-size:16px;"><b>Staff Remark: </b></td>
                                    <td colspan="5"><?php
                                        if($result->AdminRemark==""){
                                            echo "waiting for Approval";
                                        }
                                        else{
                                            echo htmlentities($result->AdminRemark);
                                        }
                                        ?></td>
                                </tr>

                                <tr>
                                    <td style="font-size:16px;"><b>Action taken date : </b></td>
                                    <td colspan="5"><?php
                                        if($result->AdminRemarkDate==""){
                                            echo "NA";
                                        }
                                        else{
                                            echo htmlentities($result->AdminRemarkDate);
                                        }
                                        ?></td>
                                </tr>
                                <?php
                                if($stats==0)
                                {

                                ?>
                                <tr>
                                    <td colspan="5">
                                        <a class="modal-trigger waves-effect waves-light btn" href="#modal1">Take&nbsp;Action</a>
                                        <form name="adminaction" method="post">
                                            <div id="modal1" class="modal modal-fixed-footer" style="height: 60%">
                                                <div class="modal-content" style="width:90%">
                                                    <h4>Leave take action</h4>
                                                    <select class="browser-default" name="status" required="">
                                                        <option value="">Choose your option</option>
                                                        <option value="1">Approve</option>
                                                        <option value="2">Decline</option>
                                                    </select></p>
                                                    <p><textarea id="textarea1" name="description" class="materialize-textarea" placeholder="Description" length="500" maxlength="500" required></textarea></p>
                                                </div>
                                                <div class="modal-footer" style="width:90%">
                                                    <input type="submit" class="waves-effect waves-light btn blue m-b-xs" name="update" value="Submit">
                                                </div>

                                            </div>

                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php $cnt++;} }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php include ('partials/footer.php');?>
<?php } ?>