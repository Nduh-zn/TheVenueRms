<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['stlogin'])==0)
{
    header('location:login.php');
}
else{
    if(isset($_POST['add']))
    {
        $room=$_POST['room'];
        $roomtype=$_POST['roomtype'];
        $description=$_POST['description'];

        $sql="INSERT INTO room(RoomName,RoomType,Description) VALUES(:room,:roomtype,:description)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':room',$room,PDO::PARAM_STR);
        $query->bindParam(':roomtype',$roomtype,PDO::PARAM_STR);
        $query->bindParam(':description',$description,PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId)
        {
            $msg="Room Created Successfully";
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
            <div class="page-title">Add Room</div>
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
                                        <input id="room" type="text"  class="validate" autocomplete="off" name="room"  required>
                                        <label for="room">Room Name</label>
                                    </div>
                                    <div class="input-field col m6 s12">
                                        <select  name="roomtype" autocomplete="off">
                                            <option value="">Room Type...</option>
                                            <?php $sql = "SELECT roomType from roomtype";
                                            $query = $dbh -> prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if($query->rowCount() > 0)
                                            {
                                                foreach($results as $result)
                                                {   ?>
                                                    <option value="<?php echo htmlentities($result->roomType);?>"><?php echo htmlentities($result->roomType);?></option>
                                                <?php }} ?>
                                        </select>
                                    </div>
                                    <div class="input-field col s12">
                                        <input id="description" type="text"  class="validate" autocomplete="off" name="description"  required>
                                        <label for="description">Description</label>
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