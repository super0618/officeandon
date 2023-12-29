<?php
require_once ("db_config.php");
require_once ("functions.php");
$page_name = "Login";
require_once ("assets_inc.php");

?>
<body class="hold-transition login-page" style="margin-top: 100px;">
<div class="login-box" style="margin: 0 auto">
    <div class="login-logo">
        Office Andon
    </div>
</div>
<!-- <div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">Login</div>
            <div class="panel-body">
                <form class="form-horizontal" method="POST" action="auth.php">
                    <div class="form-group">
                        <label for="email" class="col-md-4 control-label">Logged in MBR</label>
                        <div class="col-md-6">
                            <input id="guest_user_no" type="text" class="form-control" name="guest_user_no" value="" required autofocus readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-primary">
            <div class="panel-heading">Administrator Login</div>
            <div class="panel-body">
                <form class="form-horizontal" method="POST" action="auth.php">
                    <div class="form-group">
                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" name="email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Admin Login
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<script src="components/jquery/dist/jquery.min.js"></script>
<script src="components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/adminlte.min.js"></script>
<script src="assets/js/custom.js"></script>
<script>
    var WinNetwork = new ActiveXObject("WScript.Network");
    $("#guest_user_no").val(WinNetwork.UserName);
    $(function () {

    });

</script>

</body>
</html>