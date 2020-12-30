
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Aplikasi Perkiraan Curah Hujan</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#"><b>Aplikasi Perkiraan</b> Curah Hujan</a>
  </div>

  <div class="register-box-body">
  <?php
      if($this->session->flashdata('register')){
        echo"
        <div class='alert alert-danger alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-ban'></i> Alert!</h4>".
        $this->session->flashdata('register').
        "</div>
        ";
        }else{
        // echo"
        // <div class='alert alert-info alert-dismissible'>
        //   Regiter new membership
        // </div>
        // ";
        }
  ?>
    <p class="login-box-msg">Daftar</p>
    <?php echo form_open("user/register");?>
    <form action="" method="post">
      <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Full Name" name="user_profile_fullname" value="<?php echo set_value('user_profile_fullname'); ?>"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <span style="color:red"><?php echo form_error('user_profile_fullname'); ?></span>
          </div>
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="user_profile_email" value="<?php echo set_value('user_profile_email'); ?>"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <span style="color:red"><?php echo form_error('user_profile_email'); ?></span>
          </div>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Username" name="user_username" value="<?php echo set_value('user_username'); ?>"/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <span style="color:red"><?php echo form_error('user_username'); ?></span>
          </div>
          <div class="form-group has-feedback">
              <input type="password" class="form-control" placeholder="Password" name="user_password" value="<?php echo set_value('user_password'); ?>"/>
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              <span style="color:red"><?php echo form_error('user_password'); ?></span>
          </div>
      <div class="row">
        <!-- <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> I agree to the <a href="#">terms</a>
            </label>
          </div>
        </div> -->
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <!-- <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
        Google+</a> -->
    </div>

    <a href="login" class="text-center">Sudah punya akun</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url() ?>assets/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
