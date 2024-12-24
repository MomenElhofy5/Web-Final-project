<?php

include ("config.php");

session_start();

if (isset ($_POST['submit_signIn'])) {



    $userName = mysqli_real_escape_string($conn, $_POST['UserName']);
    $password = md5($_POST['Password']);

    $select = " SELECT * FROM employee WHERE Employee_UserName = '$userName' && Employee_Password = '$password' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);
        $_SESSION['Employee_name'] = $row['Employee_UserName'];
        header('location:dashboard.php');
    } else {
        $error[] = 'incorrect email or password!';
    }

}
;
if (isset ($_POST['submit_signUp'])) {


    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    // $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    // $code = 0;



    $select = " SELECT * FROM employee WHERE Employee_UserName = '$userName' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $error[] = 'User name already exist!';

    } else {

        if ($password != $cpass) {
            $error[] = 'password not matched!';
        } else {
            $insert = "INSERT INTO employee(Employee_FirstName, Employee_LastName, Employee_UserName,Employee_Password) VALUES('$firstName','$lastName','$userName','$password')";
            mysqli_query($conn, $insert);
            $_SESSION['Employee_name'] = $row['Employee_UserName'];
            header('location:dashboard.php');
        }
    }

}
;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginpage.css">
    <style>
        /* Add any additional inline styles if needed */
    </style>
</head>

<body>

    <div class="login-wrap">
        <div class="login-html">
            <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign
                In</label>
            <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
            <div class="login-form">
                <form action="" method="post">

                    <div class="sign-in-htm">
                        <div class="group">
                            <label for="user" class="label">Username</label>
                            <input id="user" type="text" class="input" name="UserName">
                        </div>
                        <div class="group">
                            <label for="pass" class="label">Password</label>
                            <input id="pass" type="password" class="input" data-type="password" name="Password">
                        </div>
                        <div class="group">
                            <input id="check" type="checkbox" class="check" checked>
                            <label for="check"><span class="icon"></span> Keep me Signed in</label>
                        </div>
                        <div class="group">

                            <button type="submit" class="button" name="submit_signIn">Sign In</button>
                        </div>
                        <div class="hr">
                            <p>
                                <?php
                                if (isset ($error)) {
                                    foreach ($error as $error) {
                                        echo '<span class="error-msg">' . $error . '</span>';
                                    }
                                    ;
                                }
                                ;
                                ?>
                            </p>
                        </div>

                        <div class="foot-lnk">
                            <a href="#forgot">Forgot Password?</a>
                        </div>
                </form>
            </div>
            <div class="sign-up-htm">
                <form action="" method="post">
                    <div class="group">
                        <label for="user" class="label">First Name</label>
                        <input id="user" type="text" class="input" name="firstName">
                    </div>
                    <div class="group">
                        <label for="user" class="label">Last Name</label>
                        <input id="user" type="text" class="input" name="lastName">
                    </div>
                    <div class="group">
                        <label for="user" class="label">UserName</label>
                        <input id="user" type="text" class="input" name="userName">
                    </div>
                    <!-- <div class="group">
                        <label for="pass" class="label">Email Address</label>
                        <input id="pass" type="text" class="input">
                    </div> -->
                    <div class="group">
                        <label for="pass" class="label">Password</label>
                        <input id="pass" type="password" class="input" data-type="password" name="password">
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Confirm Password</label>
                        <input id="pass" type="password" class="input" data-type="password" name="cpassword">
                    </div>
                    <div class="hr"></div>
                    <div class="group">
                        <button type="submit" class="button" name="submit_signUp">Sign UP</button>
                    </div>
                    <div class="foot-lnk">

                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

</body>

</html>