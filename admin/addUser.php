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
$uid=$_POST['ucode'];
$fname=$_POST['firstName'];
$lname=$_POST['lastName'];
$email=$_POST['email'];
$password=md5($_POST['password']);
$gender=$_POST['gender'];
$dob=$_POST['dob'];
$department=$_POST['department'];
$address=$_POST['address'];
$city=$_POST['city'];
$country=$_POST['country'];
$mobileno=$_POST['mobileno'];
$status=1;

$sql="INSERT INTO users(username,FirstName,LastName,EmailId,Password,Gender,Dob,Department,Address,City,Country,Phonenumber,Status) VALUES(:uid,:fname,:lname,:email,:password,:gender,:dob,:department,:address,:city,:country,:mobileno,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':uid',$uid,PDO::PARAM_STR);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':lname',$lname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':department',$department,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':city',$city,PDO::PARAM_STR);
$query->bindParam(':country',$country,PDO::PARAM_STR);
$query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Employee record added Successfully";
}
else
{
$error="Something went wrong. Please try again";
}

}

    ?>


    <script type="text/javascript">
function valid()
{
if(document.addemp.password.value!== document.addemp.confirmpassword.value)
{
alert("New Password and Confirmed Password Fields do not match!!");
document.addemp.confirmpassword.focus();
return false;
}
return true;
}
</script>

<script>
function checkAvailabilityuid() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'ucode='+$("#ucode").val(),
type: "POST",
success:function(data){
$("#uid-availability").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>

<script>
function checkAvailabilityEmailid() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#email").val(),
type: "POST",
success:function(data){
$("#emailid-availability").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>


<?php include('partials/head.php');?>
<?php include('partials/header.php');?>
<?php include('partials/sidebar.php');?>
<main class="mn-inner">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <form id="example-form" method="post" name="addemp">
                            <div>
                                <h3>User Info</h3>
                                <section>
                                    <div class="wizard-content">
                                        <div class="row">
                                            <div class="col m6">
                                                <div class="row">
                                                <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                                                else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

                                             <div class="input-field col  s12">
                                                <label for="ucode">Username (Must be unique)</label>
                                                <input  name="ucode" id="ucode" onBlur="checkAvailabilityuid()" type="text" autocomplete="off" required>
                                                <span id="uid-availability" style="font-size:12px;"></span>
                                            </div>

                                            <div class="input-field col m6 s12">
                                                <label for="firstName">First name</label>
                                                <input id="firstName" name="firstName" type="text" required>
                                            </div>

                                            <div class="input-field col m6 s12">
                                                <label for="lastName">Last name</label>
                                                <input id="lastName" name="lastName" type="text" autocomplete="off" required>
                                            </div>

                                            <div class="input-field col s12">
                                                <label for="email">Email</label>
                                                <input  name="email" type="email" id="email" onBlur="checkAvailabilityEmailid()" autocomplete="off" required>
                                                <span id="emailid-availability" style="font-size:12px;"></span>
                                            </div>

                                            <div class="input-field col s12">
                                                <label for="password">Password</label>
                                                <input id="password" name="password" type="password" autocomplete="off" required>
                                            </div>

                                            <div class="input-field col s12">
                                                <label for="confirm">Confirm password</label>
                                                <input id="confirm" name="confirmpassword" type="password" autocomplete="off" required>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="col m6">
                                        <div class="row">
                                            <div class="input-field col m6 s12">
                                            <select  name="gender" autocomplete="off">
                                            <option value="">Gender...</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                            </select>
                                        </div>

                                        <div class="input-field col m6 s12">
                                            <label for="birthdate">Birthdate</label>
                                            <input id="birthdate" name="dob" type="date" class="datepicker" autocomplete="off" >
                                        </div>


                                        <div class="input-field col m6 s12">
                                            <select  name="department" autocomplete="off">
                                            <option value="">Role...</option>
                                            <?php $sql = "SELECT roleName from roles";
                                            $query = $dbh -> prepare($sql);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if($query->rowCount() > 0)
                                            {
                                            foreach($results as $result)
                                            {   ?>
                                            <option value="<?php echo htmlentities($result->roleName);?>"><?php echo htmlentities($result->roleName);?></option>
                                            <?php }} ?>
                                            </select>
                                        </div>

                                        <div class="input-field col m6 s12">
                                            <label for="address">Address</label>
                                            <input id="address" name="address" type="text" autocomplete="off" required>
                                        </div>

                                        <div class="input-field col m6 s12">
                                            <label for="city">City/Town</label>
                                            <input id="city" name="city" type="text" autocomplete="off" required>
                                        </div>

                                        <div class="input-field col m6 s12">
                                            <label for="country">Country</label>
                                            <input id="country" name="country" type="text" autocomplete="off" required>
                                        </div>

                                        <div class="input-field col s12">
                                            <label for="phone">Mobile number</label>
                                            <input id="phone" name="mobileno" type="tel" maxlength="10" autocomplete="off" required>
                                        </div>

                                        <div class="input-field col s12">
                                            <button type="submit" name="add" onclick="return valid();" id="add" class="waves-effect waves-light btn indigo m-b-xs">ADD</button>
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