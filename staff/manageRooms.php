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
        $sql = "delete from  room  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':id',$id, PDO::PARAM_STR);
        $query -> execute();
        $msg="Room deleted";

    }

    ?>
<?php include('partials/head.php');?>
<?php include('partials/header.php');?>
<?php include('partials/sidebar.php');?>
    <main class="mn-inner">
        <div class="row">
            <div class="col s12">
                <div class="page-title">Manage Rooms</div>
            </div>
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">Room Info</span>
                        <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                        <table id="example" class="display responsive-table ">
                            <thead>
                            <tr>
                                <th>no</th>
                                <th>Room Name</th>
                                <th>Role Type</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $sql = "SELECT * from room";
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
                                        <td><?php echo htmlentities($result->RoomName);?></td>
                                        <td><?php echo htmlentities($result->RoomType);?></td>
                                        <td><?php echo htmlentities($result->Description);?></td>
                                        <td><a href="editRoom.php?rid=<?php echo htmlentities($result->id);?>"><i class="material-icons">mode_edit</i></a><a href="manageRoles.php?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to delete this room?');"> <i class="material-icons">delete_forever</i></a></td>
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