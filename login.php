
<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('includes/config.php');

$error = "";
$msg ="";


if(isset($_POST['signin']))
{
    $uname=$_POST['username'];
    $password=md5($_POST['password']);

    $sql ="SELECT * FROM users WHERE username=:uname and Password=:password";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
    {
        foreach ($results as $result) {
            $status=$result->Status;
            $role = $result->Role;
            $_SESSION['uid']=$result->id;
        }
        if($status==0)
        {
            $msg="Your account is Inactive. Please contact admin";
        }
        if($role=='Guest'){
            $_SESSION['gtlogin']=$_POST['username'];
            header('Location: changePassword.php');
            exit;
            //echo "<script type='text/javascript'> document.location = 'changePassword.php'; </script>";
        }
        if($role=='Staff'){
            $_SESSION['stlogin']=$_POST['username'];
            header('location: staff/dashboard.php');
            //echo "<script type='text/javascript'> document.location = 'staff/dashboard.php'; </script>";
        }
        if($role=='Admin'){
            $_SESSION['alogin']=$_POST['username'];
            header('location: admin/dashboard.php');
            //echo "<script type='text/javascript'> document.location = 'admin/dashboard.php'; </script>";
        }
    }

    else{

        echo "<script>alert('Invalid Details');</script>";

    }

}

?>
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
        <p class="copyright"> &copy; Copyright 2019 <a href="http://nducv@000webhostapp.com/"> Ndu </a></p>
     </div>
    </div>
</aside>
<main class="mn-inner">
    <div class="row">
        <div class="col s12">
          <div class="col s12 m6 l8 offset-l2 offset-m3">
              <div class="card white darken-1">

                  <div class="card-content ">
                      <span class="card-title" style="font-size:20px;">Login..</span>
                      <?php if($msg){?><div class="errorWrap"><strong>Error</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                       <div class="row">
                           <form class="col s12" name="signin" method="post">
                               <div class="input-field col s12">
                                   <input id="username" type="text" name="username" class="validate" autocomplete="off" required >
                                   <label for="email">Username</label>
                               </div>
                               <div class="input-field col s12">
                                   <input id="password" type="password" class="validate" name="password" autocomplete="off" required>
                                   <label for="password">Password</label>
                               </div>
                               <div class="col s12 right-align m-t-sm">
                                   <input type="submit" name="signin" value="Sign in" class="waves-effect waves-light btn teal">
                               </div>
                               </form>
                              </div>
                          </div>
                      </div>
                  </div>
            </div>
        </div>
    </main>
<?php include ('includes/footer.php');?>