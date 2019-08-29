<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['stlogin'])==0)
    {   
header('location:login.php');
}
else{
?>

<?php include('partials/head.php');?>
<?php include('partials/header.php');?>
<?php include('partials/sidebar.php');?>
<main class="mn-inner">
    <div class="middle-content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l4">
            <div class="card stats-card">
                <div class="card-content">
                    <span class="card-title">Registered Users</span>
                        <span class="stats-counter">
                        <?php
                        $sql = "SELECT id from users";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $userCount=$query->rowCount();
                        ?>
                        <span class="counter"><?php echo htmlentities($userCount);?></span></span>
                </div>
                <div id="sparkline-bar"></div>
            </div>
        </div>
        <div class="col s12 m12 l4">
            <div class="card stats-card">
                <div class="card-content">
                    <span class="card-title">Total Rooms </span>
                    <?php
                    $sql = "SELECT id from room";
                    $query = $dbh -> prepare($sql);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    $roomCount=$query->rowCount();
                    ?>
                    <span class="stats-counter"><span class="counter"><?php echo htmlentities($roomCount);?></span></span>
                </div>
                <div id="sparkline-line"></div>
            </div>
        </div>
        <div class="col s12 m12 l4">
            <div class="card stats-card">
                <div class="card-content">
                    <span class="card-title">Total Room Types</span>
                        <?php
                        $sql = "SELECT id from  roomtype";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $rmtypCount=$query->rowCount();
                        ?>
                        <span class="stats-counter"><span class="counter"><?php echo htmlentities($rmtypCount);?></span></span>
                        </div>
                            <div class="progress stats-card-progress">
                                <div class="determinate" style="width: 70%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row no-m-t no-m-b">
                        <div class="col s12 m12 l12">
                            <div class="card invoices-card">
                                <div class="card-content">
                                 
                                    <span class="card-title">Latest Reservations </span>
                             <table id="example" class="display responsive-table ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th width="200">Name</th>
                                            <th width="120">Room Type</th>

                                             <th width="180">Posting Date</th>                 
                                            <th>Status</th>
                                            <th align="center">Action</th>
                                        </tr>
                                    </thead>
                                 
                                    <tbody>
                                    <?php $sql = "SELECT reservation.id as rid,users.FirstName,users.LastName,users.username,users.id,reservation.RoomType,reservation.PostingDate,reservation.Status from reservation join users on reservation.uid=users.id order by rid desc limit 6";
                                    $query = $dbh -> prepare($sql);
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
                                            <td><?php echo htmlentities($result->FirstName." ".$result->LastName);?>(<?php echo htmlentities($result->username);?>)</a></td>
                                            <td><?php echo htmlentities($result->RoomType);?></td>
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
                                            <td><a href="reservationDetails.php?resid=<?php echo htmlentities($result->rid);?>" class="waves-effect waves-light btn blue m-b-xs"  > View Details</a></td>
                                    </tr>
                                         <?php $cnt++;} }?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
 <?php include ('partials/footer.php');?>
<?php } ?>