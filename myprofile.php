<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['gtlogin'])==0)
    {   
header('location:login.php');
}
else{
    $uid=$_SESSION['gtlogin'];
    if(isset($_POST['update']))
    {

        $fname=$_POST['firstName'];
        $lname=$_POST['lastName'];
        $gender=$_POST['gender'];
        $dob=$_POST['dob'];
        $address=$_POST['address'];
        $city=$_POST['city'];
        $country=$_POST['country'];
        $mobileno=$_POST['mobileno'];
        $sql="update users set FirstName=:fname,LastName=:lname,Gender=:gender,Dob=:dob,Address=:address,City=:city,Country=:country,Phonenumber=:mobileno where username=:uid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname',$fname,PDO::PARAM_STR);
        $query->bindParam(':lname',$lname,PDO::PARAM_STR);
        $query->bindParam(':gender',$gender,PDO::PARAM_STR);
        $query->bindParam(':dob',$dob,PDO::PARAM_STR);
        $query->bindParam(':address',$address,PDO::PARAM_STR);
        $query->bindParam(':city',$city,PDO::PARAM_STR);
        $query->bindParam(':country',$country,PDO::PARAM_STR);
        $query->bindParam(':mobileno',$mobileno,PDO::PARAM_STR);
        $query->bindParam(':uid',$uid,PDO::PARAM_STR);
        $query->execute();
        $msg="Profile updated Successfully";
    }

    ?>
<?php include('includes/head.php');?>
<?php include('includes/header.php');?>
<?php include('includes/sidebar.php');?>
<main class="mn-inner">
<div class="col s12 m12 l12">
    <div class="card">
        <div class="card-content">
            <form id="example-form" method="post" name="updatemp">
                <div>
                    <h4>Update Profile</h4>
                       <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                        <section>
                        <div class="wizard-content">
                            <div class="row">
                                <div class="col m6">
                                    <div class="row">
<?php
$uid=$_SESSION['gtlogin'];
$sql = "SELECT * from  users where username=:uid";
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
<label for="username">Username</label>
<input  name="username" id="username" value="<?php echo htmlentities($result->username);?>" type="text" autocomplete="off" readonly required>
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
<label for="birthdate">Date of Birth</label>
<div class="input-field col m6 s12">

<input id="birthdate" name="dob"  class="datepicker" value="<?php echo htmlentities($result->Dob);?>" >
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
</div>
</form>
</div>
</div>
</div>
</div>
</main>
</div>
<?php include('includes/footer.php');?>
<?php } ?>