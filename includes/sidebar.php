 <aside id="slide-out" class="side-nav white fixed">
            <div class="side-nav-wrapper">
                <div class="sidebar-profile">
                    <div class="sidebar-profile-image">
                        <img src="assets/images/profile-image.png" class="circle" alt="">
                    </div>
                    <div class="sidebar-profile-info">
                    <?php
$uid=$_SESSION['uid'];
$sql = "SELECT FirstName,LastName,username from  users where id=:uid";
$query = $dbh -> prepare($sql);
$query->bindParam(':uid',$uid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
?>
<p><?php echo htmlentities($result->FirstName." ".$result->LastName);?></p>
<span><?php echo htmlentities($result->username)?></span>
<?php }} ?>
                    </div>
                </div>

<ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion">
  <li class="no-padding"><a class="waves-effect waves-grey" href="myprofile.php"><i class="material-icons">account_box</i>My Profile</a></li>
  <li class="no-padding"><a class="waves-effect waves-grey" href="changePassword.php"><i class="material-icons">settings_input_svideo</i>Change Password</a></li>
    <li class="no-padding">
        <a class="collapsible-header waves-effect waves-grey"><i class="material-icons">apps</i>Reservations<i class="nav-drop-icon material-icons">keyboard_arrow_right</i></a>
        <div class="collapsible-body">
            <ul>
                <li><a href="reservation.php">Book Reservation</a></li>
                <li><a href="reservationHistory.php">Reservation History</a></li>
            </ul>
        </div>
    </li>

    <li class="no-padding">
        <a class="waves-effect waves-grey" href="logout.php"><i class="material-icons">exit_to_app</i>Sign Out</a>
    </li>
    </ul>
    <div class="footer">
        <p class="copyright">&copy; Copyright 2019 <a href="https://nducv.000webhostapp.com/">Ndu</a></p>
    </div>
    </div>
</aside>
