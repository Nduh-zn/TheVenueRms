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
$roomtype=$_POST['roomtype'];
$description=$_POST['description'];
$sql="update roomtype set roomType=:roomtype,Description=:description where id=:rid";
$query = $dbh->prepare($sql);
$query->bindParam(':roomtype',$roomtype,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();

$msg="Room type updated Successfully";


}

?>

<?php include('partials/head.php');?>
<?php include('partials/header.php');?>
<?php include('partials/sidebar.php');?>
<main class="mn-inner">
    <div class="row">
        <div class="col s12">
            <div class="page-title">Edit Room Type</div>
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
                                $sql = "SELECT * from roomtype where id=:rid";
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
                                        <input id="roomtype" type="text"  class="validate" autocomplete="off" name="roomtype" value="<?php echo htmlentities($result->roomType);?>"  required>
                                        <label for="roomtype">Room Type</label>
                                    </div>

                                    <div class="input-field col s12">
                                        <textarea id="textarea1" name="description" class="materialize-textarea" name="description" length="500"><?php echo htmlentities($result->Description);?></textarea>
                                        <label for="deptshortname">Description</label>
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