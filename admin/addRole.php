<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{
if(isset($_POST['add']))
{
$role=$_POST['role'];
$roleShortName=$_POST['roleShortName'];

$sql="INSERT INTO roles(RoleName,RoleShortName) VALUES(:role,:roleShortName)";
$query = $dbh->prepare($sql);
$query->bindParam(':role',$role,PDO::PARAM_STR);
$query->bindParam(':roleShortName',$roleShortName,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Role Created Successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

}

    ?>


<?php include('partials/head.php');?>
<?php include('partials/header.php');?>
<?php include('partials/sidebar.php');?>
<main class="mn-inner">
    <div class="row">
        <div class="col s12">
            <div class="page-title">Add Role</div>
        </div>
        <div class="col s12 m12 l6">
            <div class="card">
                <div class="card-content">

                    <div class="row">
                        <form class="col s12" name="chngpwd" method="post">
                              <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                             else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="role" type="text"  class="validate" autocomplete="off" name="role"  required>
                                    <label for="role">Role Name</label>
                                </div>

                                <div class="input-field col s12">
                                    <input id="roleshortname" type="text"  class="validate" autocomplete="off" name="roleshortname"  required>
                                    <label for="roleshortname">Role code</label>
                                </div>

                                <div class="input-field col s12">
                                    <button type="submit" name="add" class="waves-effect waves-light btn indigo m-b-xs">ADD</button>
                               </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include ('partials/footer.php');?>
<?php } ?> 