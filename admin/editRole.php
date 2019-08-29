<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{
    header('location:index.php');
}
else{
    if(isset($_POST['update']))
    {
        $rid=intval($_GET['rid']);
        $role=$_POST['role'];
        $rolecode=$_POST['rolecode'];
        $sql="update roles set RoleName=:role,RoleShortName=:rolecode where id=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':role',$role,PDO::PARAM_STR);
        $query->bindParam(':rolecode',$rolecode,PDO::PARAM_STR);
        $query->bindParam(':rid',$rid,PDO::PARAM_STR);
        $query->execute();

        $msg="Role updated Successfully";

    }

    ?>
<?php include('partials/head.php');?>
<?php include('partials/header.php');?>
<?php include('partials/sidebar.php');?>
<main class="mn-inner">
    <div class="row">
        <div class="col s12">
            <div class="page-title">Edit Role</div>
        </div>
        <div class="col s12 m12 l6">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <form class="col s12" name="chngpwd" method="post">
                            <?php if($error){?><div class="errorWrap"><strong>ERROR</strong> : <?php echo htmlentities($error); ?> </div><?php }
                            else if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                            <?php
                            $rid=intval($_GET['rid']);
                            $sql = "SELECT * from roles where id=:rid";
                            $query = $dbh -> prepare($sql);
                            $query->bindParam(':rid',$rid,PDO::PARAM_STR);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            $cnt=1;
                            if($query->rowCount() > 0)
                            {
                            foreach($results as $result)
                            {               ?>

                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="role" type="text"  class="validate" autocomplete="off" name="role" value="<?php echo htmlentities($result->RoleName);?>"  required>
                                    <label for="role">Role Name</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="roleShortName" type="text"  class="validate" autocomplete="off" name="rolecode" value="<?php echo htmlentities($result->RoleShortName);?>"  required>
                                    <label for="roleShortName">Role Code</label>
                                </div>

                                <?php }} ?>
                                <div class="input-field col s12">
                                    <button type="submit" name="update" class="waves-effect waves-light btn indigo m-b-xs">Update</button>
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