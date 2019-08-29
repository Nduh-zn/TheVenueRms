<?php
session_start();
error_reporting(0);
include('../includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{
$uid=intval($_GET['unid']);
if(isset($_POST['update']))
{

$fname=$_POST['firstName'];
$lname=$_POST['lastName'];   
$gender=$_POST['gender']; 
$dob=$_POST['dob']; 
$role=$_POST['role'];
$address=$_POST['address']; 
$city=$_POST['city']; 
$country=$_POST['country']; 
$mobileno=$_POST['mobileno']; 
$sql="update users set FirstName=:fname,LastName=:lname,Gender=:gender,Dob=:dob,Role=:role,Address=:address,City=:city,Country=:country,Phonenumber=:mobileno where id=:uid";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':lname',$lname,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':role',$role,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':city',$city,PDO::PARAM_STR);
$query->bindParam(':country',$country,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->bindParam(':uid',$uid,PDO::PARAM_STR);
$query->execute();
$msg="Employee record updated Successfully";
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
                    <form id="example-form" method="post" name="updatemp">
                        <div>
                            <h5>Update User Info</h5>
                               <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                                else if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                            <section>
                            <div class="wizard-content">
                                <div class="row">
                                    <div class="col m6">
                                        <div class="row">
                                    <?php
                                    $uid=intval($_GET['unid']);
                                    $sql = "SELECT * from  users where id=:uid";
                                    $query = $dbh -> prepare($sql);
                                    $query -> bindParam(':uid',$uid, PDO::PARAM_STR);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0)
                                    {
                                    foreach($results as $result)
                                    {               ?>
                                     <div class="input-field col  s12">
                                        <label for="empcode">Username(Must be unique)</label>
                                        <input  name="empcode" id="empcode" value="<?php echo htmlentities($result->username);?>" type="text" autocomplete="off" readonly required>
                                        <span id="empid-availability" style="font-size:12px;"></span>
                                    </div>

                                    <div class="input-field col m6 s12">
                                        <label for="firstName">First name</label>
                                        <input id="firstName" name="firstName" value="<?php echo htmlentities($result->FirstName);?>"  type="text" required>
                                    </div>

                                    <div class="input-field col m6 s12">
                                        <label for="lastName">Last name </label>
                                        <input id="lastName" name="lastName" value="<?php echo htmlentities($result->LastName);?>" type="text" autocomplete="off" required>
                                    </div>

                                    <div class="input-field col s12">
                                        <label for="email">Email</label>
                                        <input  name="email" type="email" id="email" value="<?php echo htmlentities($result->EmailId);?>" readonly autocomplete="off" required>
                                        <span id="emailid-availability" style="font-size:12px;"></span>
                                    </div>

                                    <div class="input-field col s12">
                                        <label for="phone">Mobile number</label>
                                        <input id="phone" name="mobileno" type="tel" value="<?php echo htmlentities($result->Phonenumber);?>" maxlength="10" autocomplete="off" required>
                                     </div>
                                </div>
                            </div>
                                                    
                            <div class="col m6">
                            <div class="row">
                            <div class="input-field col m6 s12">
                                <select  name="gender" autocomplete="off">
                                    <option value="<?php echo htmlentities($result->Gender);?>"><?php echo htmlentities($result->Gender);?></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="input-field col m6 s12">
                                <label for="birthdate">Date of Birth</label>
                                <input id="birthdate" name="dob"  class="datepicker" value="<?php echo htmlentities($result->Dob);?>" >
                            </div>

                            <div class="input-field col m6 s12">
                            <select  name="role" autocomplete="off">
                                <option value="<?php echo htmlentities($result->Role);?>"><?php echo htmlentities($result->Role);?></option>
                                <?php $sql = "SELECT roleName from roles";
                                $query = $dbh -> prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                $cnt=1;
                                if($query->rowCount() > 0)
                                {
                                foreach($results as $resultt)
                                {   ?>
                                <option value="<?php echo htmlentities($resultt->roleName);?>"><?php echo htmlentities($resultt->roleName);?></option>
                                <?php }} ?>
                            </select>
                            </div>

                            <div class="input-field col m6 s12">
                                <label for="address">Address</label>
                                <input id="address" name="address" type="text"  value="<?php echo htmlentities($result->Address);?>" autocomplete="off" required>
                            </div>

                            <div class="input-field col m6 s12">
                                <label for="city">City/Town</label>
                                <input id="city" name="city" type="text"  value="<?php echo htmlentities($result->City);?>" autocomplete="off" required>
                             </div>
   
                            <div class="input-field col m6 s12">
                                <label for="country">Country</label>
                                <input id="country" name="country" type="text"  value="<?php echo htmlentities($result->Country);?>" autocomplete="off" required>
                            </div>
                            <?php }}?>
                            <div class="input-field col s12">
                                <button type="submit" name="update"  id="update" class="waves-effect waves-light btn indigo m-b-xs">UPDATE</button>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</main>
<?php include ('partials/footer.php');?>
<?php } ?> 