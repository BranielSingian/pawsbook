<?php
    include("dbh.php");
    if(isset($_POST['update_profile'])){
        $user_id = $_POST['user_id'];
        $fname = ucfirst($_POST['fname']);
        $lname = ucfirst($_POST['lname']);
        $email = strtolower($_POST['email']);
        $phone_number = $_POST['phone_number'];

        $mysqli->query("UPDATE users SET firstname = '$fname', lastname = '$lname', email = '$email', phone_number= '$phone_number'
        WHERE id = '$user_id' ") or die ($mysqli->error());

        $_SESSION['profileError'] = "Profile has been updated!";
        header("location: profile.php?user=".$user_id);
    }
?>