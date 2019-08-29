
<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('includes/config.php');

$error = "";
$msg ="";

if(isset($_POST['add']))
{
$username=$_POST['username'];
$fname=$_POST['firstName'];
$lname=$_POST['lastName'];
$email=$_POST['email'];
$gender=$_POST['gender'];
$dob=$_POST['dob'];
$address=$_POST['address'];
$city=$_POST['city'];
$country=$_POST['country'];
$mobileno=$_POST['mobileno'];
$status=1;
$role="Guest";

$password=$_POST['password'];
$passwordConfirm=['passwordConfirm'];

    if($_SERVER['REQUEST_METHOD']== "POST") {

    if (empty(['username']) ||empty(['firstName']) || empty($_POST['lastName']) || empty($_POST['email']) || empty(['password']) || empty(['passwordConfirm']) || empty($_POST['gender']) ||   empty($_POST['dob'])  || empty(['address']) || empty(['city']) || empty(['country']) || empty($_POST['mobileno'])) {

        $error =  "Please make sure that all fields are filled!";
    }
    else {
        $sql = "SELECT id FROM users WHERE username = :username";

    if($stmt = $dbh->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{

                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }
        // Validate password
        if(strlen(trim($_POST["password"])) < 6){
        $error = "Password must have at least 6 characters.";
        }
        else{
            $password = trim($_POST["password"]);
        }
        // Validate confirm password
         if($password ==! $passwordConfirm){
            $error = "Passwords did not match.";
            }
         else{
             $password=md5($_POST['password']);

             $sql="INSERT INTO users(username,FirstName,LastName,EmailId,Password,Gender,Dob,Role,Address,City,Country,Phonenumber,Status) VALUES(:username,:fname,:lname,:email,:password,:gender,:dob,:role,:address,:city,:country,:mobileno,:status)";
             $query = $dbh->prepare($sql);
             $query->bindParam(':username',$username,PDO::PARAM_STR);
             $query->bindParam(':fname',$fname,PDO::PARAM_STR);
             $query->bindParam(':lname',$lname,PDO::PARAM_STR);
             $query->bindParam(':email',$email,PDO::PARAM_STR);
             $query->bindParam(':password',$password,PDO::PARAM_STR);
             $query->bindParam(':gender',$gender,PDO::PARAM_STR);
             $query->bindParam(':dob',$dob,PDO::PARAM_STR);
             $query->bindParam(':role',$role,PDO::PARAM_STR);
             $query->bindParam(':address',$address,PDO::PARAM_STR);
             $query->bindParam(':city',$city,PDO::PARAM_STR);
             $query->bindParam(':country',$country,PDO::PARAM_STR);
             $query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
             $query->bindParam(':status',$status,PDO::PARAM_STR);
             $query->execute();
             $lastInsertId = $dbh->lastInsertId();

             if($lastInsertId)
             {

                 $msg="User added Successfully";
             }
             else
             {
                 $error="Something went wrong. Please try again";
             }

         }

    }
}
?>

<script type="text/javascript">
    function valid()
    {
        if(document.addemp.password.value!== document.addemp.passwordConfirm.value)
        {
            alert("New Password and Confirm Password Field do not match  !!");
            document.addemp.passwordConfirm.focus();
            return false;
        }
        return true;
    }
</script>

    <!--- Javascript --->
<script type="text/javascript">


    function checkUsernameAvailability() {
        $("#loader").show();
        jQuery.ajax({
            url: "admin/check_availability.php",
            data:'username='+$("#username").val(),
            type: "POST",
            success:function(data){
                $("#username_avail").html(data);
                $("#loaderIcon").hide();
                $("#loader").hide();
            },
            error:function (){}
        });
    }



    function checkEmailAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "admin/check_availability.php",
            data:'email='+$("#email").val(),
            type: "POST",
            success:function(data){
                $("#email_avail").html(data);
                $("#loaderIcon").hide();
            },
            error:function (){}
        });
    }

</script>
<?php include('includes/head.php');?>
<?php include ('includes/header.php');?>
    <aside id="slide-out" class="side-nav white fixed">
        <div class="side-nav-wrapper">
            <ul class="sidebar-menu collapsible collapsible-accordion" data-collapsible="accordion" style="">
                <li>&nbsp;</li>
                <li class="no-padding"><a class="waves-effect waves-grey" href="login.php"><i class="material-icons">account_box</i>Login</a></li>
                <li class="no-padding"><a class="waves-effect waves-grey" href="signup.php"><i class="material-icons">account_box</i>Sign up</a></li>
            </ul>
            <div class="footer">
                <p class="copyright"> &copy; Copyright 2019 <a href="http://nducv@000webhostapp.com/">Ndu</a></p>
            </div>
        </div>
    </aside>
    <main class="mn-inner">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card">
                    <div class="card-content">
                        <form id="example-form" method="post" name="addemp">
                            <div>
                                <h4>Sign Up...</h4>
                                <section>
                                    <div class="wizard-content">
                                        <div class="row">
                                            <div class="col m6">
                                                <div class="row">
                                                    <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                                                    else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
                                                    <div class="input-field col s12">
                                                        <label for="username">Username</label>
                                                        <input  name="username" type="text" onblur="checkUsernameAvailability()" id="username" required/>
                                                        <div id="username_error" class="val_error"></div>
                                                        <span id="username_avail" style="font-size:12px;"></span>
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
                                                        <input  name="email" type="email" onblur="checkEmailAvailability()" id="email" required>
                                                        <div id="email_error" class="val_error"></div>
                                                        <span id="email_avail" style="font-size:12px;"></span>
                                                    </div>
                                                    <div class="input-field col s12">
                                                        <label for="password">Password</label>
                                                        <input id="password" name="password" type="password" autocomplete="off" required>
                                                    </div>
                                                    <div class="input-field col s12">
                                                        <label for="confirm">Confirm password</label>
                                                        <input id="confirm" name="passwordConfirm" type="password" autocomplete="off" required>
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
<?php include ('includes/footer.php');?>
<?php ?>