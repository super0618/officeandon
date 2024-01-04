<?php
require_once ("db_config.php");
require_once ("functions.php");
$page_name = "page_cycle_settings";
require_once ("assets_inc.php");
if(!isset($_SESSION['user_info']))

?>

<link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<style>
    th {
        font-size: 16px;
        text-align: center;
    }
</style>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse" onload="startTime()">
<div class="wrapper">

    <!-- Main Header -->
    <?php include("header.php"); ?>

    <!-- Left side column. contains the logo and sidebar -->
    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content container-fluid">
            <div class="row" id="">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <span style="font-size: 20px;">PAGE CYCLE SETTING</span>
                        </div>
                        <div class="box-body" style="min-height: 200px;">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Page Name</th>
                                    <th>Page URL</th>
                                    <th>Seconds</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="page_name" id="page_name" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="page_url" id="page_url" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" name="seconds" id="seconds" class="form-control">
                                    </td>
                                    <td>
                                        <input type="hidden" id="page_cycle_id" name="page_cycle_id" value="0">
                                        <button class="btn btn-primary" style="width: 80px;" id="save_page_cycle">Save</button>&nbsp;&nbsp;
                                        <button class="btn btn-default" style="width: 80px;" id="btn_cancel">Cancel</button>
                                    </td>
                                </tr>
                            <?php
                            $page_cycles = get_page_cycles();
                            if(count($page_cycles) > 0) {
                                foreach ($page_cycles as $page_cycle){
                                    echo '<tr>';
                                    echo '<td class="page-name">'.$page_cycle->page_name.'</td>';
                                    echo '<td class="page-url">'.$page_cycle->page_url.'</td>';
                                    echo '<td class="seconds">'.$page_cycle->seconds.'</td>';
                                    echo '<td>';
                                    echo '<button class="btn btn-success update_page_cycle" style="width: 80px;" value="'.$page_cycle->id.'">UPDATE</button> &nbsp;&nbsp;';
                                    echo '<button class="btn btn-danger delete_page_cycle" style="width: 80px;" value="'.$page_cycle->id.'">DELETE</button>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4">NO DATA</td></tr>';
                            }

                            ?>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <span style="font-size: 20px;">HEADER LINK SETTING</span>
                        </div>
                        <div class="box-body" style="min-height: 200px;">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Header Name</th>
                                    <th>Link</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th>ASSEMBLY</th>
                                    <th colspan="2"></th>
                                </tr>
                                <?php
                                foreach ($g_andon as $andon){
                                    echo '<tr>';
                                    echo '<td>'.$andon.'</td>';
                                    $header_link = get_setting($andon . ' LINK');
                                    echo '<td><input type="text" class="form-control header_link" value="'.$header_link.'"></td>';
                                    echo '<td><button class="btn btn-primary save-header-link" value="'.$andon . ' LINK" style="width: 80px;">Save</button></td>';
                                    echo '</tr>';
                                }
                                ?>
                                <tr><td colspan="3" style="height: 20px;"></td></tr>
                                <tr>
                                    <th>MACHINING</th>
                                    <th colspan="2"></th>
                                </tr>
                                <?php
                                foreach ($g_machines as $machine){
                                    echo '<tr>';
                                    echo '<td>'.$machine.'</td>';
                                    $header_link = get_setting($machine . ' LINK');
                                    echo '<td><input type="text" class="form-control header_link" value="'.$header_link.'"></td>';
                                    echo '<td><button class="btn btn-primary save-header-link" value="'.$machine . ' LINK" style="width: 80px;">Save</button></td>';
                                    echo '</tr>';
                                }
                                ?>
                                <tr><td colspan="3" style="height: 20px;"></td></tr>
                                <tr>
                                    <th>EDM ACTUAL</th>
                                    <?php
                                    $header_link = get_setting('EDM ACTUAL LINK');
                                    echo '<td><input type="text" class="form-control header_link" value="'.$header_link.'"></td>';
                                    echo '<td><button class="btn btn-primary save-header-link" value="EDM ACTUAL LINK" style="width: 80px;">Save</button></td>';
                                    ?>
                                </tr>

                                <?php
                                $edms = array('EDM1', 'EDM2', 'EDM3', 'EDM4', 'EDM5', 'EDM6');
                                foreach ($edms as $machine){
                                    echo '<tr>';
                                    echo '<td>'.$machine.'</td>';
                                    $header_link = get_setting($machine . ' LINK');
                                    echo '<td><input type="text" class="form-control header_link" value="'.$header_link.'"></td>';
                                    echo '<td><button class="btn btn-primary save-header-link" value="'.$machine . ' LINK" style="width: 80px;">Save</button></td>';
                                    echo '</tr>';
                                }
                                ?>


                                <tr><td colspan="3" style="height: 20px;"></td></tr>
                                <tr>
                                    <th>H1 / H2 ACTUAL</th>
                                    <?php
                                    $header_link = get_setting('H1 H2 ACTUAL LINK');
                                    echo '<td><input type="text" class="form-control header_link" value="'.$header_link.'"></td>';
                                    echo '<td><button class="btn btn-primary save-header-link" value="H1 H2 ACTUAL LINK" style="width: 80px;">Save</button></td>';
                                    ?>
                                </tr>

                                <?php
                                $hs = array('H1', 'H2');
                                foreach ($hs as $machine){
                                    echo '<tr>';
                                    echo '<td>'.$machine.'</td>';
                                    $header_link = get_setting($machine . ' LINK');
                                    echo '<td><input type="text" class="form-control header_link" value="'.$header_link.'"></td>';
                                    echo '<td><button class="btn btn-primary save-header-link" value="'.$machine . ' LINK" style="width: 80px;">Save</button></td>';
                                    echo '</tr>';
                                }
                                ?>


                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <?php include ("footer.php"); ?>

</div>

<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<script src="components/jquery/dist/jquery.min.js"></script>
<script src="components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/adminlte.min.js"></script>
<script src="assets/js/custom.js"></script>
<script>
    $(function () {

        $(document).on('click', '#save_page_cycle', function () {
            var page_name = $("#page_name").val();
            var page_url = $("#page_url").val();
            var seconds = $("#seconds").val();
            var id = $("#page_cycle_id").val();
            if(page_name == ""){
                $("#page_name").focus();
                return false;
            }

            if(page_url == ""){
                $("#page_url").focus();
                return false;
            }

            if(seconds == ""){
                $("#seconds").focus();
                return false;
            }

            $.ajax({
                url: "actions.php",
                method: "post",
                data: {
                    action: "save_page_cycle",
                    page_name: page_name,
                    page_url: page_url,
                    seconds: seconds,
                    id: id,
                }
            }).done(function (result) {
                if(result != "OK") {
                    alert('Save failed');
                } else{
                    location.reload();
                }
            });
        });

        $(document).on('click', '#btn_cancel', function () {
            $("#page_name").val('');
            $("#page_url").val('');
            $("#seconds").val('');
            $("#page_cycle_id").val(0);
        });

        $(document).on('click', '.delete_page_cycle', function () {
            var id = $(this).val();
            if(confirm('Are you sure?')){
                $.ajax({
                    url: "actions.php",
                    method: "post",
                    data: {
                        action: "delete_page_cycle",
                        id: id,
                    }
                }).done(function (result) {
                    if(result != "OK") {
                        alert('Delete failed');
                    } else{
                        location.reload();
                    }
                });
            }
        });

        $(document).on('click', '.update_page_cycle', function () {
            var id = $(this).val();
            var tr = $(this).closest('tr');
            var page_name = tr.find(".page-name").text();
            var page_url = tr.find(".page-url").text();
            var seconds = tr.find(".seconds").text();
            $("#page_name").val(page_name);
            $("#page_url").val(page_url);
            $("#seconds").val(seconds);
            $("#page_cycle_id").val(id);
        });


        $(document).on('click', '.save-header-link', function () {
            var set_type = $(this).val();
            var set_value = $(this).closest('tr').find('input[type="text"]').val();
            if(set_value == "")
                return false;
            $.ajax({
                url: "actions.php",
                method: "post",
                data: {
                    action: "save_header_link",
                    set_type: set_type,
                    set_value: set_value
                }
            }).done(function (result) {
                console.log(result);
            });
        });
    });
</script>

</body>
</html>