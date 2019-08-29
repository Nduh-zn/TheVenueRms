<?php 
require_once("../includes/config.php");
// code for username availability
if(!empty($_POST["username"])) {
    $username=$_POST["username"];

    $sql ="SELECT username FROM `users` WHERE username=:username";
    $query= $dbh->prepare($sql);
    $query-> bindParam(':username',$username, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);


    if($query->rowCount() > 0)
    {
        echo "<span style='color:red'> Username already in use!</span>";
        echo "<script>$('#add').prop('disabled',true);</script>";
    } else{

        echo "<span style='color:green'> Username available.</span>";
        echo "<script>$('#add').prop('disabled',false);</script>";
    }
}

// code for email availability
if(!empty($_POST["email"])) {
    $email= $_POST["email"];

    $sql ="SELECT EmailId FROM `users` WHERE EmailId=:email";
    $query= $dbh->prepare($sql);
    $query-> bindParam(':email',$email, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
    if($query -> rowCount() > 0)
    {
        echo "<span style='color:red'> Email already in use!</span>";
        echo "<script>$('#add').prop('disabled',true);</script>";
    } else{

        echo "<span style='color:green'> Email available for Registration.</span>";
        echo "<script>$('#add').prop('disabled',false);</script>";
    }
}





?>
