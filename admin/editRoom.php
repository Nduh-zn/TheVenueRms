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
        $roomname=$_POST['roomname'];
        $roomtype=$_POST['roomtype'];
        $description=$_POST['description'];
        $sql="update room set RoomName=:roomname, RoomType=:roomtype,Description=:description where id=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':roomname',$roomname,PDO::PARAM_STR);
        $query->bindParam(':roomtype',$roomtype,PDO::PARAM_STR);
        $query->bindParam(':description',$description,PDO::PARAM_STR);
        $query->bindParam(':rid',$rid,PDO::PARAM_STR);
        $query->execute();

        $msg="Room updated Successfully";
    }

    ?>

<?php include('partials/header.php');?>
<?php include('partials/sidebar.php');?>
<main class="mn-inner">
    <div class="row">
        <div class="col s12">
            <div class="page-title">Edit Room</div>
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
                            $sql = "SELECT * from room where id=:rid";
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
                                    <input id="roomname" type="text"  class="validate" autocomplete="off" name="roomname" value="<?php echo htmlentities($result->RoomName);?>"  required>
                                    <label for="roomname">Room Name</label>
                                </div>

                                <div class="input-field col m6 s12">
                                    <select  name="roomtype" autocomplete="off">
                                        <option value="<?php echo htmlentities($result->RoomType);?>"><?php echo htmlentities($result->RoomType);?></option>
                                        <?php $sql = "SELECT RoomType from roomtype";
                                        $query = $dbh -> prepare($sql);
                                        $query->execute();
                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt=1;
                                        if($query->rowCount() > 0)
                                        {
                                            foreach($results as $resultt)
                                            {   ?>
                                                <option value="<?php echo htmlentities($resultt->RoomType);?>"><?php echo htmlentities($resultt->RoomType);?></option>
                                            <?php }} ?>
                                    </select>
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