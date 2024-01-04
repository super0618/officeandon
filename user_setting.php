<?php
require_once ("db_config.php");
require_once ("functions.php");

//$_SESSION['prev_page'] = 'user_setting.php';

if(!isset($_SESSION['user_info']))
    header('Location:login.php');

$page_name = "user_setting";

require_once ("assets_inc.php");
?>
<body class="hold-transition skin-blue sidebar-mini" onload="startTime()">
<div class="wrapper">

    <!-- Main Header -->
    <?php include("header.php"); ?>

    <!-- Left side column. contains the logo and sidebar -->
    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <form class="form-horizontal" id="price_form">
                            <div class="box-body">
                                <div class="col-md-12">
                                    <!--Alert-->
                                    <div class="alert alert-success alert-dismissible" id="success-alert" style="display: none;">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h4><i class="icon fa fa-check"></i> SUCCESS!</h4>
                                        User information was saved successfully.
                                    </div>
                                    <div class="alert alert-danger alert-dismissible" id="fault-alert" style="display: none;">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h4><i class="icon fa fa-ban"></i> ERROR!</h4>
                                        User information was not saved.
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" id="btn_add_new_user" class="btn btn-danger pull-right">ADD USER</button>
                                </div>

                                <!-- /.Alert -->
                                <div class="col-md-12" id="user_list" style="margin-top: 10px;">

                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <?php include ("footer.php"); ?>

    <?php // include ("control_side.php"); ?>
</div>

<div class="modal fade" id="user-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">USER</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="user_form" name="user_form">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="widget_name">Member Number</label>
                            <input type="text" class="form-control" id="user_no" name="user_no" placeholder="Member Number">
                            <span class="help-block" id="help_member_no" style="display: none;">Already exist same member number. Please enter other number</span>
                        </div>
                        <div class="form-group">
                            <label for="widget_name">Name</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Name">
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <input type="hidden" name="action" id="action" value="save_user">
                    <input type="hidden" name="user_id" id="user_id" value="0">
                    <input type="hidden" name="check_duplicate_member_no" id="check_duplicate_member_no" value="1">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save-user">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/js/adminlte.min.js"></script>
<!-- DataTable -->
<script src="components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="assets/js/custom.js"></script>
<script>
    $(document).ready(function(){
        read_users();

        $("#btn_add_new_user").on('click', function () {
            $("#user_no").val('');
            $("#username").val('');
            $("#user_id").val(0);
            $("#user-modal").modal();

        });

        $("#save-user").on('click', function () {

            if($("#user_no").val() == "") {
                $("#user_no").focus();
                return false;
            }

            if($("#username").val() == "") {
                $("#username").focus();
                return false;
            }

            if($("#check_duplicate_member_no").val() == 0) {
                $("#user_no").focus();
                return false;
            }

            var form = $("#user_form");
            $.ajax({
                url: "actions.php",
                method: "post",
                data: form.serialize()
            }).done(function (result) {
                if(result == "ok") {
                    $("#user-modal").modal('hide');
                    read_users();
                } else {
                    $("#fault-alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#fault-alert").slideUp(500);
                    });
                }
            });
        });

        $("#user_no").on('change', function () {
            var user_no = $(this).val();
            var user_id = $("#user_id").val();
            $.ajax({
                url: "actions.php",
                method: "post",
                data: {user_no:user_no, user_id:user_id, action:"check_duplicate_user_no"}
            }).done(function (result) {
                if(result == "ok") {
                    $("#user-check_duplicate_member_no").val(1);
                    $("#help_member_no").closest('div').removeClass('has-error');
                    $("#help_member_no").hide();
                } else {
                    $("#help_member_no").closest('div').addClass('has-error');
                    $("#help_member_no").show();
                    $("#user-check_duplicate_member_no").val(0);
                }
            });

        });

        $(document).on("click", ".delete-user", function () {
            var user_id = $(this).closest('tr').data('user');
            if(confirm("Are you sure?")){
                $.ajax({
                    url: "actions.php",
                    method: "post",
                    data: {user_id:user_id, action:"delete_user"}
                }).done(function (result) {
                    if(result == "ok") {
                        read_users();
                    } else {

                        $("#fault-alert").fadeTo(2000, 500).slideUp(500, function(){
                            $("#fault-alert").slideUp(500);
                        });
                    }
                });
            }
        });

        $(document).on("click", ".edit-user", function () {
            var user_id = $(this).closest('tr').data('user');
            $.ajax({
                url: "actions.php",
                method: "post",
                data: {user_id:user_id, action:"get_user_info"},
                dataType:"json"
            }).done(function (result) {
                $("#user_id").val(result.id);
                $("#user_no").val(result.user_no);
                $("#check_duplicate_member_no").val(1);
                $("#username").val(result.username);
                $("#user-modal").modal();
            });
        });
    });

    function read_users()
    {
        $.ajax({
            url: "actions.php",
            method: "post",
            data: {action:"read_users"},
            dataType: "HTML"
        }).done(function (html) {
            $("#user_list").html(html);
            $("#user_table").dataTable({
                'paging'   : true,
                'stateSave': true,
                'order': [[ 0, "asc" ]],
                'columnDefs': [{
                    "targets": [2],
                    "orderable": false
                }]
            });
        });
    }

    function update_user_info(value, user_id, kind)
    {
        $.ajax({
            url: "actions.php",
            method: "post",
            data: {action:"update_user_info", update_value:value, user_id:user_id, kind:kind}
        }).done(function (result) {
            if(result == "ok") {
            } else {
                $("#fault-alert").fadeTo(2000, 500).slideUp(500, function(){
                    $("#fault-alert").slideUp(500);
                });
            }
        });
    }
</script>
</body>
</html>