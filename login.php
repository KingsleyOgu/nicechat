<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NiceChat • Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <!-- Custom -->
  <link rel="stylesheet" href="dist/css/custom.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

   <style>
    body {
      /* background: linear-gradient(to right,#4b189c,#fc115c,#4665fe)!important; */
      background: #bdbbb9;
    }
    .login-box-body, .register-box-body {
    background: #fff;
    padding: 20px;
    border-top: 0;
    color: #666;
    border-radius: 3px;
    box-shadow: 0 17px 50px 0 rgba(0, 0, 0, 0.19), 0 12px 15px 0 rgba(0, 0, 0, 0.24);
    }
    .login-page, .register-page {
    background: #bdbbb9;
    }
    .header {
    content: '';
    height: 222px;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: -1;
    background-color: #2c3e50;
    }
    /* .nicechat-text {
      margin-left: 14px;
      color: #fff;
      font-size: 14px;
      font-weight: 500;
      line-height: normal;
      text-transform: uppercase;
      display: block;
    } */
    .login-logo {
      color: #fff;
    }
    </style>

</head>

<body class="hold-transition login-page">
<div class="header"></div>
<div class="login-box">
  <div class="login-logo">
    <a href="index2.html" style="color:#fff;"><b>Nice</b>Chat</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign In</p>

    <form id="loginForm" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>          
        </div>
        <!-- /.col -->
      </div>
      <div class="row">
        <div class="col-xs-12">
            <span id="loginError" class="color-red hide-me">Invalid Email/Password!</span>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <?php if(isset($_SESSION['registeredSuccessfully'])) { ?>
            <span id="registeredSuccessfully" class="color-green">You Have Registered Successfully!</span>
          <?php unset($_SESSION['registeredSuccessfully']); } ?>
        </div>
      </div>
    </form>
    <!-- /.social-auth-links -->

    <a href="#">I forgot my password</a><br>
    <a href="register.php" class="text-center">Create an account</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<!-- Custom -->
<script>
  $(function() {
    $("#registeredSuccessfully:visible").fadeOut(8000);
  });
</script>
<script>
  $("#loginForm").on("submit", function(e) {
    e.preventDefault();
    $.post("checklogin.php", $(this).serialize() ).done(function(data) {
        var result = $.trim(data);
        if(result == "ok") {
          window.location.href = "index.php";
        } else {
          $("#loginError").show();
        }
      });
  });
</script>
</body>
</html>
