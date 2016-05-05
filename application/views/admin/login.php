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
        <link href="<?php echo base_url('assets/admin/css/bootstrap.min.css'); ?>" rel="stylesheet">

        <link href="<?php echo base_url('assets/admin/fonts/css/font-awesome.min.css'); ?>" rel="stylesheet">
        <link href="<?php echo base_url('assets/admin/css/animate.min.css'); ?>" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="<?php echo base_url('assets/admin/css/custom.css'); ?>" rel="stylesheet"> 
        <link href="<?php echo base_url('assets/admin/css/icheck/flat/green.css'); ?>" rel="stylesheet">        

        <script src="<?php echo base_url('assets/admin/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/admin/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/admin/js/validator/validator.js'); ?>"></script>

        <script src="<?php echo base_url('assets/admin/js/pages/login.js'); ?>"></script>

        <?php
            if($isinvalidForm){
        ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("#bx-alert").html("Invalid data"); 
                    $("#bx-alert").show(); 
                    var timer = setInterval(function(){ 
                        $("#bx-alert").hide(); 
                        $("#bx-alert").html(''); 
                        clearInterval(timer); 
                    },2000);
                });
            </script>
        <?php
            }
        ?>
    </head>

    <body style="background:#F7F7F7;">
        <div>
            <a class="hiddenanchor" id="tologin"></a>
            <a class="hiddenanchor" id="tolostpass"></a>

            <div id="wrapper">
                <div id="login" class="animate form">
                    <div class="alert alert-danger alert-dismissible fade in" role="alert" id="bx-alert" style="display:none;"></div>

                    <section class="login_content">
                        <form id="frm-login" action="<?php echo base_url('admin/security/login/validatelogin/'); ?>" method="POST" novalidate>
                            <h1>Welcome</h1>
                            <div>
                                <input name="txt-login" type="text" class="form-control" placeholder="Username" required="required" value="<?php echo $txtLogin; ?>" />
                            </div>
                            <div>
                                <input name="txt-password" type="password" class="form-control" placeholder="Password" required="required" />
                            </div>
                            <div>
                                <input type="submit" class="btn btn-default submit" value="Log in" />
                                <a href="#tolostpass" class="reset_pass">Lost your password?</a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="separator">
                                <div class="clearfix"></div>
                                <div>
                                    <h1>Cronos CMS</h1>
                                    <p>©2016 All Rights Reserved. Privacy and Terms.</p>
                                    <a id="company" href="http://www.heylesoft.com" target="blank">Heylesoft</a>
                                </div>
                            </div>
                        </form>
                        <!-- form -->
                    </section>
                    <!-- content -->
                </div>

                <div id="lostpass" class="animate form">
                    <section class="login_content">
                        <form id="frm-recover" action="./validatelogin" method="POST" novalidate>
                            <h1>Recover Password</h1>
                            <div>
                                <input type="text" class="form-control" placeholder="Username" required="required" />
                            </div>
                            <div>
                                <input type="email" class="form-control" placeholder="Email" required="required" />
                            </div>
                            <div>
                                <input type="submit" class="btn btn-default submit" value="Submit" />
                                <a href="#tologin" class="to_register">Cancel</a>
                            </div>
                            <div class="clearfix"></div>
                            <div class="separator">
                                <div class="clearfix"></div>
                                <div>
                                    <h1>Cronos CMS</h1>
                                    <p>©2016 All Rights Reserved. Privacy and Terms</p>
                                    <a id="company" href="http://www.heylesoft.com" target="blank">Heylesoft</a>
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