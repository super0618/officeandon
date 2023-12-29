<?php
require_once ("db_config.php");
require_once ("functions.php");
$page_name = "live2_settings";
require_once ("assets_inc.php");
// if(!isset($_SESSION['user_info']))
//     header('Location:login.php');

$shift = get_shift($current, 'shift2');
$start_time = $shift['start'];
$end_time = $shift['end'];
$live_shift = $shift['shift'];
$live_date = $shift['date'];
$plan_date = date('j-M', strtotime($live_date));
//Get shift plan
$all_machines = ['LP HEAD', 'HP BLOCK'];
foreach ($all_machines as $machine){
    $shift_plan[$machine] = get_shift_plan($plan_date, $live_shift, $machine, 'shift_plan');
    $ot_plan[$machine] = get_shift_plan($plan_date, $live_shift, $machine, 'ot_plan');
    $opr[$machine] = get_shift_plan($plan_date, $live_shift, $machine, 'opr');
}

$show_items = $g_items;
if (($key = array_search('SHIFT OPR IN', $show_items)) !== false) {
    unset($show_items[$key]);
}

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
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <span style="font-size: 20px;">LIVE PAGE 2 SETTING</span>
                        </div>
                        <div class="box-body" style="min-height: 700px;">
                            <div class="row">
                                <div class="col-md-9">
                                    <table class="table table-bordered" id="LOW_PRESSURE_CASTING">
                                        <tr>
                                            <td style="border-top: 1px solid #808080;border-left: 1px solid #808080; "></td>
                                            <td colspan="13" class="title-td" style="font-size: 30px;font-weight: bold;">LOW PRESSURE CASTING</td>
                                        </tr>
                                        <tr>
                                            <td style="border-top: 1px solid #808080;border-left: 1px solid #808080; "></td>
                                            <td class="title-td" colspan="3" data-machine="HEAD">
                                                HEAD<br/>
                                                Takt Time: <input type="number" class="form-control " name="opr" style="display: inline; width: 150px;" value="<?php echo get_tag_setting('LOW_PRESSURE_CASTING', 'HEAD', 'opr')?>">
                                            </td>
                                            <td style="width: 10px;" rowspan="13" class="title-td"></td>
                                            <td class="title-td" colspan="2">
                                                EDM ACTUAL
                                            </td>

                                        </tr>
                                        <?php
                                        echo '<tr>';
                                        echo '<td style="border: 1px solid #373737;"></td>';
                                        echo '<td style="border: 1px solid #373737;">TAG NAME</td>';
                                        echo '<td style="border: 1px solid #373737; width: 100px;">RED</td>';
                                        echo '<td style="border: 1px solid #373737; width: 100px;">YELLOW</td>';
                                        echo '<td class="title-td">EDM1</td>';
                                        echo '<td class="title-td">EDM4</td>';
                                        echo '</tr>';

                                        $machines = array('LP HEAD');
                                        foreach($show_items as $item) {
                                            echo '<tr>';
                                            echo '<td class="title-td">'.$item.'</td>';
                                            $input_name = str_replace(" +/-", "", $item);
                                            $input_name = str_replace("/", "", $input_name);
                                            $input_name = str_replace(" ", "_", strtolower($input_name));
                                            foreach($machines as $machine){
                                                if($item == 'SHIFT PLAN') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" colspan="3" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'" value="'.$shift_plan[$machine].'">';
                                                    echo '</td>';

                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="EDM1">';
                                                    echo '<input type="text" class="form-control" name="actual_tag" value="'.get_tag_setting("LOW_PRESSURE_CASTING", 'EDM1', 'actual_tag').'">';
                                                    
                                                    echo '<input type="text" class="form-control" name="shift_line_stop_fault_tag" value="'.get_tag_setting("LOW_PRESSURE_CASTING", 'EDM1', 'shift_line_stop_fault_tag').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="EDM4">';
                                                    echo '<input type="text" class="form-control" name="actual_tag" value="'.get_tag_setting("LOW_PRESSURE_CASTING", 'EDM4', 'actual_tag').'">';
                                                    echo '<input type="text" class="form-control" name="shift_line_stop_fault_tag" value="'.get_tag_setting("LOW_PRESSURE_CASTING", 'EDM4', 'shift_line_stop_fault_tag').'">';
                                                    echo '</td>';
                                                }
                                                else if($item == 'O/T PLAN') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" colspan="3" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'" value="'.$ot_plan[$machine].'">';
                                                    echo '</td>';
                                                }
                                                else if($item == 'TARGET' || $item == 'LAST HOUR OPR' || $item == 'LIVE +/-') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;"></td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_red" value="'.get_tag_setting("LOW_PRESSURE_CASTING", $machine, $input_name.'_red').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_yellow" value="'.get_tag_setting("LOW_PRESSURE_CASTING", $machine, $input_name.'_yellow').'">';
                                                    echo '</td>';
                                                }
                                                else {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="text" class="form-control" name="'.$input_name.'_tag" value="'.get_tag_setting("LOW_PRESSURE_CASTING", $machine, $input_name.'_tag').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_red" value="'.get_tag_setting("LOW_PRESSURE_CASTING", $machine, $input_name.'_red').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_yellow" value="'.get_tag_setting("LOW_PRESSURE_CASTING", $machine, $input_name.'_yellow').'">';
                                                    echo '</td>';
                                                }

                                                if($item == 'TARGET') {
                                                    echo '<td class="title-td">EDM2</td>';
                                                    echo '<td class="title-td">EDM5</td>';
                                                }

                                                if($item == 'ACTUAL') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="EDM2">';
                                                    echo '<input type="text" class="form-control" name="actual_tag" value="'.get_tag_setting("LOW_PRESSURE_CASTING", 'EDM2', 'actual_tag').'">';
                                                    echo '<input type="text" class="form-control" name="shift_line_stop_fault_tag" value="'.get_tag_setting("LOW_PRESSURE_CASTING", 'EDM2', 'shift_line_stop_fault_tag').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="EDM5">';
                                                    echo '<input type="text" class="form-control" name="actual_tag" value="'.get_tag_setting("LOW_PRESSURE_CASTING", 'EDM5', 'actual_tag').'">';
                                                    echo '<input type="text" class="form-control" name="shift_line_stop_fault_tag" value="'.get_tag_setting("LOW_PRESSURE_CASTING", 'EDM5', 'shift_line_stop_fault_tag').'">';
                                                    echo '</td>';
                                                }

                                                if($item == 'LIVE +/-') {
                                                    echo '<td class="title-td">EDM3</td>';
                                                    echo '<td class="title-td">EDM6</td>';
                                                }

                                                if($item == 'SHIFT LINE STOP') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="EDM3">';
                                                    echo '<input type="text" class="form-control" name="actual_tag" value="'.get_tag_setting("LOW_PRESSURE_CASTING", 'EDM3', 'actual_tag').'">';
                                                    echo '<input type="text" class="form-control" name="shift_line_stop_fault_tag" value="'.get_tag_setting("LOW_PRESSURE_CASTING", 'EDM3', 'shift_line_stop_fault_tag').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="EDM6">';
                                                    echo '<input type="text" class="form-control" name="actual_tag" value="'.get_tag_setting("LOW_PRESSURE_CASTING", 'EDM6', 'actual_tag').'">';
                                                    echo '<input type="text" class="form-control" name="shift_line_stop_fault_tag" value="'.get_tag_setting("LOW_PRESSURE_CASTING", 'EDM6', 'shift_line_stop_fault_tag').'">';
                                                    echo '</td>';
                                                }

                                            }
                                            echo '</tr>';
                                        }
                                        ?>

                                    </table>

                                    <table class="table table-bordered" id="HIGH_PRESSURE_CASTING">
                                        <tr>
                                            <td style="border-top: 1px solid #808080;border-left: 1px solid #808080; "></td>
                                            <td colspan="13" class="title-td" style="font-size: 30px;font-weight: bold;">HIGH PRESSURE CASTING</td>
                                        </tr>
                                        <tr>
                                            <td style="border-top: 1px solid #808080;border-left: 1px solid #808080; "></td>
                                            <td class="title-td" colspan="3" data-machine="HEAD">
                                                BLOCK<br/>
                                                Takt Time: <input type="number" class="form-control " name="opr" style="display: inline; width: 150px;" value="<?php echo get_tag_setting('HIGH_PRESSURE_CASTING', 'HEAD', 'opr')?>">
                                            </td>
                                            <td style="width: 10px;" rowspan="13" class="title-td"></td>
                                            <td class="title-td" colspan="2">
                                                H1/H2 ACTUAL
                                            </td>

                                        </tr>
                                        <?php
                                        echo '<tr>';
                                        echo '<td style="border: 1px solid #373737;"></td>';
                                        echo '<td style="border: 1px solid #373737;">TAG NAME</td>';
                                        echo '<td style="border: 1px solid #373737; width: 100px;">RED</td>';
                                        echo '<td style="border: 1px solid #373737; width: 100px;">YELLOW</td>';
                                        echo '<td class="title-td">H1</td>';
                                        echo '<td class="title-td">H2</td>';
                                        echo '</tr>';

                                        $machines = array('HP BLOCK');
                                        foreach($show_items as $item) {
                                            echo '<tr>';
                                            echo '<td class="title-td">'.$item.'</td>';
                                            $input_name = str_replace(" +/-", "", $item);
                                            $input_name = str_replace("/", "", $input_name);
                                            $input_name = str_replace(" ", "_", strtolower($input_name));
                                            foreach($machines as $machine){
                                                if($item == 'SHIFT PLAN') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" colspan="3" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'" value="'.$shift_plan[$machine].'">';
                                                    echo '</td>';

                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="H1">';
                                                    echo '<input type="text" class="form-control" name="actual_tag" value="'.get_tag_setting("HIGH_PRESSURE_CASTING", 'H1', 'actual_tag').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="H2">';
                                                    echo '<input type="text" class="form-control" name="actual_tag" value="'.get_tag_setting("HIGH_PRESSURE_CASTING", 'H2', 'actual_tag').'">';
                                                    echo '</td>';
                                                }
                                                else if($item == 'O/T PLAN') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" colspan="3" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'" value="'.$ot_plan[$machine].'">';
                                                    echo '</td>';
                                                }
                                                else if($item == 'TARGET' || $item == 'LAST HOUR OPR' || $item == 'LIVE +/-') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;"></td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_red" value="'.get_tag_setting("HIGH_PRESSURE_CASTING", $machine, $input_name.'_red').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_yellow" value="'.get_tag_setting("HIGH_PRESSURE_CASTING", $machine, $input_name.'_yellow').'">';
                                                    echo '</td>';
                                                } else {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="text" class="form-control" name="'.$input_name.'_tag" value="'.get_tag_setting("HIGH_PRESSURE_CASTING", $machine, $input_name.'_tag').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_red" value="'.get_tag_setting("HIGH_PRESSURE_CASTING", $machine, $input_name.'_red').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_yellow" value="'.get_tag_setting("HIGH_PRESSURE_CASTING", $machine, $input_name.'_yellow').'">';
                                                    echo '</td>';
                                                }
                                            }
                                            echo '</tr>';
                                        }
                                        ?>

                                    </table>
                                </div>
                                <div class="col-md-3">
                                    <table class="table table-bordered" id="SHIFT_PATTERN">
                                        <tr><td colspan="2" class="title-td" style="font-size: 30px;font-weight: bold;">SHIFT PATTERN</td></tr>
                                        <?php
                                        foreach ($g_shift_patterns as $machine){
                                            echo '<tr>';
                                            if($machine == 'TMAB 5' || $machine == 'TMAB 10' || $machine == 'TMAB 15' || $machine == 'TBU 30')
                                                echo '<td class="title-td">'.$machine.'`</td>';
                                            else
                                                echo '<td class="title-td">'.$machine.'</td>';
                                            echo '<td class="value-td" style="border-bottom: 1px solid #373737;" data-machine="'.$machine.'">';
                                            echo '<input type="text" class="form-control" name="actual_tag" value="'.get_tag_setting("SHIFT_PATTERN", $machine, 'actual_tag').'">';
                                            echo '</td>';
                                            echo '</tr>';

                                        }
                                        ?>
                                    </table>
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
        $(document).on('change', 'input', function () {
            var value = $(this).val();
            var td = $(this).closest('td');
            var table = $(this).closest('table');
            var table_name = table.attr('id');
            var machine = td.data('machine');
            var field_name = $(this).attr('name')

            if(field_name==="shift_line_stop_fault_tag") {
                $.ajax({
                    url: "actions.php",
                    method: "post",
                    data: {
                        action: "save_tag_setting",
                        value: value,
                        table_name: table_name,
                        machine: machine,
                        field_name: "shift_line_stop_tag",
                    }
                })
            }
            $.ajax({
                url: "actions.php",
                method: "post",
                data: {
                    action: "save_tag_setting",
                    value: value,
                    table_name: table_name,
                    machine: machine,
                    field_name: field_name,
                }
            }).done(function (result) {
                if(result == "OK") {
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