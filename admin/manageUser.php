<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{
// code for Inactive  user
if(isset($_GET['inid']))
{
$id=$_GET['inid'];
$status=0;
$sql = "update users set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:manageUser.php');
}


//code for active user
if(isset($_GET['id']))
{
$id=$_GET['id'];
$status=1;
$sql = "update users set Status=:status  WHERE id=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:manageUser.php');
}
 ?>
<?php include('partials/header.php');?>
<?php include('partials/sidebar.php');?>
<main class="mn-inner">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">User Info</span>
                    <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                    <table id="example" class="display responsive-table ">
                        <thead>
                            <tr>
                                <th>no.</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Role</th>
                                 <th>Status</th>
                                 <th>Reg Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php $sql = "SELECT username,FirstName,LastName,Role,Status,RegDate,id from  users";
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
                            <td><?php echo htmlentities($result->username);?></td>
                            <td><?php echo htmlentities($result->FirstName);?>&nbsp;<?php echo htmlentities($result->LastName);?></td>
                            <td><?php echo htmlentities($result->Role);?></td>
                             <td><?php $stats=$result->Status;
                            if($stats){
                                         ?>
                             <a class="waves-effect waves-green btn-flat m-b-xs">Active</a>
                             <?php } else { ?>
                             <a class="waves-effect waves-red btn-flat m-b-xs">Inactive</a>
                             <?php } ?>
                             </td>

                            <td><?php echo htmlentities($result->RegDate);?></td>
                            <td><a href="editUser.php?unid=<?php echo htmlentities($result->id);?>"><i class="material-icons">mode_edit</i></a>
                            <?php if($result->Status==1)
                             {?>
                            <a href="manageUser.php?inid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to disable this user?');"" > <i class="material-icons" title="Inactive">clear</i>
                            <?php } else {?>

                            <a href="manageUser.php?id=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to activate this user?');""><i class="material-icons" title="Active">done</i>
                            <?php } ?> </td>
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