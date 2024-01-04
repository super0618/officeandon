<?php
require_once ("db_config.php");
require_once ("functions.php");
$page_name = "shift_settings";
require_once ("assets_inc.php");

if(!isset($_SESSION['user_info']))
    printf('%s','fffffffffff');
    // header('Location:login.php');


?>

<link href="assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
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

            <div class="my-alert alert alert-success" id="success-alert" style="display: none">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong id="alert_title">Success! </strong>
                <span id="alert_message">Saved successfully.</span>
            </div>

            <div class="my-alert alert alert-danger" id="fault-alert" style="display: none">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong id="fault_title">Fail! </strong>
                <span id="fault_message">Saved failed.</span>
            </div>

            <div class="row" id="">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <span style="font-size: 20px;">2 SHIFT SETTING</span>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    $shift_setting = get_setting('shift2');
                                    if($shift_setting != '')
                                        $shifts = json_decode($shift_setting, true);
                                    else{
                                        $string = file_get_contents("./shift.json");
                                        $shifts = json_decode($string, true);
                                    }

                                    ?>
                                    <form method="post" id="shift_setting_form">
                                        <table class="table table-bordered ">
                                            <thead>
                                            <tr>
                                                <th style="width: 120px;"></th>
                                                <th colspan="2" style="text-align: center;">
                                                    SHIFT 1
                                                </th>
                                                <th colspan="2" style="text-align: center;">
                                                    SHIFT 2
                                                </th>
                                                <th colspan="2" style="text-align: center;">
                                                    Friday Shift2
                                                </th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th style="text-align: center;">Start</th>
                                                <th style="text-align: center;">End</th>
                                                <th style="text-align: center;">Start</th>
                                                <th style="text-align: center;">End</th>
                                                <th style="text-align: center;">Start</th>
                                                <th style="text-align: center;">End</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td style="text-align: center;">Time</td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    echo '<div class="input-group bootstrap-timepicker timepicker" style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="shift1_start" value="'.$shifts['shift1']['start'].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    echo '<div class="input-group bootstrap-timepicker timepicker" style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="shift1_end" value="'.$shifts['shift1']['end'].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    echo '<div class="input-group bootstrap-timepicker timepicker" style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="shift2_start" value="'.$shifts['shift2']['start'].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    echo '<div class="input-group bootstrap-timepicker timepicker" style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="shift2_end" value="'.$shifts['shift2']['end'].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    echo '<div class="input-group bootstrap-timepicker timepicker" style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="shift3_start" value="'.$shifts['shift3']['start'].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    echo '<div class="input-group bootstrap-timepicker timepicker"  style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="shift3_end" value="'.$shifts['shift3']['end'].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    ?>
                                                </td>
                                            </tr>

                                            <?php
                                            for($i = 1; $i<5; $i++){
                                                echo "<tr>";
                                                echo "<td style=\"text-align: center;\">Break ".$i."</td>";
                                                foreach ($g_shifts as $key=>$shift) {
                                                    echo "<td>";
                                                    echo '<div class="input-group bootstrap-timepicker timepicker" style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="'.$shift.'_break_start[]" value="'.$shifts[$shift]['breaks']['start'.$i].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo '<div class="input-group bootstrap-timepicker timepicker" style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="'.$shift.'_break_end[]" value="'.$shifts[$shift]['breaks']['end'.$i].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    echo "</td>";

                                                }
                                                echo "<tr>";
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="action" value="save_shift">
                                        <input type="hidden" name="set_type" value="shift2">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-primary pull-right" id="shift_save" style="width: 200px;"> Save </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <span style="font-size: 20px;">3 SHIFT SETTING</span>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    $shift_setting = get_setting('shift3');
                                    if($shift_setting != '')
                                        $shifts = json_decode($shift_setting, true);
                                    else{
                                        $string = file_get_contents("./shift.json");
                                        $shifts = json_decode($string, true);
                                    }

                                    ?>
                                    <form method="post" id="friday_shift_setting_form">
                                        <table class="table table-bordered ">
                                            <thead>
                                            <tr>
                                                <th style="width: 120px;"></th>
                                                <th colspan="2" style="text-align: center;">
                                                    SHIFT 1
                                                </th>
                                                <th colspan="2" style="text-align: center;">
                                                    SHIFT 2
                                                </th>
                                                <th colspan="2" style="text-align: center;">
                                                    SHIFT 3
                                                </th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th style="text-align: center;">Start</th>
                                                <th style="text-align: center;">End</th>
                                                <th style="text-align: center;">Start</th>
                                                <th style="text-align: center;">End</th>
                                                <th style="text-align: center;">Start</th>
                                                <th style="text-align: center;">End</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td style="text-align: center;">Time</td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    echo '<div class="input-group bootstrap-timepicker timepicker" style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="shift1_start" value="'.$shifts['shift1']['start'].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    echo '<div class="input-group bootstrap-timepicker timepicker" style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="shift1_end" value="'.$shifts['shift1']['end'].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    echo '<div class="input-group bootstrap-timepicker timepicker" style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="shift2_start" value="'.$shifts['shift2']['start'].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    echo '<div class="input-group bootstrap-timepicker timepicker" style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="shift2_end" value="'.$shifts['shift2']['end'].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    echo '<div class="input-group bootstrap-timepicker timepicker" style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="shift3_start" value="'.$shifts['shift3']['start'].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    echo '<div class="input-group bootstrap-timepicker timepicker"  style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="shift3_end" value="'.$shifts['shift3']['end'].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    ?>
                                                </td>
                                            </tr>

                                            <?php
                                            for($i = 1; $i<5; $i++){
                                                echo "<tr>";
                                                echo "<td style=\"text-align: center;\">Break ".$i."</td>";
                                                foreach ($g_shifts as $key=>$shift) {
                                                    echo "<td>";
                                                    echo '<div class="input-group bootstrap-timepicker timepicker" style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="'.$shift.'_break_start[]" value="'.$shifts[$shift]['breaks']['start'.$i].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo '<div class="input-group bootstrap-timepicker timepicker" style="width: 100%">';
                                                    echo '<input type="text" class="time-picker form-control input-small" name="'.$shift.'_break_end[]" value="'.$shifts[$shift]['breaks']['end'.$i].'" style="min-width:70px;">';
                                                    echo '</div>';
                                                    echo "</td>";

                                                }
                                                echo "<tr>";
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="action" value="save_shift">
                                        <input type="hidden" name="set_type" value="shift3">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-primary pull-right" id="friday_shift_save" style="width: 200px;"> Save </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <span style="font-size: 20px;">Shift Pattern Setting</span>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th colspan="<?php echo count($g_andon);?>">ASSEMBLY</th>
                                            <th colspan="<?php echo count($g_machines);?>">MACHINING</th>
                                        </tr>
                                        <tr>
                                            <?php
                                            foreach ($g_andon as $andon){
                                                echo '<th>'. $andon .'</th>';
                                            }

                                            foreach ($g_machines as $machine){
                                                echo '<th>'. $machine .'</th>';
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <?php
                                            foreach ($g_andon as $andon){
                                                $shift_pattern = get_setting($andon.' shift pattern');
                                                echo '<td>';
                                                echo '<select class="form-control shift-pattern" data-target="'.$andon.'">';
                                                if($shift_pattern == 'shift2') {
                                                    echo '<option value="shift2" selected>2 Shifts</option>';
                                                    echo '<option value="shift3">3 Shifts</option>';
                                                } else if($shift_pattern == 'shift3') {
                                                    echo '<option value="shift2">2 Shifts</option>';
                                                    echo '<option value="shift3" selected>3 Shifts</option>';
                                                } else {
                                                    echo '<option value="shift2">2 Shifts</option>';
                                                    echo '<option value="shift3">3 Shifts</option>';
                                                }
                                                echo '</select>';
                                                echo '</td>';
                                            }

                                            foreach ($g_machines as $machine){
                                                echo '<td>';
                                                $shift_pattern = get_setting($machine.' shift pattern');
                                                echo '<select class="form-control shift-pattern" data-target="'.$machine.'">';
                                                if($shift_pattern == 'shift2') {
                                                    echo '<option value="shift2" selected>2 Shifts</option>';
                                                    echo '<option value="shift3">3 Shifts</option>';
                                                } else if($shift_pattern == 'shift3') {
                                                    echo '<option value="shift2">2 Shifts</option>';
                                                    echo '<option value="shift3" selected>3 Shifts</option>';
                                                } else {
                                                    echo '<option value="shift2">2 Shifts</option>';
                                                    echo '<option value="shift3">3 Shifts</option>';
                                                }
                                                echo '</select>';
                                                echo '</td>';
                                            }
                                            ?>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>LOW PRESSURE CASTING</th>
                                            <th>HIGH PRESSURE CASTING</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <?php
                                            $shift_pattern = get_setting('LOW PRESSURE CASTING shift pattern');
                                            echo '<td>';
                                            echo '<select class="form-control shift-pattern" data-target="LOW PRESSURE CASTING">';
                                            if($shift_pattern == 'shift2') {
                                                echo '<option value="shift2" selected>2 Shifts</option>';
                                                echo '<option value="shift3">3 Shifts</option>';
                                            } else if($shift_pattern == 'shift3') {
                                                echo '<option value="shift2">2 Shifts</option>';
                                                echo '<option value="shift3" selected>3 Shifts</option>';
                                            } else {
                                                echo '<option value="shift2">2 Shifts</option>';
                                                echo '<option value="shift3">3 Shifts</option>';
                                            }
                                            echo '</select>';
                                            echo '</td>';

                                            $shift_pattern = get_setting('HIGH PRESSURE CASTING shift pattern');
                                            echo '<td>';
                                            echo '<select class="form-control shift-pattern" data-target="HIGH PRESSURE CASTING">';
                                            if($shift_pattern == 'shift2') {
                                                echo '<option value="shift2" selected>2 Shifts</option>';
                                                echo '<option value="shift3">3 Shifts</option>';
                                            } else if($shift_pattern == 'shift3') {
                                                echo '<option value="shift2">2 Shifts</option>';
                                                echo '<option value="shift3" selected>3 Shifts</option>';
                                            } else {
                                                echo '<option value="shift2">2 Shifts</option>';
                                                echo '<option value="shift3">3 Shifts</option>';
                                            }
                                            echo '</select>';
                                            echo '</td>';
                                            ?>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <span style="font-size: 20px;">Shift Stop Tag</span>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Assembly</th>
                                    <th>Machining</th>
                                    <th>Casting</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control shift_stop_tag" id="assembly_shift_stop_tag" value="<?php echo get_setting('assembly_shift_stop_tag'); ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control shift_stop_tag" id="machining_shift_stop_tag" value="<?php echo get_setting('machining_shift_stop_tag'); ?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control shift_stop_tag" id="casting_shift_stop_tag" value="<?php echo get_setting('casting_shift_stop_tag'); ?>">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box-header with-border">
                                    <span style="font-size: 20px;">Import CSV for shift plan, O/T plan and OPR</span>
                                </div>
                                <div class="box-body">
                                    <form id="plan_csv_form" class="form-inline" enctype="multipart/form-data" method="post">
                                        <input type="file" id="plan_csv" name="plan_csv" style="display: inline;" required>
                                        <button type="submit" class="btn btn-primary">Import</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="box-header with-border">
                                    <span style="font-size: 20px;">Import Excel for shift plan, O/T plan and OPR</span>
                                </div>
                                <div class="box-body">
                                    <form id="plan_xls_form" class="form-inline" enctype="multipart/form-data" method="post">
                                        <input type="file" id="plan_xls" name="plan_xls" style="display: inline;" required>
                                        <button type="submit" class="btn btn-primary">Import</button>
                                    </form>
                                </div>
                                <div class="box-footer">
                                    <button class="btn btn-primary pull-right" id="reset_button" style="width: 200px;"> Reset </button>
                                </div>
                            </div>
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
<script src="components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="assets/js/custom.js"></script>
<script>
    $(function () {
        $(".time-picker").datetimepicker({
            'format': 'HH:mm'
        })

        $(document).on('click', '#shift_save', function () {
            var form = $("#shift_setting_form")
            $.ajax({
                url: "actions.php",
                method: "post",
                data: form.serialize()
            }).done(function (res) {
                if(res =="OK") {
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#success-alert").slideUp(500);
                    });
                } else {
                    $("#fault-alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#fault-alert").slideUp(500);
                    });
                }
            });
        });

        $(document).on('click', '#friday_shift_save', function () {
            var form = $("#friday_shift_setting_form")
            $.ajax({
                url: "actions.php",
                method: "post",
                data: form.serialize()
            }).done(function (res) {
                if(res =="OK") {
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#success-alert").slideUp(500);
                    });
                } else {
                    $("#fault-alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#fault-alert").slideUp(500);
                    });
                }
            });
        });

        $("#plan_csv_form").on('submit',(function(e) {
            $("#loading").fadeIn(500);
            e.preventDefault();
            $.ajax({
                url: "import_plan_csv.php",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data)
                {
                    $("#loading").fadeOut(500);
                    if(data == "OK") {
                        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                            $("#success-alert").slideUp(500);
                        });
                    } else {
                        $("#fault-alert").fadeTo(2000, 500).slideUp(500, function(){
                            $("#fault-alert").slideUp(500);
                        });
                    }

                    $("#plan_csv").val('');

                },
                error: function(e)
                {
                    $("#loading").fadeOut(500);
                    $("#fault-alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#fault-alert").slideUp(500);
                    });
                }
            });
        }));

        $("#plan_xls_form").on('submit',(function(e) {
            $("#loading").fadeIn(500);
            e.preventDefault();
            $.ajax({
                url: "import_plan_xls.php",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data)
                {
                    $("#loading").fadeOut(500);
                    console.log(data);
                    if(data.indexOf("OK") >= 0) {
                        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                            $("#success-alert").slideUp(500);
                        });
                    } else {
                        $("#fault-alert").fadeTo(2000, 500).slideUp(500, function(){
                            $("#fault-alert").slideUp(500);
                        });
                    }

                    $("#plan_csv").val('');

                },
                error: function(e)
                {
                    $("#loading").fadeOut(500);
                    $("#fault-alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#fault-alert").slideUp(500);
                    });
                }
            });
        }));

        $("#reset_button").on('click', (function(e) {
            $("#plan_xls_form")[0].reset();
            $("#plan_csv_form")[0].reset();
        }));

        $(".shift-pattern").on('change', function () {
            var setting_value = $(this).val();
            var setting_type = $(this).attr('data-target') + ' shift pattern';
            $.ajax({
                url: "actions.php",
                method: "post",
                data: {
                    'set_value': setting_value,
                    'set_type': setting_type,
                    'action':'save_header_link',
                }
            }).done(function (res) {
                if(res =="ok") {
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#success-alert").slideUp(500);
                    });
                } else {
                    $("#fault-alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#fault-alert").slideUp(500);
                    });
                }
            });
        });

        $(".shift_stop_tag").on('change', function () {
            var setting_value = $(this).val();
            var setting_type = $(this).attr('id');
            $.ajax({
                url: "actions.php",
                method: "post",
                data: {
                    'set_value': setting_value,
                    'set_type': setting_type,
                    'action':'save_header_link',
                }
            }).done(function (res) {
                if(res =="ok") {
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#success-alert").slideUp(500);
                    });
                } else {
                    $("#fault-alert").fadeTo(2000, 500).slideUp(500, function(){
                        $("#fault-alert").slideUp(500);
                    });
                }
            });
        });
    });
</script>

</body>
</html>