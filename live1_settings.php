<?php
require_once ("db_config.php");
require_once ("functions.php");
$page_name = "live1_settings";
require_once ("assets_inc.php");
// if(!isset($_SESSION['user_info']))
//     header('Location:login.php');

$plan_date = date('j-M', strtotime($current));
//Get shift plan
$all_machines = array_merge($g_andon, $g_machines);
foreach ($all_machines as $machine){
    $shift = get_live_shift($machine);
    $live_shift = $shift['shift'];
    $live_date = $shift['date'];
    $shift_plan[$machine] = get_shift_plan($plan_date, $live_shift, $machine, 'shift_plan');
    $ot_plan[$machine] = get_shift_plan($plan_date, $live_shift, $machine, 'ot_plan');
    $opr[$machine] = get_shift_plan($plan_date, $live_shift, $machine, 'opr');
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
                            <span style="font-size: 20px;">LIVE PAGE 1 SETTING</span>
                        </div>
                        <div class="box-body" style="min-height: 700px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered" id="ASSEMBLY">
                                        <tr>
                                            <td style="border-top: 1px solid #808080;border-left: 1px solid #808080; "></td>
                                            <td colspan="13" class="title-td" style="font-size: 30px;font-weight: bold;">ASSEMBLY</td>
                                        </tr>
                                        <tr>
                                            <td class="title-td" style="font-weight: bold; font-size: 24px">ANDON</td>
                                            <td class="title-td" colspan="3" data-machine="ASSY">
                                                ASSY<br/>
                                                Takt Time: <input type="number" class="form-control " name="opr" style="display: inline; width: 150px;" value="<?php echo get_tag_setting('ASSEMBLY', 'ASSY', 'opr')?>">
                                            </td>
                                            <td style="width: 10px;" rowspan="13" class="title-td"></td>
                                            <td class="title-td" colspan="3" data-machine="SHORT BLOCK">
                                                S/BLOCK<br/>
                                                Takt Time: <input type="number" class="form-control" name="opr" style="display: inline; width: 150px;" value="<?php echo get_tag_setting('ASSEMBLY', 'SHORT BLOCK', 'opr')?>">
                                            </td>
                                            <td class="title-td" colspan="3" data-machine="HEAD SUB">
                                                HEAD SUB<br/>
                                                Takt Time: <input type="number" class="form-control" name="opr" style="display: inline; width: 150px;" value="<?php echo get_tag_setting('ASSEMBLY', 'HEAD SUB', 'opr')?>">
                                            </td>
                                            <td class="title-td" colspan="3" data-machine="CAM HSG">
                                                CAM HSG<br/>
                                                Takt Time: <input type="number" class="form-control" name="opr" style="display: inline; width: 150px;" value="<?php echo get_tag_setting('ASSEMBLY', 'CAM HSG', 'opr')?>">
                                            </td>
                                        </tr>
                                        <?php
                                        echo '<tr>';
                                        echo '<td style="border: 1px solid #373737;"></td>';
                                        for($i=0;$i<4;$i++){
                                            echo '<td style="border: 1px solid #373737;">TAG NAME</td>
                                                  <td style="border: 1px solid #373737; width: 90px;">RED</td>
                                                  <td style="border: 1px solid #373737; width: 90px;">YELLOW</td>';
                                        }
                                        echo '</tr>';
                                        foreach($g_items as $item) {
                                            echo '<tr>';
                                            echo '<td class="title-td">'.$item.'</td>';
                                            $input_name = str_replace(" +/-", "", $item);
                                            $input_name = str_replace("/", "", $input_name);
                                            $input_name = str_replace(" ", "_", strtolower($input_name));
                                            foreach($g_andon as $machine){
                                                if($item == 'SHIFT PLAN') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" colspan="3" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'" value="'.$shift_plan[$machine].'">';
                                                    echo '</td>';
                                                } else if($item == 'O/T PLAN') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" colspan="3" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'" value="'.$ot_plan[$machine].'">';
                                                    echo '</td>';
                                                }
                                                else if($item == 'TARGET') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'" value="'.get_tag_setting("ASSEMBLY", $machine, $input_name).'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_red" value="'.get_tag_setting("ASSEMBLY", $machine, $input_name.'_red').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_yellow" value="'.get_tag_setting("ASSEMBLY", $machine, $input_name.'_yellow').'">';
                                                    echo '</td>';
                                                }
                                                else if($item == 'LAST HOUR OPR' || $item == 'LIVE +/-') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;"></td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_red" value="'.get_tag_setting("ASSEMBLY", $machine, $input_name.'_red').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_yellow" value="'.get_tag_setting("ASSEMBLY", $machine, $input_name.'_yellow').'">';
                                                    echo '</td>';
                                                } else {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    if($item == 'SHIFT LINE STOP') {
                                                        echo '<input type="text" class="form-control" name="'.$input_name.'_fault_tag" value="'.get_tag_setting("ASSEMBLY", $machine, $input_name.'_fault_tag').'">';
                                                        echo '<input type="text" class="form-control" name="' . $input_name . '_tag" value="' . get_tag_setting("ASSEMBLY", $machine, $input_name . '_tag') . '">';
                                                        echo '<input type="text" class="form-control" name="' . $input_name . '_finish_tag" value="' . get_tag_setting("ASSEMBLY", $machine, $input_name . '_finish_tag') . '">';
                                                    } else {
                                                        echo '<input type="text" class="form-control" name="' . $input_name . '_tag" value="' . get_tag_setting("ASSEMBLY", $machine, $input_name . '_tag') . '">';
                                                    }
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_red" value="'.get_tag_setting("ASSEMBLY", $machine, $input_name.'_red').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_yellow" value="'.get_tag_setting("ASSEMBLY", $machine, $input_name.'_yellow').'">';
                                                    echo '</td>';
                                                }
                                            }
                                            echo '</tr>';
                                        }
                                        ?>

                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered" id="MACHINING">
                                        <tr>
                                            <td style="border-top: 1px solid #808080;border-left: 1px solid #808080; border-bottom: 1px solid #808080"></td>
                                            <td colspan="18" class="title-td" style="font-size: 30px; font-weight: bold;">MACHINING</td>
                                        </tr>
                                        <tr>
                                            <td style="border-top: 1px solid #808080;border-left: 1px solid #808080;"></td>
                                            <td class="title-td" colspan="3" data-machine="CRANK">
                                                CRANK<br/>
                                                Takt Time: <input type="number" class="form-control" name="opr" style="display: inline; width: 150px;" value="<?php echo get_tag_setting('MACHINING', 'CRANK', 'opr')?>">
                                            </td>
                                            <td class="title-td" colspan="3" data-machine="BLOCK">
                                                BLOCK<br/>
                                                Takt Time: <input type="number" class="form-control" name="opr" style="display: inline; width: 150px;" value="<?php echo get_tag_setting('MACHINING', 'BLOCK', 'opr')?>">
                                            </td>
                                            <td class="title-td" colspan="3" data-machine="HEAD">
                                                HEAD<br/>
                                                Takt Time: <input type="number" class="form-control " name="opr" style="display: inline; width: 150px;" value="<?php echo get_tag_setting('MACHINING', 'HEAD', 'opr')?>">
                                            </td>
                                            <td class="title-td" colspan="3" data-machine="HOUSING">
                                                HOUSING<br/>
                                                Takt Time: <input type="number" class="form-control " name="opr" style="display: inline; width: 150px;" value="<?php echo get_tag_setting('MACHINING', 'HOUSING', 'opr')?>">
                                            </td>
                                            <td class="title-td" colspan="3" data-machine="ROD">
                                                ROD<br/>
                                                Takt Time: <input type="number" class="form-control " name="opr" style="display: inline; width: 150px;" value="<?php echo get_tag_setting('MACHINING', 'ROD', 'opr')?>">
                                            </td>
                                            <td class="title-td" colspan="3" data-machine="CAM">
                                                CAM<br/>
                                                Takt Time: <input type="number" class="form-control " name="opr" style="display: inline; width: 150px;" value="<?php echo get_tag_setting('MACHINING', 'CAM', 'opr')?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid #373737;"></td>
                                            <?php
                                            for($i=0;$i<6;$i++){
                                                echo '<td style="border: 1px solid #373737;">TAG NAME</td>
                                                        <td style="border: 1px solid #373737; width: 75px;">RED</td>
                                                        <td style="border: 1px solid #373737; width: 75px;">YELLOW</td>';
                                            }
                                            ?>
                                        </tr>
                                        <?php

                                        foreach($g_items as $item) {
                                            echo '<tr>';
                                            echo '<td class="title-td">'.$item.'</td>';
                                            $input_name = str_replace(" +/-", "", $item);
                                            $input_name = str_replace("/", "", $input_name);
                                            $input_name = str_replace(" ", "_", strtolower($input_name));
                                            foreach($g_machines as $machine){
                                                if($item == 'SHIFT PLAN') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" colspan="3" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'" value="'.$shift_plan[$machine].'">';
                                                    echo '</td>';
                                                }
                                                else if($item == 'O/T PLAN') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" colspan="3" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'" value="'.$ot_plan[$machine].'">';
                                                    echo '</td>';
                                                }
                                                else if($item == 'TARGET') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'" value="'.get_tag_setting("MACHINING", $machine, $input_name).'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_red" value="'.get_tag_setting("MACHINING", $machine, $input_name.'_red').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_yellow" value="'.get_tag_setting("MACHINING", $machine, $input_name.'_yellow').'">';
                                                    echo '</td>';
                                                }
                                                else if($item == 'LAST HOUR OPR' || $item == 'LIVE +/-') {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;"></td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_red" value="'.get_tag_setting("MACHINING", $machine, $input_name.'_red').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_yellow" value="'.get_tag_setting("MACHINING", $machine, $input_name.'_yellow').'">';
                                                    echo '</td>';
                                                } else {
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="text" class="form-control" name="'.$input_name.'_tag" value="'.get_tag_setting("MACHINING", $machine, $input_name.'_tag').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_red" value="'.get_tag_setting("MACHINING", $machine, $input_name.'_red').'">';
                                                    echo '</td>';
                                                    echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'">';
                                                    echo '<input type="number" class="form-control" name="'.$input_name.'_yellow" value="'.get_tag_setting("MACHINING", $machine, $input_name.'_yellow').'">';
                                                    echo '</td>';
                                                }
                                            }
                                            echo '</tr>';
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered" id="Period_Cumulative">
                                        <tr>
                                            <td colspan="9" class="title-td" style="font-size: 30px;font-weight: bold ">Period Cumulative (Updated @ EOS)</td>
                                        </tr>
                                        <tr>
                                            <td class="title-td">K</td>
                                            <td colspan="6" class="title-td">M</td>
                                            <td colspan="2" class="title-td">C</td>
                                        </tr>
                                        <?php
                                        echo '<tr>';
                                        foreach ($g_period_cumulative as $machine) {
                                            echo '<td class="title-td">'.$machine.'</td>';
                                        }
                                        echo '</tr>';

                                        /*echo '<tr>';
                                        echo '<td>TAG NAME</td>';
                                        foreach ($g_period_cumulative as $machine) {
                                            echo '<td class="value-td" data-machine="'.$machine.'">';
                                            echo '<input type="text" class="form-control" name="actual_tag" value="'.get_tag_setting("Period_Cumulative", $machine, 'actual_tag').'">';
                                            echo '</td>';
                                        }
                                        echo '</tr>';

                                        echo '<tr>';
                                        echo '<td>RED</td>';
                                        foreach ($g_period_cumulative as $machine) {
                                            echo '<td class="value-td" data-machine="'.$machine.'">';
                                            echo '<input type="number" class="form-control" name="actual_red" value="'.get_tag_setting("Period_Cumulative", $machine, 'actual_red').'">';
                                            echo '</td>';
                                        }
                                        echo '</tr>';
                                        echo '<tr>';
                                        echo '<td>YELLOW</td>';
                                        foreach ($g_period_cumulative as $machine) {
                                            echo '<td class="value-td" data-machine="'.$machine.'">';
                                            echo '<input type="number" class="form-control" name="actual_yellow" value="'.get_tag_setting("Period_Cumulative", $machine, 'actual_yellow').'">';
                                            echo '</td>';
                                        }
                                        echo '</tr>';*/
                                            $period_start_date = get_setting('period_start_date');
                                            $period_end_date = get_setting('period_end_date');
                                        ?>
                                        <tr>
                                            <td colspan="5">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right date-picker" id="period_start_date" name="period_start_date" value="<?php echo $period_start_date; ?>">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </td>
                                            <td colspan="4">
                                                <div class="form-group">
                                                    <label>End Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control pull-right date-picker" id="period_end_date" name="period_end_date" value="<?php echo $period_end_date; ?>">
                                                    </div>
                                                    <!-- /.input group -->
                                                </div>
                                            </td>
                                        </tr>
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
            var field_name = $(this).attr('name');
            var value = $(this).val();
            var td = $(this).closest('td');
            var table = $(this).closest('table');
            var table_name = table.attr('id');
            var machine = td.data('machine');

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
        })

        $(".date-picker").datetimepicker({
            format: "DD/MM/YYYY",
            useCurrent: false
        });

        $('.date-picker').datetimepicker().on('dp.change', function (ev) {
            var field_name = $(this).attr('name');
            var value = $(this).val();
            $.ajax({
                url: "actions.php",
                method: "post",
                data: {
                    'set_value': value,
                    'set_type': field_name,
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