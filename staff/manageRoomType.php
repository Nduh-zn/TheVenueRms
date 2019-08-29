<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['stlogin'])==0)
    {   
header('location:login.php');
}
else{
if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from  roomtype  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$msg="Room type successfully deleted";

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
                    <span class="card-title">Room Type Info</span>
                    <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                    <table id="example" class="display responsive-table ">
                        <thead>
                            <tr>
                                <th>no</th>
                                <th>Room Type</th>
                                <th>Description</th>
                                <th>Creation Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                                 
                        <tbody>
                        <?php $sql = "SELECT * from roomtype";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $result)
                        {               ?>
                        <tr>
                            <td> <?php echo htmlentities($cnt);?></td>
                            <td><?php echo htmlentities($result->roomType);?></td>
                            <td><?php echo htmlentities($result->Description);?></td>
                            <td><?php echo htmlentities($result->CreationDate);?></td>
                            <td><a href="editRoomType.php?rid=<?php echo htmlentities($result->id);?>"><i class="material-icons">mode_edit</i></a>
                            <a href="manageRoomType.php?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to delete this room type?');"> <i class="material-icons">delete_forever</i></a> </td>
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