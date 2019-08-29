<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{

 ?>
<?php include('partials/head.php');?>
<?php include('partials/header.php');?>
<?php include('partials/sidebar.php');?>
<main class="mn-inner">
    <div class="row">
        <div class="col s12">
            <div class="page-title">Pending Reservations</div>
        </div>
        <div class="col s12 m12 l12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Pending Reservations</span>
                    <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                    <table id="example" class="display responsive-table ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th width="200">Name</th>
                                <th width="120">Reservation Type</th>

                                 <th width="180">Posting Date</th>
                                <th>Status</th>
                                <th align="center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                        $status=0;
                        $sql = "SELECT reservation.id as rid,users.FirstName,users.LastName,users.username,users.id,reservation.roomType,reservation.PostingDate,reservation.Status from reservation join users on reservation.uid=users.id where reservation.Status=:status order by rid desc";
                        $query = $dbh -> prepare($sql);
                        $query->bindParam(':status',$status,PDO::PARAM_STR);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $result)
                        {
                              ?>

                            <tr>
                                <td> <b><?php echo htmlentities($cnt);?></b></td>
                                  <td><a href="editUser.php?unid=<?php echo htmlentities($result->id);?>" target="_blank"><?php echo htmlentities($result->FirstName." ".$result->LastName);?>(<?php echo htmlentities($result->username);?>)</a></td>
                                <td><?php echo htmlentities($result->roomType);?></td>
                                <td><?php echo htmlentities($result->PostingDate);?></td>
                                <td><?php $stats=$result->Status;
                                            if($stats==1){
                                                              ?>
                                     <span style="color: green">Approved</span>
                                     <?php } if($stats==2)  { ?>
                                    <span style="color: red">Declined</span>
                                     <?php } if($stats==0)  { ?>
                                     <span style="color: blue">waiting for approval</span>
                                     <?php } ?>
                                </td>

                                <td>
                                    <a href="reservationDetails.php?resid=<?php echo htmlentities($result->rid);?>" class="waves-effect waves-light btn blue m-b-xs"> View Details</a>
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
<?php include ('partials/footer.php');?>
<?php } ?>