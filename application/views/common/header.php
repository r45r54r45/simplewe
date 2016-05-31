<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="eng">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Simplwe</title>
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.3.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <link href="/src/common.css" rel="stylesheet">

  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>

  <!-- AngularJS -->
  <script src="https://code.angularjs.org/1.4.7/angular.js"></script>

  <script type="text/javascript" src="https://code.angularjs.org/1.4.7/angular-cookies.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular-route.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.4.7/angular-sanitize.min.js" charset="utf-8"></script>
  <script src="/src/app.js" charset="utf-8"></script>
  <script src="/src/controller.js" charset="utf-8"></script>
  <script src="/src/ninja-slider.js" charset="utf-8"></script>
  <link rel="stylesheet" href="/src/ninja-slider.css" charset="utf-8">
  <script src="/src/rating.js" charset="utf-8"></script>
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="/src/summernote.css" charset="utf-8">
  <script src="/src/summernote.min.js" charset="utf-8"></script>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
  <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
  <script src="/src/js.jcarousel.js" charset="utf-8"></script>
</head>
<body ng-app="app">
  <!-- Navbar static top -->
  <nav class="navbar navbar-default navbar-static-top container" role="navigation" ng-controller="nav">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="/" class="pull-left"><img src="/src/logo.png" style="width:160px;"></a>
      </div>
      <div class="navbar-collapse collapse">
        <!-- Right nav -->
        <ul class="nav navbar-nav navbar-right">
          <li><a href="/">HOME</a></li>
          <li><a href="/search">HOSPITAL</a></li>
          <li><a href="/consultation">CONSULTATION</a></li>
          <? if(!$login){?>
          <li><a onclick="$('#login_modal').modal('show')">LOGIN</a></li>
          <?}else{?>
          <li><a ng-click="logout()">LOGOUT</a></li>
          <?}?>
        </ul>
      </div><!--/.nav-collapse -->
    </div><!--/.container -->

  </nav>
  <!-- end of nav -->
  <div class="container-fluid header-banner" ng-controller="header" >
    <img class="banner-img " src="/src/banner.png" style="width: 1000px;"/>
    <div class="absolute text-center" style="top: 80px;width: 400px;left: 50%;margin-left: -200px;">
      <div style="
    color: #fffffe;
    font-size: 45px;
    font-weight: 700;
">Simplewe</div>
      <div style="
    color: #fffffe;
    font-size: 18px;
    font-weight: 600;
">Redefining quality on a whole new level</div>
      <div style="
    color: #fffffe;
    font-size: 10px;
    font-weight: 600;
">One stop for Korean Beauty and Medical Service</div>
    </div>
    <div class="search-field">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2 ">
                <div class="input-group">
                  <input type="text" class="form-control banner-input" placeholder="Find hospital" ng-model="search_query">
                  <span class="input-group-btn">
                    <button class=" banner-button" type="button" ng-click="search()">SEARCH</button>
                  </span>
                </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- modal collection -->
  <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" ng-controller="login" ng-init="login={}">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header text-center">
          <span class="modal-title">LOGIN</span>
        </div>
        <div class="modal-body">
          <div class="form-group has-feedback has-feedback-left">
            <input type="email" class="placeholder form-control no-border" placeholder="Email" ng-model="login.email" />
            <i class="form-control-feedback glyphicon glyphicon-envelope"></i>
          </div>
          <div class="form-group has-feedback has-feedback-left">
            <input type="password" class=" placeholder form-control no-border" placeholder="Password" ng-model="login.password" />
            <i class="form-control-feedback glyphicon glyphicon-lock"></i>
          </div>
          <div style="margin-top: -10px;">
            <span style="font-size: 10px;">Forgot your password? <a onclick="$('#login_modal').modal('hide');$('#reset_modal').modal('show');" style="color:#c8e7f1;">Reset Password</a></span>
          </div>
          <div class="btn btn-block" style="margin-top:15px; background:#49c4d5;color:white; font-size: 7px;" ng-click="loginForm(login)">LOGIN</div>
          <div class="pull-right">
            <span style="font-size: 10px;">Don't have an account? <a onclick="$('#login_modal').modal('hide');$('#register_modal').modal('show');" style="color:#c8e7f1;">Sign Up</a></span>
          </div>
          <div class="clearfix">

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="reset_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" ng-controller="reset" ng-init="reset={}">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header text-center">
          <span class="modal-title">RESET PASSWORD</span>
        </div>
        <div class="text-center" style="margin-bottom:20px;">
          <div style="font-size: 9px;">Please input the Email you used to register.</div>
          <div style="font-size: 9px;">A link to reset your password will be sent to your email.</div>
        </div>
        <div class="modal-body">
          <div class="form-group has-feedback has-feedback-left">
            <input type="email" class="placeholder form-control no-border" placeholder="Email" ng-model="reset.email" />
            <i class="form-control-feedback glyphicon glyphicon-envelope"></i>
          </div>
          <div class="btn btn-block" style="margin-top:15px; background:#49c4d5;color:white; font-size: 7px;" ng-click="resetForm(reset)">SEND</div>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="actual_reset_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" ng-controller="actual_reset"  ng-init="reset_code='<?=$reset_code?>'; init();actual_reset={};">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header text-center">
          <span class="modal-title">RESET PASSWORD</span>
        </div>
        <div class="modal-body">
          <div class="form-group has-feedback has-feedback-left">
            <input type="password" class=" placeholder form-control no-border" placeholder="New Password" ng-model="actual_reset.pw1"/>
            <i class="form-control-feedback glyphicon glyphicon-lock"></i>
          </div>
          <div class="form-group has-feedback has-feedback-left">
            <input type="password" class=" placeholder form-control no-border" placeholder="Confirm Password" ng-model="actual_reset.pw2"/>
            <i class="form-control-feedback glyphicon glyphicon-lock"></i>
          </div>
          <div class="btn btn-block" style="margin-top:15px; background:#49c4d5;color:white; font-size: 7px;" ng-click="resetForm()">RESET</div>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="register_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" ng-controller="register" ng-init="register={}">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header text-center">
          <span class="modal-title">REGISTER</span>
        </div>
        <div class="modal-body">
          <div class="form-group has-feedback has-feedback-left">
            <input type="text" class="placeholder form-control no-border" placeholder="Name" ng-model="register.name"/>

            <i class="form-control-feedback glyphicon glyphicon-user"></i>
          </div>
          <div class="form-group has-feedback has-feedback-left">
            <input type="email" class="placeholder form-control no-border" placeholder="Email" ng-model="register.email"/>
            <i class="form-control-feedback glyphicon glyphicon-envelope"></i>
          </div>
          <div class="form-group has-feedback has-feedback-left">
            <input type="password" class=" placeholder form-control no-border" placeholder="Password" ng-model="register.password"/>
            <i class="form-control-feedback glyphicon glyphicon-lock"></i>
          </div>
          <div class="btn btn-block" style="margin-top:15px; background:#49c4d5;color:white; font-size: 7px;" ng-click="registerForm(register)">REGISTER</div>
          <div class="pull-right">
            <span style="font-size: 10px;">Already have an account? <a onclick="$('#register_modal').modal('hide'); $('#login_modal').modal('show');" style="color:#c8e7f1;">Log in</a></span>
          </div>
          <div class="clearfix">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="consult_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" ng-controller="consult" ng-init="consult={}">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header text-center">
          <span class="modal-title">CONSULT</span>
        </div>
        <div class="modal-body">
          <div class="form-group has-feedback has-feedback-left">
            <input type="text" class="placeholder form-control no-border" placeholder="Name"  ng-model="consult.name" />
            <img class="form-padding form-control-feedback" src="/src/name.svg">
          </div>
          <div class="form-group has-feedback has-feedback-left">
            <input type="email" class="placeholder form-control no-border"  placeholder="Email" ng-model="consult.email" />
            <img class="form-padding form-control-feedback" src="/src/email.svg">
          </div>
          <div class="form-group has-feedback has-feedback-left">
            <textarea class="placeholder form-control" rows="5" id="consult_body" style="border:none; box-shadow:none;" placeholder="Message" ng-model="consult.body" ></textarea>
            <i class="form-control-feedback glyphicon "></i>
          </div>
          <div class="btn btn-block" style="margin-top:15px; background:#49c4d5;color:white; font-size: 10px;" ng-click="consultForm(consult)">SEND</div>
        </div>
      </div>
    </div>
  </div>

  <!-- consult button -->
  <div class="consult-button hidden-xs" onclick="$('#consult_modal').modal('show')" style="z-index: 9000;
    border: 1px solid white;">
    <div class="vertical-text consult-text">CONSULT</div>
  </div>

  <div class="" style="background-color:white;">
