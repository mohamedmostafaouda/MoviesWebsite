<?php
    session_start();
    include 'includes/user.php';
    if (!isset($_SESSION['username'])){
        header("Location: signup.php");
        exit();
    }
    else if(isset($_POST['signup'])){
      $password = htmlentities($_POST['password']);
      $passwordC = htmlentities($_POST['passwordConfirm']);
      if (empty($passwordC)||empty($password)){
        $msg="There is Empty fields";
      }
      else {
        $user = new User();
        if($password != $passwordC){
          $msg = "Password do not match";
        }
        else if (strlen($password)<8){
          $msg = "Password should be 8 characters or more";
        }
        else{
          $user->change_password($password,$_SESSION['username']);
          header("Location: main.php");
          exit();
        }
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Sign In</title>
    <link rel="stylesheet" href="bootstrap4/css/bootstrap.css" />
    <link rel="stylesheet" href="css/head.css" />
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="css/animate.css" />
  </head>
  <body>
    <?php include 'header.php'?>
    <form action="changepass.php" method="POST" onsubmit="return validate()" class="container signContainer wow fadeIn">
      <?php if (isset($msg) && $msg!=''){
        echo "<div class='alert alert-danger col-12 col-lg-12'>
        <strong>$msg</strong> 
        </div>";}  
      ?>
      <div class="alert alert-danger col-12 col-lg-12" id="bad">
        <strong>Something Wrong occured</strong> 
      </div>
        <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
          <label for="password">New Password</label>
          <br />
          <input type="password" name="password" class="inputStyle" id="password" />
        </div>
        <div class="col-12 col-lg-6">
          <label for="passwordConfirm">Confirm password</label>
          <br />
          <input type="password" name="passwordConfirm" class="inputStyle" id="passwordConfirm" />
        </div>
      </div>
      <div class="text-right">
        <input
          type="submit"
          value="Confirm"
          class="btn btn-danger mt-3"
          name="signup"
          id="signup"
        />
      </div>
    </form>
    <script src="javascript/jquery.js"></script>
    <script src="bootstrap4/js/bootstrap.js"></script>
    <script src="javascript/wow.js"></script>
    <script>
      new WOW().init();
      $('#bad').hide();
      function validate(){
        $('#bad').hide();
        var name = $('#name').val();
        var userName = $('#userName').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var password = $('#password').val();
        var passwordConfirm = $('#passwordConfirm').val();
        if ( password=='' || passwordConfirm==''){
          $('#bad').html("<strong>Please check empty fields</strong> ");
          $('#bad').show();
          return false;
        }
        else if (password!=passwordConfirm){
          $('#bad').html("<strong>Passwords don't match</strong> ");
          $('#bad').show();
          return false;
        }
        else if(password.length<8){
          $('#bad').html("<strong>Password should be 8 characters and numbers or more</strong> ");
          $('#bad').show();
          return false;
        }
      }
      function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
      }
      function validateName(name){
        var re = /^[a-zA-Z ]*$/;
        return re.test(String(name).toLowerCase());
      }
    </script>
    <script src="https://kit.fontawesome.com/473d9c5ae4.js" crossorigin="anonymous"></script>
  </body>
</html>
