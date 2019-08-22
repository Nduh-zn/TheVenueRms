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

    <!DOCTYPE html>
    <html lang="en">
    <head>

        <!-- Title -->
        <title>Admin | Add Role</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />

        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
                box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            }
            .succWrap{
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
                box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            }
        </style>
    </head>
    <body>
    <?php include('includes/header.php');?>

    <?php include('includes/sidebar.php');?>
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

    </div>
    <div class="left-sidebar-hover"></div>

    <!-- Javascripts -->
    <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
    <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
    <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
    <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
    <script src="../assets/js/alpha.min.js"></script>
    <script src="../assets/js/pages/form_elements.js"></script>

    </body>
    </html>
<?php } ?>