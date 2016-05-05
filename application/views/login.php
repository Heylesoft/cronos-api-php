<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>..:: CronosCMS ::..</title>

        <!-- Bootstrap core CSS -->

        <link href="public/css/bootstrap.min.css" rel="stylesheet">

        <link href="public/fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="public/css/animate.min.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="public/css/custom.css" rel="stylesheet">
        <link href="public/css/icheck/flat/green.css" rel="stylesheet">

        <script src="public/js/jquery.min.js"></script>
    </head>

    <body style="background:#F7F7F7;">
        <div>
            <a class="hiddenanchor" id="toregister"></a>
            <a class="hiddenanchor" id="tologin"></a>

            <div id="wrapper">
                <div id="login" class="animate form">
                    <section class="login_content">
                        <form action="./login/validateLogin" method="POST">
                            <h1>Welcome</h1>
                            <div>
                                <input name="txt-login" type="text" class="form-control" placeholder="Username" required="" />
                            </div>
                            <div>
                                <input name="txt-password" type="password" class="form-control" placeholder="Password" required="" />
                            </div>
                            <div>
                                <input type="submit" class="btn btn-default submit">Log in</a>
                                <a class="reset_pass" href="#">Lost your password?</a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="separator">
                                <div class="clearfix"></div>
                                <br />
                                <div>
                                    <h1><i class="fa fa-paw" style="font-size: 26px;"></i> Cronos CMS</h1>
                                    <p>©2016 All Rights Reserved. Heylesoft. Privacy and Terms</p>
                                </div>
                            </div>
                        </form>
                        <!-- form -->
                    </section>
                    <!-- content -->
                </div>

                <div id="register" class="animate form">
                    <section class="login_content">
                        <form>
                            <h1>Create Account</h1>
                            <div>
                                <input type="text" class="form-control" placeholder="Username" required="" />
                            </div>
                            <div>
                                <input type="email" class="form-control" placeholder="Email" required="" />
                            </div>
                            <div>
                                <input type="password" class="form-control" placeholder="Password" required="" />
                            </div>
                            <div>
                                <a class="btn btn-default submit" href="index.html">Submit</a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="separator">

                                <p class="change_link">Already a member ?
                                    <a href="#tologin" class="to_register"> Log in </a>
                                </p>
                                <div class="clearfix"></div>
                                <br />
                                <div>
                                    <h1><i class="fa fa-paw" style="font-size: 26px;"></i> Cronos CMS</h1>
                                    <p>©2016 All Rights Reserved. Heylesoft. Privacy and Terms</p>
                                </div>
                            </div>
                        </form>
                        <!-- form -->
                    </section>
                    <!-- content -->
                </div>
            </div>
        </div>
    </body>
</html>