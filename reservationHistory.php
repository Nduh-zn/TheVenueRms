<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['gtlogin'])==0)
    {   
header('location: login.php');
}
else{

 ?>
<?php include('includes/head.php');?>
<?php include('includes/header.php');?>
<?php include('includes/sidebar.php');?>
<main class="mn-inner">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Reservation History</span>
                    <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                    <table id="example" class="display responsive-table ">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th width="120">Reservation Type</th>
                        <th>From</th>
                        <th>To</th>
                         <th>Description</th>
                         <th width="120">Posting Date</th>
                        <th width="200">Admin Remak</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $uid=$_SESSION['uid'];
                    $sql = "SELECT RoomType,ToDate,FromDate,Description,PostingDate,AdminRemarkDate,AdminRemark,Status from reservation where uid=:uid";
                    $query = $dbh -> prepare($sql);
                    $query->bindParam(':uid',$uid,PDO::PARAM_STR);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    $cnt=1;
                    if($query->rowCount() > 0)
                    {
                    foreach($results as $result)
                    {               ?>
                        <tr>
                            <td> <?php echo htmlentities($cnt);?></td>
                            <td><?php echo htmlentities($result->RoomType);?></td>
                            <td><?php echo htmlentities($result->ToDate);?></td>
                            <td><?php echo htmlentities($result->FromDate);?></td>
                           <td><?php echo htmlentities($result->Description);?></td>
                            <td><?php echo htmlentities($result->PostingDate);?></td>
                            <td><?php if($result->AdminRemark=="")
                            {
                            echo htmlentities('waiting for approval');
                            }
                            else
                                {
                                    echo htmlentities(($result->AdminRemark)." "."at"." ".$result->AdminRemarkDate);
                                }
                            ?></td>
                            <td><?php $stats=$result->Status;
                            if($stats==1)
                                {
                                    ?>
                                 <span style="color: green">Approved</span>
                                 <?php } if($stats==2)  { ?>
                                <span style="color: red">Declined</span>
                                 <?php } if($stats==0)  { ?>
                                <span style="color: blue">waiting for approval</span>
                                <?php } ?>

                             </td>
                        </tr>
                         <?php $cnt++;} }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
<?php include('includes/footer.php');?>
<?php } ?>